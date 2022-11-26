@extends('layouts.menu')
@section('title')
: Citas
@endsection
@section('content')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" defer></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />

<style>
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 29px;
    }

    html body .content .content-wrapper {
        padding: 0.5rem 2rem 0;
    }
</style>
<div class="container-fluid">
    @if(session('Ok2'))
    <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Excelente!</strong> {{session('Ok2')}}
    </div>
    @endif

    @if(session('Error2'))
    <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Error!</strong> {{session('Error2')}}
    </div>
    @endif

    <div id="errorRazon" style="display:none" class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Error!</strong> <span id="error1"></span>
    </div>

    <div id="ok" style="display:none" class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Excelente!</strong> <span id="ok1"></span>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th align="left" style="text-align:left; padding: 3px">
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="crear_cita" style="color: white" role="button">
                                                <i class="fas fa-plus-circle"></i> Crear Cita
                                            </a>
                                        </th>
                                        <th align="center" style="text-align:center; padding: 3px">
                                        </th>
                                        <th align="right" style="text-align:right; padding: 3px">
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="agregar_paciente" style="color: white" role="button">
                                                <i class="fas fa-user"></i> Agregar Paciente
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <table id="cita_tables" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Paciente</th>
                                        <th>Tipo</th>
                                        <th>Fecha - Hora</th>
                                        <th>Estatus</th>
                                        <th width="15%">Acci&oacute;n</th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="altaPacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-user-plus"></i> Agregar Paciente
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaPaciente">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_paciente" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-4">
                                            <label>Nombre(s) </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Nombre(s)" id="nombre" name="nombre" onKeyUp="this.value = this.value.toUpperCase();" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Apellido paterno </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Apellido paterno" id="ap_pat" name="ap_pat" onKeyUp="this.value = this.value.toUpperCase();" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Apellido materno </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Apellido materno" id="ap_mat" name="ap_mat" onKeyUp="this.value = this.value.toUpperCase();" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Fecha de Nacimiento </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Edad </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Edad" id="edad" name="edad" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-sort"></i>
                                                </div>
                                                <span style="color: black;" id="meses"> </span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Tipo Sangre</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <select class="select2 form-control" id="tipo_sangre" name="tipo_sangre" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>G&eacute;nero</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <select class="select2 form-control" id="genero" name="genero" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value="M">Femenino</option>
                                                    <option value="H">Masculino</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Talla </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Talla Paciente CM" id="talla" name="talla" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-text-height'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-user-check"></i> Datos de Contacto</h4>
                                        </div>

                                        <div class="col-4">
                                            <label>Celular </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Celular - WhatsApp" id="celular" name="celular" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-lock"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Correo </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="email" placeholder="Correo Electrónico" id="email" name="email" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-lock"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Contacto Emergencia </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Contacto de Emergencia" id="contacto_emergencia" name="contacto_emergencia" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-lock"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                </form>

                <div class="col-12">
                    <div class="modal-footer">
                        <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                            <i class="fas fa-ban"></i> Salir
                        </a>
                        <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                        <input type="hidden" id="hidden_id" name="hidden_id">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="registrar_paciente" id="registrar_paciente" role="button">
                            <i class="fas fa-share"></i> Registrar
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="verPacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-plus"></i> Seleccionar Paciente
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response" role="alert" style="display:none">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive-lg">
                                                        <table id="pacientes_tables2" class="table table-responsive-lg table-bordered table-striped" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th style="width: 100%;">Nombre</th>
                                                                    <th>Fecha Nacimiento</th>
                                                                    <th width="10%">Acci&oacute;n</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="modal-footer">
                                                <!--<a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                                    <i class="fas fa-ban"></i> Cancelar
                                                </a>-->
                                                <a href="#" id="cerrar_salir" class="btn btn-info btn-min-width btn-glow" style="color: white" role="button">
                                                    <i class="fas fa-ban"></i> Salir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="citaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class='fa fa-arrow-right'></i> Generar Cita
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="altaCitaForm" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_cita" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_cita" name="nombre_cita" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Fecha Agendar</label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_agenda" name="fecha_agenda" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Hora Agendar</label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="time" id="hora_agenda" name="hora_agenda" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Tipo de Consulta</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class='fa fa-plus'></i>
                                                </div>
                                                <select class="select2 form-control" id="control" name="control" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value="General">General</option>
                                                    <option value="Control">Control Prenatal</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer">
                            <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                <i class="fas fa-ban"></i> Salir
                            </a>
                            <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                            <input type="hidden" id="id_hidden_cita" name="id_hidden_cita">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="agen_cita" id="agen_cita" role="button">
                                <i class="fas fa-share"></i> Crear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="consultaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-check"></i> Creaci&oacute;n Consulta
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="altaConsultaCrd" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_consulta_cita" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_select_cita" name="nombre_select" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Tipo de Consulta</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <select class="select2 form-control" id="tipo_consulta_cita" name="tipo_consulta_cita" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    @foreach($tipoC as $x)
                                                    <option value="{{ $x->id }}">{{ $x->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer">
                            <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
                            <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                            <input type="hidden" id="id_hidden_paciente_cita" name="id_hidden_paciente_cita">
                            <input type="hidden" id="id_hidden_id_cita" name="id_hidden_id_cita">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="crear_consulta" id="crear_consulta" role="button">
                                <i class="fas fa-share"></i> Crear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="consultaModal2" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-check"></i> Creaci&oacute;n Consulta
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="altaConsultaCrd2" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_consulta_cita2" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_select_cita2" name="nombre_select2" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Tipo de Consulta</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <select class="select2 form-control" id="tipo_consulta_cita2" name="tipo_consulta_cita2" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    @foreach($tipoC as $x)
                                                    <option value="{{ $x->id }}">{{ $x->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer">
                            <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
                            <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                            <input type="hidden" id="id_hidden_paciente_cita2" name="id_hidden_paciente_cita2">
                            <input type="hidden" id="id_hidden_id_cita2" name="id_hidden_id_cita2">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="crear_consulta2" id="crear_consulta2" role="button">
                                <i class="fas fa-share"></i> Crear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="consultaPrenatalModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-check"></i> Confirmaci&oacute;n de Cita
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="altaCpform" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_cp role=" alert" style="display:none"></div>
                                        </div>
                                        <div class="col-12">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_cp" name="nombre_cp" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer">
                            <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
                            <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                            <input type="hidden" id="id_hidden_paciente_cita_pre" name="id_hidden_paciente_cita_pre">
                            <input type="hidden" id="id_hidden_id_cita_pre" name="id_hidden_id_cita_pre">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="confirmar_consulta_cp" id="confirmar_consulta_cp" role="button">
                                <i class="fas fa-share"></i> Confirmar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function($) {

        $('#alertaAlta').hide();
        $('#alertaEli').hide();
        $('#alertaMod').hide();

        $('#errorRazon').hide();

        $('#cerrar_salir').click(function() {
            // paciente_table.destroy();
            $('#verPacienteModal').modal('hide');

        });

        $('#cerrar_salir2').click(function() {
            // paciente_table.destroy();
            $('#recetaMedicaModal').modal('hide');

        });

        function errorRazon(valor) {
            $('#error1').html('<span>' + valor + '</span>');
            $('#errorRazon').show();
        }

        function ok(valor) {
            $('#ok1').html('<span>' + valor + '</span>');
            $('#ok').show();
        }
        $('#agregar_paciente').click(function() {
            $('#altaPacienteModal').modal('show');
        });

        $('#crear_cita').click(function() {
            $('#verPacienteModal').appendTo("body")
            $('#verPacienteModal').modal('show');
            $('#verPacienteModal').css('overflow-y', 'auto');
            $('#verPacienteModal > .modal-body').css({
                width: 'auto',
                height: 'auto',
                'max-height': '100%'
            });
            $('#pacientes_tables2').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]

                ],
                "order": [
                    [0, 'desc'],
                    [1, 'desc']
                ],
                processing: true,
                serverSide: true,
                destroy: true,
                //searching: false,
                scrollY: '50vh',

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                ajax: {
                    "url": "{{ url('Cita/PacienteSel') }}",
                },
                responsive: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombre_c',
                        data: 'nombre_c',
                    },
                    {
                        data: 'fecha_nacimiento',
                        name: 'fecha_nacimiento'
                    },
                    {
                        data: 'accion',
                        name: 'accion',
                    }
                ]
            });
        });

        $('#cita_tables').DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            "order": [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            scrollY: '50vh',

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            ajax: {
                "url": "{{ url('Citas') }}",
            },
            responsive: true,
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nombre_c',
                    name: 'nombre_c'
                },
                {
                    data: 'tipo_c',
                    name: 'tipo_c',
                },
                {
                    data: 'fecha_jora',
                    render: function(data, type, row) {
                        // esto es lo que se va a renderizar como html
                        return `${row.fecha_proxima} ${row.hora_proxima}`;
                    }
                },
                {
                    data: 'estatus_c',
                    name: 'estatus_c',
                },
                {
                    data: 'accion',
                    name: 'accion',
                }
            ]

        });

        $(document).on('click', '.seleccionar_paciente', function() {
            let id_paciente = $(this).attr('id');
            $('#tipo_consulta_c').val("").select2();
            $.ajax({
                url: "/Consulta/Paciente2/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#citaModal').appendTo("body")
                    $('#citaModal').modal('show');
                    $('#citaModal').css('overflow-y', 'auto');
                    $('#citaModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#id_hidden_cita').val(id_paciente);
                    $('#nombre_cita').val(data.nombre_c);
                }
            });
        });

        $('#agen_cita').click(function() {
            let token = '{{csrf_token()}}';
            let id_paciente = $('#id_hidden_cita').val();
            let fecha_agenda = $('#fecha_agenda').val();
            let hora_agenda = $('#hora_agenda').val();
            let tipo_con = $('#control').val();
            let data = {
                id_paciente: id_paciente,
                fecha_agenda: fecha_agenda,
                hora_agenda: hora_agenda,
                _token: token
            };

            if (tipo_con != '') {
                let respuesta = confirm("¿Confirmar Cita?");
                if (respuesta) {

                    if (tipo_con == 'General') {
                        $.ajax({
                            method: 'POST',
                            url: '{{ route("create_cita") }}',
                            data: data
                        }).done(function(jqXHR) {
                            $('#citaModal').modal('hide');
                            $('#verPacienteModal').modal('hide');
                            $("#altaCitaForm")[0].reset();
                            $('#control').val("").select2();
                            $('#cita_tables').DataTable().ajax.reload();
                            ok(jqXHR);
                            setTimeout(function() {
                                $('#ok').hide();
                            }, 2000);
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            if (jqXHR.status == 422) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }

                                $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                                    if ($.isPlainObject(value)) {
                                        $.each(value, function(key, value) {
                                            $('#response_cita').show().append(`
                                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <ul class="list-group">
                                                                <li class="list-group-item" style="color:black">` + value + `
                                                                    <span class="float-left">
                                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                                    </span>
                                                                </li>
                                                        </ul>`);
                                        });
                                    }
                                    setTimeout(function() {
                                        $('#response_cita').hide();
                                    }, 3000);
                                });
                            }
                            if (jqXHR.status == 442) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#response_cita').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + responseText + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);
                                $('#control').val("").select2();
                                setTimeout(function() {
                                    $('#response_cita').hide();
                                    $('#citaModal').modal('hide');
                                    $("#altaCitaForm")[0].reset();
                                }, 2000);

                            }
                            if (jqXHR.status == 500) {
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#citaModal').modal('hide');
                                $('#verPacienteModal').modal('hide');
                                $("#altaCitaForm")[0].reset();
                                $('#control').val("").select2();
                                $('#cita_tables').DataTable().ajax.reload();
                                errorRazon(responseText)
                            }
                            if (jqXHR.status == 404) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#response_cita').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + responseText + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);
                                setTimeout(function() {
                                    $('#response_cita').hide();
                                }, 4000);

                            }
                        });
                    }

                    if (tipo_con == 'Control') {
                        $.ajax({
                            method: 'POST',
                            url: '{{ route("create_citaE") }}',
                            data: data
                        }).done(function(jqXHR) {
                            $('#citaModal').modal('hide');
                            $('#verPacienteModal').modal('hide');
                            $("#altaCitaForm")[0].reset();
                            $('#control').val("").select2();
                            $('#cita_tables').DataTable().ajax.reload();
                            ok(jqXHR);
                            setTimeout(function() {
                                $('#ok').hide();
                            }, 2000);
                        }).fail(function(jqXHR, textStatus, errorThrown) {

                            console.log(jqXHR);
                            if (jqXHR.status == 422) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }

                                $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                                    if ($.isPlainObject(value)) {
                                        $.each(value, function(key, value) {
                                            $('#response_cita').show().append(`
                                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <ul class="list-group">
                                                                <li class="list-group-item" style="color:black">` + value + `
                                                                    <span class="float-left">
                                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                                    </span>
                                                                </li>
                                                        </ul>`);
                                        });
                                    }
                                    setTimeout(function() {
                                        $('#response_cita').hide();
                                    }, 3000);
                                });
                            }
                            if (jqXHR.status == 442) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#response_cita').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + responseText + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);

                                $('#control').val("").select2();
                                setTimeout(function() {
                                    $('#response_cita').hide();
                                    $('#citaModal').modal('hide');
                                    $("#altaCitaForm")[0].reset();
                                }, 2000);

                            }
                            if (jqXHR.status == 500) {
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#citaModal').modal('hide');
                                $('#verPacienteModal').modal('hide');
                                $("#altaCitaForm")[0].reset();
                                $('#control').val("").select2();
                                $('#cita_tables').DataTable().ajax.reload();
                                errorRazon(responseText)
                                errorRazon(responseText)
                            }
                            if (jqXHR.status == 404) {
                                if (!$('#response_cita').empty()) {
                                    $('#response_cita').empty();
                                }
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#response_cita').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + responseText + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);
                                setTimeout(function() {
                                    $('#response_cita').hide();
                                }, 4000);

                            }
                        });
                    }
                }
            } else {
                alert('Seleccione tipo de Consulta');
            }

        });

        $(document).on('click', '.create_cg', function() {
            let id_cita = $(this).attr('id');
            let id_paciente = $(this).attr('name');
            $('#tipo_consulta_cita').val("").select2();
            $.ajax({
                url: "/ConsultaG/CheckExpediente/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#consultaModal').appendTo("body")
                    $('#consultaModal').modal('show');
                    $('#consultaModal').css('overflow-y', 'auto');
                    $('#consultaModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#id_hidden_paciente_cita').val(id_paciente);
                    $('#id_hidden_id_cita').val(id_cita);
                    $('#nombre_select_cita').val(data.nombre_c);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert(XMLHttpRequest.responseJSON);                   
                    $.ajax({
                        url: "/Consulta/Paciente2/" + id_paciente,
                        dataType: "json",
                        success: function(data) {
                            $('#consultaModal2').appendTo("body")
                            $('#consultaModal2').modal('show');
                            $('#consultaModal2').css('overflow-y', 'auto');
                            $('#consultaModal2 > .modal-body').css({
                                width: 'auto',
                                height: 'auto',
                                'max-height': '100%'
                            });
                            $('#id_hidden_paciente_cita2').val(id_paciente);
                            $('#id_hidden_id_cita2').val(id_cita);
                            $('#nombre_select_cita2').val(data.nombre_c);
                        }
                    });
                }
            });
        });

        $('#crear_consulta').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#id_hidden_paciente_cita').val();
            let id_cita = $('#id_hidden_id_cita').val();
            let tipo_consulta = $('#tipo_consulta_cita').val();
            let data = {
                id: id,
                id_cita: id_cita,
                tipo_consulta: tipo_consulta,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("consultaRegistrocita") }}',
                data: data
            }).done(function(jqXHR) {
                $('#tipo_consulta_cita').val("").select2();
                $('#consultaModal').modal('hide');
                $('#cita_tables').DataTable().ajax.reload();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                    returnUrl = window.location.protocol + "//" + window.location.host +
                        "/Consulta/ConsultaGeneral/";
                    location.href = returnUrl;
                }, 3000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_consulta_cita').empty()) {
                        $('#response_consulta_cita').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_consulta_cita').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + value + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);
                            });
                        }
                        setTimeout(function() {
                            $('#response_consulta_cita').hide();
                        }, 2000);
                    });
                }
                if (jqXHR.status == 500) {
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#tipo_consulta_cita').val("").select2();
                    $('#cita_tables').DataTable().ajax.reload();
                    $('#consultaModal').modal('hide');
                    errorRazon(responseText)

                }
            });
        });

        $('#crear_consulta2').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#id_hidden_paciente_cita2').val();
            let id_cita = $('#id_hidden_id_cita2').val();
            let tipo_consulta = $('#tipo_consulta_cita2').val();
            let data = {
                id: id,
                id_cita: id_cita,
                tipo_consulta: tipo_consulta,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("consultaRegistrocita2") }}',
                data: data
            }).done(function(jqXHR) {
                $('#tipo_consulta_cita2').val("").select2();
                $('#consultaModal2').modal('hide');
                $('#cita_tables').DataTable().ajax.reload();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                    returnUrl = window.location.protocol + "//" + window.location.host +
                        "/Consulta/ConsultaGeneral/";
                    location.href = returnUrl;
                }, 3000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_consulta_cita2').empty()) {
                        $('#response_consulta_cita2').empty();
                    }
                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_consulta_cita2').show().append(`
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="list-group">
                                                <li class="list-group-item" style="color:black">` + value + `
                                                    <span class="float-left">
                                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                                    </span>
                                                </li>
                                        </ul>`);
                            });
                        }
                        setTimeout(function() {
                            $('#response_consulta_cita2').hide();
                        }, 2000);
                    });
                }
                if (jqXHR.status == 500) {
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#tipo_consulta_cita2').val("").select2();
                    $('#cita_tables').DataTable().ajax.reload();
                    $('#consultaModal2').modal('hide');
                    errorRazon(responseText)

                }
            });
        });

        $(document).on('click', '.create_cp', function() {
            let id_cita = $(this).attr('id');
            let id_paciente = $(this).attr('name');
            $.ajax({
                url: "/ConsultaP/CheckExpediente/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#consultaPrenatalModal').appendTo("body")
                    $('#consultaPrenatalModal').modal('show');
                    $('#consultaPrenatalModal').css('overflow-y', 'auto');
                    $('#consultaPrenatalModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#id_hidden_paciente_cita_pre').val(id_paciente);
                    $('#id_hidden_id_cita_pre').val(id_cita);
                    $('#nombre_cp').val(data.nombre_c);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert(XMLHttpRequest.responseJSON);
                    let respuesta = confirm("La paciente seleccionada no tiene un expediente creado, de clic en aceptar para confirmar la cita y acceder al Panel de Expedientes");
                    let token = '{{csrf_token()}}';
                    let data = {
                        id_cita: id_cita,
                        _token: token
                    };
                    if (respuesta) {

                        $.ajax({
                            method: 'POST',
                            url: '{{ route("confirmar_cp_cita") }}',
                            data: data
                        }).done(function(jqXHR) {
                            $('#consultaPrenatalModal').modal('hide');
                            $('#cita_tables').DataTable().ajax.reload();
                            ok(jqXHR);
                            setTimeout(function() {
                                $('#ok').hide();
                                returnUrl = window.location.protocol + "//" + window.location.host +
                                    "/Expediente/ControlPrenatal/";
                                location.href = returnUrl;
                            }, 2000);
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status == 500) {
                                let responseText = jQuery.parseJSON(jqXHR.responseText);
                                $('#consultaPrenatalModal').modal('hide');
                                $('#cita_tables').DataTable().ajax.reload();
                                errorRazon(responseText);
                            }
                        });
                    }
                }
            });
        });

        $('#confirmar_consulta_cp').click(function() {
            let token = '{{csrf_token()}}';
            let id_cita = $('#id_hidden_id_cita_pre').val();
            let data = {
                id_cita: id_cita,
                _token: token
            };
            let respuesta = confirm("¿Confirmar cita?");
            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("confirmar_cp_cita") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#consultaPrenatalModal').modal('hide');
                    $('#cita_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() {
                        $('#ok').hide();
                        returnUrl = window.location.protocol + "//" + window.location.host +
                            "/Consulta/Embarazadas/";
                        location.href = returnUrl;
                    }, 3000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 500) {
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#consultaPrenatalModal').modal('hide');
                        $('#cita_tables').DataTable().ajax.reload();
                        errorRazon(responseText);
                    }
                });
            }
        });

        $('#registrar_paciente').click(function() {
            let token = '{{csrf_token()}}';
            let nombre = $('#nombre').val();
            let ap_pat = $('#ap_pat').val();
            let ap_mat = $('#ap_mat').val();
            let fecha_nacimiento = $('#fecha_nacimiento').val();
            let edad = $('#edad').val();
            let tipo_sangre = $('#tipo_sangre').val();
            let celular = $('#celular').val();
            let email = $('#email').val();
            let contacto_emergencia = $('#contacto_emergencia').val();
            let genero = $('#genero').val();
            let talla = $('#talla').val();

            let data = {
                nombre: nombre,
                ap_pat: ap_pat,
                ap_mat: ap_mat,
                fecha_nacimiento: fecha_nacimiento,
                edad: edad,
                tipo_sangre: tipo_sangre,
                celular: celular,
                email: email,
                contacto_emergencia: contacto_emergencia,
                genero: genero,
                talla: talla,
                _token: token
            };
            let respuesta = confirm("¡Al dar clic en aceptar se registrarán los datos del paciente!");
            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("PacienteRegistro2") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#altaPacienteModal').modal('hide');
                    $('#tipo_sangre').val("").select2();
                    $('#genero').val("").select2();
                    $("#altaPaciente")[0].reset();
                    $('#pacientes_tables2').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() {
                        $('#ok').hide();
                    }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        if (!$('#response_paciente').empty()) {
                            $('#response_paciente').empty();
                        }

                        $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    $('#response_paciente').show().append(`
                        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="list-group">
                                    <li class="list-group-item" style="color:black">` + value + `
                                        <span class="float-left">
                                            <i class="fa fa-exclamation-circle mr-1"></i>
                                        </span>
                                    </li>
                            </ul>`);
                                });
                            }
                        });
                        setTimeout(function() {
                            $('#response_paciente').hide();
                        }, 2000);
                    }
                    if (jqXHR.status == 500) {
                        var responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#pacientes_tables2').DataTable().ajax.reload();
                        $('#altaPacienteModal').modal('hide');
                        $('#tipo_sangre').val("").select2();
                        $("#altaPaciente")[0].reset();
                        errorRazon(responseText)

                    }
                });
            }
        });

        $('#cerrarImprimir').click(function() {
            $('#pdfModal').modal('hide');
        });

        $('#cerrarImprimir2').click(function() {
            $('#pdfModal').modal('hide');
        });

        $(document).on('change', '#fecha_nacimiento', function() {
            let fecha_nacimiento = $('#fecha_nacimiento').val();
            let hoy = new Date();
            let nacimiento = new Date(fecha_nacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            let m = hoy.getMonth() - nacimiento.getMonth();
            let d = hoy.getDay() - nacimiento.getDay();
            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }
            /*if (edad < 1) {
                $('#edad').val(edad);
                if (m < 2) {
                    meses.innerHTML = m + " mes de Nacimiento";
                } else {
                    meses.innerHTML = m + " meses de Nacimiento";
                }

            } else {*/
            $('#edad').val(edad);
            meses.innerHTML = "";
            //}


        });


    });
</script>


@endsection