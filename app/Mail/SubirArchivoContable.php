<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubirArchivoContable extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $nombre_proyecto;
    public $diez_por;
    public $cuarenta_por;
    public $cincuenta_por;
    public $id_proyecto;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $nombre_proyecto
     * @param string $diez_por
     * @param string $cuarenta_por
     * @param string $cincuenta_por
     * @param string $id_proyecto
     * @return void
     */
    public function __construct($name, $nombre_proyecto, $diez_por, $cuarenta_por, $cincuenta_por, $id_proyecto)
    {
        $this->name = $name;
        $this->nombre_proyecto = $nombre_proyecto;
        $this->diez_por = $diez_por;
        $this->cuarenta_por = $cuarenta_por;
        $this->cincuenta_por = $cincuenta_por;
        $this->id_proyecto = $id_proyecto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notificaciones@clientes.ohffice.cl', 'Portal Ohffice')
            ->subject('Se ha cargado un Archivo en la Fase Contable de Tú Proyecto')
            ->view('frontend.mails.sube_archivo_conta');
    }
}
