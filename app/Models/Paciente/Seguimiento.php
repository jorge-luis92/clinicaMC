<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    use HasFactory;

    protected  $table = 'seguimiento';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_expediente', 'id_paciente', 'id_medico', 'exploracion_fisica', 'semana_gesta', 'peso', 'ta', 'fondo_uterino', 
    'presentacion', 'frecuencia_cardiaca', 'otro', 'estatus', 'padecimiento', 'procedimiento', 'observaciones', 'fecha', 'hora'];
}
