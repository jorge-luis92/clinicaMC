<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Consulta\PacienteController;
use App\Http\Controllers\Consulta\ConsultaGeneralController;
use App\Http\Controllers\Consulta\ControlPrenatalController;
use App\Http\Controllers\Consulta\CitaController;
use App\Http\Controllers\Medicamento\MedicamentoController;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Administrador;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTAS PÚBLICAS Y DE AUTENTICACIÓN
// ==========================================
Route::get('/', [HomeController::class, 'login'])->name('login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('principal');
Route::post('/logueo', [LoginController::class, 'authenticate'])->name('logueo');

Auth::routes([
    "login" => false,
    "register" => true
]);

// ==========================================
// RUTAS PROTEGIDAS (ADMINISTRADOR)
// ==========================================
Route::middleware([Administrador::class])->group(function () {

    // ----- USUARIOS -----
    Route::controller(UsuarioController::class)->prefix('usuarios')->group(function () {
        Route::get('/', 'index')->name('listadoUsuario');
        Route::post('/registro', 'regUsuario')->name('UsuarioRegistro');
    });

    // ----- PACIENTES -----
    Route::controller(PacienteController::class)->prefix('pacientes')->group(function () {
        Route::get('/', 'index')->name('listadoGeneral');
        Route::get('/seleccion', 'select_paciente');
        Route::get('/consulta/{id}', 'data_paciente');
        Route::get('/consulta-2/{id}', 'data_paciente2');
        Route::post('/registro', 'regPaciente')->name('PacienteRegistro');
        Route::post('/registro-2', 'regPaciente2')->name('PacienteRegistro2');
        Route::put('/editar', 'editPaciente')->name('PacienteEditar'); // Cambiado a PUT
    });

    // ----- CONSULTA GENERAL -----
    Route::controller(ConsultaGeneralController::class)->prefix('consulta-general')->group(function () {
        // Vistas y datos (GET)
        Route::get('/', 'index')->name('consulta_general');
        Route::get('/paciente-data/{id}', 'data_consultag');
        Route::get('/expediente', 'expediente_CG')->name('CGexpediente');
        Route::get('/expediente/ver/{id}/{id2}', 'expediente_CG_pa');
        Route::get('/vista-previa/{id}', 'vistapreviaC');
        Route::get('/data/{id}', 'verDataCon');
        Route::get('/paciente/{id}', 'verDataPac');
        Route::get('/expediente/seleccion-paciente', 'expediente_selPaciente');
        Route::get('/expediente-data/{id}/{id2}', 'verDataConExp');
        Route::get('/check-expediente/{id}', 'check_expediente');
        Route::get('/pdf/{id}', 'vista_pdf');
        Route::get('/receta-medica/select/{id}', 'med_pacienteRec');

        // Creación (POST)
        Route::post('/crear', 'create_consulta')->name('consultaRegistro');
        Route::post('/crear-expediente', 'create_expediente')->name('expRegistro');
        Route::post('/crear-cita', 'create_consulta_cita')->name('consultaRegistrocita');
        Route::post('/crear-cita-2', 'create_consulta_cita2')->name('consultaRegistrocita2');
        Route::post('/finalizar', 'end_consultaGeneral')->name('end_consultaG');
        Route::post('/enviar-email', 'enviarPdfcg')->name('en_pdfcg');

        // Edición y Eliminación (PUT / DELETE)
        Route::put('/editar', 'save_EditConsulta')->name('reg_EditConsulta');
        Route::delete('/borrar-medicamento/{id}', 'delete_medicamento');
    });

    // ----- MEDICAMENTOS -----
    Route::controller(MedicamentoController::class)->prefix('medicamentos')->group(function () {
        Route::get('/inventario', 'index')->name('medicamento_inventario');
        Route::get('/data', 'data_medicamentos');
        Route::get('/seleccion/{id}', 'med_select');
        Route::post('/crear', 'registerMedicamento')->name('regMedicamento');
        Route::post('/receta-medica', 'regMed_RecetaM')->name('med_RecetaMedica');
        Route::post('/receta-medica-seg', 'regMed_RecetaSeg')->name('med_RecetaMedicaSeg');
    });

    // ----- CONTROL PRENATAL (EMBARAZADAS) -----
    Route::controller(ControlPrenatalController::class)->prefix('control-prenatal')->group(function () {
        // Vistas y datos (GET)
        Route::get('/embarazadas', 'index')->name('consulta_embarazadas');
        Route::get('/catalogo', 'select_embarazada');
        Route::get('/data-ant/{id}', 'data_ant');
        Route::get('/data-ant-dos/{id}', 'data_antdos');
        Route::get('/expediente', 'index_expCP');
        Route::get('/expediente-d', 'index_expCPd');
        Route::get('/expediente-final', 'index_exp');
        Route::get('/expediente/ver/{id}', 'expediente_CE_pa');
        Route::get('/data-existe/{id}', 'data_existe');
        Route::get('/data-ante/{id}', 'data_ante');
        Route::get('/expediente-existe/{id}', 'expediente_existe');
        Route::get('/exp-emb/{id}', 'data_expEmb');
        Route::get('/calculo-fpp/{id}', 'calcular_fpp');
        Route::get('/calculo-nacido/{id}', 'consulta_fechapp');
        Route::get('/seguimiento/detalles/{id}', 'detalles_seguimiento');
        Route::get('/receta/select-seg/{id}/{id2}', 'med_pacienteRecSeg');
        Route::get('/check-expediente/{id}', 'check_expediente_cp');
        Route::get('/seguimiento-pdf/{id}', 'pdf_cp');
        // Ojo: Si "finalizar_seguimiento" altera datos en la BD, debería ser POST o PUT, lo mantuve GET asumiendo que muestra una vista previa.
        Route::get('/finalizar/{id}', 'finalizar_seguimiento');

        // Creación (POST)
        Route::post('/registro', 'regExp')->name('regExpedienteEm');
        Route::post('/registro-con', 'regConEmb')->name('regConEmm');
        Route::post('/registro-control', 'regControl')->name('regExpedienteEmdos');
        Route::post('/finalizar-cp', 'endCP')->name('end_expCP');
        Route::post('/confirmar-cita', 'confirmar_cp')->name('confirmar_cp_cita');
        Route::post('/finalizar-control', 'end_seguimiento')->name('finalizar_seguimientoCP');

        // Edición y Eliminación (PUT / DELETE)
        Route::put('/editar-ago', 'edit_antgo')->name('antgo_edit');
        Route::delete('/borrar-medicamento/{id}', 'delete_medicamentoSeg');
    });

    // ----- CITAS -----
    Route::controller(CitaController::class)->prefix('citas')->group(function () {
        Route::get('/', 'index')->name('citas');
        Route::get('/paciente-sel', 'sepaciente_cita');
        Route::post('/registro', 'reg_Cita')->name('create_cita');
        Route::post('/registro-e', 'reg_CitaE')->name('create_citaE');
    });

    // ----- MISCELÁNEOS / HERRAMIENTAS -----
    Route::get('/enviar-mensaje', [Controller::class, 'enviarMensaje']);
});

// ==========================================
// RUTAS FUERA DEL MIDDLEWARE (CRON / SCRIPTS)
// ==========================================
Route::controller(Controller::class)->group(function () {
    Route::get('/scripts/run-citas', 'run_script');
    Route::get('/scripts/run-depurar', 'run_depurar');
});
