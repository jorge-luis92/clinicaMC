<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteInicio extends Model
{
    use HasFactory;

    protected  $table = 'expediente_inicio';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_expediente', 'id_control', 'id_paciente', 'fur', 
    'fpp', 'estudio_lab', 'estatus', 'fecha', 'hora'];
}
