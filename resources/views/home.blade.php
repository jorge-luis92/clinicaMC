@extends('layouts.menu')

@section('title', 'Inicio')

@section('css')
<style>
    .app-main-content {
        background-color: #f1f5f9;
        padding: 2.5rem;
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .greeting-text h2 {
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
    }

    .greeting-text p {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0.2rem 0 0;
    }

    /* Tarjetas de Métricas */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05);
        border-color: #0d9488;
    }

    .metric-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        margin-bottom: 0.8rem;
    }

    .m-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.5px;
        line-height: 1;
        margin-bottom: 0.2rem;
    }

    .m-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Paneles Centrales */
    .activity-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 992px) {
        .activity-container {
            grid-template-columns: 1fr;
        }
    }

    .main-panel {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }

    .panel-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 1.05rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Botones y Acciones */
    .action-grid {
        display: grid;
        gap: 0.8rem;
    }

    .action-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .action-item:hover {
        background: #fff;
        border-color: #0d9488;
        box-shadow: 0 4px 6px -2px rgba(13, 148, 136, 0.08);
    }

    .action-item i {
        width: 32px;
        height: 32px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d9488;
        font-size: 0.9rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .action-text b {
        display: block;
        color: #1e293b;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .action-text span {
        color: #64748b;
        font-size: 0.75rem;
    }

    .btn-agendar {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background-color: #0f172a;
        color: #ffffff !important;
        border-radius: 14px;
        padding: 6px 20px 6px 6px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none !important;
        transition: all 0.25s ease;
        border: 1px solid #1e293b;
    }

    .btn-agendar:hover {
        background-color: #1e293b;
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.2);
    }

    .btn-agendar .icon-plus {
        background-color: #0d9488;
        color: #ffffff;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.1rem;
        box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.1);
    }

    /* Agenda del Médico */
    .agenda-list {
        position: relative;
        margin-top: 1.5rem;
    }

    .agenda-list::before {
        content: '';
        position: absolute;
        left: 42px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .agenda-item {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .agenda-item:hover {
        border-color: #0d9488;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        transform: scale(1.01);
    }

    .agenda-time {
        min-width: 85px;
        text-align: center;
        font-weight: 800;
        color: #0d9488;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 8px;
        margin-right: 15px;
    }

    .agenda-time span {
        display: block;
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
    }

    .patient-avatar {
        width: 42px;
        height: 42px;
        background: #ccfbf1;
        color: #0d9488;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        margin-right: 15px;
        border: 2px solid #ffffff;
    }

    .agenda-info {
        flex-grow: 1;
    }

    .agenda-info h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .agenda-info p {
        margin: 0;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .btn-atender {
        background: #0d9488;
        color: white !important;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        text-decoration: none !important;
    }

    .btn-atender:hover {
        background: #0f766e;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    /* Empty States */
    .empty-agenda {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #94a3b8;
    }

    .empty-agenda i {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        opacity: 0.4;
        color: #0d9488;
    }

    .empty-agenda h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.3rem;
    }

    .empty-agenda p {
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')

@php
$hora = \Carbon\Carbon::now()->format('H');
$saludo = 'Buenos días';
if ($hora >= 12 && $hora < 19) { $saludo='Buenas tardes' ; }
    elseif ($hora>= 19 || $hora < 5) { $saludo='Buenas noches' ; }

        // Prefijo solo para Médicos
        $prefijo='' ;
        if (isset($data->tipo_usuario) && ($data->tipo_usuario == 'Médico' || $data->tipo_usuario == 'Medico' || auth()->user()->tipo_usuario == 2)) {
        $prefijo = (isset($data->genero) && $data->genero == 'M') ? 'Dra. ' : 'Dr. ';
        }
        @endphp

        <div class="app-content content">
            <div class="content-wrapper app-main-content">

                <header class="page-header">
                    <div class="greeting-text">
                        <h2>{{ $saludo }}, {{ $prefijo }}{{ explode(' ', $data->nombre ?? auth()->user()->name)[0] }}</h2>
                        <p>Resumen de actividad en <b>Servicios Médicos "San Agustín"</b></p>
                    </div>
                    <div class="d-none d-md-block">
                        <div style="background: white; padding: 6px 14px; border-radius: 10px; box-shadow: 0 1px 2px rgba(0,0,0,0.02); font-weight: 600; font-size: 0.85rem; color: #0d9488; border: 1px solid #e2e8f0;">
                            <i class="far fa-clock mr-1"></i>
                            <span id="reloj-tiempo-real">{{ \Carbon\Carbon::now()->format('h:i A') }}</span>
                        </div>
                    </div>
                </header>

                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0.5rem 1rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="metric-grid">
                    <div class="metric-card">
                        <div class="metric-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-calendar-day"></i></div>
                        <div>
                            <div class="m-value">{{ $citasPendientes ?? 0 }}</div>
                            <div class="m-label">{{ auth()->user()->tipo_usuario == 2 ? 'Citas Pendientes' : 'Citas Globales' }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-user-injured"></i></div>
                        <div>
                            <div class="m-value">{{ $pacientesHoy ?? 0 }}</div>
                            <div class="m-label">Pacientes de Hoy</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon" style="background: #fff7ed; color: #ea580c;"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div>
                            <div class="m-value">{{ $consultasTotales ?? 0 }}</div>
                            <div class="m-label">{{ auth()->user()->tipo_usuario == 2 ? 'Consultas Totales' : 'Ventas del Día' }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon" style="background: #f3e8ff; color: #9333ea;"><i class="fas fa-folder-plus"></i></div>
                        <div>
                            <div class="m-value">{{ $nuevosExpedientes ?? 0 }}</div>
                            <div class="m-label">{{ auth()->user()->tipo_usuario == 2 ? 'Nuevos Expedientes' : 'Stock Bajo' }}</div>
                        </div>
                    </div>
                </div>

                <div class="activity-container">

                    @if(auth()->user()->tipo_usuario == 2)
                    <div class="main-panel shadow-sm">
                        <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 0;">
                            <div>
                                <i class="fas fa-calendar-check" style="color: #0d9488; font-size: 1.1rem; margin-right: 8px;"></i>
                                <span style="font-weight: 800; font-size: 1.1rem; color: #0f172a;">Agenda de Hoy</span>
                            </div>
                            <a href="{{ route('citas') }}" class="btn-agendar">
                                <div class="icon-plus" style="width: 24px; height: 24px;"><i class="fas fa-plus"></i></div>
                                <span>Nueva Cita</span>
                            </a>
                        </div>

                        @if(isset($citasHoy) && count($citasHoy) > 0)
                        <div class="agenda-list">
                            @foreach($citasHoy as $cita)
                            <div class="agenda-item">
                                <div class="agenda-time">
                                    {{ \Carbon\Carbon::parse($cita->hora_proxima)->format('h:i') }}
                                    <span>{{ \Carbon\Carbon::parse($cita->hora_proxima)->format('A') }}</span>
                                </div>
                                <div class="patient-avatar" style="{{ isset($cita->genero) && $cita->genero == 'F' ? 'background: #fdf2f8; color: #db2777;' : 'background: #eff6ff; color: #2563eb;' }}">
                                    {{ substr($cita->paciente_nom, 0, 1) }}
                                </div>
                                <div class="agenda-info">
                                    <h5>{{ $cita->paciente_nom }} {{ $cita->ap_paterno }}</h5>
                                    <p><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($cita->fecha_proxima)->format('d/m/Y') }}</p>
                                </div>
                                <div class="agenda-action">
                                    <a href="{{ route('citas', ['id' => $cita->id]) }}" class="btn-atender">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Gestionar</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="empty-agenda mt-5 mb-5">
                            <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-notes-medical" style="font-size: 2rem; color: #cbd5e1;"></i>
                            </div>
                            <h4 style="font-weight: 800; color: #475569;">No hay pendientes</h4>
                            <p style="color: #94a3b8;">Todas las citas de hoy han sido atendidas o no hay registros.</p>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="main-panel shadow-sm">
                        <div class="panel-title" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 0;">
                            <i class="fas fa-chart-line" style="color: #0d9488; font-size: 1.1rem; margin-right: 8px;"></i>
                            <span style="font-weight: 800; font-size: 1.1rem; color: #0f172a;">Resumen Operativo (Farmacia)</span>
                        </div>

                        <div class="empty-agenda mt-5 mb-5 text-center">
                            <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-pills" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                            </div>
                            <h4 style="font-weight: 800; color: #475569;">Panel de Control Administrativo</h4>
                            <p style="color: #94a3b8;">Bienvenido. Aquí se mostrarán los reportes de ventas y movimientos de almacén.</p>
                            <a href="{{ route('medicamento_inventario') }}" class="btn-agendar mt-3" style="margin: 0 auto;">
                                <div class="icon-plus" style="width: 24px; height: 24px; background: #0f172a;"><i class="fas fa-box"></i></div>
                                <span>Ir al Inventario</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <div>
                        <div class="main-panel">
                            <div class="panel-title" style="font-size: 1rem;">Acciones Frecuentes</div>
                            <div class="action-grid">

                                @if(auth()->user()->tipo_usuario == 2)
                                <a href="{{ route('listadoGeneral') }}" class="action-item">
                                    <i class="fas fa-user-plus"></i>
                                    <div class="action-text"><b>Nuevo Paciente</b><span>Registrar datos</span></div>
                                </a>
                                <a href="{{ route('consulta_general') }}" class="action-item">
                                    <i class="fas fa-stethoscope"></i>
                                    <div class="action-text"><b>Nueva Consulta</b><span>Iniciar atención</span></div>
                                </a>
                                @else
                                <a href="#" class="action-item">
                                    <i class="fas fa-cart-plus"></i>
                                    <div class="action-text"><b>Punto de Venta</b><span>Salida de Medicamentos</span></div>
                                </a>
                                <a href="{{ route('listadoUsuario') }}" class="action-item">
                                    <i class="fas fa-users-cog"></i>
                                    <div class="action-text"><b>Cuentas</b><span>Gestionar Personal</span></div>
                                </a>
                                @endif

                                <a href="{{ route('medicamento_inventario') }}" class="action-item">
                                    <i class="fas fa-box-open"></i>
                                    <div class="action-text"><b>Farmacia</b><span>Consultar Stock</span></div>
                                </a>

                            </div>
                        </div>

                        <div class="mt-4 p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 24px; color: white;">
                            <h5 style="font-weight: 700;">MCSystem v2.0</h5>
                            <p style="font-size: 0.85rem; opacity: 0.7;">Seguridad de datos de grado clínico y encriptación activa.</p>
                            <div class="d-flex align-items-center mt-3" style="gap: 10px;">
                                <span style="width: 10px; height: 10px; background: #22c55e; border-radius: 50%; display: inline-block; box-shadow: 0 0 5px #22c55e;"></span>
                                <small style="font-weight: 600;">Servidor Online</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function actualizarReloj() {
                    const ahora = new Date();
                    let horas = ahora.getHours();
                    let minutos = ahora.getMinutes();
                    const ampm = horas >= 12 ? 'PM' : 'AM';

                    horas = horas % 12;
                    horas = horas ? horas : 12;
                    minutos = minutos < 10 ? '0' + minutos : minutos;

                    const horaFormateada = horas + ':' + minutos + ' ' + ampm;
                    const elementoReloj = document.getElementById('reloj-tiempo-real');

                    if (elementoReloj) {
                        elementoReloj.innerText = horaFormateada;
                    }
                }
                setInterval(actualizarReloj, 1000);
                actualizarReloj();
            });
        </script>

        @endsection