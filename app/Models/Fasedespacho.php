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

class Fasedespacho extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'fasedespachos';

    protected $appends = [
        'guia_despacho',
        'galeria_estado_muebles',
    ];

    public const RECIBE_CONFORME_SELECT = [
        'si' => 'Sí',
        'no' => 'No',
    ];

    public const HORARIO_SELECT = [
        'AM' => 'AM',
        'PM' => 'PM',
    ];

    protected $dates = [
        'fecha_despacho',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ESTADO_INSTALACION_SELECT = [
        'Proceso'   => 'En proceso',
        'agendada'  => 'Agendada',
        'pendiente' => 'Pendiente',
        'Terminada' => 'Terminada'
    ];

    public const TOTAL_PARCIAL_SELECT = [
        'Total'   => 'Total',
        'Parcial' => 'Parcial'
    ];

    protected $fillable = [
        'fecha_despacho',
        'estado_instalacion',
        'comentario',
        'recibe_conforme',
        'id_proyecto_id',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'distribucion',
        'armado',
        'entrega_conforme',
        'carguio',
        'transporte',
        'entrega',
        'horario',
        'empresa_transporte',
        'nombre_conductor',
        'celular_conductor',
        'nombre_acompañantes',
        'total_parcial',
        'lotes',
        'confirma_horario',
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

    /*public function getGuiaDespachoAttribute()
    {
        return $this->getMedia('guia_despacho')->last();
    }*/

    public function getFechaDespachoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setFechaDespachoAttribute($value)
    {
        $this->attributes['fecha_despacho'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getGaleriaEstadoMueblesAttribute()
    {
        $files = $this->getMedia('galeria_estado_muebles');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
    
     public function getGuiaDespachoAttribute()
    {
        $files = $this->getMedia('guia_despacho');
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
