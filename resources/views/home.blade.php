@extends('layouts.menu')
@section('title')
: Home
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
<br>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="card-header">{{ __('Dashboard') }}</div>
                                <div class="card-body" align="center" style="background-image: url('/image/home.jpg'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF;">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <h3> {{ __('Bienvenido (a) ') }} <strong>{{ $data->nombre }}</strong> </h3>
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
            </section>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

@endsection