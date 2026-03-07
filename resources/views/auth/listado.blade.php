@extends('layouts.menu')
@section('title')
: Usuarios
@endsection
@section('content')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" defer></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />

<style>
    /* ==================================================
       SISTEMA DE DISEÑO PREMIUM - SAAS UI (USUARIOS)
       ================================================== */

    /* --- Tarjetas y Botones Principales --- */
    .card-premium {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        background-color: #ffffff;
    }

    .btn-info {
        background-color: #0d9488 !important;
        border: none !important;
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2) !important;
        color: #fff !important;
    }

    .btn-info:hover {
        background-color: #0f766e !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 8px -1px rgba(13, 148, 136, 0.3) !important;
    }

    /* --- DataTables Premium --- */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
        margin-top: 1rem !important;
    }

    table.dataTable thead th {
        border-bottom: 2px solid #e2e8f0 !important;
        border-top: none !important;
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 14px 15px;
    }

    table.dataTable thead th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    table.dataTable thead th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    table.dataTable tbody td {
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle;
        padding: 16px 15px;
        color: #1e293b;
        font-weight: 500;
        font-size: 0.9rem;
    }

    table.dataTable tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    .dataTables_wrapper .row {
        align-items: center;
        margin-bottom: 0.5rem;
    }

    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: 500;
        color: #64748b;
        font-size: 0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 0.5rem 1.2rem;
        width: 250px;
        background-color: #f8fafc;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    div.dataTables_wrapper div.dataTables_filter input:focus {
        outline: none;
        background-color: #ffffff;
        border-color: #0d9488;
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        border: none !important;
        padding: 0.4rem 0.8rem !important;
        margin: 0 3px !important;
        font-weight: 600;
        color: #64748b !important;
        background: transparent !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d9488 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);
    }

    /* --- Modales Globales --- */
    .modal-content {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden;
    }

    .modal-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.5rem 1.5rem 1rem;
    }

    .modal-header .modal-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.25rem;
    }

    .modal-header .close {
        margin-top: -1rem;
        color: #64748b;
        opacity: 0.7;
        transition: 0.2s;
    }

    .modal-header .close:hover {
        opacity: 1;
        color: #ef4444;
    }

    .modal-body {
        padding: 1.5rem;
        background-color: #ffffff;
        overflow-x: hidden;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        background-color: #f8fafc;
        padding: 1rem 1.5rem;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    /* --- Formularios (Responsivos) --- */
    .form-group {
        margin-bottom: 1.2rem;
        width: 100%;
    }

    .form-group label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
        color: #334155;
        transition: all 0.2s;
        box-shadow: none;
        background-color: #f8fafc;
        width: 100% !important;
        box-sizing: border-box !important;
        height: calc(2.25rem + 10px) !important;
    }

    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 10px) !important;
    }

    .form-control:focus {
        background-color: #ffffff;
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
    }

    textarea.form-control {
        height: auto !important;
        resize: none;
    }

    /* --- Bugs de Librerías (Select2 y Tablas) --- */
    .select2-container {
        width: 100% !important;
        max-width: 100%;
    }

    .select2-container .select2-selection--single {
        height: calc(2.25rem + 10px) !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #f8fafc !important;
        display: flex;
        align-items: center;
        padding-left: 29px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
    }

    .has-icon-left .form-control,
    .has-icon-left .select2-selection__rendered {
        padding-left: 2.8rem !important;
    }

    .has-icon-left .form-control-position {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        width: 2.8rem;
        text-align: center;
        margin-top: 13px;
        z-index: 4;
    }

    .has-icon-left .form-control-position i {
        color: #94a3b8;
        font-size: 1.1rem;
    }

    .modal-body .table-responsive {
        width: 100%;
        overflow-x: auto;
        display: block;
        -webkit-overflow-scrolling: touch;
    }

    /* --- Botones Modales Específicos de Usuarios --- */
    .modal-footer .btn-info {
        background-color: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: none !important;
        padding: 0.5rem 1.2rem;
    }

    .modal-footer .btn-info:hover {
        background-color: #e2e8f0 !important;
        color: #1e293b !important;
    }

    #add_user,
    .btn-danger {
        background-color: #0d9488 !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2) !important;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
    }

    #add_user:hover,
    .btn-danger:hover {
        background-color: #0f766e !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 8px -1px rgba(13, 148, 136, 0.3) !important;
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
                                            <a class="btn btn-info btn-min-width btn-glow" style="color: white" id="create_record" role="button">
                                                <i class="fa fa-user-plus"></i> Agregar
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <table id="users_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre completo</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Tipo Usuario</th>
                                        <th>Estatus</th>
                                        <th width="15%">Acci&oacute;n</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Modal -->


            </div>
        </div>

    </div>

    <div id="altaUModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-user-plus"></i> Agregar usuario
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="altaUsuario" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_user" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre(s) </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Nombre(s)" id="nombre" name="nombre" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Apellido paterno </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Apellido paterno" id="ap_pat" name="ap_pat" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Apellido Materno</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Apellido materno" id="ap_mat" name="ap_mat" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
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
                                            <label>Tipo </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <select class="select2 form-control" id="tipo_usuario" name="tipo_usuario" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    @foreach($tipoU as $x)
                                                    <option value="{{ $x->id }}">{{ $x->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12" id="medico_show" style="display:none">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4 class="form-section"><i class="fas fa-stethoscope"></i> Datos del Médico</h4>
                                                </div>

                                                <div class="col-4">
                                                    <label>C&eacute;dula </label><span style="color:red"> *</span>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="text" onKeyUp="this.value = this.value.toUpperCase();" placeholder="Cédula Profesional" id="cedula" name="cedula" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class="fas fa-layer-group"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label>Especialidad </label><span style="color:red"> *</span>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="text" placeholder="Especialidad" id="especialidad" name="especialidad" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class="fas fa-bars"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label>Whatsapp </label><span style="color:red"> *</span>
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="number" placeholder="Whatsapp" id="whatsapp" name="whatsapp" class="form-control">
                                                        <div class="form-control-position">
                                                            <i class="fas fa-bars"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-user-check"></i> Datos de acceso</h4>
                                        </div>

                                        <div class="col-6">
                                            <label>Usuario </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" placeholder="Usuario" id="usuario_name" name="usuario_name" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-lock"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Email </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="email" placeholder="Email" id="email" name="email" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user-lock"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Contraseña </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="password" placeholder="Contraseña" id="password" name="password" class="form-control">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label> Confirmar Contraseña </label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                <div class="form-control-position">
                                                    <i class="fas fa-user"></i>
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
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_user" id="reg_user" role="button">
                            <i class="fas fa-share"></i> Registrar
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>


</div>
</div>

@endsection

@section('scripts')
<script>
    jQuery(document).ready(function($) {

        $('.select2').each(function() {
            var modalPadre = $(this).closest('.modal');
            $(this).select2({
                dropdownParent: modalPadre.length ? modalPadre : $(document.body),
                width: '100%'
            });
        });

        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        $('.modal').on('shown.bs.modal', function() {
            var $tablas = $(this).find('table.dataTable');
            if ($tablas.length > 0) {
                $tablas.DataTable().columns.adjust().responsive.recalc();
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
        $('#create_record').click(function() {
            $('#altaUModal').modal('show');
        });

        $(document).on('change', '#tipo_usuario', function() {
            let usuario = $('#tipo_usuario').val();

            if (usuario == 2) {
                $('#medico_show').show();
                //$('#altaCModal').css('overflow-y', 'auto');
                //$('#altaCModal > .modal-body').css({width:'auto',height:'auto', 'max-height':'100%'});
            } else {
                $('#medico_show').hide();
            }
        });

        $('#users_table').DataTable({
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
                "url": "{{ url('usuarios') }}",
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
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'n_tipo',
                    name: 'n_tipo',
                },
                {
                    data: 'estatus_u',
                    name: 'estatus_u',
                },
                {
                    data: 'accion',
                    name: 'accion',
                }
            ]

        });

        $('#reg_user').click(function() {
            let token = '{{csrf_token()}}';
            let nombre = $('#nombre').val();
            let ap_pat = $('#ap_pat').val();
            let ap_mat = $('#ap_mat').val();
            let tipo_usuario = $('#tipo_usuario').val();
            let cedula = $('#cedula').val();
            let whatsapp = $('#whatsapp').val();
            let name = $('#usuario_name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let password_confirmation = $('#password-confirm').val();
            let genero = $('#genero').val();
            let especialidad = $('#especialidad').val();

            let data = {
                nombre: nombre,
                ap_pat: ap_pat,
                ap_mat: ap_mat,
                tipo_usuario: tipo_usuario,
                cedula: cedula,
                genero: genero,
                whatsapp: whatsapp,
                especialidad: especialidad,
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("UsuarioRegistro") }}',
                data: data
            }).done(function(jqXHR) {
                $('#altaUModal').modal('hide');
                $('#tipo_usuario').val("").select2();
                $('#genero').val("").select2();
                $("#altaUsuario")[0].reset();
                $('#users_table').DataTable().ajax.reload();
                $('#response_user').hide();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                }, 3000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_user').empty()) {
                        $('#response_user').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_user').show().append(`
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
                    let responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#users_table').DataTable().ajax.reload();
                    $('#altaUModal').modal('hide');
                    $('#tipo_usuario').val("").select2();
                    $("#altaUsuario")[0].reset();
                    $('#response_user').hide();
                    errorRazon(responseText)


                }
            });
        });

    });
</script>


@endsection