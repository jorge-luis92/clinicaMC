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
        Schema::create('stock_medicamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medicamento'); // FK
            $table->string('clave_med')->nullable();
            $table->integer('cantidad')->default(0);
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
        Schema::dropIfExists('stock_medicamento');
    }
};
