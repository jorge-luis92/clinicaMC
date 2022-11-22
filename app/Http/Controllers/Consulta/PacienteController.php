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
            $data = Paciente::select(
                'paciente.id',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
                ->orderBy('persona.nombre', 'asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="detalles_paciente btn btn-primary btn-sm btn-glow mr-1 mb-1"><i class="fas fa-user-edit fa-1x"></i> Detalles</button>';

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

    public function regPaciente(Request $v)
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
            'id_tiposangre' => $tipo_sangre,
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
}
