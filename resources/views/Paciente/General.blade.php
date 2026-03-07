
@extends('layouts.menu')
@section('title')
: Pacientes
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css" />

<style>
    /* ==================================================
       SISTEMA DE DISEÑO PREMIUM - SAAS UI
       ================================================== */
    .card-premium { border: none; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025); background-color: #ffffff; }
    .btn-teal { background-color: #0d9488; color: #ffffff !important; border: none; border-radius: 8px; padding: 0.6rem 1.2rem; font-weight: 600; transition: all 0.2s ease; }
    .btn-teal:hover { background-color: #0f766e; transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.4); }
    .btn-light-premium { background-color: #f1f5f9; color: #475569 !important; border: none; border-radius: 8px; padding: 0.6rem 1.2rem; font-weight: 600; transition: all 0.2s; }
    .btn-light-premium:hover { background-color: #e2e8f0; color: #1e293b !important; }

    table.dataTable { border-collapse: collapse !important; width: 100% !important; margin-top: 1rem !important; }
    table.dataTable thead th { border-bottom: 2px solid #e2e8f0 !important; border-top: none !important; background-color: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 14px 15px; }
    table.dataTable thead th:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    table.dataTable thead th:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    table.dataTable tbody td { border-bottom: 1px solid #f1f5f9 !important; vertical-align: middle; padding: 16px 15px; color: #1e293b; font-weight: 500; font-size: 0.9rem; }
    table.dataTable tbody tr:hover td { background-color: #f8fafc !important; }
    .table-bordered th, .table-bordered td { border: none !important; border-bottom: 1px solid #f1f5f9 !important; }

    .dataTables_wrapper .row { align-items: center; margin-bottom: 0.5rem; }
    div.dataTables_wrapper div.dataTables_filter label { font-weight: 500; color: #64748b; font-size: 0; display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;}
    div.dataTables_wrapper div.dataTables_filter input { border-radius: 20px; border: 1px solid #cbd5e1; padding: 0.5rem 1.2rem; width: 250px; background-color: #f8fafc; font-size: 0.85rem; transition: all 0.3s; }
    div.dataTables_wrapper div.dataTables_filter input:focus { outline: none; background-color: #ffffff; border-color: #0d9488; box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1); }
    div.dataTables_wrapper div.dataTables_length label { display: flex; align-items: center; gap: 0.5rem; font-weight: 500; color: #64748b; }
    div.dataTables_wrapper div.dataTables_length select { border-radius: 8px; border: 1px solid #cbd5e1; padding: 0.3rem 0.8rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 8px !important; border: none !important; padding: 0.4rem 0.8rem !important; margin: 0 3px !important; font-weight: 600; color: #64748b !important; background: transparent !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #1e293b !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #0d9488 !important; color: #ffffff !important; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2); }

    .modal-content { border: none; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 1.5rem 2rem; border-radius: 20px 20px 0 0; background-color: #ffffff; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 1.2rem 2rem; background-color: #f8fafc; border-radius: 0 0 20px 20px; }
    label { font-weight: 600; color: #475569; font-size: 0.85rem; margin-bottom: 0.4rem; }
    .form-control { border: 1px solid #cbd5e1; border-radius: 10px; padding: 0.6rem 1rem; color: #334155; font-weight: 500; height: calc(2.8rem + 2px); transition: all 0.2s; background-color: #f8fafc;}
    .form-control:focus { background-color: #ffffff; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
    .has-icon-left { position: relative; }
    .has-icon-left .form-control { padding-left: 2.8rem !important; }
    .has-icon-left .form-control-position { position: absolute; top: 50%; transform: translateY(-50%); left: 14px; color: #94a3b8; z-index: 10; pointer-events: none; }
    .select2-container .select2-selection--single { border: 1px solid #cbd5e1 !important; border-radius: 10px !important; height: calc(2.8rem + 2px) !important; display: flex; align-items: center; background-color: #f8fafc; }
    .select2-container .select2-selection--single .select2-selection__rendered { padding-left: 2.8rem; font-weight: 500; color: #334155; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { top: 50%; transform: translateY(-50%); right: 10px; }

    html body .content .content-wrapper { padding: 0.5rem 2rem 0; }
</style>
@endsection

@section('content')
<div class="container-fluid mb-5">
    
    @if(session('Ok2'))
    <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2 text-white" role="alert" style="border-radius: 10px;">
        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Excelente!</strong> {{session('Ok2')}}
    </div>
    @endif

    @if(session('Error2'))
    <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2 text-white" role="alert" style="border-radius: 10px;">
        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Error!</strong> {{session('Error2')}}
    </div>
    @endif

    <div id="errorRazon" style="display:none" class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2 text-white" role="alert" style="border-radius: 10px;">
        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Error!</strong> <span id="error1"></span>
    </div>

    <div id="ok" style="display:none" class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2 text-white" role="alert" style="border-radius: 10px;">
        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>¡Excelente!</strong> <span id="ok1"></span>
    </div>

    <div class="row mb-4 align-items-center mt-3">
        <div class="col-md-6">
            <h2 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 1.8rem; letter-spacing: -0.5px;">Listado de Pacientes</h2>
            <p class="mb-0" style="color: #64748b; font-size: 0.95rem;">Directorio general y expedientes</p>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-teal" id="agregar_paciente">
                <i class="fas fa-user-plus mr-1"></i> Agregar Paciente
            </button>
        </div>
    </div>

    <div class="card card-premium">
        <div class="card-body p-4">
            <div class="table-responsive" style="overflow-x: hidden;">
                <table id="paciente_tables" class="table dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Tipo Sangre</th>
                            <th>Celular</th>
                            <th width="15%">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="altaPacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 800; color: #0f172a;" id="myModalLabel34">
                    <i class="fas fa-user-plus text-teal mr-2" style="color: #0d9488;"></i> Agregar Paciente
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="altaPaciente" class="form" autocomplete="off">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1 text-white" id="response_paciente" role="alert" style="display:none; border-radius: 8px;"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nombre(s) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre(s)" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Paterno <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_pat" name="ap_pat" class="form-control" placeholder="Apellido paterno" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Materno</label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_mat" name="ap_mat" class="form-control" placeholder="Apellido materno" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" max="{{ date('Y-m-d') }}" class="form-control">
                                <div class="form-control-position"><i class="fas fa-birthday-cake"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edad (Años) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="number" id="edad" name="edad" placeholder="Edad" class="form-control" readonly>
                                <div class="form-control-position"><i class="fas fa-sort"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tipo Sangre <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-user-shield"></i></div>
                                <select class="select2 form-control" id="tipo_sangre" name="tipo_sangre" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    @foreach($tipoS as $x)
                                    <option value="{{ $x->id }}">{{ $x->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Género <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fa fa-user"></i></div>
                                <select class="select2 form-control" id="genero" name="genero" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    <option value="M">Femenino</option>
                                    <option value="H">Masculino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Talla (CM) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="number" id="talla" name="talla" placeholder="Talla Paciente CM" class="form-control">
                                <div class="form-control-position"><i class='fa fa-text-height'></i></div>
                            </div>
                        </div>

                        <div class="col-12 mt-3 mb-2">
                            <h6 class="text-uppercase text-muted" style="font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;"><i class="fas fa-user-check mr-1"></i> Datos de Contacto</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Celular</label>
                            <div class="has-icon-left">
                                <input type="text" id="celular" name="celular" placeholder="10 dígitos" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                <div class="form-control-position"><i class="fas fa-mobile-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Correo</label>
                            <div class="has-icon-left">
                                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" class="form-control">
                                <div class="form-control-position"><i class="fas fa-envelope"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Contacto Emergencia</label>
                            <div class="has-icon-left">
                                <input type="text" id="contacto_emergencia" name="contacto_emergencia" placeholder="10 dígitos" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                <div class="form-control-position"><i class="fas fa-phone-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light-premium" data-dismiss="modal">
                        <i class="fas fa-ban mr-1"></i> Salir
                    </button>
                    <input type="hidden" id="hidden_id" name="hidden_id">
                    <button type="button" class="btn btn-teal" id="registrar_paciente">
                        <i class="fas fa-share mr-1"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="detalles_pacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 800; color: #0f172a;" id="myModalLabel34">
                    <i class="fas fa-list text-teal mr-2" style="color: #0d9488;"></i> Datos Paciente
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="altaPaciente2" class="form" autocomplete="off">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1 text-white" id="response_paciente_detalle" role="alert" style="display:none; border-radius: 8px;"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nombre(s) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="nombre_detalle" name="nombre_detalle" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Paterno <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_pat_detalle" name="ap_pat_detalle" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Materno</label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_mat_detalle" name="ap_mat_detalle" placeholder="Apellido Materno" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="date" id="fecha_nacimiento_detalle" name="fecha_nacimiento_detalle" max="{{ date('Y-m-d') }}" class="form-control">
                                <div class="form-control-position"><i class="fas fa-birthday-cake"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edad (Años) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="number" id="edad_detalle" name="edad_detalle" class="form-control" readonly>
                                <div class="form-control-position"><i class="fas fa-sort"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tipo Sangre <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-user-shield"></i></div>
                                <select class="select2 form-control" id="tipo_sangre_detalle" name="tipo_sangre_detalle" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    @foreach($tipoS as $x)
                                    <option value="{{ $x->id }}">{{ $x->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Género <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fa fa-user"></i></div>
                                <select class="select2 form-control" id="genero_detalle" name="genero_detalle" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    <option value="M">Femenino</option>
                                    <option value="H">Masculino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Talla (CM) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="number" id="talla_detalle" name="talla_detalle" class="form-control">
                                <div class="form-control-position"><i class='fa fa-text-height'></i></div>
                            </div>
                        </div>

                        <div class="col-12 mt-3 mb-2">
                            <h6 class="text-uppercase text-muted" style="font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;"><i class="fas fa-user-check mr-1"></i> Datos de Contacto</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Celular</label>
                            <div class="has-icon-left">
                                <input type="text" id="celular_detalle" name="celular_detalle" placeholder="10 dígitos" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                <div class="form-control-position"><i class="fas fa-mobile-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Correo</label>
                            <div class="has-icon-left">
                                <input type="email" id="email_detalle" name="email_detalle" placeholder="ejemplo@correo.com" class="form-control">
                                <div class="form-control-position"><i class="fas fa-envelope"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Contacto Emergencia</label>
                            <div class="has-icon-left">
                                <input type="text" id="contacto_emergencia_detalle" name="contacto_emergencia_detalle" placeholder="10 dígitos" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                <div class="form-control-position"><i class="fas fa-phone-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light-premium" data-dismiss="modal">
                        <i class="fas fa-ban mr-1"></i> Salir
                    </button>
                    <input type="hidden" id="hidden_id_detalle" name="hidden_id_detalle">
                    <button type="button" class="btn btn-teal" id="editar_paciente">
                        <i class="fas fa-share mr-1"></i> Actualizar Datos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<script>
    jQuery(document).ready(function($) {

        // ==========================================
        // ESTÉTICA DE DATATABLES
        // ==========================================
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                search: "", 
                searchPlaceholder: "Buscar paciente...",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ al _END_ de _TOTAL_ pacientes",
                paginate: {
                    first: "Primero", last: "Último",
                    next: "<i class='fas fa-chevron-right'></i>", previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        $('#alertaAlta').hide();
        $('#alertaEli').hide();
        $('#alertaMod').hide();
        $('#errorRazon').hide();

        function errorRazon(valor) {
            $('#error1').html('<span>' + valor + '</span>');
            $('#errorRazon').show();
        }

        function ok(valor) {
            $('#ok1').html('<span>' + valor + '</span>');
            $('#ok').show();
        }

        // ==========================================
        // RESETEAR MODALES AL CERRAR (Requisito Nuevo)
        // ==========================================
        $('#altaPacienteModal').on('hidden.bs.modal', function () {
            $('#altaPaciente')[0].reset();
            $('#tipo_sangre').val("").trigger('change');
            $('#genero').val("").trigger('change');
            $('#response_paciente').hide().empty();
        });

        $('#detalles_pacienteModal').on('hidden.bs.modal', function () {
            $('#altaPaciente2')[0].reset();
            $('#tipo_sangre_detalle').val("").trigger('change');
            $('#genero_detalle').val("").trigger('change');
            $('#response_paciente_detalle').hide().empty();
        });

        // ==========================================
        // FUNCIONALIDAD ORIGINAL
        // ==========================================
        $('#agregar_paciente').click(function() {
            $('#altaPacienteModal').modal('show');
            $('#tipo_sangre').select2({ dropdownParent: $('#altaPacienteModal') });
            $('#genero').select2({ dropdownParent: $('#altaPacienteModal') });
        });

        $(document).on('change', '#fecha_nacimiento', function() {
            let fecha_nacimiento = $('#fecha_nacimiento').val();
            let hoy = new Date();
            let nacimiento = new Date(fecha_nacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            let m = hoy.getMonth() - nacimiento.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) { edad--; }
            $('#edad').val(edad);
        });

        $(document).on('change', '#fecha_nacimiento_detalle', function() {
            let fecha_nacimiento = $('#fecha_nacimiento_detalle').val();
            let hoy = new Date();
            let nacimiento = new Date(fecha_nacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            let m = hoy.getMonth() - nacimiento.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) { edad--; }
            $('#edad_detalle').val(edad);
        });

        $('#paciente_tables').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "order": [[1, 'asc']],
            processing: true,
            serverSide: true,
            scrollY: '50vh',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                "search": "",
                "searchPlaceholder": "Buscar paciente..."
            },
            ajax: { "url": "{{ url('pacientes') }}" },
            responsive: true,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_c', name: 'nombre_c' },
                { data: 'edad', name: 'edad' },
                { data: 'tipo', name: 'tipo' },
                { data: 'celular', name: 'celular' },
                { data: 'accion', name: 'accion' }
            ]
        });

        // ==========================================
        // FUNCIÓN AUXILIAR DE VALIDACIÓN FRONTEND
        // ==========================================
        function validarFormulario(celular, emergencia, email) {
            let errores = [];
            const regexEmail = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

            if (celular && celular.length !== 10) {
                errores.push("El <b>Celular</b> debe tener exactamente 10 dígitos.");
            }
            if (emergencia && emergencia.length !== 10) {
                errores.push("El <b>Contacto de Emergencia</b> debe tener exactamente 10 dígitos.");
            }
            if (email && !regexEmail.test(email)) {
                errores.push("El formato del <b>Correo Electrónico</b> es inválido.");
            }
            return errores;
        }

        // ==========================================
        // REGISTRAR (Con Validación Frontend)
        // ==========================================
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

            // EJECUTAMOS VALIDACIÓN DE UX
            let fallos = validarFormulario(celular, contacto_emergencia, email);
            if(fallos.length > 0) {
                $('#response_paciente').empty().show();
                fallos.forEach(function(errorMsg) {
                    $('#response_paciente').append(`
                        <div class="mb-1">
                            <i class="fa fa-exclamation-circle mr-2"></i> ${errorMsg}
                        </div>
                    `);
                });
                setTimeout(function(){ $('#response_paciente').fadeOut(); }, 5000);
                return false; // Evitamos que avance
            }

            let data = {
                nombre: nombre, ap_pat: ap_pat, ap_mat: ap_mat, fecha_nacimiento: fecha_nacimiento,
                edad: edad, tipo_sangre: tipo_sangre, celular: celular, email: email,
                contacto_emergencia: contacto_emergencia, genero: genero, talla: talla, _token: token
            };

            let respuesta = confirm("¡Al dar clic en aceptar se registrarán los datos del paciente!");
            if (respuesta) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("PacienteRegistro") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#altaPacienteModal').modal('hide'); // El evento hidden.bs.modal limpiará todo
                    $('#paciente_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() { $('#ok').hide(); }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        $('#response_paciente').empty();
                        $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, msg) {
                                    $('#response_paciente').show().append(`
                                        <div class="mb-1"><i class="fa fa-exclamation-circle mr-2"></i> ${msg}</div>
                                    `);
                                });
                            }
                        });
                        setTimeout(function() { $('#response_paciente').fadeOut(); }, 4000);
                    }
                    if (jqXHR.status == 500) {
                        var responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#paciente_tables').DataTable().ajax.reload();
                        $('#altaPacienteModal').modal('hide');
                        errorRazon(responseText)
                    }
                });
            }
        });

        // ==========================================
        // MOSTRAR DETALLES
        // ==========================================
        $(document).on('click', '.detalles_paciente', function() {
            let id_paciente = $(this).attr('id');
            $('#hidden_id_detalle').val(id_paciente);
            $('#detalles_pacienteModal').appendTo("body");
            $('#detalles_pacienteModal').modal('show');
            
            $('#tipo_sangre_detalle').select2({ dropdownParent: $('#detalles_pacienteModal') });
            $('#genero_detalle').select2({ dropdownParent: $('#detalles_pacienteModal') });

            $.ajax({
                url: "/pacientes/consulta/" + id_paciente,
                dataType: "json",
                success: function(data) {
                    $('#nombre_detalle').val(data.nombre);
                    $('#ap_pat_detalle').val(data.ap_paterno);
                    $('#ap_mat_detalle').val(data.ap_materno);
                    $('#fecha_nacimiento_detalle').val(data.fecha_nacimiento);
                    $('#edad_detalle').val(data.edad);
                    $('#tipo_sangre_detalle').val(data.tipo_sangre).select2();
                    $('#genero_detalle').val(data.genero).select2();
                    $('#talla_detalle').val(data.talla);
                    $('#celular_detalle').val(data.celular);
                    $('#email_detalle').val(data.correo);
                    $('#contacto_emergencia_detalle').val(data.contacto_emergencia);
                }
            });
        });

        // ==========================================
        // EDITAR (Con Validación Frontend)
        // ==========================================
        $('#editar_paciente').click(function() {
            let token = '{{csrf_token()}}';
            let id_paciente = $('#hidden_id_detalle').val();
            let nombre = $('#nombre_detalle').val();
            let ap_pat = $('#ap_pat_detalle').val();
            let ap_mat = $('#ap_mat_detalle').val();
            let fecha_nacimiento = $('#fecha_nacimiento_detalle').val();
            let edad = $('#edad_detalle').val();
            let tipo_sangre = $('#tipo_sangre_detalle').val();
            let celular = $('#celular_detalle').val();
            let email = $('#email_detalle').val();
            let contacto_emergencia = $('#contacto_emergencia_detalle').val();
            let genero = $('#genero_detalle').val();
            let talla = $('#talla_detalle').val();

            // EJECUTAMOS VALIDACIÓN DE UX
            let fallos = validarFormulario(celular, contacto_emergencia, email);
            if(fallos.length > 0) {
                $('#response_paciente_detalle').empty().show();
                fallos.forEach(function(errorMsg) {
                    $('#response_paciente_detalle').append(`
                        <div class="mb-1"><i class="fa fa-exclamation-circle mr-2"></i> ${errorMsg}</div>
                    `);
                });
                setTimeout(function(){ $('#response_paciente_detalle').fadeOut(); }, 5000);
                return false; 
            }

            let data = {
                nombre: nombre, ap_pat: ap_pat, ap_mat: ap_mat, fecha_nacimiento: fecha_nacimiento,
                edad: edad, tipo_sangre: tipo_sangre, celular: celular, email: email,
                contacto_emergencia: contacto_emergencia, genero: genero, id_paciente: id_paciente,
                talla: talla, _token: token
            };

            let respuesta = confirm("¡Al dar clic en aceptar se actualizarán los datos del paciente!");
            if (respuesta) {
                $.ajax({
                    method: 'PUT',
                    url: '{{ route("PacienteEditar") }}',
                    data: data
                }).done(function(jqXHR) {
                    $('#detalles_pacienteModal').modal('hide'); // El evento hidden lo limpia solo
                    $('#paciente_tables').DataTable().ajax.reload();
                    ok(jqXHR);
                    setTimeout(function() { $('#ok').hide(); }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        $('#response_paciente_detalle').empty();
                        $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, msg) {
                                    $('#response_paciente_detalle').show().append(`
                                        <div class="mb-1"><i class="fa fa-exclamation-circle mr-2"></i> ${msg}</div>
                                    `);
                                });
                            }
                        });
                        setTimeout(function() { $('#response_paciente_detalle').fadeOut(); }, 4000);
                    }
                    if (jqXHR.status == 500) {
                        var responseText = jQuery.parseJSON(jqXHR.responseText);
                        $('#paciente_tables').DataTable().ajax.reload();
                        $('#detalles_pacienteModal').modal('hide');
                        errorRazon(responseText)
                    }
                });
            }
        });

    });
</script>
@endsection