<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaGeneral extends Model
{
    use HasFactory;

    protected  $table = 'consulta_general';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_paciente', 'temperatura', 'peso', 'talla', 'diagnostico',
    'id_tipoconsulta', 'id_usuario', 'id_medico', 'estatus', 'fecha', 'hora'];
}
