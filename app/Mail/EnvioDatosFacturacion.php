<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioDatosFacturacion extends Mailable
{
    use Queueable, SerializesModels;

    public $razon_social;
    public $rut;
    public $giro;
    public $direccion;
    public $email;
    public $nombre_contacto;
    public $direccion_despacho;
    public $nombre_despacho;
    public $telefono_despacho;
    public $nombre_proyecto;

    /**
     * Create a new message instance.
     *
     * @param string $razon_social
     * @param string $rut
     * @param string $giro
     * @param string $direccion
     * @param string $email
     * @param string $nombre_contacto
     * @param string $direccion_despacho
     * @param string $nombre_despacho
     * @param string $telefono_despacho
     * @param string $nombre_proyecto
     * @return void
     */
    public function __construct($razon_social, $rut, $giro, $direccion, $email, $nombre_contacto, $direccion_despacho, $nombre_despacho, $telefono_despacho, $nombre_proyecto)
    {
        $this->razon_social = $razon_social;
        $this->rut = $rut;
        $this->giro = $giro;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->nombre_contacto = $nombre_contacto;
        $this->direccion_despacho = $direccion_despacho;
        $this->nombre_despacho = $nombre_despacho;
        $this->telefono_despacho = $telefono_despacho;
        $this->nombre_proyecto = $nombre_proyecto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notificaciones@clientes.ohffice.cl', 'Portal Ohffice')
            ->subject('Envío de Datos de Facturación')
            ->view('frontend.mails.envio_datos_facturacion');
    }
}