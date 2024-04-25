<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Fasecomercial extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'fasecomercials';

    protected $appends = [
        'cotizacion',
        'oc',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'comentarios',
        'estado',
        'id_proyecto_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'monto'
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

   /* public function getCotizacionAttribute()
    {
        return $this->getMedia('cotizacion')->last();
    }*/

    public function getOcAttribute()
    {
        return $this->getMedia('oc')->last();
    }

    public function id_proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto_id');
    }
    
     public function getCotizacionAttribute()
    {
        $files = $this->getMedia('cotizacion');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
