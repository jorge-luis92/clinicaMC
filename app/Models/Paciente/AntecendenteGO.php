<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecendenteGO extends Model
{
    use HasFactory;

    protected  $table = 'antecedentes_go';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_expediente', 'id_paciente', 'gesta', 'parto', 'cesarea', 'aborto', 'fecha', 'hora'];
}
