<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FasePostventum extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'fase_postventa';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ESTADO_SELECT = [
        'En Proceso' => 'En Proceso',
        'Finalizada' => 'Finalizada',
    ];
    protected $fillable = [
        'encuesta_id',
        'ticket_id',
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

    public function encuesta()
    {
        return $this->belongsTo(Encuestum::class, 'encuesta_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function id_proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto_id');
    }

    public function id_usuarios()
    {
        return $this->belongsToMany(User::class);
    }
}
