<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected  $table = 'paciente';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_persona', 'id_tiposangre', 'celular', 'contacto_emergencia', 
    'correo', 'id_usuario', 'fecha_registro', 'hora_registro'];
}
