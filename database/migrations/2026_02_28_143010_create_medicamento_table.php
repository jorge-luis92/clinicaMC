<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamento', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->nullable();
            $table->string('sustancia')->nullable();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha_cad')->nullable();
            $table->string('lote')->nullable();
            $table->string('presentacion')->nullable();
            $table->decimal('costo_unitario', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK
            $table->boolean('activo')->default(true);
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicamento');
    }
};
