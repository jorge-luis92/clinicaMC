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
        Schema::create('seguimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente')->nullable(); // FK
            $table->unsignedBigInteger('id_paciente'); // FK
            $table->unsignedBigInteger('id_medico'); // FK
            $table->text('exploracion_fisica')->nullable();
            $table->string('semana_gesta')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('ta')->nullable();
            $table->string('fondo_uterino')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('otro')->nullable();
            $table->string('estatus')->nullable();
            $table->text('padecimiento')->nullable();
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
        Schema::dropIfExists('seguimiento');
    }
};
