<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected  $table = 'users';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'email', 'tipo_usuario', 'id_persona', 'activo', 'id_usuario',
     'fecha', 'hora', 'password'];
}
