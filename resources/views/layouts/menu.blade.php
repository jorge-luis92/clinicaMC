<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="shortcut icon" href="{{asset('med.ico')}}">
  <!-- Custom fonts for this template-->
  <link  rel="stylesheet" href="{{asset('requisitos/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link  rel="stylesheet" href="{{asset('css/sb-admin-3.min.css')}}">
  <link rel="stylesheet"  href="{{asset('css/nuevso.css')}}">
  <title>Clinica MC @yield('title')</title>
 
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/selects/select2.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
   
    <!-- END: Custom CSS-->
    <script src="{{ asset('js/mijs.js') }}" defer></script>

 <link rel="stylesheet"  href="{{asset('css/nuevo.css')}}">
   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

   <!-- Styles -->
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{ asset('main.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('datatables/datatables.min.css')}}"/>
   <link rel="stylesheet"  type="text/css" href="{{ asset('datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css')}}">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper" style="font-family: 'Century Gothic';"><!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark " style="background-color: #191970; font-size: 1.0em;" id="accordionSidebar" ><!-- Sidebar - Brand -->
          <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/home">
          <img class="img-responsive center-block" src="{{asset('med.ico')}}" width="47" height="47" alt="">
          <span style="font-size: 1.0em">&nbsp;Home</span></a></li><!-- Divider -->
      <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">

      </div><!-- Nav Item - Pages Collapse Menu -->

      <li class="nav-item">
      <a class="nav-link"  href="{{ url('Usuarios/Listado') }}" aria-expanded="true">
      <i class="fas fa-fw fa-users"></i>
      <span style="font-size: 0.9em;">Usuarios</span>
    </a>
      </li>     <!-- Sidebar Toggler (Sidebar) -->

      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#consultas" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-stethoscope"></i><span style="font-size: 0.8em;">&nbsp;Consulta</span>

        </a>
        <div id="consultas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="dropdown-item" href="venta_nueva"> General</a>
            <a class="collapse-item" href="ventas_del_dia">Embarazadas</a>
          </div>
        </div>
      </li>

      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datos_estudiante" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-folder-open"></i><span style="font-size: 0.8em;">&nbsp;Expedientes</span>

        </a>
        <div id="datos_estudiante" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="dropdown-item" href="venta_nueva"> Consulta General</a>
            <a class="collapse-item" href="ventas_del_dia">Embarazadas</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#activid_extra" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-capsules"></i><span style="font-size: 0.8em;">&nbsp;Medicamentos</span>
        </a>
        <div id="activid_extra" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a  class="collapse-item" href="products">Todos los productos</a>
            <a  class="collapse-item" href="warning">Inventario</a>
        </div>
      </li>



      <hr class="sidebar-divider" style=" background-color: #FFFFFF;">
      <!-- Sidebar Toggler (Sidebar) -->
      <!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">
       Utilidades
      </div>

      <li class="nav-item" >
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#registar_talleritas" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-book" aria-hidden="true"></i></i><span style="font-size: 0.9em;">&nbsp;Reportes</span>
              </a>
              <div id="registar_talleritas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header" style="color: blue">Opciones:</h6>
                  <a class="collapse-item" href="registros_especificos">Consulta General</a>
                  <a class="collapse-item" href="registros_especificos">Embarazadas</a>
                </div>
              </div>
            </li>
            <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>

      </div>
    </ul> <!-- End of Sidebar -->
    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column" style="background-image: url('/fondo.jpg'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF;">
          <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

			<li >
				 <a class="navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <!--<img class="img-responsive center-block" src="logo.ico" width="47" height="47" alt="">-->
           <h1 class="mr-2 d-none d-lg-inline" style="color: #0B173B;font-size: 35px;">&nbsp;Clinica y Laboratorio MC</h1>
			              </a>
            </li>

<div class="topbar-divider d-none d-sm-block"></div>

<div class="topbar-divider d-none d-sm-block"></div>
<li class="nav-item dropdown">
    <a id="navbarDropdown" style="color: #0B173B;font-size: 15px;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }} <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

          <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Cerrar Sesión') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a class="dropdown-item" href="#" >
            {{ __('Configuración de Contraseña') }}
        </a>
    </div>
</li>
                      </ul>

        </nav>

        <!-- End of Topbar -->
@yield('content')
      </div>

      <!-- Footer -->
      <footer class="container-fluid text-center" style="background-color: #E8C6E9; ">
                <div >
          <p style="color: black; font-size: 15px;" ><strong> Benito Juárez 306, San Agustín de Las Juntas, 71260 Oax. - Tel: 9515115071 </br>Copyright &copy; <a style="color: black">Clinica MC</a> <?php $anio= date("Y"); echo $anio?>. Todos los derechos reservados.</p></strong>
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

      
    <!-- BEGIN: Vendor JS-->
    <script src="../../../tema/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
   

    <!-- END: Page Vendor JS-->

    <script src="../../../tema/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    <!-- BEGIN: Theme JS-->
  

    <!-- BEGIN: Page JS-->
    <script src="../../../tema/app-assets/js/scripts/forms/select/form-select2.js"></script>
        <script src="{{asset('requisitos/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{asset('requisitos/jquery-easing/jquery.easing.min.js')}}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    

        
 @yield('scripts')

</body>
</html>

