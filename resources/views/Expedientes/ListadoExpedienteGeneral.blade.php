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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="paciente_tables" class="table table-bordered table-striped">
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


    <div id="verExpPacienteModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel34">
                        <i class="fas fa-list"></i> Expediente Paciente
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
                                                                    <th>Paciente</th>
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

        $('#paciente_tables').DataTable({
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
            let id_paciente = $(this).attr('id');

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
    });
</script>
@endsection