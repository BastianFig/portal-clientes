<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encuestum extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'encuesta';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'observacion',
        'created_at',
        'updated_at',
        'deleted_at',
        'empresa_id',
        'nombre_encuestado',
        'como_llegaste',
        'calificacion',
        'satisfaccion1',
        'satisfaccion2',
        'satisfaccion3',
        'satisfaccion4',
        'satisfaccion5',
        'satisfaccion6',
        'satisfaccion7',
        'rating',
        'mejorar_servicio',
        'autorizacion',
        'user_id',
        'proyecto_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}
