<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecendenteGO extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_go';
    public $timestamps = false;

    protected $fillable = [
        'id_expediente',
        'id_paciente',
        'id_medico',
        'gesta',
        'parto',
        'cesarea',
        'aborto',
        'fecha',
        'hora'
    ];
}
