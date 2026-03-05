@extends('layouts.menu')

@section('title', 'Agenda y Citas')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<style>
    /* ==================================================
       TEMA PREMIUM CLÍNICO - CSS OVERRIDES
       ================================================== */
    .card-premium {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        background-color: #ffffff;
    }

    .btn-teal {
        background-color: #0d9488;
        color: #ffffff !important;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-teal:hover {
        background-color: #0f766e;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.4);
    }

    .btn-light-premium {
        background-color: #f1f5f9;
        color: #475569 !important;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-light-premium:hover {
        background-color: #e2e8f0;
        color: #1e293b !important;
    }

    /* Modales Redondeados */
    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.5rem 2rem;
        border-radius: 20px 20px 0 0;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 1.2rem 2rem;
        background-color: #f8fafc;
        border-radius: 0 0 20px 20px;
    }

    /* ==================================================
       FIX: INPUTS E ÍCONOS PERFECTAMENTE ALINEADOS
       ================================================== */
    label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
    }

    .form-control {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        color: #334155;
        font-weight: 500;
        transition: all 0.2s;
        height: calc(2.5rem + 2px);
    }

    .form-control:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }

    .has-icon-left {
        position: relative;
    }

    .has-icon-left .form-control {
        padding-left: 2.8rem !important;
    }

    .has-icon-left .form-control-position {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 14px;
        color: #94a3b8;
        z-index: 10;
        pointer-events: none;
        /* Permite hacer clic "a través" del ícono */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .select2-container .select2-selection--single {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        height: calc(2.5rem + 2px) !important;
        display: flex;
        align-items: center;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 2.8rem;
        font-weight: 500;
        color: #334155;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 50%;
        transform: translateY(-50%);
        right: 10px;
    }

    /* ==================================================
       FIX: DATATABLES "MOSTRAR REGISTROS" Y BUSCADOR
       ================================================== */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
        margin-top: 1rem !important;
    }

    table.dataTable thead th {
        border-bottom: 2px solid #e2e8f0 !important;
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 10px;
    }

    table.dataTable tbody td {
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        padding: 12px 10px;
    }

    .dataTables_wrapper .row {
        align-items: center;
        margin-bottom: 0.5rem;
    }

    /* Filtro de cantidad de registros */
    div.dataTables_wrapper div.dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        color: #64748b;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: auto;
        display: inline-block;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 0.3rem 1rem;
        color: #334155;
    }

    /* Buscador DataTables */
    div.dataTables_wrapper div.dataTables_filter label {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        font-weight: 500;
        color: #64748b;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 0.4rem 1rem;
        display: inline-block;
        width: 250px;
    }

    div.dataTables_wrapper div.dataTables_filter input:focus {
        outline: none;
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }
</style>
@endsection

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="mb-0" style="font-weight: 800; color: #1e293b;">Agenda y Citas</h3>
        <p class="text-muted mb-0">Gestión de consultas y programación de pacientes</p>
    </div>
    <div class="col-md-6 text-right">
        <a href="#" class="btn btn-light-premium mr-2" id="agregar_paciente">
            <i class="fas fa-user-plus mr-1"></i> Nuevo Paciente
        </a>
        <a href="#" class="btn btn-teal" id="crear_cita">
            <i class="fas fa-calendar-plus mr-1"></i> Agendar Cita
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="cita_tables" class="table table-hover dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Paciente</th>
                                <th>Tipo</th>
                                <th>Fecha - Hora</th>
                                <th>Estatus</th>
                                <th width="15%">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="altaPacienteModal" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 700; color: #1e293b;"><i class="fas fa-user-plus text-info mr-2"></i> Nuevo Paciente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="altaPaciente">
                <div class="modal-body p-4">
                    <h6 class="mb-3 text-uppercase text-muted" style="font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;">Datos Personales</h6>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label>Nombre(s) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="nombre" name="nombre" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Paterno <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_pat" name="ap_pat" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Apellido Materno</label>
                            <div class="has-icon-left">
                                <input type="text" id="ap_mat" name="ap_mat" class="form-control" onKeyUp="this.value = this.value.toUpperCase();">
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nacimiento</label>
                            <div class="has-icon-left">
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                                <div class="form-control-position"><i class="fas fa-birthday-cake"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edad</label>
                            <div class="has-icon-left">
                                <input type="number" id="edad" name="edad" class="form-control bg-light" readonly>
                                <div class="form-control-position"><i class="fas fa-sort-numeric-up-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Género</label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-venus-mars"></i></div>
                                <select class="select2 form-control" id="genero" name="genero" style="width: 100%;">
                                    <option value="">Seleccione...</option>
                                    <option value="M">Femenino</option>
                                    <option value="H">Masculino</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3 text-uppercase text-muted" style="font-weight: 700; font-size: 0.75rem;">Contacto y Salud</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Tipo Sangre</label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-tint text-danger"></i></div>
                                <select class="select2 form-control" id="tipo_sangre" name="tipo_sangre" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    @foreach($tipoSangre as $tp)
                                    <option value="{{ $tp->id }}">{{ $tp->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Talla (cm)</label>
                            <div class="has-icon-left">
                                <input type="number" id="talla" name="talla" class="form-control">
                                <div class="form-control-position"><i class="fas fa-ruler-vertical"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3"></div>

                        <div class="col-md-4 mb-3">
                            <label>Celular (10 dgt) <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="text" id="celular" name="celular" class="form-control" maxlength="10">
                                <div class="form-control-position"><i class="fas fa-mobile-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Correo</label>
                            <div class="has-icon-left">
                                <input type="email" id="email" name="email" class="form-control">
                                <div class="form-control-position"><i class="fas fa-envelope"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Emergencia</label>
                            <div class="has-icon-left">
                                <input type="text" id="contacto_emergencia" name="contacto_emergencia" class="form-control" maxlength="10">
                                <div class="form-control-position"><i class="fas fa-phone-alt text-danger"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light-premium" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-teal" id="registrar_paciente"><i class="fas fa-save mr-1"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="verPacienteModal" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 700; color: #1e293b;"><i class="fas fa-search text-info mr-2"></i> Buscar Paciente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table id="pacientes_tables2" class="table table-hover dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Nacimiento</th>
                                <th width="10%">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light-premium" data-dismiss="modal">Cerrar</button></div>
        </div>
    </div>
</div>

<div id="citaModal" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 700; color: #1e293b;"><i class="fas fa-calendar-check text-info mr-2"></i> Agendar Cita</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="altaCitaForm">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Paciente Seleccionado</label>
                            <div class="has-icon-left">
                                <input type="text" id="nombre_cita" class="form-control bg-light" readonly>
                                <div class="form-control-position"><i class="fas fa-user-check text-success"></i></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Fecha <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="date" id="fecha_agenda" class="form-control">
                                <div class="form-control-position"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Hora <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <input type="time" id="hora_agenda" class="form-control">
                                <div class="form-control-position"><i class="fas fa-clock"></i></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Tipo de Consulta <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-stethoscope"></i></div>
                                <select class="select2 form-control" id="control" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    <option value="General">General</option>
                                    <option value="Control">Control Prenatal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_hidden_cita">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light-premium" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-teal" id="agen_cita"><i class="fas fa-save mr-1"></i> Confirmar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach(['consultaModal' => '', 'consultaModal2' => '2'] as $modalId => $suffix)
<div id="{{ $modalId }}" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 700; color: #1e293b;"><i class="fas fa-notes-medical text-info mr-2"></i> Iniciar Consulta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="altaConsultaCrd{{ $suffix }}">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Paciente</label>
                            <div class="has-icon-left">
                                <input type="text" id="nombre_select_cita{{ $suffix }}" class="form-control bg-light" readonly>
                                <div class="form-control-position"><i class="fas fa-user"></i></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Motivo <span class="text-danger">*</span></label>
                            <div class="has-icon-left">
                                <div class="form-control-position"><i class="fas fa-clipboard-list"></i></div>
                                <select class="select2 form-control" id="tipo_consulta_cita{{ $suffix }}" style="width: 100%;">
                                    <option value="">Seleccione</option>
                                    @foreach($tipoC as $x)
                                    <option value="{{ $x->id }}">{{ $x->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_hidden_paciente_cita{{ $suffix }}">
                    <input type="hidden" id="id_hidden_id_cita{{ $suffix }}">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light-premium" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-teal" id="crear_consulta{{ $suffix }}"><i class="fas fa-play mr-1"></i> Iniciar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div id="consultaPrenatalModal" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-3"><i class="fas fa-baby text-info" style="font-size: 3rem;"></i></div>
                <h5 style="font-weight: 700; color: #1e293b;">Control Prenatal</h5>
                <p class="text-muted mb-4">¿Confirmar inicio para <span id="nombre_cp" class="font-weight-bold"></span>?</p>
                <input type="hidden" id="id_hidden_paciente_cita_pre">
                <input type="hidden" id="id_hidden_id_cita_pre">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-light-premium mr-2" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-teal" id="confirmar_consulta_cp">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    jQuery(document).ready(function($) {
        let token = '{{csrf_token()}}';

        // FIX #1: Solución para Focus Trap en Select2 dentro de Modales
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        // Inicializamos Select2 dinámicamente apuntando a su contenedor padre
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this).parent()
                });
            });
        });

        // FIX #2: Recalcular DataTables al abrir modales para que no se apachurren las columnas
        $('#verPacienteModal').on('shown.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#pacientes_tables2')) {
                $('#pacientes_tables2').DataTable().columns.adjust().responsive.recalc();
            }
        });

        // Función global de SweetAlert para atrapar Status 422 o 500
        // Función global de SweetAlert para atrapar errores 422, 403, 404 o 500
        function mostrarErrores(jqXHR) {
            let erroresHtml = '<ul style="text-align: left; list-style-type: none; padding: 0;">';

            try {
                let response = JSON.parse(jqXHR.responseText);

                // 1. Si es un error de validación automático de Laravel (Status 422)
                if (jqXHR.status === 422 && response.errors) {
                    $.each(response.errors, function(key, msgArray) {
                        $.each(msgArray, function(index, msg) {
                            erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> ${msg}</li>`;
                        });
                    });
                }
                // 2. Si es un error personalizado que mandamos desde el controlador (ej. { error: 'Mensaje' })
                else if (response.error) {
                    erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> ${response.error}</li>`;
                }
                // 3. Si Laravel devuelve un string directo o la respuesta plana vieja
                else if (typeof response === 'string') {
                    erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> ${response}</li>`;
                }
                // 4. Fallback si el JSON tiene otra estructura rara
                else {
                    $.each(response, function(key, value) {
                        if (typeof value === 'string') {
                            erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> ${value}</li>`;
                        }
                    });
                }
            } catch (e) {
                // 5. Si de plano no es JSON (ejemplo, la pantalla roja del error 500 fatal)
                erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> Error procesando la solicitud (Error ${jqXHR.status}). Revisa la consola.</li>`;
                console.error("Error completo:", jqXHR.responseText);
            }

            if (erroresHtml === '<ul style="text-align: left; list-style-type: none; padding: 0;"></ul>') {
                erroresHtml += `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-1"></i> Error desconocido.</li></ul>`;
            } else {
                erroresHtml += '</ul>';
            }

            Swal.fire({
                title: 'Atención',
                html: erroresHtml,
                icon: 'warning',
                confirmButtonColor: '#0d9488'
            });
        }

        // ---------------------------------------------------------
        // 1. DATATABLES PRINCIPAL (CITAS)
        // ---------------------------------------------------------
        $('#cita_tables').DataTable({
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            ajax: "{{ route('citas') }}",
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
                    name: 'tipo_c'
                },
                {
                    data: 'fecha_jora',
                    render: function(data, type, row) {
                        return `${row.fecha_proxima} ${row.hora_proxima}`;
                    }
                },
                {
                    data: 'estatus_c',
                    name: 'estatus_c'
                },
                {
                    data: 'accion',
                    name: 'accion',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Cálculo de Edad Automático
        $(document).on('change', '#fecha_nacimiento', function() {
            let val = $(this).val();
            if (!val) return;
            let hoy = new Date();
            let nac = new Date(val);
            let edad = hoy.getFullYear() - nac.getFullYear();
            let m = hoy.getMonth() - nac.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < nac.getDate())) {
                edad--;
            }
            $('#edad').val(edad >= 0 ? edad : 0);
        });

        // ---------------------------------------------------------
        // 2. ALTA PACIENTE
        // ---------------------------------------------------------
        $('#agregar_paciente').click(function(e) {
            e.preventDefault();
            $('#altaPaciente')[0].reset();
            $('.select2').val('').trigger('change');
            $('#altaPacienteModal').modal('show');
        });

        $('#registrar_paciente').click(function() {
            let cel = $('#celular').val().trim();
            if (!$('#nombre').val() || !$('#ap_pat').val() || !cel) return Swal.fire('Error', 'Nombre, Apellido y Celular son obligatorios.', 'warning');
            if (!/^[0-9]{10}$/.test(cel)) return Swal.fire('Error', 'El celular debe tener 10 dígitos numéricos.', 'error');

            let data = $('#altaPaciente').serialize() + '&_token=' + token;
            $.ajax({
                    method: 'POST',
                    url: '{{ route("PacienteRegistro2") }}',
                    data: data
                })
                .done(function() {
                    $('#altaPacienteModal').modal('hide');
                    if ($.fn.DataTable.isDataTable('#pacientes_tables2')) $('#pacientes_tables2').DataTable().ajax.reload(null, false);
                    Swal.fire('¡Éxito!', 'Paciente registrado.', 'success');
                }).fail(mostrarErrores);
        });

        // ---------------------------------------------------------
        // 3. AGENDAR CITA
        // ---------------------------------------------------------
        $('#crear_cita').click(function(e) {
            e.preventDefault();
            $('#verPacienteModal').modal('show');

            $('#pacientes_tables2').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                responsive: true,
                scrollY: '50vh',
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                ajax: "{{ url('citas/paciente-sel') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, {
                        data: 'nombre_c',
                        name: 'nombre_c'
                    },
                    {
                        data: 'fecha_nacimiento',
                        name: 'fecha_nacimiento'
                    }, {
                        data: 'accion',
                        name: 'accion'
                    }
                ]
            });
        });

        $(document).on('click', '.seleccionar_paciente', function() {
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ url('pacientes/consulta-2') }}/" + id,
                dataType: "json",
                success: function(data) {
                    $('#id_hidden_cita').val(id);
                    $('#nombre_cita').val(data.nombre_c);
                    $('#control').val("").trigger('change');
                    $('#citaModal').modal('show');
                }
            });
        });

        $('#agen_cita').click(function() {
            let tipo = $('#control').val();
            if (!tipo || !$('#fecha_agenda').val() || !$('#hora_agenda').val()) return Swal.fire('Atención', 'Complete fecha, hora y tipo.', 'warning');

            let data = {
                id_paciente: $('#id_hidden_cita').val(),
                fecha_agenda: $('#fecha_agenda').val(),
                hora_agenda: $('#hora_agenda').val(),
                _token: token
            };
            let ruta = (tipo === 'General') ? '{{ route("create_cita") }}' : '{{ route("create_citaE") }}';

            $.ajax({
                    method: 'POST',
                    url: ruta,
                    data: data
                })
                .done(function() {
                    $('#citaModal, #verPacienteModal').modal('hide');
                    $('#cita_tables').DataTable().ajax.reload(null, false);
                    Swal.fire('¡Agendada!', 'Cita registrada.', 'success');
                }).fail(mostrarErrores);
        });

        // ---------------------------------------------------------
        // 4. INICIAR CONSULTAS (General y Control Prenatal)
        // ---------------------------------------------------------
        function iniciarModalCG(modalStr, id_cita, id_pac, urlCheck) {
            $.ajax({
                url: urlCheck + id_pac,
                dataType: "json",
                success: function(data) {
                    $(`#id_hidden_paciente_cita${modalStr}`).val(id_pac);
                    $(`#id_hidden_id_cita${modalStr}`).val(id_cita);
                    $(`#nombre_select_cita${modalStr}`).val(data.nombre_c);
                    $(`#tipo_consulta_cita${modalStr}`).val("").trigger('change');
                    $(`#consultaModal${modalStr}`).modal('show');
                },
                error: function() {
                    // Ruta de respaldo
                    if (modalStr === '') iniciarModalCG('2', id_cita, id_pac, "{{ url('pacientes/consulta-2') }}/");
                }
            });
        }

        $(document).on('click', '.create_cg', function() {
            iniciarModalCG('', $(this).attr('id'), $(this).attr('name'), "{{ url('consulta-general/check-expediente') }}/");
        });

        function procesarInicioCG(modalStr, rutaPost) {
            let data = {
                id: $(`#id_hidden_paciente_cita${modalStr}`).val(),
                id_cita: $(`#id_hidden_id_cita${modalStr}`).val(),
                tipo_consulta: $(`#tipo_consulta_cita${modalStr}`).val(),
                _token: token
            };
            if (!data.tipo_consulta) return Swal.fire('Error', 'Seleccione el motivo de consulta.', 'warning');

            $.ajax({
                    method: 'POST',
                    url: rutaPost,
                    data: data
                })
                .done(function() {
                    Swal.fire({
                        title: 'Redirigiendo',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('consulta_general') }}";
                    }, 1500);
                }).fail(mostrarErrores);
        }

        $('#crear_consulta').click(function() {
            procesarInicioCG('', '{{ route("consultaRegistrocita") }}');
        });
        $('#crear_consulta2').click(function() {
            procesarInicioCG('2', '{{ route("consultaRegistrocita2") }}');
        });

        // EMBARAZADAS
        $(document).on('click', '.create_cp', function() {
            let id_cita = $(this).attr('id'),
                id_pac = $(this).attr('name');
            $.ajax({
                url: "{{ url('control-prenatal/check-expediente') }}/" + id_pac,
                dataType: "json",
                success: function(data) {
                    $('#id_hidden_paciente_cita_pre').val(id_pac);
                    $('#id_hidden_id_cita_pre').val(id_cita);
                    $('#nombre_cp').text(data.nombre_c);
                    $('#consultaPrenatalModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                            title: 'Sin Expediente',
                            text: "¿Desea confirmar la cita y crear Expediente Prenatal?",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#0d9488'
                        })
                        .then((res) => {
                            if (res.isConfirmed) {
                                $.ajax({
                                        method: 'POST',
                                        url: '{{ route("confirmar_cp_cita") }}',
                                        data: {
                                            id_cita: id_cita,
                                            _token: token
                                        }
                                    })
                                    .done(function() {
                                        window.location.href = "{{ url('control-prenatal/expediente') }}";
                                    }).fail(mostrarErrores);
                            }
                        });
                }
            });
        });

        $('#confirmar_consulta_cp').click(function() {
            $.ajax({
                    method: 'POST',
                    url: '{{ route("confirmar_cp_cita") }}',
                    data: {
                        id_cita: $('#id_hidden_id_cita_pre').val(),
                        _token: token
                    }
                })
                .done(function() {
                    Swal.fire({
                        title: 'Iniciando',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('consulta_embarazadas') }}";
                    }, 1500);
                }).fail(mostrarErrores);
        });
    });
</script>
@endsection