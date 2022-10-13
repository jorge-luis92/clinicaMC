@extends('layouts.menu')
@section('title')
: Home
@endsection
@section('content')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"/>    

    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 29px;
        }

        html body .content .content-wrapper {
            padding: 0.5rem 2rem 0;
        }
    </style>
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body" align="center" style="background-image: url('./fondo_home.jpg')">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bienvenido(a)') }} <strong>{{ Auth::user()->name }}</strong>                    
                  </br>
                  </br>
                  </br>
                  </br>
                </br>
                </br>
                </br>
                </br>
                </br>
              </br>
              </br>            
                </div>
                
            </div>
        </div>
    </div>

</div>

@endsection
