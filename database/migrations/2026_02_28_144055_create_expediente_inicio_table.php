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
        Schema::create('expediente_inicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente')->nullable(); // FK
            $table->unsignedBigInteger('id_control')->nullable(); // FK
            $table->unsignedBigInteger('id_paciente'); // FK
            $table->date('fur')->nullable(); // Fecha de última regla
            $table->date('fpp')->nullable(); // Fecha probable de parto
            $table->text('estudio_lab')->nullable();
            $table->string('estatus')->nullable();
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
        Schema::dropIfExists('expediente_inicio');
    }
};
