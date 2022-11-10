<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receta M&eacute;dica</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
</head>

<style>
    <?php
    $fondo = public_path() . '/image/prueba.png';
    ?>@page {
        margin: 0cm 0cm;
    }

    body {
      
        margin-top: 4cm;
        margin-left: 2cm;
        margin-right: 2cm;
        margin-bottom: 2cm;
       
        background-color: rgba(0, 0, 0, 0.0) !important;
        background-repeat: no-repeat;
        background-size: 100%;
        background-image: url(<?php echo $fondo; ?>);
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        background-color: #FFFFFF;
    }

    header {
        position: fixed;
        top: 0.2cm;
        left: .3cm;
        right: .3cm;
        height: 0cm;
    }

    #estilo_mio {
        position: fixed;
        top: 5.3cm;
        left: 0.3cm;
        right: 10cm;
        height: 0cm;
    }

    #estilo_mio2 {

        position: fixed;
        top: 13.4cm;
        left: 0.3cm;
        right: 0.3cm;
        height: 0cm;
        text-align: left;

    }

    #tres {

        position: fixed;
        top: 12.2cm;
        left: 0.8cm;
        right: 0.8cm;
        height: 0cm;
        text-align: left;

    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0.8cm;
        right: 0.8cm;
        height: 3cm;

        p {
            margin: 0 !important;
        }

        table {
            margin: 0 !important;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            /* font-weight: 100; */
            /* src: local('Montserrat-Light'), url(http://fonts.gstatic.com/s/montserrat/v6/zhcz-_WihjSQC0oHJ9TCYC3USBnSvpkopQaUR-2r7iU.ttf) format('truetype'); */
            /* src: local('Montserrat'), url(storage_path('fonts/Montserrat-Light.ttf')) format('truetype'); */
        }

        /* @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            src: local('Montserrat-Bold'), url(http://fonts.gstatic.com/s/montserrat/v6/IQHow_FEYlDC4Gzy_m8fcvEr6Hm6RMS0v1dtXsGir4g.ttf) format('truetype');
            } */

        body {
            /* background: url('http://unisystem.unillantas.com.mx/imagenes/membrete.jpg');
                background-position: top center; */
            font-family: 'Montserrat', serif;
            background-color: #fff;
            /* background-repeat: no-repeat;
                background-size: 100% 100%; */
        }
</style>

<?php
$header1 = public_path() . '/image/logopdf1.png';
$header2 = public_path() . '/image/logopdf2.png';
$header3 = public_path() . '/image/wa.png';
setlocale(LC_ALL, 'es_MX');
setlocale(LC_TIME, "spanish");
$fc = $data->fecha;
$cc = date('d/m/Y', strtotime($fc));
$genero = $medico->doc;
$nombre = $data->nombre_p;
$tipo_con = $data->nombre;
$diag = $data->diagnostico;
$edad = $data->edad;
$peso = $data->peso . " " . "KG";
$talla = $data->talla . " " . " CM";
$temperatura = $data->temperatura . " " . " °";
$ta = $data->ta;
$es = $medico->especialidad;
$motivo = $data->motivo_consulta;
$examen = $data->examen_fisico;
$rec = $data->observaciones;
$glu = $data->glucosa;
$tel = $medico->celular;
$ed = "";
$nmedico = $medico->nombre_p;
$ced = $medico->cedula;
$instituto = $medico->institutos;
if ($edad > "1") {
    $ed = $edad . " " .  "años";
} else {
    $ed = $edad . " " . "año";
}
?>


