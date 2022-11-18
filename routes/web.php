<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Consulta\CitaController;
use App\Http\Controllers\Consulta\ConsultaGeneralController;
use App\Http\Controllers\Consulta\ControlPrenatalController;
use App\Http\Controllers\Consulta\PacienteController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Medicamento\MedicamentoController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Middleware\Administrador;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\TelegramBotHandler;

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
Route::middleware([Administrador::class])->group(function () 
{
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
Route::get('/Expediente/CGver/{id}/{id2}', [ConsultaGeneralController::class, 'expediente_CG_pa']);
Route::get('ConsultaGneralEdit/Vistaprevia/{id}', [ConsultaGeneralController::class, 'vistapreviaC']);
Route::get('/ConsultaGeneral/CGData/{id}', [ConsultaGeneralController::class, 'verDataCon']);
Route::get('/ConsultaGeneral/CGPaciente/{id}', [ConsultaGeneralController::class, 'verDataPac']);
Route::post('ConsultaGeneral/End', [ConsultaGeneralController::class, 'end_consultaGeneral'])->name('end_consultaG');
Route::post('ConsultaGeneral/Semail', [ConsultaGeneralController::class, 'enviarPdfcg'])->name('en_pdfcg');
Route::post('ConsultaGeneral/CreateExp', [ConsultaGeneralController::class, 'create_expediente'])->name('expRegistro');
Route::get('/Expediente/ConsultaGeneralSelPaciente', [ConsultaGeneralController::class, 'expediente_selPaciente']);
Route::get('/ConsultaGeneral/CGDataExp/{id}/{id2}', [ConsultaGeneralController::class, 'verDataConExp']);

//Medicamentos
Route::get('/Medicamentos/Inventario', [MedicamentoController::class, 'index'])->name('medicamento_inventario');
Route::post('Medicamentos/Create', [MedicamentoController::class, 'registerMedicamento'])->name('regMedicamento');
Route::get('/Medicamentos/DataMedicamentos', [MedicamentoController::class, 'data_medicamentos']);
Route::get('MedicamentoSeleccionado/{id}', [MedicamentoController::class, 'med_select']);
Route::post('Medicamentos/RecetaMedica', [MedicamentoController::class, 'regMed_RecetaM'])->name('med_RecetaMedica');
Route::get('/RecetaMedica/Select/{id}', [ConsultaGeneralController::class, 'med_pacienteRec']);

//Consulta Embarazadas
Route::get('/Consulta/Embarazadas', [ControlPrenatalController::class, 'index'])->name('consulta_embarazadas');
Route::get('/Catalogo/ControlP', [ControlPrenatalController::class, 'select_embarazada']);
Route::post('ControlP/Registro', [ControlPrenatalController::class, 'regExp'])->name('regExpedienteEm');
Route::get('/ControlP/DataAnt/{id}', [ControlPrenatalController::class, 'data_ant']);
Route::get('/ControlP/DataAntD/{id}', [ControlPrenatalController::class, 'data_antdos']);
Route::get('/Expediente/CEmver/{id}', [ControlPrenatalController::class, 'expediente_CE_pa']);
Route::post('ControlP/RegistroCon', [ControlPrenatalController::class, 'regConEmb'])->name('regConEmm');
Route::get('/ControlP/DataExiste/{id}', [ControlPrenatalController::class, 'data_existe']);
Route::get('/ControlP/DataAnte/{id}', [ControlPrenatalController::class, 'data_ante']);
Route::get('/Expediente/ControlPrenatal', [ControlPrenatalController::class, 'index_expCP']);
Route::post('ControlP/End', [ControlPrenatalController::class, 'endCP'])->name('end_expCP');
Route::get('/ControlP/ExpedienteExiste/{id}', [ControlPrenatalController::class, 'expediente_existe']);
Route::post('ControlP/EditAGO', [ControlPrenatalController::class, 'edit_antgo'])->name('antgo_edit');
Route::get('/Expediente/ControlPrenatald', [ControlPrenatalController::class, 'index_expCPd']);
Route::post('ControlP/RegistroControl', [ControlPrenatalController::class, 'regControl'])->name('regExpedienteEmdos');
Route::get('/ControlP/Calculofpp/{id}', [ControlPrenatalController::class, 'calcular_fpp']);


//Citas
Route::get('/Citas', [CitaController::class, 'index'])->name('citas');
Route::post('ConsultaGeneral/Cita', [CitaController::class, 'reg_Cita'])->name('create_cita');
Route::post('ConsultaGeneral/CitaE', [CitaController::class, 'reg_CitaE'])->name('create_citaE');
Route::get('/Cita/PacienteSel', [CitaController::class, 'sepaciente_cita']);

Route::get('/Enviar', [Controller::class, 'enviarMensaje']);
});

Route::get('/runCitas', [Controller::class, 'run_script']);
Auth::routes(["register" => false]);
