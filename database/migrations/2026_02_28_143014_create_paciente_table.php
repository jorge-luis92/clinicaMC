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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona'); // FK
            $table->unsignedBigInteger('id_tiposangre')->nullable(); // FK
            $table->string('talla')->nullable();
            $table->string('celular')->nullable();
            $table->string('contacto_emergencia')->nullable();
            $table->string('correo')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK

            // 👉 Nuevo campo para manejar la desactivación
            $table->boolean('activo')->default(true);

            $table->date('fecha_registro')->nullable();
            $table->time('hora_registro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente');
    }
};
