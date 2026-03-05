@extends('layouts.app')

@section('content')
<style>
    .login-box { width: 100%; max-width: 420px; padding: 2rem; }
    
    .login-header { text-align: center; margin-bottom: 2.5rem; }
    .login-header img { width: 70px; margin-bottom: 1.5rem; }
    .login-title { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; letter-spacing: -0.5px; }
    .login-subtitle { font-size: 0.95rem; color: #64748b; font-weight: 400; }
    
    /* Inputs Modernos */
    .form-group { margin-bottom: 1.5rem; }
    .form-label { font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .input-wrapper { 
        display: flex; 
        align-items: center; 
        background: #f1f5f9; 
        border: 2px solid transparent; 
        border-radius: 12px; 
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }
    .input-wrapper:focus-within { border-color: #0d9488; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.1); }
    .input-wrapper i { color: #94a3b8; font-size: 1.1rem; width: 30px; }
    .input-wrapper input { border: none; background: transparent; width: 100%; outline: none; color: #1e293b; font-weight: 500; font-size: 1rem; padding: 0.3rem 0; }
    .input-wrapper input::placeholder { color: #94a3b8; font-weight: 400; }
    
    /* Botón Principal */
    .btn-login { 
        background: #0d9488; 
        color: white; 
        width: 100%; 
        border: none; 
        padding: 0.9rem; 
        border-radius: 12px; 
        font-weight: 700; 
        font-size: 1.05rem; 
        transition: all 0.3s; 
        margin-top: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .btn-login:hover { background: #0f766e; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.3); color: white; }
    
    /* Utilerías */
    .auth-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; margin-top: 1rem; }
    .forgot-pass { font-size: 0.85rem; color: #0d9488; text-decoration: none; font-weight: 600; transition: color 0.2s; }
    .forgot-pass:hover { color: #0f766e; text-decoration: underline; }
    
    .custom-control-label { font-size: 0.85rem; color: #475569; font-weight: 500; cursor: pointer; padding-left: 5px; }
    .version-tag { text-align: center; font-size: 0.75rem; color: #94a3b8; margin-top: 3rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;}
    
    /* Alertas */
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 10px; padding: 1rem; font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
</style>

<div class="login-box">
    <div class="login-header">
        <img src="{{ asset('iconos/med.ico') }}" alt="Logo Clínica">
        <h2 class="login-title">Bienvenido de nuevo</h2>
        <p class="login-subtitle">Ingresa tus credenciales para continuar.</p>
    </div>

    @if(session('Error2'))
    <div class="alert-error">
        <i class="fas fa-exclamation-triangle"></i>
        <div><strong>Acceso denegado:</strong> {{ session('Error2') }}</div>
    </div>
    @endif

    <form method="POST" action="{{ route('logueo') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Usuario</label>
            <div class="input-wrapper" style="{{ $errors->has('name') ? 'border-color: #ef4444; background: #fff;' : '' }}">
                <i class="fas fa-user"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ej. administrador" required autocomplete="name" autofocus>
            </div>
            @error('name')
            <span class="text-danger" style="font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; display: block;">
                <i class="fas fa-info-circle"></i> {{ $message }}
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-wrapper" style="{{ $errors->has('password') ? 'border-color: #ef4444; background: #fff;' : '' }}">
                <i class="fas fa-lock"></i>
                <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
            @error('password')
            <span class="text-danger" style="font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; display: block;">
                <i class="fas fa-info-circle"></i> {{ $message }}
            </span>
            @enderror
        </div>

        <div class="auth-actions">
            <div class="custom-control custom-checkbox d-flex align-items-center">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Recordarme</label>
            </div>
            @if (Route::has('password.request'))
            <a class="forgot-pass" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
            @endif
        </div>

        <button type="submit" class="btn-login">
            Acceder al Sistema <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <div class="version-tag">
        MCSystem v.2.0
    </div>
</div>
@endsection