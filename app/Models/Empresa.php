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

class Empresa extends Model implements HasMedia
{
    use SoftDeletes, HasFactory,InteractsWithMedia;

    public $table = 'empresas';

    protected $appends = [
        'logo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ANTIGUEDAD_EMPRESA = [
        'Nuevo'    => 'Nuevo',
        'Confiable' => 'Confiable',
        'Especial' => 'Especial',
    ];

    public const COMUNA_SELECT = [
        'Maipú'    => 'Maipú',
        'Pudahuel' => 'Pudahuel',
    ];
    
    public const TIPO_EMPRESA_SELECT = [
        'Mayorista'    => 'Mayorista',
        'Minorista' => 'Minorista',
    ];


    public const ESTADO_SELECT = [
        'activo'            => 'Activo',
        'moroso'            => 'Moroso',
        'pendiente de pago' => 'Pendiente de pago',
    ];

    public const REGION_SELECT = [
        'Región de Arica y Parinacota' => 'Región de Arica y Parinacota',
        'Región de Tarapacá' => 'Región de Tarapacá',
        'Región de Antofagasta' => 'Región de Antofagasta',
        'Región de Atacama' => 'Región de Atacama',
        'Región de Coquimbo' => 'Región de Coquimbo',
        'Región de Valparaíso' => 'Región de Valparaíso',
        "Región del Libertador Gral. Bernardo O'Higgins" => "Región del Libertador Gral. Bernardo O'Higgins",
        'Región del Maule' => 'Región del Maule',
        'Región del Biobío' => 'Región del Biobío',
        'Región de la Araucanía' => 'Región de la Araucanía',
        'Región de Los Ríos' => 'Región de Los Ríos',
        'Región de Los Lagos' => 'Región de Los Lagos',
        'Región Aisén del Gral. Carlos Ibáñez del Campo' => 'Región Aisén del Gral. Carlos Ibáñez del Campo',
        'Región de Magallanes y de la Antártica Chilena' => 'Región de Magallanes y de la Antártica Chilena',
        'Región Metropolitana de Santiago' => 'Región Metropolitana de Santiago',
    ];

    protected $fillable = [
        'direccion',
        'comuna',
        'region',
        'rut',
        'razon_social',
        'nombe_de_fantasia',
        'rubro',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'antiguedad_empresa',
        'tipo_empresa',
    ];


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }


    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function empresaSucursals()
    {
        return $this->hasMany(Sucursal::class, 'empresa_id', 'id');
    }

    public function empresaUsers()
    {
        return $this->hasMany(User::class, 'empresa_id', 'id');
    }

    public function idClienteProyectos()
    {
        return $this->hasMany(Proyecto::class, 'id_cliente_id', 'id');
    }
}
