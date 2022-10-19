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

            p { margin: 0 !important; }

            table { margin: 0 !important; }

            @font-face {
            font-family: 'Montserrat';
            font-style: normal; }
            body {
            
                font-family: 'Montserrat', serif;
                background-color: #fff;
                /* background-repeat: no-repeat;
                background-size: 100% 100%; */
            }
</style>

<?php 
 $header = public_path().'/image/med.png';
?>

<body>

        <header>
        <img src="{{ $header }}" width="35%" height="80%"/>
        </header>

    <?php
        setlocale(LC_ALL, 'es_MX');
        setlocale(LC_TIME, "spanish");
        $fc = $data->fecha;
        $cc= date('d/m/Y', strtotime($fc));
        $genero = $medico->doc;
    
    ?>

    <div align="right">
        <p style="text-align: right; font-size: 9pt">
            Oaxaca de Ju&aacute;rez, Oax., a {{ $cc }}
        </p>
        <p style="text-align: right; font-size: 9pt"> {{ $genero }}
            Cotizaci&oacute;n n&uacute;m.: <strong></strong>
        </p>
    </div>

    <br>

    <div align="left">
        <p class="text-break" style="text-align: justify; font-size: 9pt">
            A continuaci&oacute;n se enlista vista previa de la cotizaci&oacute;n, que a continuaci&oacute;n se detalla.
        </p>
    </div>

    <br>

    <div class="table-responsive">
        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <thead>
                <tr class="table-secondary">
                    <td width="10%"><strong>es?? </strong></td>
                    <td width="30%"><strong>Producto</strong></td>
                    <td width="25%"><strong>Precio unitario</strong></td>
                    <td width="25%"><strong>Descuento</strong></td>
                    <td width="25%"><strong>Importe</strong></td>
                </tr>
            </thead>
            <tbody>
               
                
                <tr>
                    <td width="10%"></td>
                    <td width="30%"></td>
                    <td width="25%" align="right"></td>
                    <td width="25%" align="right"></td>
                    <td width="25%" align="right"></td>
                </tr>
            </tbody>
        </table>

       
        <br><br>

        <table class="table table-bordered" style="font-size: 9pt; padding: 0;" width="100%">
            <tbody>
                <tr>
                    <td width="42.4%" rowspan="4" style="border: inset 0pt;"></td>
                    <td width="26%" align="right"><strong>Subtotal</strong></td>
                    <td width="25%" align="right"></td>
                </tr>
                <tr>
                    <td width="25%" align="right"><strong>Descuento adicional</strong></td>
                    <td width="25%" align="right"></td>
                </tr>
                <tr>
                    <!-- <td width="41.5%" rowspan="3" style="border: inset 0pt;"></td> -->
                    <td width="25%" align="right"><strong>I.V.A.</strong></td>
                    <td width="25%" align="right"></td>
                </tr>
                <tr>
                    <td width="25%" align="right"><strong>Total</strong></td>
                    <td width="25%" align="right"><strong></strong></td>
                </tr>
            </tbody>
        </table>

    </div>
    
</body>
</html>