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

            $mensaje = "Cita el día de hoy con " . $cita->genero_s . " paciente: <b>" . $cita->nombre_c . "</b>" . " de tipo <b>" . $cita->tipo_c . "</b>  a las " . $date . " del día " . $fecha . ".";

            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);
        }
    }

    public function run_depurar()
    {

        $usuario = auth()->user();
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $fecha = date('Y-m-d');

        $cita_pasada = Cita::select(
            'cita.id',
        )
            ->where('cita.id_medico', $medico->id)
            ->where('cita.fecha_proxima', '<', $fecha)
            ->where('estatus', '=', '1')
            ->get();
        //return $cita_pasada;

        foreach ($cita_pasada as  $cita) {
            $updateCita = Cita::where('id', $cita->id)->update([
                'estatus' => '0',
            ]);
        }

        if ($updateCita != '') {
            $mensaje = "Citas actualizadas";

            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);
        } else {
            $mensaje = "Ocurrió un error";

            Telegram::sendMessage([
                'chat_id' => '-1001726685878',
                'parse_mode' => 'HTML',
                'text' =>  $mensaje
            ]);
        }
    }

    public function verCFDI_facturados()
  {
    $usuario = auth()->user();


    $cfdi_uid = '13cbaf33-4526-4ad3-93a8-909825fdae6b';
    $name_file =  "prueba.pdf";
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://factura.com/api/v4/cfdi40/' . $cfdi_uid . '/pdf',
      // CURLOPT_URL => 'https://sandbox.factura.com/api/v4/cfdi40/'.$cfdi_uid.'/pdf',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'F-PLUGIN: 9d4095c8f7ed5785cb14c0e3b033eeb8252416ed',
        // 'F-Api-Key: JDJ5JDEwJERadzJSUjBGQ082OHE1MDBJb0RxZy43TmdndjFtYkM3MWYyMHdkLjJOU2ltYm5oUUhWTWVx',
        'F-Api-Key: JDJ5JDEwJHIxaUJGNGVyQlZsRXFuTFo5NzVjcE9BVFBFR095TFY5MkN1U0R4QmFDMS5qcTZuOGRpakNh',
        // 'F-Secret-Key: JDJ5JDEwJHRCbVZtRUVHVTlCeC9kbzZzQlNyTE80amRkNC83V0EwM1NnaDNLVjZVTVgzcnVDa0hWUU5D'
        'F-Secret-Key: JDJ5JDEwJFA2Sm1tR3VTd1RPd3ozZVVVdHAzMi5WZWU2QnVOZmlQSmpmR05ua0xoZzlvNW84Z1FrWUNt'
      ),
    ));

    $response = curl_exec($curl);
    header('Content-type: application/pdf');
    Header("Content-Disposition: inline; filename=$name_file");

    echo $response;

    curl_close($curl);
  }
}
