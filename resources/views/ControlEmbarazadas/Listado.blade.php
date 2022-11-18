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
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="nueva_consulta" style="color: white" role="button">
                                                <i class="fas fa-notes-medical"></i> Nuevo Control
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <table id="consultaE_tables" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Paciente</th>
                                        <th>Fecha Registro</th>
                                        <th>Etapa</th>
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

    <div id="expedienteInicioModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-baby"></i> Datos Embarazo Actual
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaExpIni">
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
                                                <input type="text" id="nombre_select_em" name="nombre_select_em" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Fecha de Nacimiento </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_nacimiento_em" name="fecha_nacimiento_em" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Edad </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Edad" id="edad_em" name="edad_em" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-sort"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-baby"></i> Datos Embarazo</h4>
                                        </div>

                                        <div class="col-6">
                                            <label>FUM </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fur" name="fur" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>FPP </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fpp" name="fpp" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Estudios Laboratorio </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="estudio_lab" id="estudio_lab" cols="150" rows="2" class="form-control" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
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
                        <input type="hidden" id="id_hidden_expediente" name="id_hidden_expediente">
                        <input type="hidden" id="id_hidden_pacienteu" name="id_hidden_pacienteu">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_expinicio" id="reg_expinicio" role="button">
                            <i class="fas fa-share"></i> Registrar
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="antecedentesModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-list"></i> Datos Inicio
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="antForm" class="form">
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
                                                <input type="text" id="nombre_ant" name="nombre_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Fecha de Nacimiento </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_nacimiento_ant" name="fecha_nacimiento_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Creaci&oacute;n Expediente </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="c_expant" name="c_expant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-birthday-cake"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-sticky-note"></i> Antecedentes Ginecoobst&eacute;tricos</h4>
                                        </div>

                                        <div class="col-3">
                                            <label>Gestas</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-baby"></i>
                                                </div>
                                                <input type="number" placeholder="Gestas" id="gesta_ant" name="gesta_ant" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Partos</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Partos" id="parto_ant" name="parto_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class='fa fa-child'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Ces&aacute;reas</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Ces&aacute;reas" id="cesarea_ant" name="cesarea_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fa fa-cut"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Abortos</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Abortos" id="aborto_ant" name="aborto_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fa fa-stop"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-baby-carriage"></i> Embarazo Actual</h4>
                                        </div>

                                        <div class="col-3">
                                            <label>FUM </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fur_ant" name="fur_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>FPP </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fpp_ant" name="fpp_ant" class="form-control" readonly>
                                                <div class="form-control-position">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Estudios Laboratorio </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="estudio_labant" id="estudio_labant" cols="150" rows="2" class="form-control" readonly></textarea>
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
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="verExpEmbModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-list"></i> Control Prenatal: <span id="pac_span" style="color:black"> </span>
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

                                    <table class="table" id="ag_segnone" style="display:none;">
                                        <thead>
                                            <tr>
                                                <th align="left" style="text-align:left; padding: 3px">
                                                    <a href="#" class="btn btn-info btn-min-width btn-glow" id="gen_seguimiento" style="color: white" role="button">
                                                        <i class="fas fa-arrow-right"></i> Agregar Seguimiento
                                                    </a>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>

                                    <div class="col-12">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive-lg">
                                                        <table id="expedienteEm_table" class="table table-bordered table-striped" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Exploraci&oacute;n F&iacute;sica</th>
                                                                    <th>Semana Gesta</th>
                                                                    <th>Peso</th>
                                                                    <th>Fondo Uterino</th>
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
                                                <input type="hidden" id="hidden_id_exp" name="hidden_id_exp">
                                                <a class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" style="color: white" role="button">
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

    <div id="altaSegModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-arrow-right"></i> Seguimiento
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaSegForm" class="form" style="font-size: 1.1em;">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_agEmb" role="alert" style="display:none"></div>
                                            <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_agEmbOK" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Exploraci&oacute;n F&iacute;sica</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="expl_fisi" id="expl_fisi" cols="150" rows="2" placeholder="Exploraci&oacute;n F&iacute;sica" class="form-control" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-check'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Presentaci&oacute;n </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="presentacion_s" id="presentacion_s" cols="150" rows="2" placeholder="Presentaci&oacute;n" class="form-control" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fa fa-list'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Semana Gesta </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Semana Gesta" id="sem_ges" name="sem_ges" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-calendar-week'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Peso</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" placeholder="Peso" id="peso_seg" name="peso_seg" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-weight'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>T/A </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Tensi&oacute;n Arterial" id="tension_seg" name="tension_seg" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-chevron-down'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label>Frecuencia Card&iacute;aca</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Frecuencia Card&iacute;aca" id="fc_seg" name="fc_seg" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fa fa-heartbeat'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Fondo Uterino</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Fondo Uterino" id="fu_seg" name="fu_seg" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                                <div class="form-control-position">
                                                    <i class='fa fa-align-right'></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Movimiento Fetal</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <select class="select2 form-control" id="otro" name="otro" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <div class="form-control-position">
                                                    <i class='fa fa-list'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Padecimiento</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <select class="select2 form-control" id="padecimiento_ac" name="padecimiento_ac" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <div class="form-control-position">
                                                    <i class='fa fa-diagnoses'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6" id="show_pad" style="display:none">
                                            <label>Padecimiento actual</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="padecimiento_actual" id="padecimiento_actual" cols="150" rows="2" class="form-control" placeholder="Procedimiento actual" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fa fa-edit'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="show_pro" style="display:none">
                                            <label>Procedimiento</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="procedimiento_realizado" id="procedimiento_realizado" cols="150" rows="2" class="form-control" placeholder="Procedimiento realizado" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fa fa-list'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-list"></i> Extras</h4>
                                        </div>

                                        <div class="col-12">
                                            <label>Recomendaciones</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="observaciones_seg" id="observaciones_seg" cols="150" rows="2" class="form-control" placeholder="Recomendaciones" onKeyUp="this.value = this.value.toUpperCase();"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fa fa-eye'></i>
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
                        <input type="hidden" id="hidden_id_seg" name="hidden_id_seg">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_conEm" id="reg_conEm" role="button">
                            <i class="fas fa-share"></i> Registrar
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="finalizar_CPModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-lock"></i> Cerrar Expediente
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="cerrar_cp">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_adddatabb" role="alert" style="display:none"></div>
                                        </div>

                                        <div class="col-12">
                                            <label>Agregar Datos Reci&eacute;n Nacido</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-list"></i>
                                                </div>
                                                <select class="select2 form-control" id="ag_databb" name="ag_databb" style="width: 100%;">
                                                    <option value="" selected>Seleccione</option>
                                                    <option value="1">Si</option>
                                                    <option value="2">NO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12" id="add_bebe" style="display:none">
                                            <div class="row">

                                                <div class="col-6">
                                                    <label>Fecha de Nacimiento </label> <span style="color:red"> *</span>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="date" id="fecha_nacimientobb" name="fecha_nacimientobb" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class="fas fa-birthday-cake"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label>Naci&oacute;</label><span style="color:red"> *</span>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <div class="form-control-position">
                                                            <i class="fas fa-list"></i>
                                                        </div>
                                                        <select class="select2 form-control" id="nacio" name="nacio" style="width: 100%;">
                                                            <option value="" selected>Seleccione</option>
                                                            <option value="Vivo">Vivo</option>
                                                            <option value="Muerto">Muerto</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label>Peso </label>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="number" placeholder="Peso Paciente KG" id="pesobb" name="pesobb" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class='fas fa-weight'></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label>Talla </label>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="number" placeholder="Talla Paciente CM" id="tallabb" name="tallabb" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class='fa fa-text-height'></i>
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
                            <i class="fas fa-ban"></i> Salir
                        </a>
                        <!-- <input type="reset" class="btn btn-info btn-min-width btn-glow" data-dismiss="modal" value="No">                         -->
                        <input type="hidden" id="hidden_id_pacbb" name="hidden_id_pacbb">
                        <input type="hidden" id="hidden_id_cpbb" name="hidden_id_cpbb">
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="end_cp" id="end_cp" role="button">
                            <i class="fas fa-share"></i> Finalizar
                        </a>
                    </div>
                </div>
                </form>
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

        $('#reg_expinicio').click(function() {

            let token = '{{csrf_token()}}';
            let id_paciente = $('#id_hidden_pacienteu').val();
            let id_expediente = $('#id_hidden_expediente').val();
            let fur = $('#fur').val();
            let fpp = $('#fpp').val();
            let estudio_laboratorio = $('#estudio_lab').val();

            let data = {
                id_paciente: id_paciente,
                id_expediente: id_expediente,
                fum: fur,
                fpp: fpp,
                estudio_laboratorio: estudio_laboratorio,
                _token: token
            };

            $.ajax({
                method: 'POST',
                url: '{{ route("regExpedienteEmdos") }}',
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
                    "url": "{{ url('Expediente/ControlPrenatald') }}",
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

        $(document).on('click', '.ver_antecedente', function() {
            let id_exp = $(this).attr('name');
            $.ajax({
                url: "/ControlP/DataAnt/" + id_exp,
                dataType: "json",
                success: function(data) {
                    $('#antecedentesModal').appendTo("body")
                    $('#antecedentesModal').modal('show');
                    //$('#antecedentesModal').css('overflow-y', 'auto');
                    /*$('#antecedentesModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });*/
                    $('#nombre_ant').val(data.nombre_c);
                    $('#fecha_nacimiento_ant').val(data.fecha_nacimiento);
                    $('#c_expant').val(data.fecha);
                    $('#gesta_ant').val(data.gesta);
                    $('#parto_ant').val(data.parto);
                    $('#cesarea_ant').val(data.cesarea);
                    $('#aborto_ant').val(data.aborto);
                    $('#fur_ant').val(data.fur);
                    $('#fpp_ant').val(data.fpp);
                    $('#estudio_labant').val(data.estudio_lab);
                }
            });
        });

        $(document).on('click', '.exp_emb', function() {
            let id_control = $(this).attr('id');
            let id_exp = $(this).attr('name');

            $('#hidden_id_exp').val(id_control);

            $('#verExpEmbModal').appendTo("body")
            $('#verExpEmbModal').modal('show');
            $('#ag_segnone').show();
            //$('#antecedentesModal').css('overflow-y', 'auto');
            /*$('#antecedentesModal > .modal-body').css({
                        width: 'auto',
                        height: 'auto',
                        'max-height': '100%'
                    });*/
            $.ajax({
                url: "/ControlP/DataAnt/" + id_exp,
                dataType: "json",
                success: function(data) {
                    pac_span.innerHTML = data.nombre_c;

                    $('#expedienteEm_table').DataTable({
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
                            "url": "{{ url('Expediente/CEmver') }}" + "/" + id_control,
                        },
                        responsive: true,
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'exploracion_fisica',
                                name: 'exploracion_fisica',
                            },
                            {
                                data: 'semana_gesta',
                                name: 'semana_gesta',
                            },
                            {
                                data: 'peso',
                                name: 'peso',
                            },
                            {
                                data: 'fondo_uterino',
                                name: 'fondo_uterino',
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
                }
            });
        });

        $('#gen_seguimiento').click(function() {
            let id_ex = $('#hidden_id_exp').val();
            $('#hidden_id_seg').val(id_ex);
            $('#altaSegModal').appendTo("body")
            $('#altaSegModal').modal('show');
        });

        $('#reg_conEm').click(function() {

            let token = '{{csrf_token()}}';
            let id_exp = $('#hidden_id_seg').val();
            let exploracion_fisica = $('#expl_fisi').val();
            let presentacion = $('#presentacion_s').val();
            let semana_gesta = $('#sem_ges').val();
            let peso = $('#peso_seg').val();
            let tension_arterial = $('#tension_seg').val();
            let frecuencia_cardiaca = $('#fc_seg').val();
            let fondo_uterino = $('#fu_seg').val();
            let movimiento_fetal = $('#otro').val();
            let recomendaciones = $('#observaciones_seg').val();
            let padecimiento = $('#padecimiento_ac').val();
            let padecimiento_actual = $('#padecimiento_actual').val();
            let procedimiento_realizado = $('#procedimiento_realizado').val();

            let data = {
                id_exp: id_exp,
                exploracion_fisica: exploracion_fisica,
                presentacion: presentacion,
                semana_gesta: semana_gesta,
                peso: peso,
                tension_arterial: tension_arterial,
                frecuencia_cardiaca: frecuencia_cardiaca,
                fondo_uterino: fondo_uterino,
                movimiento_fetal: movimiento_fetal,
                padecimiento: padecimiento,
                padecimiento_actual: padecimiento_actual,
                procedimiento_realizado: procedimiento_realizado,
                recomendaciones: recomendaciones,
                _token: token
            };

            $.ajax({
                method: 'POST',
                url: '{{ route("regConEmm") }}',
                data: data
            }).done(function(jqXHR) {
                $("#altaSegForm")[0].reset();
                $('#padecimiento_ac').val('').select2();
                $('#otro').val('').select2();
                $('#show_pad').hide();
                $('#show_pro').hide();
                $('#altaSegModal').modal('hide');
                $('#expedienteEm_table').DataTable().ajax.reload();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                }, 2000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_agEmb').empty()) {
                        $('#response_agEmb').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_agEmb').show().append(`
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
                        $('#response_agEmb').hide();
                    }, 4000);
                }
                if (jqXHR.status == 500) {
                    var responseText = jQuery.parseJSON(jqXHR.responseText);
                    $("#altaSegForm")[0].reset();
                    $('#altaSegModal').modal('hide');
                    $('#expedienteEm_table').DataTable().ajax.reload();
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
            columns: [
                /*{
                                    data: 'id',
                                    name: 'id'
                                },*/
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
            let id_paciente = $(this).attr('name');
            let id_expediente = $(this).attr('id');

            $.ajax({
                url: "/ControlP/DataExiste/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    alert('Error: Existe un expediente abierto con la paciente que seleccionó, ¡Favor de Verificar!')
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
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

                            $("#altaExpIni")[0].reset();

                            $('#id_hidden_em').val(id_paciente);
                            $('#id_hidden_pacienteu').val(id_paciente);
                            $('#id_hidden_expediente').val(id_expediente);
                            $('#nombre_select_em').val(data.nombre + " " + data.ap_paterno + " " + data.ap_materno);
                            $('#fecha_nacimiento_em').val(data.fecha_nacimiento);
                            $('#edad_em').val(data.edad);
                        }
                    });
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

        $(document).on('click', '.finalizar_cp', function() {
            let id_consulta = $(this).attr('id');
            let id_paciente = $(this).attr('name');

            $('#hidden_id_cpbb').val(id_consulta);
            $('#hidden_id_pacbb').val(id_paciente);
            $('#finalizar_CPModal').appendTo("body")
            $('#finalizar_CPModal').modal('show');
            $("#cerrar_cp")[0].reset();
            $("#nacio").val("").select2();
            $('#add_bebe').hide();
        });

        $('#ag_databb').change(function() {
            let add = $('#ag_databb').val();
            //$("#cerrar_cp")[0].reset();
            $("#nacio").val("").select2();
            $("#fecha_nacimientobb").val("");
            $("#pesobb").val("");
            $("#tallabb").val("");

            if (add == 1) {
                $('#add_bebe').show();
            } else if (add == 2) {
                $('#add_bebe').hide();
            }
        });

        $('#end_cp').click(function() {
            let id_consulta = $('#hidden_id_cpbb').val();
            let id_paciente = $('#hidden_id_pacbb').val();
            let token = '{{csrf_token()}}';
            let fecha_nacimiento = $('#fecha_nacimientobb').val();
            let nacio = $('#nacio').val();
            let peso = $('#pesobb').val();
            let talla = $('#tallabb').val();
            let question = $('#ag_databb').val();

            let data = {
                id_consulta: id_consulta,
                id_paciente: id_paciente,
                fecha_nacimiento: fecha_nacimiento,
                nacio: nacio,
                peso: peso,
                talla: talla,
                question: question,
                _token: token
            };

            if (question == "") {
                alert("Seleccione una opción");
            } else {
                let respuesta = confirm("¡El expediente se Finalizará!");
                if (respuesta) {
                    $.ajax({
                        method: 'POST',
                        url: '{{ route("end_expCP") }}',
                        data: data
                    }).done(function(jqXHR) {
                        $("#cerrar_cp")[0].reset();
                        $("#nacio").val("").select2();
                        $('#finalizar_CPModal').modal('hide');
                        $('#consultaE_tables').DataTable().ajax.reload();
                        ok(jqXHR);
                        setTimeout(function() {
                            $('#ok').hide();
                        }, 2000);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 422) {
                            if (!$('#response_adddatabb').empty()) {
                                $('#response_adddatabb').empty();
                            }

                            $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function(key, value) {
                                        $('#response_adddatabb').show().append(`
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
                                    $('#response_adddatabb').hide();
                                }, 5000);
                            });
                        }
                        if (jqXHR.status == 442) {
                            if (!$('#response_adddatabb').empty()) {
                                $('#response_adddatabb').empty();
                            }
                            let responseText = jQuery.parseJSON(jqXHR.responseText);
                            $('#response_adddatabb').show().append(`
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
                                $('#response_adddatabb').hide();
                            }, 5000);

                        }
                        if (jqXHR.status == 500) {
                            let responseText = jQuery.parseJSON(jqXHR.responseText);
                            $("#cerrar_cp")[0].reset();
                            $("#nacio").val("").select2();
                            $('#finalizar_CPModal').modal('hide');
                            $('#consultaE_tables').DataTable().ajax.reload();
                            errorRazon(responseText)

                        }
                    });
                }
            }
        });

        $(document).on('change', '#fur', function() {
            let fum = $('#fur').val();
            $.ajax({
                url: "/ControlP/Calculofpp/" + fum,
                // dataType: "json",
                success: function(data) {
                    $('#fpp').val(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });

        });

        $('#cerrarImprimir').click(function() {
            $('#pdfModal').modal('hide');
        });

        $(document).on('change', '#padecimiento_ac', function() {
            let respuesta = $('#padecimiento_ac').val();

            if (respuesta == "Si") {
                $('#show_pad').show();
                $('#show_pro').show();
            } else {
                $('#show_pad').hide();
                $('#show_pro').hide();
            }
        });


        $('#cerrarImprimir2').click(function() {
            $('#pdfModal').modal('hide');
        });

    });
</script>

<script>
    jQuery(document).ready(function($) {


    });
</script>

@endsection