<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Medico\Medico;
use App\Models\Persona\Persona;
use App\Models\Usuario\TipoUsuario;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Usuario::select(
                'users.id',
                'users.name',
                'users.activo',
                'users.email',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'tipo_usuario.id AS id_tipo',
                'tipo_usuario.nombre AS n_tipo',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ', COALESCE(persona.ap_materno, '')) AS nombre_c"),
                DB::raw('(CASE WHEN users.activo = "1" THEN "Activo" WHEN users.activo = "0" THEN "Desactivado" END) AS estatus_u')
            )
                ->join('persona', 'persona.id', '=', 'users.id_persona')
                ->join('tipo_usuario', 'tipo_usuario.id', '=', 'users.tipo_usuario')
                ->orderBy('users.id', 'desc');

            return DataTables::of($query)
                ->addColumn('accion', function ($row) {
                    if ($row->activo == "0") {
                        return '&nbsp;<button type="button" name="' . $row->id . '" id="' . $row->id . '" class="activar_usuario btn btn-success btn-sm btn-glow mr-1 mb-1"><i class="bx bx-check"></i> Activar</button>';
                    } else {
                        return '&nbsp;<button type="button" name="' . $row->id . '" id="' . $row->id . '" class="desactivar_usuario btn btn-danger btn-sm btn-glow mr-1 mb-1"><i class="bx bx-x"></i> Desactivar</button>';
                    }
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoU = TipoUsuario::all();
        return view('auth.listado')->with('tipoU', $tipoU);
    }

    public function regUsuario(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:1'],
            'tipo_usuario' => ['required', 'integer'],
            'name'   => ['required', 'string', 'max:255', 'unique:users,name'], // Asegura que 'users' sea tu tabla
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $persona = Persona::create([
                'nombre'         => strtoupper($request->nombre),
                'ap_paterno'     => strtoupper($request->ap_pat),
                'ap_materno'     => strtoupper($request->ap_mat ?: ""),
                'genero'         => $request->genero,
                'id_usuario'     => auth()->id(),
                'fecha_registro' => date('Y-m-d'),
                'hora_registro'  => date('H:i:s'),
            ]);

            if (!$persona->id) {
                throw new \Exception("No se pudo obtener el ID de la persona creada. Revisa el modelo Persona.");
            }

            if ($request->tipo_usuario == 2) {
                if (!$request->cedula || !$request->whatsapp) {
                    throw new \Exception("La cédula y el whatsapp son obligatorios para registrar un médico.");
                }

                Medico::create([
                    'id_persona'   => $persona->id,
                    'cedula'       => $request->cedula,
                    'celular'      => $request->whatsapp,
                    'id_usuario'   => auth()->id(),
                    'especialidad' => strtoupper($request->especialidad ?: "GENERAL"),
                    'fecha'        => date('Y-m-d'),
                    'hora'         => date('H:i:s'),
                ]);
            }

            Usuario::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'password'     => Hash::make($request->password),
                'tipo_usuario' => $request->tipo_usuario,
                'id_persona'   => $persona->id,
                'activo'       => 1,
                'id_usuario'   => auth()->id(),
                'fecha'        => date('Y-m-d'),
                'hora'         => date('H:i:s'),
            ]);

            DB::commit();
            return response()->json(['success' => 'Usuario creado satisfactoriamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
