@extends('layouts.menu')
@section('title')
: Inventario Medicamentos
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
                                            <a href="#" class="btn btn-info btn-min-width btn-glow" id="agregar_medicamento" style="color: white" role="button">
                                                <i class='fas fa-tablets'></i> Agregar Medicamento
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <table id="medicamentos_tables" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Caducidad</th>
                                        <th>Existencia</th>
                                        <th>Precio Venta</th>
                                        <th>Estatus</th>
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

    <div id="agregarMedicamentoModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-plus-square"></i> Agregar Medicamento
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form id="altaCompra" class="form">   -->
                <form id="agregarMedicamento" class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" id="response_agMedicamento" role="alert" style="display:none"></div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fas fa-tablets"></i> Datos Medicamento</h4>
                                        </div>
                                        <div class="col-4">
                                            <label>Clave </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="clave_m" name="clave_m" class="form-control" onKeyUp="this.value = this.value.toUpperCase();" placeholder="ej. Código barra caja">
                                                <div class="form-control-position">
                                                    <i class="fas fa-barcode"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Sustancia Activa</label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="sustancia_m" name="sustancia_m" class="form-control" placeholder="Sustancia Activa">
                                                <div class="form-control-position">
                                                    <i class='fas fa-edit'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Nombre Comercial </label> <span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="nombre_m" name="nombre_m" class="form-control" placeholder="Nombre Comercial">
                                                <div class="form-control-position">
                                                    <i class='fas fa-edit'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Fecha Caducidad</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="date" id="fecha_cad" name="fecha_cad" class="form-control">
                                                <div class="form-control-position">
                                                    <i class='fas fa-calendar'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Lote</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="text" id="lote" name="lote" class="form-control" onKeyUp="this.value = this.value.toUpperCase();" placeholder="Lote">
                                                <div class="form-control-position">
                                                    <i class='fas fa-database'></i>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <label>Presentaci&oacute;n</label><span style="color:red"> *</span>
                                            <div class="form-group position-relative has-icon-left">
                                                <div class="form-control-position">
                                                    <i class="fa fa-gift"></i>
                                                </div>
                                                <select class="select2 form-control" id="presentacion" name="presentacion" style="width: 100%;">
                                                    <option value="">Seleccione</option>
                                                    <option value="Tabletas">Tabletas</option>
                                                    <option value="Capsulas">C&aacute;psulas</option>
                                                    <option value="Grageas">Grageas</option>
                                                    <option value="Solucion">Soluci&oacute;n</option>
                                                    <option value="Solucion Inyectable">Soluci&oacute;n Inyectable</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label>Costo Unitario</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" id="costo_unitario" name="costo_unitario" class="form-control" placeholder="Costo Unitario">
                                                <div class="form-control-position">
                                                    <i class='fas fa-money-bill'></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label>Precio Venta</label>
                                            <div class="form-group position-relative has-icon-left">
                                                <input type="number" id="precio_venta" name="precio_venta" class="form-control" placeholder="Precio Venta">
                                                <div class="form-control-position">
                                                    <i class='fas fa-money-bill'></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="form-section"><i class="fa fa-edit"></i> Observaciones</h4>
                                        </div>

                                        <div class="col-12">
                                            <label>Observaciones </label>
                                            <div class="form-group position-relative has-icon-left">
                                                <textarea name="observaciones" id="observaciones" cols="150" rows="3" class="form-control" placeholder="Observaciones"></textarea>
                                                <div class="form-control-position">
                                                    <i class='fas fa-eye'></i>
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
                        <a class="btn btn-danger btn-min-width btn-glow"" style=" color: white" name="reg_medicamento" id="reg_medicamento" role="button">
                            <i class="fas fa-save"></i> Registrar
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

        function errorRazon(valor) {
            $('#error1').html('<span>' + valor + '</span>');
            $('#errorRazon').show();
        }

        function ok(valor) {
            $('#ok1').html('<span>' + valor + '</span>');
            $('#ok').show();
        }

        $('#agregar_medicamento').click(function() {
            $('#agregarMedicamentoModal').modal('show');

        });

        $('#reg_medicamento').click(function() {
            let token = '{{csrf_token()}}';
            let clave = $('#clave_m').val();
            let nombre = $('#nombre_m').val();
            let fecha_cad = $('#fecha_cad').val();
            let lote = $('#lote').val();
            let presentacion = $('#presentacion').val();
            let costo_unitario = $('#costo_unitario').val();
            let precio_venta = $('#precio_venta').val();
            let observaciones = $('#observaciones').val();
            let sustancia = $('#sustancia_m').val();

            let data = {
                clave: clave,
                nombre: nombre,
                fecha_cad: fecha_cad,
                lote: lote,
                presentacion: presentacion,
                costo_unitario: costo_unitario,
                precio_venta: precio_venta,
                observaciones: observaciones,
                sustancia: sustancia,
                _token: token
            };
            $.ajax({
                method: 'POST',
                url: '{{ route("regMedicamento") }}',
                data: data
            }).done(function(jqXHR) {
                $('#agregarMedicamentoModal').modal('hide');
                $('#presentacion').val("").select2();
                $("#agregarMedicamento")[0].reset();
                $('#medicamentos_tables').DataTable().ajax.reload();
                ok(jqXHR);
                setTimeout(function() {
                    $('#ok').hide();
                }, 4000);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    if (!$('#response_agMedicamento').empty()) {
                        $('#response_agMedicamento').empty();
                    }

                    $.each(JSON.parse(jqXHR.responseText), function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
                                $('#response_agMedicamento').show().append(`
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
                    $('#response_agMedicamento').hide();
                }, 3000);
                }
                if (jqXHR.status == 500) {
                    var responseText = jQuery.parseJSON(jqXHR.responseText);
                    $('#medicamentos_tables').DataTable().ajax.reload();
                    $('#agregarMedicamentoModal').modal('hide');
                    $('#presentacion').val("").select2();
                    $("#agregarMedicamento")[0].reset();
                    errorRazon(responseText)
                }
            });
        });

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

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            ajax: {
                "url": "{{ url('Medicamentos/Inventario') }}",
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
                    data: 'caducidad',
                    name: 'caducidad',
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
                    data: 'estatus',
                    name: 'estatus',
                },
                {
                    data: 'accion',
                    name: 'accion',
                }
            ]

        });

        $(document).on('click', '.expediente_paciente', function() {
            let id_paciente = $(this).attr('id');

            $('#verExpPacienteModal').appendTo("body")
            $('#verExpPacienteModal').modal('show');
            $('#verExpPacienteModal').css('overflow-y', 'auto');
            $('#verExpPacienteModal > .modal-body').css({
                width: 'auto',
                height: 'auto',
                'max-height': '100%'
            });
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
                    "url": "{{ url('Expediente/CGver') }}" + "/" + id_paciente,
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
    });
</script>
@endsection