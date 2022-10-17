<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Models\Medico\Medico;
use App\Models\Paciente\ConsultaGeneral;
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

class ConsultaGeneralController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = ConsultaGeneral::select(
                'consulta_general.id',
                'consulta_general.diagnostico',
                'consulta_general.fecha',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'consulta_general.estatus',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN consulta_general.estatus = "1" THEN "Proceso"  
                WHEN consulta_general.estatus= "2" THEN "FInalizada"
                WHEN consulta_general.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->orderBy('consulta_general.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->estatus == 1) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar_consulta btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Notas</button>';
                        return $button;
                    }
                    if ($data->estatus == 2) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_detalles btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Detalles</button>';
                        return $button;
                    }
                    if ($data->estatus == 0) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_cancelacion btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Ver</button>';
                        return $button;
                    }
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('ConsultaGeneral.listado')
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

        $v->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'string', 'max:255'],
            'edad' => 'required|numeric|min:0|not_in:-1',
            'tipo_sangre' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
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

    public function create_consulta(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'tipo_consulta' => ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id;
        $tipo_consulta = $data->tipo_consulta;
        if ($usuario->tipo_usuario == 2) {
            $datos_medico = Medico::select('id')
                ->where('id_persona', $usuario->id_persona)
                ->first();
        } else {
            return response()->json('Error: Usuario no Identificado como Médico, Favor de Validar', 442);
        }

        $registrarC = ConsultaGeneral::create([
            'id_paciente' => $id_paciente,
            'id_tipoconsulta' => $tipo_consulta,
            'id_usuario' => $id_usuario,
            'id_medico' => $datos_medico->id,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),

        ]);

        if ($registrarC != '') {
            return response()->json('Se ha creado la Consulta', 200);
        }
    }

    public function data_consultag($id)
    {
        $data = ConsultaGeneral::select(
            'persona.edad',
            'tipo_sangre.tipo',
            'tipo_consulta.nombre AS tipo_consulta',
            'tipo_sangre.tipo AS tipo_sangre',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
            ->where('consulta_general.id', $id)
            ->first();

        return $data;
    }

    public function save_EditConsulta(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $data = $v;
        $id = $data->id;
        $talla = $data->talla;
        $peso = $data->peso;
        $temperatura = $data->temperatura;
        $diagnostico = $data->diagnostico;

        $v->validate([
            'peso' => 'required|numeric|min:1|not_in:-1',
            'talla' => 'required|numeric|min:25|not_in:-1',
            'temperatura' => 'required|numeric|min:30|not_in:-1',
            'diagnostico' => ['required', 'string', 'max:255'],
        ]);

        $updateC = ConsultaGeneral::where('id', $id)->update([
            'temperatura' => $temperatura,
            'peso' => $peso,
            'talla' => $talla,
            'diagnostico' => $diagnostico,
            'estatus' => '2',
        ]);

        if ($updateC != '') {
            return response()->json('Diagnóstico guardado Correctamente', 200);
        }else{
            return response()->json('Error: Sin cambios', 500);
        }
    }

    public function expediente_CG(Request $request)
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
                    $button = '&nbsp;<button type="button" name="del" id="' . $data->id . '" class="expediente_paciente btn btn-success btn-xs btn-glow mr-1 mb-1"><i class="fa fa-archive"></i></i> Expediente</button>'; 

                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Expedientes.ListadoExpedienteGeneral')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }
}
