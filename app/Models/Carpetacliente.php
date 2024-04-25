<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Carpetacliente extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'carpetaclientes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id_fase_comercial_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'presupuesto',
        'plano',
        'fftt',
        'presentacion',
        'rectificacion',
        'nb',
        'course',
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

    public function getPresupuestoAttribute()
    {
        return $this->getMedia('presupuesto')->last();
    }

    public function getPlanoAttribute()
    {
        return $this->getMedia('plano');
    }

    public function getFfttAttribute()
    {
        return $this->getMedia('fftt');
    }

    public function getPresentacionAttribute()
    {
        return $this->getMedia('presentacion');
    }

    public function getRectificacionAttribute()
    {
        return $this->getMedia('rectificacion')->last();
    }

    public function getNbAttribute()
    {
        return $this->getMedia('nb')->last();
    }

    public function getCourseAttribute()
    {
        return $this->getMedia('course')->last();
    }

    public function id_fase_comercial()
    {
        return $this->belongsTo(Fasecomercialproyecto::class, 'id_fase_comercial_id');
    }
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id', 'id_carpetacliente');
    }
}
