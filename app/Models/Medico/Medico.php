<?php

namespace App\Models\Medico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected  $table = 'medico';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_persona', 'cedula', 'celular', 'tipo_medico', 'id_usuario', 'fecha', 'hora'];
}
