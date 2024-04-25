<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;


class Facturacion extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'facturacion';


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'razon_social',
        'rut',
        'direccion',
        'nombre_contacto',
        'email',
        'giro',
        'direccion_despacho',
        'nombre_despacho',
        'telefono_despacho',
        'comentario',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}