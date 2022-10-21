<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotización</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
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
    }

    header {
        position: fixed;
        top: 1cm;
        left: 1.7cm;
        right: 0cm;
        height: 3cm;
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
        margin: 0 !important;
    }

    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
    }

    body {

        font-family: 'Montserrat', serif;
        background-color: #fff;
        /* background-repeat: no-repeat;
                background-size: 100% 100%; */
    }
    table {
  border:1px solid black;
   border-collapse:separate;
                    border-spacing: 10;
                    border:solid black 1px;
                    border-radius:10px;
}
</style>

<?php
$header1 = public_path() . '/image/logopdf1.png';
$header2 = public_path() . '/image/logopdf2.jpg';
?>

<body>
<?php
    setlocale(LC_ALL, 'es_MX');
    setlocale(LC_TIME, "spanish");
    $fc = $data->fecha;
    $cc = date('d/m/Y', strtotime($fc));
    $genero = $medico->doc;
    $nombre = $data->nombre_p;

    ?>

    <header align= "left">
    <div class="table-responsive">
        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <table style="width:100%" align="center">
                <tr>
                    <th> <img src="{{ $header1 }}" width="70px" height="80px"/> </th>
                    <th style="font-size: 1.0rem;" ><p style="text-align: center;"> {{ $genero }} Orquídea Hurí Mora Carrera</p>
                        <p style="font-size: .8rem; text-align: center;"> Medicina General, Ultrasonido, Laboratorio clínico </p>
                        <strong>
                            <p style="font-size: 1.1rem; text-align: center;"> UABJO - BUAP - CENACE </p>
                        </strong>
                        <a style="font-size: 0.5rem; color:black; text-align: left;">Farmacia "San Agustín" 951 51 150 71 </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="font-size: 0.5rem; color:black; text-align: right;" >Laboratorio "MC" 951 51 432 30</a></br>
                        <a style="font-size: 0.5rem; color:black;">Benito Juárez N° 306 - BIS, San Agustín de las Juntas</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="font-size: 0.5rem; color:black; text-align: right;">Bustamante N° 312 - Altos, Col. Centro</a></br>
                        <a style="font-size: 0.5rem; color:black;">Oaxaca de Juárez, Oaxaca. </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="font-size: 0.5rem; color:black; text-align: right;">Oaxaca de Juárez, Oaxaca.</a>
                    </th>
                    <th> <img src="{{ $header2 }}" width="70px" height="80px"/></th>
                </tr>
            </table>
        </table>
    </div>
       
        </header>

</br>
</br></br></br>
        <div class="table-responsive">
        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <table style="width:100%" align="center">
                <tr>
                    <th> Paciente: {{ $nombre}}</th>
                </tr>
            </table>
        </table>
    </div>


    

</body>

</html>