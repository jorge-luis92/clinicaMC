<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Prenatal - {{ $data->nombre_c }}</title>
    <style>
        /* =======================================================
           CONFIGURACIÓN BASE PARA DOMPDF
           ======================================================= */
        /* Dejamos 3.5cm abajo para que la firma y el recuadro azul queden fijos y no se encimen */
        @page { margin: 1cm 1cm 3.5cm 1cm; } 
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; margin: 0; padding: 0; }

        /* =======================================================
           MARCA DE AGUA
           ======================================================= */
        .watermark { 
            position: fixed; 
            top: 20%; 
            left: 10%; 
            width: 80%; 
            z-index: -1000; 
            opacity: 0.05; 
            text-align: center; 
        }
        .watermark img { width: 100%; max-width: 500px; }

        /* =======================================================
           CABECERA (HEADER)
           ======================================================= */
        .header { width: 100%; border-bottom: 2px solid #1e3a8a; padding-bottom: 12px; margin-bottom: 15px; }
        .doc-name { font-family: 'Times New Roman', Times, serif; font-size: 20pt; margin: 0; color: #1e3a8a; letter-spacing: -0.5px; }
        .doc-specialty { font-size: 10.5pt; font-weight: bold; letter-spacing: 1px; margin-top: 2px; text-transform: uppercase; color: #0f172a; }

        /* =======================================================
           ESTRUCTURA CENTRAL A DOS COLUMNAS (SPLIT LAYOUT)
           ======================================================= */
        .split-layout { width: 100%; border-collapse: collapse; }
        .col-sidebar { width: 33%; vertical-align: top; padding-right: 15px; border-right: 1px solid #e2e8f0; }
        .col-main { width: 67%; vertical-align: top; padding-left: 15px; }

        /* Títulos de sección */
        .section-title { font-size: 9pt; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 10px; color: #1e3a8a; }
        
        /* SIDEBAR IZQUIERDO: Datos y Signos */
        .info-block { margin-bottom: 10px; }
        .info-label { font-size: 8pt; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .info-value { font-size: 10pt; color: #1e293b; margin-top: 1px; }

        /* COLUMNA PRINCIPAL: Notas y Rx */
        .clinical-text { font-size: 9.5pt; line-height: 1.4; color: #1e293b; text-align: justify; margin-bottom: 12px; }
        .clinical-label { font-weight: bold; color: #1e3a8a; }

        .rx-mark { font-family: 'Times New Roman', Times, serif; font-size: 26pt; color: #1e3a8a; font-weight: bold; margin-bottom: 8px; line-height: 1; margin-top: 10px; }
        
        .med-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .med-table td { padding: 6px 0; border-bottom: 1px dotted #cbd5e1; vertical-align: top; }
        .med-qty { font-weight: bold; font-size: 11pt; width: 10%; text-align: center; color: #1e3a8a; }
        .med-details { width: 90%; padding-left: 10px; }
        .med-name { font-size: 11pt; font-weight: bold; color: #000; }
        .med-instructions { font-size: 10pt; color: #334155; margin-top: 3px; line-height: 1.2;}

        /* =======================================================
           PIE DE PÁGINA FIJO (FOOTER)
           ======================================================= */
        .footer-fixed { position: fixed; bottom: -2.5cm; left: 0; width: 100%; text-align: center; height: 2.5cm; }
        .signature-area { margin-bottom: 10px; }
        .signature-line { width: 220px; border-top: 1px solid #000; margin: 0 auto 5px auto; }
        .clinic-info { background-color: #1e3a8a; color: #fff; padding: 8px; font-size: 8.5pt; border-radius: 6px; letter-spacing: 0.5px; }
    </style>
</head>
<body>

    <div class="watermark">
        @if(file_exists($fondo))
            <img src="{{ $fondo }}">
        @endif
    </div>

    <div class="footer-fixed">
        <div class="signature-area">
            <div class="signature-line"></div>
            <div style="font-weight: bold; font-size: 10pt; color: #1e293b;">{{ $prefijoDoc }} {{ $medico->nombre_p }}</div>
            <div style="font-size: 8pt; color: #64748b; margin-top: 1px;">Médico Tratante / Firma Autógrafa</div>
        </div>

        <div class="clinic-info">
            Servicios Médicos San Agustín • Control Prenatal • WhatsApp: {{ $medico->celular }}
        </div>
    </div>

    <table class="header">
        <tr>
            <td width="80%" valign="middle">
                <h1 class="doc-name">{{ $prefijoDoc }} {{ $medico->nombre_p }}</h1>
                <div class="doc-specialty">{{ $medico->especialidad ?? 'Médico Cirujano' }}</div>
                <div style="font-size: 9pt; margin-top: 4px; color: #475569;">
                    Cédula Profesional: <strong style="color: #1e293b;">{{ $medico->cedula }}</strong> 
                    @if($medico->institutos) | {{ $medico->institutos }} @endif
                </div>
            </td>
            <td width="20%" align="right" valign="middle">
                @if(file_exists($header1))
                    <img src="{{ $header1 }}" style="max-height: 60px; max-width: 120px;">
                @endif
            </td>
        </tr>
    </table>

    <table class="split-layout">
        <tr>
            <td class="col-sidebar">
                
                <div class="section-title">Datos del Paciente</div>
                
                <div class="info-block">
                    <div class="info-label">Nombre</div>
                    <div class="info-value"><strong>{{ $data->nombre_c }}</strong></div>
                </div>
                
                <table width="100%">
                    <tr>
                        <td width="50%" class="info-block"><div class="info-label">Edad</div><div class="info-value">{{ $data->edad }} años</div></td>
                        <td width="50%" class="info-block"><div class="info-label">Fecha</div><div class="info-value">{{ \Carbon\Carbon::parse($data->fecha)->format('d/m/Y') }}</div></td>
                    </tr>
                </table>

                <div class="info-block" style="background-color: #f1f5f9; padding: 6px; border-radius: 4px; border-left: 3px solid #1e3a8a;">
                    <div class="info-label" style="color: #1e3a8a;">Semanas de Gestación</div>
                    <div class="info-value" style="font-size: 11pt;"><strong>{{ $data->semana_gesta }} SDG</strong></div>
                </div>

                <div style="height: 10px;"></div>
                
                <div class="section-title">Somatometría Fetal</div>
                
                <table width="100%">
                    <tr>
                        <td width="50%" class="info-block"><div class="info-label">Peso</div><div class="info-value">{{ $data->peso }} kg</div></td>
                        <td width="50%" class="info-block"><div class="info-label">Talla</div><div class="info-value">{{ $data->talla }} m</div></td>
                    </tr>
                    <tr>
                        <td width="50%" class="info-block"><div class="info-label">T.A.</div><div class="info-value">{{ $data->ta }}</div></td>
                        <td width="50%" class="info-block"><div class="info-label">F. Uterino</div><div class="info-value">{{ $data->fondo_uterino }} cm</div></td>
                    </tr>
                    <tr>
                        <td width="50%" class="info-block"><div class="info-label">F.C. Fetal</div><div class="info-value">{{ $data->frecuencia_cardiaca }} lpm</div></td>
                        <td width="50%" class="info-block"><div class="info-label">Presentación</div><div class="info-value">{{ $data->presentacion }}</div></td>
                    </tr>
                </table>

                <div class="info-block">
                    <div class="info-label">Movimientos Fetales</div>
                    <div class="info-value">{{ $data->movimiento_fetal ?? 'Adecuados' }}</div>
                </div>
            </td>

            <td class="col-main">
                
                <div class="section-title">Valoración Obstétrica</div>
                
                <div class="clinical-text">
                    <span class="clinical-label">Padecimiento Actual:</span> 
                    {{ $data->padecimiento ?? 'Paciente acude a valoración obstétrica de rutina. Sin síntomas de alarma reportados.' }}
                </div>

                <div class="clinical-text">
                    <span class="clinical-label">Exploración Física:</span> 
                    {{ $data->exploracion_fisica }}
                </div>

                @if($data->procedimiento)
                <div class="clinical-text">
                    <span class="clinical-label">Procedimientos:</span> 
                    {{ $data->procedimiento }}
                </div>
                @endif

                <div class="rx-mark">Rx</div>

                @if(count($medicamentos) > 0)
                    <table class="med-table">
                        @foreach($medicamentos as $med)
                        <tr>
                            <td class="med-qty">{{ $med->cantidad }}</td>
                            <td class="med-details">
                                <div class="med-name">{{ $med->descripcion }}</div>
                                <div class="med-instructions">{{ $med->tratamiento }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <div style="text-align: center; color: #94a3b8; font-style: italic; font-size: 9.5pt; margin-bottom: 20px;">
                        (Sin prescripción de medicamentos)
                    </div>
                @endif

                @if($data->recomendaciones)
                <div class="section-title">Recomendaciones</div>
                <p class="clinical-text" style="color: #475569;">{{ $data->recomendaciones }}</p>
                @endif

            </td>
        </tr>
    </table>

</body>
</html>