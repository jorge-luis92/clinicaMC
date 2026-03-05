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
        Schema::create('control_prenatal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente')->nullable(); // FK
            $table->unsignedBigInteger('id_paciente'); // FK
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK
            $table->unsignedBigInteger('id_medico'); // FK
            $table->string('registro')->nullable();
            $table->string('estatus')->nullable();
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
        Schema::dropIfExists('control_prenatal');
    }
};
