<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaMedica extends Model
{
    use HasFactory;

    protected  $table = 'receta_medica';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_consulta', 'id_medicamento', 'cantidad', 'tratamiento', 
    'id_usuario', 'fecha', 'hora'];
}
