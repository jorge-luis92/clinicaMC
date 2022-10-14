<?php

use App\Http\Controllers\Consulta\ConsultaGeneralController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Usuario\UsuarioController;

/*use App\Http\Controllers\Facturacion\FacturacionController;*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
    
});

//Usuarios
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/Usuarios/Listado', [UsuarioController::class, 'index'])->name('listadoUsuario');
Route::post('Usuario/Registro', [UsuarioController::class, 'regUsuario'])->name('UsuarioRegistro');

//Consulta General
Route::get('/Consulta/ConsultaGeneral', [ConsultaGeneralController::class, 'index'])->name('consulta_general');
Route::post('Paciente/Registro', [ConsultaGeneralController::class, 'regPaciente'])->name('PacienteRegistro');
    /*Route::get('Usuario/Listado', [UsuarioController::class, 'index'])->name('UsuarioListado');
    Route::get('Usuario/verListado/{id}', [UsuarioController::class, 'ver']);
    Route::post('Usuario/Registro', [UsuarioController::class, 'regUsuario'])->name('UsuarioRegistro');*/

Auth::routes();
