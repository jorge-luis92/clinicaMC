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
        Schema::create('antecedentes_go', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_medico');

            // Usamos integer para números de embarazos, partos, etc.
            $table->integer('gesta')->default(0);
            $table->integer('parto')->default(0);
            $table->integer('cesarea')->default(0);
            $table->integer('aborto')->default(0);

            $table->date('fecha');
            $table->time('hora');

            // Llaves foráneas
            $table->foreign('id_paciente')->references('id')->on('paciente')->onDelete('cascade');
            $table->foreign('id_medico')->references('id')->on('medico')->onDelete('cascade');
            // Nota: Si tu tabla de expedientes se llama diferente, ajusta el "on('expediente_cp')" 
            // $table->foreign('id_expediente')->references('id')->on('expediente_cp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antecedentes_go');
    }
};
