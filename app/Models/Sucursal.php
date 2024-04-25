<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'sucursals';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const COMUNA_SELECT = [
        'Maipú'    => 'Maipú',
        'Pudahuel' => 'Pudahuel',
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
        'nombre',
        'direccion_sucursal',
        'comuna',
        'region',
        'empresa_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sucursalProyectos()
    {
        return $this->hasMany(Proyecto::class, 'sucursal_id', 'id');
    }

    public function sucursalUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
