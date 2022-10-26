<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotización</title>
    <link rel="stylesheet" href="" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<style>
    @page {
        margin: 0cm 0cm;
    }

    body {
        margin-top: 4cm;
        margin-left: 2cm;
        margin-right: 2cm;
        margin-bottom: 2cm;
        font-family: 'Montserrat', serif;
        background-color: #fff;
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 4cm;
    }

    p {
        margin: 0 !important;
    }



    table {
        border: solid black .5px;
        border-radius: 5px;
        margin: 0 !important;
    }


    header {
        position: fixed;
        top: .5cm;
        left: .5cm;
        right: .5cm;
        height: 0cm;
    }

    #estilo_mio {

        position: fixed;
        top: 3.9cm;
        left: .5cm;
        right: .5cm;
        height: 0cm;
        text-align: justify;
    }

    #estilo_mio2 {

        position: fixed;
        top: 4.7cm;
        left: .5cm;
        right: .5cm;
        height: 0cm;
        text-align: left;
    }
</style>

<?php
$header1 = public_path() . '/image/logopdf1.png';
$header2 = public_path() . '/image/logopdf2.png';
setlocale(LC_ALL, 'es_MX');
setlocale(LC_TIME, "spanish");
$fc = $data->fecha;
$cc = date('d/m/Y', strtotime($fc));
$genero = $medico->doc;
$nombre = $data->nombre_p;
$tipo_con = $data->nombre;
$diag = $data->diagnostico;
$edad =$data->edad;
$peso = $data->peso ." ". "KG";
$talla = $data->talla ." ". " CM";
$temperatura = $data->temperatura ." ". " °";
$ta = $data->ta;
$ed = "";
if($edad > "1"){
 $ed = $edad ." ".  "años";
}
else {
    $ed = $edad ." ". "año";
}
?>

<header>
    <div class="table-responsive">
        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <table style="width:100%" align="center">
                <tr>
                    <th><img src="{{ $header1 }}" width="70px" height="80px" /> </th>
                    <th>
                        <p style="text-align: center; font-size: 1.4rem;"> {{ $genero }} Orquídea Hurí Mora Carrera</p>
                        <p style="font-size: .8rem; text-align: center;"> Medicina General, Ultrasonido, Laboratorio clínico </p>
                        <strong>
                            <p style="font-size: .8rem; text-align: center;"> UABJO - BUAP - CENACE </p>
                        </strong>
                        </br>
                        <p style="font-size: 0.7rem; color:black; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Farmacia "San Agustín" 951 51 150 71 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Laboratorio "MC" 951 51 432 30</p>
                        <p style="font-size: 0.7rem; color:black; text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Benito Juárez N° 306 - BIS, San Agustín de las Juntas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bustamante N° 312 - Altos, Col. Centro</p>
                        <p style="font-size: 0.7rem; color:black; text-align: justify;">&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oaxaca de Juárez, Oaxaca.
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oaxaca de Juárez, Oaxaca.</p>
                    </th>
                    <th><img src="{{ $header2 }}" width="70px" height="80px" /> </th>
                </tr>
            </table>
        </table>
    </div>
</header>

<body>
    <div class="table-responsive" id="estilo_mio">
        <table class="table table-bordered" style="font-size: 8pt; padding: 0;" width="100%">
            <table style="width:100%">
                <tr>
                    <th> Paciente: {{ $nombre}}</th>
                    <th> Fecha: {{ $cc}}</th>
                    <th> Tipo de Consulta: {{ $tipo_con}}</th>
                    <th>Diagn&oacute;stico: {{ $diag}}</th>
                </tr>
            </table>
        </table>
    </div>

    <div class="table-responsive" id="estilo_mio2">
    <table class="table table-bordered" style="font-size: 9pt; " width="100%">
            <tbody>
            </br>
                <td>
                    <th width="100%" align="left"><strong>Edad: {{ $ed }} Peso: {{ $peso }} Talla: {{ $talla }} 
                    Temperatura: {{ $temperatura }} T/A: {{ $ta }} Glucosa:
                    </strong></th>
                </td>
                </br>
            </tbody>
            <thead>
                <tr class="table-secondary">
                    <td width="10%"><strong>Cantidad</strong></td>
                    <td width="30%"><strong>Producto</strong></td>
                    <td width="25%"><strong>Precio unitario</strong></td>
                    <td width="25%"><strong>Descuento</strong></td>
                    <td width="25%"><strong>Importe</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10%"></td>
                    <td width="30%">}</td>
                    <td width="25%" align="right"></td>
                    <td width="25%" align="right"></td>
                    <td width="25%" align="right"></td>
                </tr>
            </tbody>
        </table>
           
    </div>




</body>

</html>