<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MiCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;


    /**
     * Create a new message instance.
     *@param string $mensaje 
     * @return void
     */
    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.mails.notificaSoporte', ['mensaje' => $this->mensaje])
            ->subject('Solicitud de soporte');
    }
}
