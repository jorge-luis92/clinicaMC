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
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_medico');
            $table->date('fecha_proxima');
            $table->time('hora_proxima');
            $table->string('tipo', 50)->nullable();
            $table->char('estatus', 1)->default('1'); // 1 = Activa, 0 = Cancelada/Pasada
            $table->date('fecha');
            $table->time('hora');

            // Llaves foráneas para mantener integridad referencial
            $table->foreign('id_paciente')->references('id')->on('paciente')->onDelete('cascade');
            $table->foreign('id_medico')->references('id')->on('medico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cita');
    }
};
