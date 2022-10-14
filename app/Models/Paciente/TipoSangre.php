<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSangre extends Model
{
    use HasFactory;

    protected  $table = 'tipo_sangre';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'tipo',];
}
