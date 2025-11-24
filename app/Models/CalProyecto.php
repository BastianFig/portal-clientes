<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalProyecto extends Model
{
    protected $connection = 'ohffice';
    protected $table = 'CalProyectos';
    protected $primaryKey = 'Id';
    
    public $timestamps = false; 
    
    protected $fillable = [
        'c_nventa',
        'c_porcentaje_Ent',
        'C_estado',
        'c_ccosto',
        'c_fechanv',
        'c_fechaEntrega',
        'c_fecha_modificada',
        'c_rut',
        'c_cliente',
        'c_descripcion',
        'c_ejecutivo',
        'c_OCIlesa',
        'c_filesa',
        'c_OCInter',
        'c_fInter',
        'c_Otro',
        'c_fotro',
        'c_OCSil',
        'c_fsilla',
        'C_Otro2',
        'c_fadic',
        'c_OBS',
        'c_Adjunto',
        'c_rutaad',
        'c_pendiente',
        'c_argumento',
        'c_causa',
        'c_OBSOC',
        'c_obs_problema',
        'c_obs_tproblema',
        'c_ot',
    ];

    protected $casts = [
        'c_fechanv' => 'date',
        'c_fechaEntrega' => 'date',
        'c_fecha_modificada' => 'datetime',
        'c_filesa' => 'date',
        'c_fInter' => 'date',
        'c_fotro' => 'date',
        'c_fsilla' => 'date',
        'c_fadic' => 'date',
        'c_porcentaje_Ent' => 'decimal:2',
    ];
}