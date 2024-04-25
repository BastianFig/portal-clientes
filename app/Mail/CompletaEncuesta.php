<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompletaEncuesta extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $nombre_proyecto;
    public $id_proyecto;
    public $encuestaId;


    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email     
     * @param string $nombre_proyecto
     * @param string $id_proyecto
     * @param string $encuestaId
     * @return void
     */
    public function __construct($nombre_proyecto, $name, $id_proyecto, $encuestaId)
    {
        $this->name = $name;
        $this->nombre_proyecto = $nombre_proyecto;
        $this->id_proyecto = $id_proyecto;
        $this->encuestaId = $encuestaId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notificaciones@clientes.ohffice.cl', 'Portal Ohffice')
            ->subject('Se ha completado la Encuesta')
            ->view('frontend.mails.completa_encuesta');
    }
}
