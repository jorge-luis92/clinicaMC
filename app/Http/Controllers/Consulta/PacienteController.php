<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Models\Medico\Medico;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\TipoConsulta;
use App\Models\Paciente\TipoSangre;
use App\Models\Persona\Persona;
use App\Models\Usuario\TipoUsuario;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Paciente::select(
                'paciente.id',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'paciente.fecha_registro',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre, ' ', persona.ap_paterno, ' ', COALESCE(persona.ap_materno, '')) AS nombre_c")
            )
                ->join('persona', 'persona.id', '=', 'paciente.id_persona')
                ->leftJoin('tipo_sangre', 'tipo_sangre.id', '=', 'paciente.id_tiposangre')
                ->orderBy('persona.nombre', 'asc');

            return DataTables::of($query)
                ->filterColumn('nombre_c', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(persona.nombre, ' ', persona.ap_paterno, ' ', COALESCE(persona.ap_materno, '')) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('nombre_c', function ($query, $order) {
                    $query->orderBy('persona.nombre', $order);
                })
                ->filterColumn('edad', function ($query, $keyword) {
                    $query->where('persona.edad', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('edad', function ($query, $order) {
                    $query->orderBy('persona.edad', $order);
                })
                ->filterColumn('fecha_nacimiento', function ($query, $keyword) {
                    $query->where('persona.fecha_nacimiento', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('fecha_nacimiento', function ($query, $order) {
                    $query->orderBy('persona.fecha_nacimiento', $order);
                })
                ->filterColumn('tipo', function ($query, $keyword) {
                    $query->where('tipo_sangre.tipo', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('tipo', function ($query, $order) {
                    $query->orderBy('tipo_sangre.tipo', $order);
                })
                ->addColumn('accion', function ($row) {
                    return '&nbsp;<button type="button" name="' . $row->id . '" id="' . $row->id . '" class="detalles_paciente btn btn-primary btn-sm btn-glow mr-1 mb-1"> Seleccionar</button>';
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Paciente.General')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function regPaciente(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'string', 'max:255'],
            'edad' => 'required|numeric|min:0|not_in:-1',
            'tipo_sangre' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
            'talla' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $ap_mat = $request->ap_mat ?: " ";
            $tipo_s = ($request->tipo_sangre == 0) ? 7 : $request->tipo_sangre;

            $persona = Persona::create([
                'nombre'           => $request->nombre,
                'ap_paterno'       => $request->ap_pat,
                'ap_materno'       => $ap_mat,
                'edad'             => $request->edad,
                'genero'           => $request->genero,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'id_usuario'       => auth()->id(),
                'fecha_registro'   => date('Y-m-d'),
                'hora_registro'    => date('H:i:s'),
            ]);

            $paciente = Paciente::create([
                'id_persona'          => $persona->id,
                'id_tiposangre'       => $tipo_s,
                'talla'               => $request->talla,
                'celular'             => $request->celular,
                'contacto_emergencia' => $request->contacto_emergencia,
                'correo'              => $request->email,
                'id_usuario'          => auth()->id(),
                'fecha_registro'      => date('Y-m-d'),
                'hora_registro'       => date('H:i:s'),
                'activo'              => 1
            ]);

            DB::commit();

            return response()->json('Paciente creado satisfactoriamente', 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Hubo un problema al registrar el paciente: ' . $e->getMessage()], 500);
        }
    }

    public function select_paciente(Request $request)
    {

        if ($request->ajax()) {
            $data = Paciente::select(
                'paciente.id',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
                ->orderBy('persona.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="seleccionar_paciente btn btn-primary btn-min-width btn-glow mr-1 mb-1"> Seleccionar</button>';
                    /*$button = '&nbsp;<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1 dropdown-toggle"
                            data-toggle="dropdown">
                            <i class="fas fa-list"></i> Opciones
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Eliminar</button></li>
                      <li><button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Detalles</button></li>
                    </ul>
                  </div>';*/
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Paciente.General')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function data_paciente($id)
    {
        $data = Paciente::select(
            'paciente.id',
            'persona.nombre',
            'persona.ap_paterno',
            'persona.ap_materno',
            'persona.edad',
            'persona.fecha_nacimiento',
            'persona.genero',
            'paciente.talla',
            'paciente.celular',
            'paciente.contacto_emergencia',
            'paciente.correo',
            'tipo_sangre.id AS tipo_sangre',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
            ->where('paciente.id', $id)
            ->first();

        return $data;
    }

    public function editPaciente(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $nombre = $v->nombre;
        $ap_pat = $v->ap_pat;
        $ap_mat = $v->ap_mat;
        $usuario = $v->usuario;
        $fecha_nacimiento = $v->fecha_nacimiento;
        $edad = $v->edad;
        $tipo_sangre = $v->tipo_sangre;
        $celular = $v->celular;
        $email = $v->email;
        $contacto_emergencia = $v->contacto_emergencia;
        $genero = $v->genero;
        $talla = $v->talla;
        $id_paciente = $v->id_paciente;

        $v->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'string', 'max:255'],
            'edad' => 'required|numeric|min:0|not_in:-1',
            'tipo_sangre' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
            'talla' => ['required', 'string', 'max:255'],
        ]);

        if ($ap_mat == null) {
            $ap_mat = " ";
        }

        $datos_persona = Paciente::select('id_persona')
            ->where('id', $id_paciente)
            ->first();

        $id_persona = $datos_persona->id_persona;

        $updatePersona = Persona::where('id', $id_persona)->update([
            'nombre' => $nombre,
            'ap_paterno' => $ap_pat,
            'ap_materno' => $ap_mat,
            'edad' => $edad,
            'genero' => $genero,
            'fecha_nacimiento' => $fecha_nacimiento,
        ]);

        $updatePaciente = Paciente::where('id', $id_paciente)->update([
            'id_tiposangre' => $tipo_sangre,
            'talla' => $talla,
            'celular' => $celular,
            'contacto_emergencia' => $contacto_emergencia,
            'correo' => $email,
        ]);

        if ($updatePaciente != '') {
            return response()->json('Datos actualizados correctamente', 200);
        }
    }

    public function regPaciente2(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $nombre = $v->nombre;
        $ap_pat = $v->ap_pat;
        $ap_mat = $v->ap_mat;
        $usuario = $v->usuario;
        $fecha_nacimiento = $v->fecha_nacimiento;
        $edad = $v->edad;
        $tipo_sangre = $v->tipo_sangre;
        $celular = $v->celular;
        $email = $v->email;
        $contacto_emergencia = $v->contacto_emergencia;
        $genero = $v->genero;
        $talla = $v->talla;
        $tipo_s = "";

        $v->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
        ]);

        if ($ap_mat == null) {
            $ap_mat = " ";
        }

        if ($tipo_sangre == "") {
            $tipo_s = 7;
        } else {
            $tipo_s = $tipo_sangre;
        }

        Persona::create([
            'nombre' => $nombre,
            'ap_paterno' => $ap_pat,
            'ap_materno' => $ap_mat,
            'edad' => $edad,
            'genero' => $genero,
            'fecha_nacimiento' => $fecha_nacimiento,
            'id_usuario' => $id_usuario,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro' => date('H:i:s'),

        ]);

        $lp = Persona::latest('id')->first();

        $registrarP = Paciente::create([
            'id_persona' => $lp->id,
            'id_tiposangre' => $tipo_s,
            'talla' => $talla,
            'celular' => $celular,
            'contacto_emergencia' => $contacto_emergencia,
            'correo' => $email,
            'id_usuario' => $id_usuario,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro' => date('H:i:s'),
        ]);

        if ($registrarP != '') {
            return response()->json('Paciente creado satisfactoriamente', 200);
        }
    }

    public function data_paciente2($id)
    {
        $data = Paciente::select(
            'paciente.id',
            'persona.fecha_nacimiento',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->where('paciente.id', $id)
            ->first();

        return $data;
    }
}
