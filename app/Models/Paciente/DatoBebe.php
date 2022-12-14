<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoBebe extends Model
{
    use HasFactory;

    protected  $table = 'datos_bebe';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_paciente', 'id_expediente' , 'id_control', 'fecha_nacimiento', 'nacio', 'peso',
     'talla', 'fecha', 'hora'];
}
