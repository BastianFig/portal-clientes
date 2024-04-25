<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CambioDeFase extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $nombre_proyecto;
    public $fase_anterior;
    public $fase_actual;
    public $id_proyecto;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $nombre_proyecto
     * @param string $fase_anterior
     * @param string $fase_actual
     * @param string $id_proyecto
     * @return void
     */
    public function __construct($name, $nombre_proyecto, $fase_anterior, $fase_actual, $id_proyecto)
    {
        $this->name = $name;
        $this->nombre_proyecto = $nombre_proyecto;
        $this->fase_anterior = $fase_anterior;
        $this->fase_actual = $fase_actual;
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
            ->subject('Cambio de Fase de tú Proyecto')
            ->view('admin.mails.cambia_fase');
    }
}