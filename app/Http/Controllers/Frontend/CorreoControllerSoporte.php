<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\MiCorreo;
use Illuminate\Support\Facades\Mail;

class CorreoControllerSoporte extends Controller
{
    public function EnviarCorreoSoporte(Request $request)
    {
        try {
            $nombre = $request->input('nombre');
            $mail = $request->input('mail');
            $empresa = $request->input('empresa');
            $asunto = $request->input('asunto');
            $mensaje = $request->input('mensaje');

            $mensajeCorreo = "Nombre: $nombre\nMail: $mail\nEmpresa: $empresa\nAsunto: $asunto\nMensaje: $mensaje";
            error_log($mensajeCorreo);

            foreach ($mail as $recipient) {
                error_log($recipient);
                Mail::to($recipient)->send(new MiCorreo($mensajeCorreo));
            }
            // Redirige de regreso con un mensaje de éxito
            return back()->with('success', 'Correo enviado con éxito');
        } catch (\Exception $e) {
            error_log($e->getMessage());

            // Redirige de regreso con un mensaje de error
            return back()->with('error', 'Ha ocurrido un error al enviar el correo.');
        }
    }
}
