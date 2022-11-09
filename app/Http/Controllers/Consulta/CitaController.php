<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;

use App\Models\Medico\Medico;
use App\Models\Paciente\Cita;
use App\Models\Paciente\Paciente;
use App\Models\Persona\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;
use DataTables;
use PDF;

class CitaController extends Controller
{
    public function index(Request $request)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

            $fecha = date('Y-m-d');

        if ($request->ajax()) {
            $data = Cita::select(
                'cita.id',
                'cita.tipo',
                'cita.fecha_proxima',
                'cita.hora_proxima',
                'persona.ap_paterno',
                'persona.ap_materno',
                'cita.estatus',
                'cita.id_paciente',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw("CONCAT(cita.fecha_proxima,' ',cita.hora_proxima) AS fecha_hora"),
                DB::raw('(CASE WHEN cita.estatus = "1" THEN "Agendado"  
                WHEN cita.estatus= "2" THEN "Consulta Generada"
                WHEN cita.estatus= "0" THEN "Cancelada" END) AS estatus_c'),
                DB::raw('(CASE WHEN cita.tipo = "General" THEN "Consulta General"  
                WHEN cita.tipo= "Control" THEN "Control Prenatal" END) AS tipo_c'),
            )
                ->join('paciente', 'paciente.id', 'cita.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->where('cita.id_medico', $medico->id)
                ->where('cita.fecha_proxima', '>=' , $fecha)
                ->orderBy('cita.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->estatus == 1) {
                        if ($data->tipo == 'General') {
                            $button = '&nbsp;<button type="button" name="' . $data->id_paciente . '" id="' . $data->id . '" class="create_cg btn btn-success btn-xs btn-glow mr-1 mb-1"><i class="fa fa-check"></i> Crear Consulta</button>';
                        }
                        if ($data->tipo == 'Control') {
                            $button = '&nbsp;<button type="button" name="' . $data->id_paciente . '" id="' . $data->id . '" class="create_cp btn btn-success btn-xs btn-glow mr-1 mb-1"><i class="fa fa-check"></i> Crear Seguimiento</button>';
                        }
                        return $button;
                    }
                    if ($data->estatus == 2) {
                        $button = '&nbsp;
                        <button type="button" class="btn btn-warning btn-xs btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i> Opciones
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="receta_medica btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-prescription-bottle fa-1x"></i> Receta Médica</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="finalizar_consulta btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-save fa-1x"></i> Finalizar</button></li>
                        </ul>
                         </div>';
                        return $button;
                    }
                    if ($data->estatus == 0) {
                        $button = '&nbsp;<label><i class="fas fa-check fa-1x"></i> Cancelada</label>';
                        return $button;
                    }
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha_proxima', function (Cita $data) {
                    return date('d/m/Y', strtotime($data->fecha_proxima));
                })
                ->editColumn('hora_proxima', function (Cita $data) {
                    return date('h:i A', strtotime($data->hora_proxima));
                })
                ->make(true);
        }

        return view('Paciente.Citalistado');
    }

    public function reg_Cita(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'fecha_agenda' => ['required', 'string', 'max:255'],
            'hora_agenda' => ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id_paciente;
        $fecha = $data->fecha_agenda;
        $hora = $data->hora_agenda;

        $datos_medico = Medico::select('id')
            ->where('id_persona', $usuario->id_persona)
            ->first();

        $hoy = date('Y-m-d');
        $busqueda = Cita::where('id_paciente', $id_paciente)
            ->where('estatus', '=', '1')
            //->whereDate('fecha_proxima', '<=','2016-12-31')
            ->first();
        if ($busqueda) {
            return response()->json('El paciente ya cuenta con una cita activa, ¡Favor de Verificar!. ', 442);
        }
        if ($fecha < $hoy) {
            return response()->json('La fecha de la cita no puede ser una fecha menor al día actual', 404);
        }

        $registrarC = Cita::create([
            'id_paciente' => $id_paciente,
            'id_medico' => $datos_medico->id,
            'fecha_proxima' => $fecha,
            'hora_proxima' => $hora,
            'tipo' => 'General',
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),

        ]);

        if ($registrarC != '') {

            $lc = Cita::latest('id')->first();
            $tipo = 'General';

            $datos_med= Medico::select(
                'persona.genero',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p"),
                DB::raw('(CASE WHEN persona.genero = "H" THEN "Dr."  
                    WHEN persona.genero= "M" THEN "Dra." END) AS doc')
            )
                ->join('persona', 'persona.id', 'medico.id_persona')
                ->where('medico.id_persona', $usuario->id_persona)
                ->first();
        
            $fecha = date('Y-m-d');
            $date = date('H:i:s');
            $fecha = date('d/m/Y', strtotime($fecha));
            $date = date('h:i A', strtotime($date));
            $mensaje = "Se ha registrado con éxito la cita #<b>" . $lc->id . "</b>" . " de tipo Consulta General por parte de la <b>" . $datos_med->doc." ".$datos_med->nombre_p. "</b>  a las " . $date . " del " . $fecha . ".";
            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);

            return response()->json('Se ha generado la Cita', 200);
        }
    }

    public function reg_CitaE(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'fecha_agenda' => ['required', 'string', 'max:255'],
            'hora_agenda' => ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id_paciente;
        $fecha = $data->fecha_agenda;
        $hora = $data->hora_agenda;
        $hoy = date('Y-m-d');

        $datos_medico = Medico::select('id')
            ->where('id_persona', $usuario->id_persona)
            ->first();

        $busqueda = Cita::where('id_paciente', $id_paciente)
            ->where('estatus', '=', '1')
            //->whereDate('fecha_proxima', '<=','2016-12-31')
            ->first();
        if ($busqueda) {
            return response()->json('El paciente ya cuenta con una cita activa, ¡Favor de Verificar!. ', 442);
        }
        if ($fecha < $hoy) {
            return response()->json('La fecha de la cita no puede ser una fecha menor al día actual', 404);
        }

        $registrarC = Cita::create([
            'id_paciente' => $id_paciente,
            'id_medico' => $datos_medico->id,
            'fecha_proxima' => $fecha,
            'hora_proxima' => $hora,
            'tipo' => 'Control',
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),

        ]);

        if ($registrarC != '') {

            $lc = Cita::latest('id')->first();

            $datos_med= Medico::select(
                'persona.genero',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p"),
                DB::raw('(CASE WHEN persona.genero = "H" THEN "Dr."  
                    WHEN persona.genero= "M" THEN "Dra." END) AS doc')
            )
                ->join('persona', 'persona.id', 'medico.id_persona')
                ->where('medico.id_persona', $usuario->id_persona)
                ->first();
        
            $fecha = date('Y-m-d');
            $date = date('H:i:s');
            $fecha = date('d/m/Y', strtotime($fecha));
            $date = date('h:i A', strtotime($date));
            $mensaje = "Se ha registrado con éxito la cita #<b>" . $lc->id . "</b>" . " de tipo Control Prenatal por parte de la <b>" . $datos_med->doc." ".$datos_med->nombre_p. "</b>  a las " . $date . " del " . $fecha . ".";
            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);

            return response()->json('Se ha generado la Cita', 200);
        }
    }

    public function sepaciente_cita(Request $request)
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
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        return view('Paciente.Citalistado');
    }
}
