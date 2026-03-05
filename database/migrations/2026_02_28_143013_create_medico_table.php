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
        Schema::create('medico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona'); // FK
            $table->string('cedula')->nullable();
            $table->string('celular')->nullable();
            $table->string('tipo_medico')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('institutos')->nullable();
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
        Schema::dropIfExists('medico');
    }
};
