<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificarTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $name_vendedor;
    public $email_vendedor;
    public $name_cliente;
    public $email_cliente;
    public $nombre_proyecto;
    public $tipo_usuario;
    public $id_proyecto;

    /**
     * Create a new message instance.
     *
     * @param string $name_vendedor
     * @param string $email_vendedor     
     * @param string $name_cliente
     * @param string $email_cliente
     * @param string $nombre_proyecto
     * @param string $tipo_usuario
     * @param string $id_proyecto
     * @return void
     */
    public function __construct($nombre_proyecto, $name_vendedor, $name_cliente, $tipo_usuario, $id_proyecto)
    {
        $this->name_vendedor = $name_vendedor;
        $this->name_cliente = $name_cliente;
        $this->nombre_proyecto = $nombre_proyecto;
        $this->tipo_usuario = $tipo_usuario;
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
            ->subject('Se ha generado una Solicitud en tu Proyecto')
            ->view('frontend.mails.notifica_ticket');
    }
}
