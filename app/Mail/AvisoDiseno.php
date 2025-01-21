<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoDiseno extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $nombre_proyecto;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $id_proyecto
     * @param string $nombre_proyecto
     * @return void
     */
    public function __construct($name, $id_proyecto, $nombre_proyecto)
    {
        $this->name = $name;
        $this->nombre_proyecto = $nombre_proyecto;
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
            ->subject('Se te ha asignado un proyecto')
            ->view('admin.mails.avisa_diseno');
    }
}