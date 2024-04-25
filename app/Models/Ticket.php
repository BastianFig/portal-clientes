<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'tickets';

    public const ESTADO_SELECT = [
        'Activo'     => 'Activo',
        'Finalizado' => 'Finalizado',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'proyecto_id',
        'asunto',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'vendedor_id',
        'estado',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function users()
    {
        return $this->belongsto(User::class, 'user_id');
    }
    public function vendedor()
    {
        return $this->belongsto(User::class, 'vendedor_id',);
    }
    public function mensaje()
    {
        return $this->hasMany(Mensajes_ticket::class, 'ticket_id',)->with('sender');
    }
}
