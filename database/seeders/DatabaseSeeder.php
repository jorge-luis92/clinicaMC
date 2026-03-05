<?php

namespace Database\Seeders;

use App\Models\Medico\Medico;
use App\Models\Persona\Persona;
use App\Models\Usuario\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear Tipos de Usuario (ID 1: Admin, ID 2: Médico)
        $idAdmin = DB::table('tipo_usuario')->insertGetId(['nombre' => 'Administrador']);
        $idMed   = DB::table('tipo_usuario')->insertGetId(['nombre' => 'Medico']);

        // --- USUARIO 1: MÉDICO (Dr. Jorge) ---
        $personaMed = Persona::create([
            'nombre'         => 'Orquídea Huri',
            'ap_paterno'     => 'Mora',
            'ap_materno'     => 'Carrera',
            'genero'         => 'M', // Masculino
            'id_usuario'     => 1,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro'  => date('H:i:s'),
        ]);

        // Registro en la tabla Medico (Obligatorio para tipo 2)
        Medico::create([
            'id_persona'   => $personaMed->id,
            'cedula'       => 'CED123456789',
            'celular'      => '9511234567',
            'especialidad' => 'Médico General - Pediatra',
            'id_usuario'   => 1,
            'fecha'        => date('Y-m-d'),
            'hora'         => date('H:i:s'),
        ]);

        Usuario::create([
            'name'         => 'huri.mora',
            'email'        => 'medico@sanagustin.com',
            'password'     => Hash::make('manga,987'),
            'tipo_usuario' => $idMed, // ID 2
            'id_persona'   => $personaMed->id,
            'activo'       => 1,
            'id_usuario'   => 1,
            'fecha'        => date('Y-m-d'),
            'hora'         => date('H:i:s'),
        ]);


        // --- USUARIO 2: ADMINISTRADOR ---
        $personaAdm = Persona::create([
            'nombre'         => 'Jorge',
            'ap_paterno'     => 'Hernández',
            'ap_materno'     => 'Velasco',
            'genero'         => 'H',
            'id_usuario'     => 1,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro'  => date('H:i:s'),
        ]);

        Usuario::create([
            'name'         => 'root',
            'email'        => 'admin@sanagustin.com',
            'password'     => Hash::make('manga,987'),
            'tipo_usuario' => $idAdmin, // ID 1
            'id_persona'   => $personaAdm->id,
            'activo'       => 1,
            'id_usuario'   => 1,
            'fecha'        => date('Y-m-d'),
            'hora'        => date('H:i:s'),
        ]);
    }
}
