<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita';
    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'id_medico',
        'fecha_proxima',
        'hora_proxima',
        'tipo',
        'estatus',
        'fecha',
        'hora'
    ];
}
