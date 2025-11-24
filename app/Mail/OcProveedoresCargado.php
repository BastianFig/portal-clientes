<?php

namespace App\Mail;

use App\Models\Proyecto;
use App\Models\Fasefabrica;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OcProveedoresCargado extends Mailable
{
    use Queueable, SerializesModels;

    public $proyecto;
    public $faseFabricacion;

    public function __construct(Proyecto $proyecto, Fasefabrica $faseFabricacion)
    {
        $this->proyecto = $proyecto;
        $this->faseFabricacion = $faseFabricacion;
    }

    public function build()
    {
        return  $this->from('notificaciones@clientes.ohffice.cl', 'Portal Ohffice')
                ->subject('Carga de OC ILESA')
                ->view('admin.mails.oc_proveedores_cargado');
    }
}
