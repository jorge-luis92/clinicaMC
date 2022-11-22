<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaSeguimiento extends Model
{
    use HasFactory;

    protected  $table = 'receta_seguimiento';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_control', 'id_seguimiento', 'id_medicamento', 'cantidad', 'tratamiento', 
    'id_usuario', 'fecha', 'hora'];
}
