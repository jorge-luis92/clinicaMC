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
        Schema::create('datos_bebe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente'); // FK
            $table->unsignedBigInteger('id_expediente')->nullable(); // FK
            $table->unsignedBigInteger('id_control')->nullable(); // FK
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nacio')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('talla')->nullable();
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
        Schema::dropIfExists('datos_bebe');
    }
};
