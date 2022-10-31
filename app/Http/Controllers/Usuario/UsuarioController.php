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
            $data = Usuario::select(
                'users.id',
                'users.name',
                'users.activo',
                'users.email',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'tipo_usuario.id AS id_tipo',
                'tipo_usuario.nombre AS n_tipo',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN users.activo = "1" THEN "Activo" WHEN users.activo= "0" THEN "Desactivado" END) AS estatus_u'),
            )
                ->join('persona', 'persona.id', 'users.id_persona')
                ->join('tipo_usuario', 'tipo_usuario.id', 'users.tipo_usuario')
                ->orderBy('users.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->activo == "0") {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="activar btn btn-success btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-lock fa-1x"></i> Activar</button>';
                    } else {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-edit fa-1x"></i> Detalles</button>';
                        //$button .= '&nbsp;<button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Eliminar</button>';
                        //$button .= '&nbsp;<button type="button" name="'.$data->id.'" id="'.$data->id.'" class="reset btn btn-success btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-lock fa-1x"></i> Reseteo</button>';
                    }
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoU = TipoUsuario::all();
        return view('auth.listado')->with('tipoU', $tipoU);
    }

    public function regUsuario(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $nombre = $v->nombre;
        $ap_pat = $v->ap_pat;
        $ap_mat = $v->ap_mat;
        $usuario = $v->usuario;
        $tipo_usuario = $v->tipo_usuario;
        $cedula = $v->cedula;
        $whatsapp = $v->whatsapp;
        $password = $v->password;
        $usuario = $v->name;
        $email = $v->email;
        $genero = $v->genero;
        $tipo = $v->tipo_usuario;
        $especialidad = $v->especialidad;

        $validated = $v->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($ap_mat == null){
            $ap_mat = " ";
        }

        Persona::create([
            'nombre' => $nombre,
            'ap_paterno' => $ap_pat,
            'ap_materno' => $ap_mat,
            'genero' => $genero,
            'id_usuario' => $id_usuario,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro' => date('H:i:s'),

        ]);

        $lp = Persona::latest('id')->first();

        if ($tipo_usuario == 2) {
            $validated = $v->validate([
                'cedula' => ['required', 'string', 'max:255'],
                'whatsapp' => ['required', 'string', 'max:255'],
            ]);

            Medico::create([
                'id_persona' => $lp->id,
                'cedula' => $cedula,
                'celular' => $whatsapp,
                'id_usuario' => $lp->id,
                'especialidad' => $especialidad,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),

            ]);
        }

        $registrarU = Usuario::create([
            'name' => $usuario,
            'email' => $email,
            'tipo_usuario' => $tipo,
            'id_persona' => $lp->id,
            'activo' => '1',
            'id_usuario' => $id_usuario,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            'password' => Hash::make($password),
        ]);

        if ($registrarU != '') {
            return response()->json('Usuario creado satisfactoriamente', 200);
        }
    }
}
