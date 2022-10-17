<?php

namespace App\Models\Medicamento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMedicamento extends Model
{
    use HasFactory;

    protected  $table = 'stock_medicamento';
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'id_medicamento', 'clave_med', 'cantidad', 'activo', 'fecha', 'hora'];

}
