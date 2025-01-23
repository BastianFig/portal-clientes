<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsignarTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $id_ticket;

    /**
     * Create a new message instance.
     *
     * @param string $nombre
     * @param string $id_ticekt   
     * @return void
     */
    public function __construct($nombre, $id_ticket)
    {
        $this->nombre = $nombre;
        $this->id_ticket = $id_ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notificaciones@clientes.ohffice.cl', 'Portal Ohffice')
            ->subject('Se te ha asignado una Solicitud')
            ->view('frontend.mails.asigna_ticket');
    }
}
