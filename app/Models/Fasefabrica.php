<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Fasefabrica extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'fasefabricas';

    protected $appends = [
        'oc_proveedores',
        'galeria_estado_entrega',
    ];

    public const APROBACION_COURSE_SELECT = [
        'si' => 'Sí',
        'no' => 'No',
    ];

    public const FASE = [
        'Ingenieria' => 'Ingenieria',
        'Produccion' => 'Produccion',
        'Embalaje' => 'Embalaje',
        'Listo para despacho' => 'Listo para despacho',
    ];

    protected $dates = [
       /* 'fecha_entrega',*/
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ESTADO_PRODUCCION_SELECT = [
        'Ingenieria' => 'Ingenieria',
        'Produccion' => 'Produccion',
        'Embalaje' => 'Embalaje',
        'Listo para despacho' => 'Listo para despacho',
    ];

    protected $fillable = [
        'aprobacion_course',
        'estado_produccion',
       /* 'fecha_entrega',*/
        'id_proyecto_id',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'fase',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getOcProveedoresAttribute()
    {
        return $this->getMedia('oc_proveedores');
    }

    public function getFechaEntregaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    // public function setFechaEntregaAttribute($value)
    // {
    //     $this->attributes['fecha_entrega'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function getGaleriaEstadoEntregaAttribute()
    {
        $files = $this->getMedia('galeria_estado_entrega');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function id_proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto_id');
    }
}
