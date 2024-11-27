<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Proyecto extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia;

    public $table = 'proyectos';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id_cliente_id',
        'sucursal_id',
        'tipo_proyecto',
        'categoria_proyecto',
        'estado',
        'fase',
        'nombre_proyecto',
        'created_at',
        'updated_at',
        'deleted_at',
        'id_fasediseno',
        'id_vendedor',
        'encuesta_id',
        'disenador',
        'instalador'
    ];

    // Registra las colecciones de medios
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cotizacion')->useDisk('public');  // Usar el disco 'public' para almacenar los archivos
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function id_cliente()
    {
        return $this->belongsTo(Empresa::class, 'id_cliente_id');
    }

    public function id_usuarios_clientes()
    {
        return $this->belongsToMany(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function fasediseno()
    {
        return $this->belongsTo(FaseDiseno::class, 'id_fasediseno');
    }

    public function fasecomercial()
    {
        return $this->belongsTo(Fasecomercial::class, 'id_fasecomercial');
    }

    public function carpetacliente()
    {
        return $this->belongsTo(Carpetacliente::class, 'id_carpetacliente');
    }

    public function fasecomercialproyecto()
    {
        return $this->belongsTo(Fasecomercialproyecto::class, 'id_fasecomercialproyectos');
    }

    public function fasecontable()
    {
        return $this->belongsTo(Fasecontable::class, 'id_fasecontables');
    }

    public function fasedespacho()
    {
        return $this->belongsTo(Fasedespacho::class, 'id_fasedespachos');
    }

    public function fasefabrica()
    {
        return $this->belongsTo(Fasefabrica::class, 'id_fasefabricas');
    }

    public function fasepostventa()
    {
        return $this->belongsTo(FasePostventum::class, 'id_fasepostventa');
    }

    public function facturacion()
    {
        return $this->belongsTo(Facturacion::class, 'facturacion_id');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuestum::class, 'encuesta_id');
    }
}
