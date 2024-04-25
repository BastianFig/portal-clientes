<?php

namespace App\Models;

use DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Fasecomercialproyecto extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    protected $appends = [
        'nota_venta',
        'facturas',
        'credito',
    ];

    public $table = 'fasecomercialproyectos';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'fecha_despacho',
    ];

    public const TIPO_PROYECTO_SELECT = [
        'Sillas'    => 'Sillas',
        'Fábrica' => 'Fábrica',
        'Sillas y Fábrica' => 'Sillas y Fábrica',
    ];

    protected $fillable = [
        'id_proyecto_id',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'fecha_despacho',
        'tipo_proyecto',
        'monto_mobiliario',
        'acepta',
        'firma'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFechaDespachoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setFechaDespachoAttribute($value)
    {
        $this->attributes['fecha_despacho'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function idFaseComercialCarpetaclientes()
    {
        return $this->hasMany(Carpetacliente::class, 'id_fase_comercial_id', 'id');
    }

    public function getNotaVentaAttribute()
    {
        return $this->getMedia('nota_venta')->last();
    }

    public function getFacturasAttribute()
    {
        $files = $this->getMedia('facturas');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getCreditoAttribute()
    {
        return $this->getMedia('credito')->last();
    }


    public function id_proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto_id');
    }
}
