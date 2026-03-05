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
        Schema::create('receta_medica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_consulta'); // FK
            $table->unsignedBigInteger('id_medicamento'); // FK
            $table->integer('cantidad');
            $table->text('tratamiento');
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
        Schema::dropIfExists('receta_medica');
    }
};
