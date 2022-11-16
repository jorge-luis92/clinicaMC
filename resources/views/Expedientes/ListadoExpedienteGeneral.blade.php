@extends('layouts.menu')
@section('title')
: Expedientes CG
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
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="agregar_paciente" style="color: white" role="button">
                                                <i class="fas fa-plus-circle"></i> Agregar Paciente
                                            </a>
                                        </th>
                                        <th align="center" style="text-align:center; padding: 3px">

                                        </th>

                                        <th align="right" style="text-align:right; padding: 3px">
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="nuevo_expediente" style="color: white" role="button">
                                                <i class='fas fa-file-archive'></i></i> Nuevo Expediente
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <table id="expediente_tables" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Edad</th>
                                        <th>Tipo Sangre</th>
                                        <th>Celular</th>
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

    <div id="verExpPacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-list"></i> Expediente<span id="paciente_detalles"></span>
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
                                                        <table id="expedienteCG_table" class="table table-bordered table-striped" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Padecimiento Indicado</th>
                                                                    <th>Diagnostico</th>
                                                                    <th>Estatus</th>
                                                                    <th>Fecha Consulta</th>
                                                                    <th width="15%">Acci&oacute;n</th>
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
                                                <a href="#"  class="btn btn-info btn-min-width btn-glow"  data-dismiss="modal" style="color: white" role="button">
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
                                            <label>Edad (A&ntilde;os) </label> <span style="color:red"> *</span>
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
                                                    <option value="">Seleccione</option>
                                                    <option value="M">Femenino</option>
                                                    <option value="H">Masculino</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Talla (CM)</label><span style="color:red"> *</span>
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

    <div id="expedienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                <input type="text" id="nombre_select" name="nombre_select" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Fecha Nacimiento </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_select" name="fecha_select" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar"></i>
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
                            <input type="hidden" id="id_hidden_paciente_c" name="id_hidden_paciente_c">
                            <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="crear_expediente" id="crear_expediente" role="button">
                                <i class="fas fa-share"></i> Crear Expediente
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="detallesConsultaModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-list"></i> Detalles de la Consulta
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
                                                <input type="text" id="ver_paciente" name="ver_paciente" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Tipo Sangre </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ver_tipo_sangreC" name="ver_tipo_sangreC" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fas fa-heart'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Edad (A&ntilde;os ) </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ver_edad_consulta" name="ver_edad_consulta" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fa fa-user-circle'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fa fa-edit"></i> Datos Consulta</h4>
                                        </div>

                                        <div class="col-3">
                                            <label>Tipo de Consulta</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ver_tip_consultaC" name="ver_tip_consultaC" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fa fa-hospital'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Padecimiento Indicado</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="ver_motivo_consulta" id="ver_motivo_consulta" cols="150" rows="1" class="form-control" placeholder="Motivo Consulta" readonly></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-edit'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Peso (KG)</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Peso Paciente KG" id="ver_peso" name="ver_peso" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fas fa-weight'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Temperatura Paciente (°) </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Temperatura Paciente" id="ver_temperatura" name="ver_temperatura" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-temperature-high"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>T/A</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ver_ta_c" name="ver_ta_c" placeholder="T/A" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fa fa-chevron-down'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Glucosa</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="ver_glucosa" name="ver_glucosa" placeholder="Glucosa" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fa fa-calculator'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Exploraci&oacute;n F&iacute;sica</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="ver_exploracion" id="ver_exploracion" cols="150" rows="2" class="form-control" placeholder="Exploración Física" readonly></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-check'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Diagn&oacute;stico </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="ver_diagnostico" id="ver_diagnostico" cols="150" rows="3" class="form-control" placeholder="Diagnóstico Paciente" readonly></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-diagnoses'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="recomedaciones1" style="display:none">
                                            <label>Recomendaciones </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="ver_recomendaciones" id="ver_recomendaciones" cols="150" rows="5" class="form-control" placeholder="Recomendaciones" readonly></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-list'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="recomedaciones2" style="display:none">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Recomendaciones </label>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <textarea name="ver_recomendacion" id="ver_recomendacion" cols="150" rows="5" class="form-control" placeholder="Recomendaciones" readonly></textarea>
                                                        <div class="form-control-position">
                                                            <i class='fas fa-list'></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label>Procedimiento realizado </label>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <textarea name="ver_procedimiento" id="ver_procedimiento" cols="150" rows="5" class="form-control" placeholder="Recomendaciones" readonly></textarea>
                                                        <div class="form-control-position">
                                                            <i class='fas fa-procedures'></i>
                                                        </div>
                                                    </div>
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
                    </div>
                </div>
                </form>
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

        function errorRazon(valor) {
            $('#error1').html('<span>' + valor + '</span>');
            $('#errorRazon').show();
        }

        function ok(valor) {
            $('#ok1').html('<span>' + valor + '</span>');
            $('#ok').show();
        }

        $('#cerrar_salir').click(function() {
            $('#verExpPacienteModal').modal('hide');

        });

        $('#expediente_tables').DataTable({
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

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            ajax: {
                "url": "{{ url('Expediente/ConsultaGeneral') }}",
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
                    data: 'edad',
                    name: 'edad',
                },
                {
                    data: 'tipo',
                    name: 'tipo',
                },
                {
                    data: 'celular',
                    name: 'celular',
                },
                {
                    data: 'accion',
                    name: 'accion',
                }
            ]

        });

        $(document).on('click', '.expediente_paciente', function() {
            let id_paciente = $(this).attr('name');
            let id_expediente = $(this).attr('id');

            $.ajax({
                url: "/ConsultaGeneral/CGPaciente/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#verExpPacienteModal').appendTo("body")
                    $('#verExpPacienteModal').modal('show');
                    $('#verExpPacienteModal').css('overflow-y', 'auto');
                    $('#verExpPacienteModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });

                    paciente_detalles.innerHTML = ": " + data.nombre_p;

                    $('#expedienteCG_table').DataTable({
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
                            "url": "{{ url('Expediente/CGver') }}" + "/" + id_paciente + "/" + id_expediente,
                        },
                        responsive: true,
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'motivo_consulta',
                                name: 'motivo_consulta'
                            },
                            {
                                data: 'diagnostico',
                                name: 'diagnostico',
                            },
                            {
                                data: 'estatus_c',
                                name: 'estatus_c',
                            },
                            {
                                data: 'fecha',
                                name: 'fecha',
                            },
                            {
                                data: 'accion',
                                name: 'accion',
                            }
                        ]
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("¡Sin registros!");
                }
            });

        });

        $('#consultag_tables').DataTable({
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
                "url": "{{ url('Consulta/ConsultaGeneral') }}",
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
                    data: 'diagnostico',
                    name: 'diagnostico',
                },
                {
                    data: 'estatus_c',
                    name: 'estatus_c',
                },
                {
                    data: 'fecha',
                    name: 'fecha',
                },
                {
                    data: 'accion',
                    name: 'accion',
                }
            ]

        });

        $('#agregar_paciente').click(function() {
            $('#altaPacienteModal').modal('show');
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

        $('#nuevo_expediente').click(function() {
            /*$('#verPacienteModal').appendTo("body");*/
            $('#verPacienteModal').modal('show');
            /* $('#verPacienteModal').css('overflow-y', 'auto');
             $('#verPacienteModal > .modal-body').css({
                 width: 'auto',
                 height: 'auto',
                 'max-height': '100%'
             });*/
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
                    "url": "{{ url('Catalogo/PacienteSel') }}",
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

        $(document).on('click', '.seleccionar_paciente', function() {
            let id_paciente = $(this).attr('id');
            $('#tipo_consulta_c').val("").select2();
            $.ajax({
                url: "/Consulta/Paciente/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#expedienteModal').appendTo("body")
                    $('#expedienteModal').modal('show');
                    $('#expedienteModal').css('overflow-y', 'auto');
                    $('#expedienteModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });
                    $('#id_hidden_paciente_c').val(id_paciente);
                    $('#nombre_select').val(data.nombre + " " + data.ap_paterno + " " + data.ap_materno);
                    $('#fecha_select').val(data.fecha_nacimiento);
                }
            });
        });

        $('#crear_expediente').click(function() {
            let token = '{{csrf_token()}}';
            let id = $('#id_hidden_paciente_c').val();
            let data = {
                id: id,
                _token: token
            };
            let respuesta = confirm("¡Se creará el Expediente!");

            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("expRegistro") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#expedienteModal').modal('hide');
                    $('#verPacienteModal').modal('hide');
                    $('#expediente_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() {
                        $('#ok').hide();
                        returnUrl = window.location.protocol + "//" + window.location.host +
                            "/Consulta/ConsultaGeneral/";
                        location.href = returnUrl;
                    }, 3000);
                       
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
                            $('#expedienteModal').modal('hide');
                        }, 3000);
                        

                    }
                    if (jqXHR.status == 500) {
                        let responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#tipo_consulta_c').val("").select2();
                        $('#consultag_tables').DataTable().ajax.reload();
                        $('#consultaModal').modal('hide');
                        errorRazon(responseText)

                    }
                });
            }
        });

        $(document).on('click', '.detalles_consulta', function() {
            let id_consulta = $(this).attr('id');
            $('#detallesConsultaModal').appendTo("body")
            $('#detallesConsultaModal').modal('show');

            $.ajax({
                url: "/ConsultaGeneral/CGData/" + id_consulta,
                dataType: "json",
                success: function(data) {
                    $('#ver_paciente').val(data.nombre_p);
                    $('#ver_tipo_sangreC').val(data.tipo);
                    $('#ver_edad_consulta').val(data.edad);
                    $('#ver_tip_consultaC').val(data.tipo_consulta);
                    $('#ver_peso').val(data.peso);
                    $('#ver_temperatura').val(data.temperatura);
                    $('#ver_ta_c').val(data.ta);
                    $('#ver_glucosa').val(data.glucosa);
                    $('#ver_motivo_consulta').val(data.motivo_consulta);
                    $('#ver_exploracion').val(data.examen_fisico);
                    $('#ver_diagnostico').val(data.diagnostico);                    
                    let pro = data.procedimiento;

                    if(pro == null){
                        $('#recomedaciones2').hide();
                        $('#recomedaciones1').show();
                        $('#ver_recomendaciones').val(data.observaciones);
                        
                    }else{
                        $('#recomedaciones1').hide();
                        $('#recomedaciones2').show();
                        $('#ver_recomendacion').val(data.observaciones);
                        $('#ver_procedimiento').val(data.procedimiento);
                        
                    }
                }
            });



        });

    });
</script>
@endsection