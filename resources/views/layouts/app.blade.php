<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/iconos/med.ico') }}">

    <title>MCSystem</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="../../../tema/app-assets/css/bootstrap.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* =========================================================
           PANEL IZQUIERDO: VERSIÓN "CLEAN CLINIC" (Luminoso)
           ========================================================= */
        .auth-side-brand {
            flex: 1.2;
            position: relative;
            display: none;
            /* Base Blanco/Gris muy suave */
            background-color: #f8fafc; 
            /* Luces en tonos Teal (Verde azulado) y Sky Blue muy tenues */
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(45, 212, 191, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 100%, rgba(13, 148, 136, 0.15) 0%, transparent 50%);
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .auth-side-brand { display: block; }
        }

        /* Cuadrícula Médica (Líneas oscuras pero muy sutiles) */
        .auth-side-brand::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(13, 148, 136, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(13, 148, 136, 0.04) 1px, transparent 1px);
            z-index: 1;
        }

        /* Animación suave de luz */
        .auth-side-brand::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.4) 0%, transparent 60%);
            z-index: 2;
            animation: pulse-glow 8s infinite alternate ease-in-out;
        }

        @keyframes pulse-glow {
            0% { opacity: 0.3; transform: scale(0.95); }
            100% { opacity: 0.8; transform: scale(1.05); }
        }

        /* Contenedor de Texto: Light Glassmorphism */
        .branding-content {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
            width: 75%;
            /* Efecto Cristal Claro */
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            padding: 3rem 2rem;
            box-shadow: 0 20px 40px -10px rgba(13, 148, 136, 0.1);
        }

        /* Icono principal */
        .branding-content .icon-brand {
            font-size: 3.5rem; 
            color: #0d9488; 
            margin-bottom: 1.2rem;
            filter: drop-shadow(0 4px 6px rgba(13, 148, 136, 0.2));
        }

        /* Textos en tonos oscuros para hacer contraste con el cristal claro */
        .branding-content h1 { 
            font-weight: 800; 
            font-size: 3.2rem; 
            margin-bottom: 1rem; 
            color: #0f172a; 
            letter-spacing: -1px; 
        }
        
        .branding-content p { 
            font-size: 1.15rem; 
            font-weight: 500; 
            color: #475569; 
            line-height: 1.6; 
            margin: 0;
        }

        /* PANEL DERECHO: Formulario */
        .auth-form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            max-width: 100%;
            position: relative;
            z-index: 20;
        }

        @media (min-width: 992px) {
            .auth-form-container {
                max-width: 500px;
                box-shadow: -20px 0 40px rgba(0,0,0,0.04);
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-side-brand">
            <div class="branding-content">
                <i class="fas fa-heartbeat icon-brand"></i>
                <h1>Servicios Médicos San Agustín</h1>
                <p>Plataforma de Gestión Médica y Expediente Clínico de Alta Especialidad.</p>
            </div>
        </div>

        <div class="auth-form-container">
            @yield('content')
        </div>
    </div>

    <script src="../../../tema/app-assets/vendors/js/vendors.min.js"></script>
</body>

</html>