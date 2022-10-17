<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Consulta\ConsultaGeneralController;
use App\Http\Controllers\Consulta\PacienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Medicamento\MedicamentoController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'login'])->name('login');
Route::get('home', [HomeController::class, 'dashboard'])->name('principal');
Route::post('/logueo', [LoginController::class, 'authenticate'])->name('logueo');

//Usuarios
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/Catalogo/Usuarios', [UsuarioController::class, 'index'])->name('listadoUsuario');
Route::post('Usuario/Registro', [UsuarioController::class, 'regUsuario'])->name('UsuarioRegistro');

//Consulta General
Route::get('/Consulta/ConsultaGeneral', [ConsultaGeneralController::class, 'index'])->name('consulta_general');
Route::post('Paciente/Registro', [PacienteController::class, 'regPaciente'])->name('PacienteRegistro');
Route::get('/Catalogo/Pacientes', [PacienteController::class, 'index'])->name('listadoGeneral');
Route::get('/Catalogo/PacienteSel', [PacienteController::class, 'select_paciente']);
Route::get('Consulta/Paciente/{id}', [PacienteController::class, 'data_paciente']);
Route::post('ConsultaGneral/Create', [ConsultaGeneralController::class, 'create_consulta'])->name('consultaRegistro');
Route::get('ConsultaGeneralP/{id}', [ConsultaGeneralController::class, 'data_consultag']);
Route::post('ConsultaGneralEdit/Save', [ConsultaGeneralController::class, 'save_EditConsulta'])->name('reg_EditConsulta');
Route::get('/Expediente/ConsultaGeneral', [ConsultaGeneralController::class, 'expediente_CG'])->name('CGexpediente');
Route::get('/Expediente/CGver/{id}', [ConsultaGeneralController::class, 'expediente_CG_pa']);

//Medicamentos
Route::get('/Medicamentos/Inventario', [MedicamentoController::class, 'index'])->name('medicamento_inventario');
Route::post('Medicamentos/Create', [MedicamentoController::class, 'registerMedicamento'])->name('regMedicamento');

Auth::routes(["register" => false]);
