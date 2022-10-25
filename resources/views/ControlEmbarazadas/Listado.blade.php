@extends('layouts.menu')
@section('title')
: Embarazadas
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
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="agregar_paciente" style="color: white" role="button">
                                                <i class="fas fa-plus-circle"></i> Agregar Paciente
                                            </a>
                                        </th>
                                        <th align="center" style="text-align:center; padding: 3px">

                                        </th>
                                        <th align="right" style="text-align:right; padding: 3px">
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="nueva_consulta" style="color: white" role="button">
                                                <i class="fas fa-notes-medical"></i> Nuevo Expediente
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <table id="consultaE_tables" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Expediente</th>
                                        <th>Paciente</th>
                                        <th>Creaci&oacute;n Expediente</th>
                                        <th>Seguimiento</th>
                                        <th width="15%">Acci&oacute;n</th>
                                    </tr>
                                </thead>
                            </table>
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
                        <i class="fas fa-user-plus"></i> Datos de Inicio
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaPaciente" class="form">
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
                                            <label>Fecha de Nacimiento </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Edad </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Edad" id="edad" name="edad" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-sort"></i>
                                                </div>
                                                <span style="color: black;" id="meses"> </span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Tipo Sangre</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <select class="select2 form-control" id="tipo_sangre" name="tipo_sangre" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    @foreach($tipoS as $x)
                                                    <option value="{{ $x->id }}">{{ $x->tipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>G&eacute;nero</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <select class="select2 form-control" id="genero" name="genero" style="width: 100%;">
                                                    <option value="M">Femenino</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Talla </label><span style="color:red"> *</span>
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

    <div id="expedienteInicioModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-user-plus"></i> Datos de Inicio
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaExpIni" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_expN" role="alert" style="display:none"></div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-user-circle"></i> Datos Paciente</h4>
                                        </div>

                                        <div class="col-4">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_select_em" name="nombre_select_em" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Fecha de Nacimiento </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_nacimiento_em" name="fecha_nacimiento_em" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Edad </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Edad" id="edad_em" name="edad_em" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-sort"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-diagnoses"></i> Antecedentes Ginecoobst&eacute;tricos </h4>
                                        </div>

                                        <div class="col-3">
                                            <label>Gestas</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-baby"></i>
                                                </div>
                                                <input type="number" placeholder="Gestas" id="gesta" name="gesta" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Partos</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Partos" id="parto" name="parto" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-child'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Ces&aacute;reas</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Ces&aacute;reas" id="cesarea" name="cesarea" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fa fa-cut"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Abortos</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Abortos" id="aborto" name="aborto" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fa fa-stop"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-baby-carriage"></i> Embarazo Actual</h4>
                                        </div>

                                        <div class="col-3">
                                            <label>FUM </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fur" name="fur" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>FPP </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fpp" name="fpp" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Estudios Laboratorio </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="estudio_lab" id="estudio_lab" cols="150" rows="2" class="form-control" placeholder="Estudios Laboratorio    "></textarea>
                                                <div class="form-control-position">
                                                    <i class='fa fa-check-square'></i>
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
                        <input type="hidden" id="id_hidden_em" name="id_hidden_em">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_expinicio" id="reg_expinicio" role="button">
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

    <div id="consultaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-user-plus"></i> Paciente Seleccionado
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="altaConsultaCr" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_consulta_crear" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_select" name="nombre_select" class="form-control">
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
                                                <select class="select2 form-control" id="tipo_consulta_c" name="tipo_consulta_c" style="width: 100%;">
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
                                <i class="fas fa-ban"></i> Salir
                            </a>
                            <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                            <input type="hidden" id="id_hidden_paciente_c" name="id_hidden_paciente_c">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="crear_consulta" id="crear_consulta" role="button">
                                <i class="fas fa-share"></i> Crear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editarConsultaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-list"></i> Notas Consulta
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="editConsulta_P" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_editConsulta" role="alert" style="display:none"></div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fa fa-user"></i> Datos Paciente</h4>
                                        </div>
                                        <div class="col-6">
                                            <label>Paciente </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="n_paciente" name="n_paciente" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Tipo Sangre </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="tipo_sangreC" name="tipo_sangreC" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-heart'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Edad</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="edad_consulta" name="edad_consulta" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-user-circle'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fa fa-edit"></i> Datos Consulta</h4>
                                        </div>

                                        <div class="col-4">
                                            <label>Tipo de Consulta</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="tip_consultaC" name="tip_consultaC" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-hospital'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Peso </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Peso Paciente KG" id="peso" name="peso" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-weight'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Temperatura Paciente </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Temperatura Paciente" id="temperatura" name="temperatura" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-temperature-high"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>T/A</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ta_c" name="ta_c" placeholder="T/A" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-chevron-down'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Glucosa</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="glucosa" name="glucosa" placeholder="Glucosa" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-calculator'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Motivo Consulta</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="motivo_consulta" id="motivo_consulta" cols="150" rows="1" class="form-control" placeholder="Motivo Consulta"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-edit'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Exploraci&oacute;n F&iacute;sica</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="exploracion" id="exploracion" cols="150" rows="2" class="form-control" placeholder="Exploración Física"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-check'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Diagn&oacute;stico </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="diagnostico" id="diagnostico" cols="150" rows="3" class="form-control" placeholder="Diagnóstico Paciente"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-diagnoses'></i>
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
                            <i class="fas fa-ban"></i> Cerrar
                        </a>
                        <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                        <input type="hidden" id="hidden_id_editarc" name="hidden_id_editarc">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_consulta" id="reg_consulta" role="button">
                            <i class="fas fa-save"></i> Guardar Notas
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="recetaMedicaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-tablets"></i> Seleccionar Medicamento
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ag_medicamentos_pa" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-1" id="alerts_regMe" role="alert" style="display:none">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label>Medicamento</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-tablets"></i>
                                                </div>
                                                <select class="select2 form-control" id="medSelect" name="medSelect" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    @foreach($med as $x)
                                                    <option value="{{ $x->id }}">{{ $x->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Existencia </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Existencia" id="existencia" name="existencia" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-store'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Precio Venta </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Precio Venta" id="pre_venta" name="pre_venta" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-money-bill'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Cantidad </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" id="cant_medicamento" placeholder="Cantidad Medicamento" name="cant_medicamento" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <label>Tratamiento </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="tratamiento" id="tratamiento" cols="150" rows="3" class="form-control" placeholder="Tratamiento"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-procedures'></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th align="left" style="text-align:left; padding: 3px">
                                                    <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="ag_medicamentoC" id="ag_medicamentoC" role="button">
                                                        <i class="fas fa-plus"></i> Agregar
                                                    </a>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                </form>
                </br>

                <div class="col-12">
                    <h4 class="form-section"><i class="fas fa-tablets"></i> Medicamentos Agregados</h4>
                </div>


                <div class="col-12">
                    <div class="table-responsive" style="width:100%">
                        <table id="medicamentos_paciente_table" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Cantidad</th>
                                    <th>Tratamiento</th>
                                    <th width="15%">Acci&oacute;n</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="col-12">
                    <div class="modal-footer">
                        <!--<a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                                    <i class="fas fa-ban"></i> Cancelar
                                                </a>-->
                        <input type="hidden" id="hidden_id_con" name="hidden_id_con">
                        <a href="#" id="cerrar_salir2" class="btn btn-info btn-min-width btn-glow" style="color: white" role="button">
                            <i class="fas fa-ban"></i> Salir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="finalizarConsultaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Finalizar Consulta</span> </strong></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th align="left" style="text-align:left; padding: 3px">
                                <a href="#" class="btn btn-warning btn-xs btn-glow" id="vista_previaReceta" style="color: white" role="button">
                                    <i class="fas fa-eye"></i> Vista Previa
                                </a>
                            </th>
                        </tr>
                    </thead>
                </table>
                <form id="finalCform" class="form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="alerts_finally" role="alert" style="display:none"></div>
                            </div>
                            <div class="col-4">
                                <label>Paciente </label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" id="nombre_paciente" name="nombre_paciente" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <label>Motivo Consulta </label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" id="mot_consul" name="mot_consul" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class='fas fa-edit'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <label>Talla (CM)</label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="number" id="talla_pac" name="talla_pac" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class='fa fa-text-height'></i>
                                    </div>
                                </div>
                            </div>


                            <div class="col-4">
                                <label>Peso (KG)</label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="number" id="peso_pac" name="peso_pac" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class='fas fa-weight'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                                <label>Diagn&oacute;stico </label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" id="diag_paciente" name="diag_paciente" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class='fas fa-diagnoses'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <label>Temperatura (°) </label> <span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="number" id="temp_pac" name="tem_pac" class="form-control" readonly>
                                    <div class="form-control-position">
                                        <i class="fas fa-temperature-high"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label>Recomendaciones </label><span style="color:red"> *</span>
                                <div class="form-group position-relative has-icon-left">
                                    <textarea name="observaciones" id="observaciones" cols="150" rows="3" class="form-control" placeholder="Recomendaciones"></textarea>
                                    <div class="form-control-position">
                                        <i class='fas fa-list'></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="modal-footer">
                                <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
                                    <i class="fas fa-ban"></i> Cerrar
                                </a>
                                <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                                <!--<input type="hidden" id="hidden_id_med" name="hidden_id_med">
                                <input type="hidden" id="hidden_id_con_final" name="hidden_id_con_final">-->
                                <input type="hidden" id="hidden_id_con_fin" name="hidden_id_con_fin">
                                <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="fin_consulta" id="fin_consulta" role="button">
                                    <i class="fas fa-save"></i> Finalizar
                                </a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div id="pdfModal" class="modal fade pdfModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-file-pdf"></i> Datos de la Consulta
                    </h3>
                    <button type="button" class="close" id="cerrarImprimir" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div style="text-align: center;">
                        <span id="form_resultPDF"></span>
                    </div>

                    <div class="modal-footer">
                        <a href="#" id="cerrarImprimir2" class="btn btn-danger btn-min-width btn-glow" style="color: white" role="button">
                            <i class="fas fa-ban"></i> Salir
                        </a>
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

        $('#reg_expinicio').click(function() {

            let token = '{{csrf_token()}}';
            let id_paciente = $('#id_hidden_em').val();
            let gesta = $('#gesta').val();
            let parto = $('#parto').val();
            let cesarea = $('#cesarea').val();
            let aborto = $('#aborto').val();
            let fur = $('#fur').val();
            let fpp = $('#fpp').val();
            let estudio_laboratorio = $('#estudio_lab').val();

            let data = {
                id_paciente: id_paciente,
                gesta: gesta,
                parto: parto,
                cesarea: cesarea,
                aborto: aborto,
                fur: fur,
                fpp: fpp,
                estudio_laboratorio: estudio_laboratorio,
                _token: token
            };

            $.ajax({
                method: 'POST',
                url: '{{ route("regExpedienteEm") }}',
                data: data
            }).done(function(jqXHR) {
                $("#altaExpIni")[0].reset();
                $('#expedienteInicioModal').modal('hide');
                $('#verPacienteModal').modal('hide');              
                $('#consultaE_tables').DataTable().ajax.reload();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                }, 2000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_expN').empty()) {
                        $('#response_expN').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_expN').show().append(`
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
                    $('#response_expN').hide();
                }, 4000);
                }
                if (jqXHR.status == 500) {
                    var responseText = jQuery.parseJSON(jqXHR.responseText);
                    $("#altaExpIni")[0].reset();                    
                    $('#expedienteInicioModal').modal('hide');
                    $('#verPacienteModal').modal('hide');                         
                    $('#consultaE_tables').DataTable().ajax.reload();
                    errorRazon(responseText)

                }
            });

        });

        $(document).on('change', '#medSelect', function() {
            let id_med = $('#medSelect').val();
            $.ajax({
                url: "/MedicamentoSeleccionado/" + id_med,
                dataType: "json",
                success: function(data) {
                    let ex = 0;
                    if (data.existencia == null) {
                        $('#existencia').val(ex);
                    } else {
                        $('#existencia').val(data.cantidad);
                    }
                    $('#pre_venta').val(data.precio_venta);
                    document.getElementById("existencia").readOnly = true;
                    document.getElementById("pre_venta").readOnly = true;

                }
            });

        });


        $('#nueva_consulta').click(function() {
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
                    "url": "{{ url('Catalogo/ControlP') }}",
                },
                responsive: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombre_c',
                        data: 'nombre_c',
                        /*render: function(data, type, row) {
                            if (row.ap_materno == null) {
                                return `${row.nombre} ${row.ap_paterno}`;
                            } else {
                                return `${row.nombre} ${row.ap_paterno} ${row.ap_materno}`;
                            }

                        }*/
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

        $('#consultaE_tables').DataTable({
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
            scrollY: '50vh',

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            ajax: {
                "url": "{{ url('Consulta/Embarazadas') }}",
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
                    data: 'fecha',
                    name: 'fecha',
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
            $.ajax({
                method: 'POST',
                url: '{{ route("PacienteRegistro") }}',
                data: data
            }).done(function(jqXHR) {
                $('#altaPacienteModal').modal('hide');
                $('#tipo_sangre').val("").select2();
                $("#altaPaciente")[0].reset();
                $('#consultag_tables').DataTable().ajax.reload();
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
                }
                if (jqXHR.status == 500) {
                    var responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#consultag_tables').DataTable().ajax.reload();
                    $('#altaPacienteModal').modal('hide');
                    $('#tipo_sangre').val("").select2();
                    $("#altaPaciente")[0].reset();
                    errorRazon(responseText)

                }
            });
        });

        $(document).on('click', '.seleccionar_paciente', function() {
            let id_paciente = $(this).attr('id');
            $('#tipo_consulta_c').val("").select2();
            $.ajax({
                url: "/Consulta/Paciente/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#expedienteInicioModal').appendTo("body")
                    $('#expedienteInicioModal').modal('show');
                    $('#expedienteInicioModal').css('overflow-y', 'auto');
                    $('#expedienteInicioModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#id_hidden_em').val(id_paciente);
                    $('#nombre_select_em').val(data.nombre + " " + data.ap_paterno + " " + data.ap_materno);
                    $('#fecha_nacimiento_em').val(data.fecha_nacimiento);
                    $('#edad_em').val(data.edad);
                    document.getElementById("nombre_select_em").readOnly = true;
                    document.getElementById("fecha_nacimiento_em").readOnly = true;
                    document.getElementById("edad_em").readOnly = true;
                }
            });
        });

        $('#crear_consulta').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#id_hidden_paciente_c').val();
            let tipo_consulta = $('#tipo_consulta_c').val();
            let data = {
                id: id,
                tipo_consulta: tipo_consulta,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("consultaRegistro") }}',
                data: data
            }).done(function(jqXHR) {
                $('#tipo_consulta_c').val("").select2();
                $('#consultaModal').modal('hide');
                $('#verPacienteModal').modal('hide');
                $('#consultag_tables').DataTable().ajax.reload();
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
                                $('#response_consulta_crear').show().append(`
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
                            $('#response_consulta_crear').hide();
                        }, 2000);
                    });
                }
                if (jqXHR.status == 442) {
                    if (!$('#response_paciente').empty()) {
                        $('#response_paciente').empty();
                    }
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#response_consulta_crear').show().append(`
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
                        $('#response_consulta_crear').hide();
                    }, 2000);

                }
                if (jqXHR.status == 500) {
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#tipo_consulta_c').val("").select2();
                    $('#consultag_tables').DataTable().ajax.reload();
                    $('#consultaModal').modal('hide');
                    errorRazon(responseText)

                }
            });
        });

        $(document).on('click', '.editar_consulta', function() {
            let id_consulta = $(this).attr('id');
            //('#tipo_consulta_c').val("").select2();
            $.ajax({
                url: "/ConsultaGeneralP/" + id_consulta,
                dataType: "json",
                success: function(data) {
                    $('#editarConsultaModal').appendTo("body")
                    $('#editarConsultaModal').modal('show');
                    $('#editarConsultaModal').css('overflow-y', 'auto');
                    $('#editarConsultaModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#hidden_id_editarc').val(id_consulta);
                    $('#n_paciente').val(data.nombre_c);
                    $('#tipo_sangreC').val(data.tipo_sangre);
                    $('#edad_consulta').val(data.edad);
                    $('#tip_consultaC').val(data.tipo_consulta);
                    document.getElementById("n_paciente").readOnly = true;
                    document.getElementById("tipo_sangreC").readOnly = true;
                    document.getElementById("edad_consulta").readOnly = true;
                    document.getElementById("tip_consultaC").readOnly = true;
                }
            });
        });

        $('#reg_consulta').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#hidden_id_editarc').val();
            let peso = $('#peso').val();
            let temperatura = $('#temperatura').val();
            let diagnostico = $('#diagnostico').val();
            let ta_c = $('#ta_c').val();
            let glucosa = $('#glucosa').val();
            let motivo_consulta = $('#motivo_consulta').val();
            let exploracion = $('#exploracion').val();
            let data = {
                id: id,
                peso: peso,
                temperatura: temperatura,
                diagnostico,
                ta_c: ta_c,
                glucosa: glucosa,
                motivo_consulta: motivo_consulta,
                exploracion: exploracion,
                _token: token
            };

            let respuesta = confirm("¿Está seguro de Guardar los datos recopilados?");
            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("reg_EditConsulta") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#editarConsultaModal').modal('hide');
                    $("#editConsulta_P")[0].reset();
                    $('#consultag_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() {
                        $('#ok').hide();
                    }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        if (!$('#response_editConsulta').empty()) {
                            $('#response_editConsulta').empty();
                        }

                        $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    $('#response_editConsulta').show().append(`
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
                                $('#response_editConsulta').hide();
                            }, 5000);
                        });
                    }
                    if (jqXHR.status == 442) {
                        if (!$('#response_editConsulta').empty()) {
                            $('#response_editConsulta').empty();
                        }
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#response_editConsulta').show().append(`
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
                            $('#response_editConsulta').hide();
                        }, 5000);

                    }
                    if (jqXHR.status == 500) {
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#consultag_tables').DataTable().ajax.reload();
                        $('#editarConsultaModal').modal('hide');
                        $("#editConsulta_P")[0].reset();
                        errorRazon(responseText)

                    }
                });
            }
        });

        $(document).on('click', '.receta_medica', function() {
            let id_consulta = $(this).attr('id');
            $('#hidden_id_con').val(id_consulta);
            $('#recetaMedicaModal').appendTo("body")
            $('#recetaMedicaModal').modal('show');
            $('#medicamentos_tables').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "order": [
                    [1, 'asc']
                ],
                processing: true,
                serverSide: true,
                scrollY: '50vh',
                destroy: true,

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                ajax: {
                    "url": "{{ url('Medicamentos/DataMedicamentos') }}",
                },
                responsive: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'fecha_cad',
                        name: 'fecha_cad',
                    },
                    {
                        data: 'cantidad',
                        name: 'cantidad',
                    },
                    {
                        data: 'precio_venta',
                        name: 'precio_venta',
                    },
                    {
                        data: 'accion',
                        name: 'accion',
                    }
                ]

            });

            $('#medicamentos_paciente_table').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "order": [
                    [0, 'desc'],
                ],
                processing: true,
                serverSide: true,
                "bDestroy": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                ajax: {
                    "url": "{{ url('RecetaMedica/Select') }}" + "/" + id_consulta,
                },
                responsive: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'cantidad',
                        name: 'cantidad',
                    },
                    {
                        data: 'tratamiento',
                        name: 'tratamiento',
                    },
                    {
                        data: 'accion',
                        name: 'accion',
                    }
                ]
            });

        });

        $(document).on('click', '.select_medicamento', function() {
            let id_medicamento = $(this).attr('id');
            let id_consulta = $('#hidden_id_con').val();
            $('#hidden_id_con_final').val(id_consulta);
            $('#modalMedicamentoSel').appendTo("body")
            $('#modalMedicamentoSel').modal('show');

            $.ajax({
                url: "/MedicamentoSeleccionado/" + id_medicamento,
                dataType: "json",
                success: function(data) {
                    $('#hidden_id_med').val(id_medicamento);
                    n_medicamento.innerHTML = data.nombre + " " + data.presentacion;
                }
            });
        });

        $('#ag_medicamentoC').click(function() {
            let token = '{{csrf_token()}}';
            let id_consulta = $('#hidden_id_con').val();
            let id_medicamento = $('#medSelect').val();
            let cantidad = $('#cant_medicamento').val();
            let tratamiento = $('#tratamiento').val();
            let data = {
                id_consulta: id_consulta,
                id_medicamento: id_medicamento,
                cantidad: cantidad,
                tratamiento: tratamiento,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("med_RecetaMedica") }}',
                data: data
            }).done(function(jqXHR) {
                $("#ag_medicamentos_pa")[0].reset();
                $('#medSelect').val("").select2();
                $('#medicamentos_paciente_table').DataTable().ajax.reload();
                let responseText = jqXHR;
                $('#alerts_regMe').show().append(`
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
                    $('#alerts_regMe').hide();
                }, 2000);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#alerts_regMe').empty()) {
                        $('#alerts_regMe').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#alerts_regMe').show().append(`
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
                            $('#alerts_regMe').hide();
                        }, 5000);
                    });
                }
                if (jqXHR.status == 442) {
                    if (!$('#alerts_regMe').empty()) {
                        $('#alerts_regMe').empty();
                    }
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#alerts_regMe').show().append(`
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
                        $('#alerts_regMe').hide();
                    }, 5000);

                }
                if (jqXHR.status == 500) {
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $("#ag_medicamentos_pa")[0].reset();
                    $('#medSelect').val("").select2();
                    $('#medicamentos_paciente_table').DataTable().ajax.reload();
                    //$('#modalMedicamentoSel').modal('hide');
                    errorRazon(responseText)

                }
            });

        });

        $(document).on('click', '.finalizar_consulta', function() {
            let id_consulta = $(this).attr('id');
            //let id_consulta = $('#hidden_id_con').val();
            $('#hidden_id_con_fin').val(id_consulta);
            $('#finalizarConsultaModal').appendTo("body")
            $('#finalizarConsultaModal').modal('show');

            $.ajax({
                url: "/ConsultaGeneral/CGData/" + id_consulta,
                dataType: "json",
                success: function(data) {
                    $('#nombre_paciente').val(data.nombre_p);
                    $('#mot_consul').val(data.motivo_consulta);
                    $('#talla_pac').val(data.talla);
                    $('#peso_pac').val(data.peso);
                    $('#diag_paciente').val(data.diagnostico);
                    $('#temp_pac').val(data.temperatura);
                }
            });
        });

        $('#vista_previaReceta').click(function() {
            let id_consulta = $('#hidden_id_con_fin').val();
            $('#pdfModal').css('overflow-y', 'auto');
            $('#form_resultPDF').html('<iframe src="../../ConsultaGneralEdit/Vistaprevia/' + id_consulta + '" style="width:100%; height:500px;" frameborder="0"></iframe>');
            $('#pdfModal').modal('show');
        });

        $('#fin_consulta').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#hidden_id_con_fin').val();
            let observaciones = $('#observaciones').val();
            let data = {
                id: id,
                observaciones: observaciones,
                _token: token
            };

            let respuesta = confirm("¡La Consulta se Finalizará!");
            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("end_consultaG") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#finalizarConsultaModal').modal('hide');
                    $("#finalCform")[0].reset();
                    $('#consultag_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() {
                        $('#ok').hide();
                    }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        if (!$('#alerts_finally').empty()) {
                            $('#alerts_finally').empty();
                        }

                        $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    $('#response_editConsulta').show().append(`
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
                                $('#alerts_finally').hide();
                            }, 5000);
                        });
                    }
                    if (jqXHR.status == 442) {
                        if (!$('#alerts_finally').empty()) {
                            $('#alerts_finally').empty();
                        }
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#alerts_finally').show().append(`
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
                            $('#alerts_finally').hide();
                        }, 5000);

                    }
                    if (jqXHR.status == 500) {
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#consultag_tables').DataTable().ajax.reload();
                        $('#finalizarConsultaModal').modal('hide');
                        $("#finalCform")[0].reset();
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

    });
</script>


@endsection