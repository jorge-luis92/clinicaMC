<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="shortcut icon" href="{{asset('iconos/med.ico')}}">
  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="{{asset('requisitos/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="{{asset('css/sb-admin-3.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/nuevso.css')}}">
  <title>Clinica MC @yield('title')</title>

  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/selects/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/plugins/forms/checkboxes-radios.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/colors.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/components.css">
  <!-- END: Theme CSS-->

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/core/menu/menu-types/horizontal-menu.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/fonts/simple-line-icons/style.css">
  <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
</head>

<body id="page-top">
  <div id="wrapper" style="font-family: 'Century Gothic';">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark " style="background-color: #191970; font-size: 1.0em;" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/home">
          <img class="img-responsive center-block" src="{{asset('iconos/med.ico')}}" width="47" height="47" alt="">
          <span style="font-size: 1.0em">&nbsp;Home</span></a>
      </li><!-- Divider -->
      <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">

      </div><!-- Nav Item - Pages Collapse Menu -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#catalogo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-users"></i></i><span style="font-size: 0.8em;">&nbsp;C&aacute;talogo</span>

        </a>
        <div id="catalogo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            @if(Auth::user()->tipo_usuario == 1)
            <a class="dropdown-item" href="{{ url('Catalogo/Usuarios') }}"> Usuarios</a>
            @endif
            <a class="dropdown-item" href="{{ url('Catalogo/Pacientes') }}"> Pacientes</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#consultas" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-stethoscope"></i><span style="font-size: 0.8em;">&nbsp;Consulta</span>

        </a>
        <div id="consultas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="dropdown-item" href="#"> Citas</a>
            <a class="dropdown-item" href="{{ url('Consulta/ConsultaGeneral') }}"> General</a>
            <a class="collapse-item" href="{{ url('Consulta/Embarazadas') }}">Embarazadas</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datos_estudiante" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-folder-open"></i><span style="font-size: 0.8em;">&nbsp;Expedientes</span>

        </a>
        <div id="datos_estudiante" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="dropdown-item" href="{{ url('Expediente/ConsultaGeneral') }}"> Consulta General</a>
            <a class="collapse-item" href="#">Embarazadas</a>
          </div>
        </div>
      </li>
      @if(Auth::user()->tipo_usuario == 1)
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#activid_extra" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-capsules"></i><span style="font-size: 0.8em;">&nbsp;Medicamentos</span>
        </a>
        <div id="activid_extra" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href="{{ url('Medicamentos/Inventario') }}">Inventario</a>
          </div>
      </li>

      <hr class="sidebar-divider" style=" background-color: #FFFFFF;">
      <!-- Sidebar Toggler (Sidebar) -->
      <!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">
        Utilidades
      </div>
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#registar_talleritas" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-book" aria-hidden="true"></i></i><span style="font-size: 0.9em;">&nbsp;Reportes</span>
        </a>
        <div id="registar_talleritas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href="#">Consulta General</a>
            <a class="collapse-item" href="#">Embarazadas</a>
          </div>
        </div>
      </li>
      @endif
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>

      </div>
    </ul> <!-- End of Sidebar -->
    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column" style="background-image: url('/image/fondo.jpg'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF;">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

            <li>
              <a class="navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!--<img class="img-responsive center-block" src="logo.ico" width="47" height="47" alt="">-->
                <h1 class="mr-2 d-none d-lg-inline" style="color: #0B173B;font-size: 35px;">&nbsp;Servicios Médicos Sán Agustin y Laboratorio Clínico</h1>
              </a>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1 user-name text-bold-700" style="color:black;">
                  <strong> {{ Auth::user()->name }} </strong>
                </span>
                <span class="avatar avatar-online"><img src="../../../image/avatar.png" alt="avatar"><i></i></span></a>
              <div class="dropdown-menu dropdown-menu-right">
                <!-- <a class="dropdown-item" id="configuracion">
                                    <i class="fas fa-user-cog"></i> Configuración
                                </a> -->
                <button class="configuracion dropdown-item" id="configuracion">
                  <i class="fas fa-user-cog"></i> Configuración Contraseña
                </button>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                  <i class="ft-power"></i>
                  {{ __('Cerrar Sesión') }}

                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          </ul>

        </nav>

        <!-- End of Topbar -->
        @yield('content')
      </div>

      <!-- Footer -->
      <footer class="container-fluid text-center" style="background-color: #E8C6E9; ">
        <div>
          <p style="color: black; font-size: 15px;"><strong> Benito Juárez 306, San Agustín de Las Juntas, 71260 Oax. - Tel: 9515115071 </br>Copyright &copy; <a style="color: black">Clinica MC</a> <?php $anio = date("Y");
                                                                                                                                                                                                      echo $anio ?>. Todos los derechos reservados.</p></strong>
        </div>
      </footer>

    </div>

    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  </div>
  <script src="../../../tema/app-assets/vendors/js/vendors.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

  <!-- BEGIN: Theme JS-->
  <!-- Custom scripts for all pages-->
  <script src="../../../tema/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/chart.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/raphael-min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/morris.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="../../../tema/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js"></script>
  <script src="../../../tema/app-assets/data/jvector/visitor-data.js"></script>
  <script src="../../../tema/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>

  <!-- BEGIN: Page JS-->
  <script src="../../../tema/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
  <script src="../../../tema/app-assets/js/scripts/pages/dashboard-sales.js"></script>
  <script src="../../../tema/app-assets/js/scripts/forms/select/form-select2.js"></script>
  <script src="../../../tema/app-assets/js/scripts/forms/checkbox-radio.js"></script>
  <script src="../../../tema/app-assets/js/scripts/forms/form-repeater.js"></script>
  <script src="{{asset('requisitos/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{asset('requisitos/jquery-easing/jquery.easing.min.js')}}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

  @yield('scripts')

</body>

</html>