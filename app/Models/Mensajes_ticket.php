<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Mensajes_ticket extends Model
{
    use HasFactory;

    public $table = 'mensajes_ticket';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'sender_id',
        'ticket_id',
        'mensaje',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sender()
    {
        return $this->belongsto(User::class, 'sender_id',);
    }


}
