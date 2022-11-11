<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteCG extends Model
{
    use HasFactory;

    protected  $table = 'expediente_cg';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_paciente', 'id_medico', 'fecha', 'hora'];
}
