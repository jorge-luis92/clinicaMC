<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected  $table = 'persona';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id', 'nombre', 'ap_paterno', 'ap_materno', 'edad', 'genero', 'fecha_nacimiento',
        'id_usuario', 'fecha_registro', 'hora_registro'
    ];
}
