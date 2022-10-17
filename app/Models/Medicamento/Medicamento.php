<?php

namespace App\Models\Medicamento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected  $table = 'medicamento';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'clave', 'nombre', 'descripcion', 'fecha_cad', 'lote', 'presentacion', 
    'costo_unitario', 'precio_venta', 'observaciones', 'id_usuario', 'activo', 'fecha', 'hora'];

}
