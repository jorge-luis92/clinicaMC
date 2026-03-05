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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Nativo de Laravel
            $table->string('password'); // Nativo de Laravel
            $table->rememberToken(); // Nativo de Laravel

            // Campos extra de tu modelo Usuario
            $table->unsignedBigInteger('tipo_usuario')->nullable(); // FK a tipo_usuario
            $table->unsignedBigInteger('id_persona')->nullable(); // FK a persona
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('id_usuario')->nullable(); // FK (por si alguien lo registró)
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
        Schema::dropIfExists('users');
    }
};
