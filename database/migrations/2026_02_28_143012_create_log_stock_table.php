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
        Schema::create('log_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medicamento'); // FK
            $table->unsignedBigInteger('id_stock'); // FK
            $table->string('clave_med')->nullable();
            $table->integer('cantidad');
            $table->integer('cantidad_anterior')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK
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
        Schema::dropIfExists('log_stock');
    }
};
