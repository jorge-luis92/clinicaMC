<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('/iconos/med.ico')}}">

    <title>{{ config('app.name', 'Clinica MC') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/plugins/forms/checkboxes-radios.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/components.css">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body style="background-image: url('/image/fondo_inicio.png'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF; background-size: cover;">
    <div class="app-content content">
        <main class="py-4">
            @yield('content')
        </main>
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
    </div>
</body>

</html>