<?php

namespace App\Http\Controllers;

use App\Models\Medico\Medico;
use App\Models\Paciente\Cita;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Monolog\Handler\TelegramBotHandler;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function enviarMensaje()
    {
        $mensaje = "Prueba";
        Telegram::sendMessage([
            'chat_id' => '-1001726685878',
            'parse_mode' => 'HTML',
            'text' =>  $mensaje
        ]);
    }

    public function  run_script()
    {

        $usuario = auth()->user();
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $fecha = date('Y-m-d');

        $citas_hoy = Cita::select(
            'cita.id',
            'cita.tipo',
            'cita.fecha_proxima',
            'cita.hora_proxima',
            'persona.ap_paterno',
            'persona.ap_materno',
            'cita.estatus',
            'cita.id_paciente',
            'persona.genero',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            DB::raw("CONCAT(cita.fecha_proxima,' ',cita.hora_proxima) AS fecha_hora"),
            DB::raw('(CASE WHEN cita.estatus = "1" THEN "Agendado"  
            WHEN cita.estatus= "2" THEN "Consulta Generada"
            WHEN cita.estatus= "0" THEN "Cancelada" END) AS estatus_c'),
            DB::raw('(CASE WHEN cita.tipo = "General" THEN "Consulta General"  
            WHEN cita.tipo= "Control" THEN "Control Prenatal" END) AS tipo_c'),
            DB::raw('(CASE WHEN persona.genero = "H" THEN "el"  
            WHEN persona.genero= "M" THEN "la" END) AS genero_s'),
        )
            ->join('paciente', 'paciente.id', 'cita.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->where('cita.id_medico', $medico->id)
            ->where('cita.fecha_proxima', '=', $fecha)
            ->orderBy('cita.fecha', 'asc')
            ->get();

        $fecha = date('Y-m-d');
        $date = date('H:i:s');
        $fecha = date('d/m/Y', strtotime($fecha));
        $date = date('h:i A', strtotime($date));

        foreach ($citas_hoy as  $cita) {

            $fecha = date('d/m/Y', strtotime($cita->fecha_proxima));
            $date = date('h:i A', strtotime($cita->hora_proxima));

            $mensaje = "Cita el día de hoy con ". $cita->genero_s." paciente: <b>" . $cita->nombre_c . "</b>" . " de tipo <b>" . $cita->tipo_c . "</b>  a las " . $date . " del día " . $fecha . ".";

            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);
        }
    }
}
