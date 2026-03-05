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
        Schema::create('consulta_general', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente')->nullable(); // FK
            $table->unsignedBigInteger('id_paciente'); // FK
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->text('diagnostico')->nullable();
            $table->unsignedBigInteger('id_tipoconsulta')->nullable(); // FK
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK
            $table->unsignedBigInteger('id_medico'); // FK
            $table->string('estatus')->nullable();
            $table->text('motivo_consulta')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->string('ta')->nullable(); // Tensión Arterial
            $table->decimal('glucosa', 5, 2)->nullable();
            $table->text('procedimiento')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('consulta_general');
    }
};
