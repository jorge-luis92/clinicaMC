@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="font-family:Century Gothic, CenturyGothic, AppleGothic; opacity: .7;">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div>
                            @if(session('Error2'))
                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>¡Error!</strong> {{session('Error2')}}
                            </div>
                            @endif
                        </div>
                        <div class="card-header border-0" style="padding: 0.5rem 3.5rem; font-size: 1.5rem; text-align: center;"> {{ __('Acceder al Sistema') }}</div>
                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;"><b><span>MCsytem v.0.1</span></b></h6>
                        <div class="card-body" style="font-size: 18px;">
                            <form method="POST" action="{{ route('logueo') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('email') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="email" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Recordarme') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button style="font-size: 1.3rem;" type="submit" class="btn btn-primary">
                                            {{ __('Acceder') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('¿Olvidaste tu Contraseña?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection