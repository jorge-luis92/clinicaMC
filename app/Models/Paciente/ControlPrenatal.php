<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPrenatal extends Model
{
    use HasFactory;

    protected  $table = 'control_prenatal';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_expediente', 'id_paciente', 'id_usuario', 'id_medico', 'registro', 'estatus', 'observaciones', 'fecha', 'hora'];
}