<body>
    <header>
        <div class="table-responsive">
            <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
                <table style="width:100%" align="center">
                    <tr>
                        <th align="center"><br><img src="{{ $header1 }}" width="70px" height="80px" /> </th>
                        <th>
                            <p style="text-align: center; font-family:  serif; font-size: 1.4rem; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px;"> {{ $genero }} {{ $nmedico }}
                                <br> <a style="font-size: .8rem; color: black;"> {{ $es }} </a> <br> <a style="font-size: .8rem; color: black;"><strong>{{ $instituto }} </strong></a>
                            </p>
                            <p style="font-size: 0.7rem; color:black; text-align: left; font-family:  serif; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Farmacia "San Agustín" 951 51 150 71
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;Laboratorio "MC" 951 51 432 30 <br>
                                <a style="font-size: 0.7rem; color:black; text-align: justify; font-family:  serif; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Benito Juárez N° 306 - BIS, San Agustín de las Juntas
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bustamante N° 312 - Altos, Col. Centro</a> <br>
                                <a style="font-size: 0.7rem; color:black; text-align: justify; font-family:  serif; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oaxaca de Juárez, Oaxaca.
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;Oaxaca de Juárez, Oaxaca.</a>
                            </p>
                        </th>
                        <th><br><img src="{{ $header2 }}" width="70px" height="80px" /> </th>
                    </tr>
                </table>
            </table>
        </div>
    </header>

    <footer>
        <div align="left">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ____________________________</p>
            <p class="text-break" style="text-align: justify; font-size: 11pt">
                <img src="{{ $header3 }}" width="35px" height="30px" /> <strong> {{ $tel }} </strong>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;{{ $genero }} {{ $nmedico }}
            </p>
            <p style="text-align: justify; font-size: 11pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&eacute;dula Profesional {{ $ced }} </p>
        </div>
    </footer>
    
    <div class="table-responsive" id="estilo_mio">
        <table class="table table-bordered" style="font-size: 8pt; padding: 0;" width="100%">
            <table style="width:100%" align="center">
                <tr >
                    <td width="24%" style="font-size: 0.8rem; text-align: justify; font-family:  serif;"><strong>Fecha Consulta: </strong> {{ $cc}}</td>
                    <td width="76%" style="font-size: 0.8rem; text-align: left; font-family:  serif;"><strong>Paciente:</strong> {{ $nombre }}&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo Consulta:</strong> {{ $tipo_con}}
                        <br><a style="font-size: 0.8rem; color:black; text-align: left; font-family:  serif;"><strong>Padecimiento Indicado:</strong> {{ $motivo }}</a> 
                    </td>
                </tr>
                <tr>
                    <td align="left" style="font-size: 0.8rem; text-align: left; font-family:  serif;"><strong>Edad:</strong> {{ $ed}} <br><strong>Peso:</strong> {{ $peso }}
                        <br><strong>Talla:</strong> {{ $talla }} <br><strong>Temperatura:</strong> {{ $temperatura }}
                        <br><strong>T/A:</strong> {{ $ta }} <br> <strong>Glucosa:</strong> {{ $glu }}
                    </td>
                    <td>
                        <p style="text-align: left; font-size: .8rem; font-family:  serif;"> <strong>DIAGN&Oacute;STICO:</strong> {{ $diag }} </p>
                        <p style="text-align: left; font-size: .8rem; font-family:  serif;"> <strong>Examen F&iacute;sico:</strong> {{ $examen }} </p>
                        <p style="text-align: left; font-size: .8rem; font-family:  serif;"> <strong>Recomendaciones:</strong> {{ $rec }} </p>
                    </td>
                </tr>
            </table>
        </table>


    </div>

    <div align="left" id="tres">
        <strong>
            <p class="text-break" style="text-align: justify; font-size: 9pt">
                A continuaci&oacute;n se enlista la cantidad de medicamentos y su tratamiento.
            </p>
        </strong>
    </div>

    <div class="table-responsive" id="estilo_mio2">
        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <table style="width:100%" align="center">
                <thead>
                    <tr>
                        <td width="10%"><strong>Cantidad</strong></td>
                        <td width="35%"><strong>Medicamento</strong></td>
                        <td width="55%"><strong>Tratamiento</strong></td>

                    </tr>
                </thead>
                <tbody>
                    @foreach($medicamentos ?? '' as $data)
                    <tr>
                        <td>{{ $data->cantidad }}</td>
                        <td>{{ $data->descripcion }}</td>
                        <td>{{ $data->tratamiento }}</td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </table>


    </div>
    <br>
</body>

</html>