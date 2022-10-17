<?php

namespace App\Models\Medicamento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStock extends Model
{
    use HasFactory;

    protected  $table = 'log_stock';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_medicamento', 'id_stock', 'clave_med', 'cantidad', 'id_usuario', 'cantidad_anterior', 'fecha', 'hora'];
}
