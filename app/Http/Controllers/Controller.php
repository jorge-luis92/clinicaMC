<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Monolog\Handler\TelegramBotHandler;
use Telegram\Bot\Laravel\Facades\Telegram;

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
}
