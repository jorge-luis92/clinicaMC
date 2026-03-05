<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Médica Premium">
    <meta name="author" content="Clínica San Agustín">

    <link rel="shortcut icon" href="{{ asset('iconos/med.ico') }}">
    <title>Clinica MC - @yield('title', 'Inicio')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('requisitos/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/tables/datatable/datatables.min.css">

    <style>
        /* ==================================================
           SISTEMA DE DISEÑO BASE (SaaS Clinical UI)
           ================================================== */
        :root {
            --primary-teal: #0d9488;
            --primary-teal-light: #ccfbf1;
            --primary-teal-hover: #0f766e;
            --bg-app: #f1f5f9;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-soft: #e2e8f0;
        }

        body, .navbar, .sidebar, .btn, table, p, h1, h2, h3, h4, h5, h6, span, a, div {
            font-family: 'Inter', sans-serif !important;
        }

        body { background-color: var(--bg-app) !important; color: var(--text-main); }
        #wrapper #content-wrapper { background-color: var(--bg-app) !important; }

        /* --- SIDEBAR REDISEÑADO --- */
        .sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid var(--border-soft);
            width: 250px !important;
            box-shadow: none !important;
        }

        .sidebar-brand { height: 80px !important; margin-bottom: 10px; }
        .sidebar-brand-text { font-weight: 800; color: #0f172a !important; letter-spacing: -0.5px; font-size: 1.15rem; }
        .sidebar-brand-icon i { color: var(--primary-teal); font-size: 1.6rem; }

        .sidebar-heading {
            color: #94a3b8 !important; font-size: 0.75rem !important; font-weight: 700 !important;
            letter-spacing: 0.5px; text-transform: uppercase; padding: 1.5rem 1.5rem 0.5rem 1.5rem !important;
        }

        .sidebar .nav-item { margin-bottom: 2px; }
        .sidebar .nav-item .nav-link {
            color: var(--text-muted) !important; font-weight: 500; padding: 0.8rem 1rem !important;
            margin: 0 1rem; border-radius: 10px; transition: all 0.2s ease-in-out; display: flex; align-items: center;
        }

        .sidebar .nav-item .nav-link:hover {
            background-color: #f8fafc !important; color: var(--text-main) !important; transform: translateX(3px);
        }

        .sidebar .nav-item.active>.nav-link, .sidebar .collapse-inner .collapse-item.active {
            background-color: var(--primary-teal-light) !important; color: var(--primary-teal-hover) !important; font-weight: 600;
        }

        .sidebar .nav-item .nav-link i { color: #94a3b8 !important; font-size: 1.1rem; margin-right: 12px; width: 20px; text-align: center; }
        .sidebar .nav-item.active>.nav-link i { color: var(--primary-teal) !important; }

        .sidebar .collapse-inner { background-color: transparent !important; padding: 0 !important; margin: 0.2rem 1rem 0.5rem 1rem !important; }
        .sidebar .collapse-item {
            color: var(--text-muted) !important; padding: 0.6rem 1rem 0.6rem 2.5rem !important;
            border-radius: 8px; margin-bottom: 2px; font-weight: 500; font-size: 0.85rem; transition: all 0.2s;
        }
        .sidebar .collapse-item:hover { background-color: #f8fafc !important; color: var(--primary-teal) !important; }

        /* --- TOPBAR --- */
        .topbar {
            background-color: #ffffff !important; border-bottom: 1px solid var(--border-soft);
            box-shadow: none !important; height: 70px !important; margin-bottom: 0 !important;
        }

        .topbar .nav-item .nav-link { color: var(--text-muted) !important; }
        hr.sidebar-divider { display: none; }

        .modal-content { border: none !important; border-radius: 20px !important; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important; }
    </style>

    @yield('css')
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav sidebar accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('principal') }}">
                <div class="sidebar-brand-icon"><i class="fas fa-heartbeat"></i></div>
                <div class="sidebar-brand-text mx-3">San Agustín</div>
            </a>

            <div class="sidebar-heading mt-2">Principal</div>

            <li class="nav-item {{ request()->routeIs('principal') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('principal') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if(auth()->check() && auth()->user()->tipo_usuario == 2)
                <li class="nav-item {{ request()->routeIs('citas') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('citas') }}">
                        <i class="far fa-fw fa-calendar-alt"></i>
                        <span>Agenda y Citas</span>
                    </a>
                </li>

                <div class="sidebar-heading">Área Clínica</div>

                <li class="nav-item {{ request()->routeIs('listadoGeneral') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('listadoGeneral') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Pacientes</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('consulta_general') || request()->routeIs('consulta_embarazadas') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('consulta_general') || request()->routeIs('consulta_embarazadas') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseConsultas">
                        <i class="fas fa-fw fa-stethoscope"></i>
                        <span>Consultas</span>
                    </a>
                    <div id="collapseConsultas" class="collapse {{ request()->routeIs('consulta_general') || request()->routeIs('consulta_embarazadas') ? 'show' : '' }}" data-parent="#accordionSidebar">
                        <div class="collapse-inner py-2">
                            <a class="collapse-item {{ request()->routeIs('consulta_general') ? 'active' : '' }}" href="{{ route('consulta_general') }}">Consulta General</a>
                            <a class="collapse-item {{ request()->routeIs('consulta_embarazadas') ? 'active' : '' }}" href="{{ route('consulta_embarazadas') }}">Control Prenatal</a>
                        </div>
                    </div>
                </li>
            @endif

            <div class="sidebar-heading">Gestión</div>

            <li class="nav-item {{ request()->routeIs('medicamento_inventario') ? 'active' : '' }}">
                <a class="nav-link {{ request()->routeIs('medicamento_inventario') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseFarmacia">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>Farmacia</span>
                </a>
                <div id="collapseFarmacia" class="collapse {{ request()->routeIs('medicamento_inventario') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <div class="collapse-inner py-2">
                        <a class="collapse-item {{ request()->routeIs('medicamento_inventario') ? 'active' : '' }}" href="{{ route('medicamento_inventario') }}">Stock Actual</a>
                        
                        @if(auth()->check() && auth()->user()->tipo_usuario == 1)
                            <a class="collapse-item" href="#">Registrar Entrada</a>
                            <a class="collapse-item" href="#">Punto de Venta</a>
                        @endif
                    </div>
                </div>
            </li>

            @if(auth()->check() && auth()->user()->tipo_usuario == 1)
                <div class="sidebar-heading">Sistema</div>
                <li class="nav-item {{ request()->routeIs('listadoUsuario') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('listadoUsuario') }}">
                        <i class="fas fa-fw fa-shield-alt"></i>
                        <span>Cuentas y Accesos</span>
                    </a>
                </li>
            @endif

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light topbar static-top">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" style="color: var(--primary-teal); background: var(--primary-teal-light);">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <span style="font-weight: 500; font-size: 0.9rem; color: #64748b; background: #f8fafc; padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <i class="far fa-calendar-check mr-1 text-teal" style="color: var(--primary-teal);"></i>
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D \d\e MMMM YYYY') }}
                        </span>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <div class="d-flex flex-column text-right mr-3 d-none d-lg-inline">
                                    <span style="font-weight: 700; font-size: 0.9rem; color: #1e293b; line-height: 1.2;">
                                        {{ isset($data) ? $data->nombre : (auth()->check() ? auth()->user()->name : 'Usuario') }}
                                    </span>
                                    <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">
                                        {{ isset($data) ? $data->tipo_usuario : (auth()->user()->tipo_usuario == 1 ? 'Administrador' : 'Médico') }}
                                    </span>
                                </div>
                                <div class="img-profile d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px; background-color: var(--primary-teal-light); color: var(--primary-teal); font-weight: 800; border-radius: 10px; font-size: 0.9rem; border: 2px solid #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    {{ substr(isset($data) ? $data->nombre : auth()->user()->name, 0, 1) }}
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in border-0 mt-2" style="border-radius: 16px; border: 1px solid #e2e8f0 !important; min-width: 200px;">
                                <a class="dropdown-item py-2" href="#" style="font-weight: 500; font-size: 0.9rem; color: #334155;">
                                    <i class="fas fa-cog fa-sm fa-fw mr-2" style="color: #94a3b8;"></i> Configuración
                                </a>
                                <div class="dropdown-divider" style="border-top: 1px solid #f1f5f9;"></div>
                                <a class="dropdown-item py-2 text-danger" href="#" data-toggle="modal" data-target="#logoutModal" style="font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Cerrar Sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                
                <div class="container-fluid" style="padding: 0;">
                    @yield('content')
                </div>

            </div>

            <footer class="sticky-footer" style="background-color: transparent !important; padding: 1.5rem 0;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto" style="font-size: 0.8rem; color: #94a3b8; font-weight: 500;">
                        <span>&copy; {{ date('Y') }} San Agustín - MCSystem v2.0</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
            <div class="modal-content p-2">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-power-off" style="font-size: 1.5rem; color: #ef4444;"></i>
                        </div>
                    </div>
                    <h5 style="font-weight: 800; color: var(--text-main); margin-bottom: 0.5rem; font-size: 1.25rem;">¿Cerrar sesión?</h5>
                    <p style="color: #64748b; font-size: 0.9rem; line-height: 1.4; margin-bottom: 1.5rem;">Asegúrate de guardar tus cambios antes de salir del sistema.</p>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

                    <div class="d-flex justify-content-center" style="gap: 10px;">
                        <button class="btn btn-light" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; width: 50%; font-size: 0.95rem; background: #f1f5f9; color: #475569;">Cancelar</button>
                        <button class="btn text-white" style="background-color: #ef4444; border-radius: 10px; font-weight: 600; width: 50%; font-size: 0.95rem;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sí, Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('requisitos/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('requisitos/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('requisitos/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="../../../tema/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="../../../tema/app-assets/js/scripts/extensions/toastr.js"></script>
    <script src="../../../tema/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../tema/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="../../../tema/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    @yield('scripts')
    @yield('js')

</body>
</html>