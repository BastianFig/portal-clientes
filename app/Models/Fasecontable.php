<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Fasecontable extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'fasecontables';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'anticipo_50',
        'anticipo_40',
        'anticipo_10',
    ];

    protected $fillable = [
        'comentario',
        'id_proyecto_id',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function getAnticipo50Attribute()
     {
        $files = $this->getMedia('anticipo_50');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getAnticipo40Attribute()
    {
        return $this->getMedia('anticipo_40')->last();
    }

    public function getAnticipo10Attribute()
    {
        return $this->getMedia('anticipo_10')->last();
    }

    public function id_proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto_id');
    }
}
