<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* Definimos explícitamente 0.5cm arriba y abajo, 1cm a los lados */
        @page { margin: 0.5cm 1cm 0.5cm 1cm; } 
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; margin: 0; padding: 0; }
        
        /* Contenedor matemático: 12.8cm garantiza que dos quepan en Carta (27.9cm) */
        .half-page-container { 
            width: 100%; 
            height: 12.8cm; 
            border-collapse: collapse; 
            table-layout: fixed; 
            overflow: hidden; 
        }

        /* Encabezado */
        .header { width: 100%; border-bottom: 2px solid #1e3a8a; padding-bottom: 8px; margin-bottom: 10px; }
        .doc-name { font-family: 'Times New Roman', Times, serif; font-size: 19pt; margin: 0; color: #1e3a8a; letter-spacing: -0.5px; }
        .doc-specialty { font-size: 10.5pt; font-weight: bold; letter-spacing: 1px; margin-top: 2px; text-transform: uppercase; color: #0f172a; }
        
        /* Estructura Central */
        .split-layout { width: 100%; border-collapse: collapse; }
        .col-sidebar { width: 33%; vertical-align: top; padding-right: 15px; border-right: 1px solid #e2e8f0; }
        .col-main { width: 67%; vertical-align: top; padding-left: 15px; }

        /* Títulos de sección */
        .section-title { font-size: 9pt; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 8px; color: #1e3a8a; }
        
        /* Sidebar Izquierdo: Datos */
        .info-block { margin-bottom: 10px; }
        .info-label { font-size: 8pt; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .info-value { font-size: 10pt; color: #1e293b; margin-top: 1px; }

        /* Centro de la hoja: Rx y Medicamentos */
        .rx-mark { font-family: 'Times New Roman', Times, serif; font-size: 26pt; color: #1e3a8a; font-weight: bold; margin-bottom: 6px; line-height: 1; }
        
        .med-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .med-table td { padding: 6px 0; border-bottom: 1px dotted #cbd5e1; vertical-align: top; }
        .med-qty { font-weight: bold; font-size: 11pt; width: 10%; text-align: center; color: #1e3a8a; }
        .med-details { width: 90%; padding-left: 10px; }
        .med-name { font-size: 11pt; font-weight: bold; color: #000; }
        .med-instructions { font-size: 10pt; color: #334155; margin-top: 3px; line-height: 1.2;}

        /* Zona Diagnóstica */
        .diag-text { font-size: 9.5pt; line-height: 1.3; color: #1e293b; margin: 4px 0 10px 0; }
        .obs-text { font-size: 9pt; line-height: 1.3; color: #475569; margin: 4px 0 0 0; }

        /* Pie de página */
        .footer-container { width: 100%; text-align: center; padding-top: 5px; }
        .signature-area { margin-bottom: 10px; }
        .signature-line { width: 220px; border-top: 1px solid #000; margin: 0 auto 5px auto; }
        .clinic-info { background-color: #1e3a8a; color: #fff; padding: 8px; font-size: 8.5pt; border-radius: 6px; letter-spacing: 0.5px; }

        /* Línea de corte (Reducida a 0.5cm) */
        .cut-line { 
            border-bottom: 1.5px dashed #cbd5e1; 
            margin: 0; 
            text-align: center; 
            font-size: 8pt; 
            color: #94a3b8; 
            letter-spacing: 3px; 
            height: 0.5cm;
            line-height: 0.5cm;
        }
    </style>
</head>
<body>

    @for ($i = 0; $i < 2; $i++)
    
    <table class="half-page-container">
        <tr>
            <td valign="top" style="padding: 0;">
                
                <table class="header">
                    <tr>
                        <td width="80%">
                            <h1 class="doc-name">{{ $medico->genero == 'H' ? 'Dr.' : 'Dra.' }} {{ $medico->nombre }} {{ $medico->ap_paterno }} {{ $medico->ap_materno }}</h1>
                            <div class="doc-specialty">{{ $medico->especialidad }}</div>
                            <div style="font-size: 9pt; margin-top: 4px; color: #475569;">Cédula Profesional: <strong style="color: #1e293b;">{{ $medico->cedula }}</strong> | {{ $medico->institutos }}</div>
                        </td>
                        <td width="20%" align="right" valign="middle">
                            <img src="{{ public_path('image/logopdf1.png') }}" width="75">
                        </td>
                    </tr>
                </table>

                <table class="split-layout">
                    <tr>
                        <td class="col-sidebar">
                            <div class="section-title">Datos del Paciente</div>
                            
                            <div class="info-block">
                                <div class="info-label">Nombre</div>
                                <div class="info-value"><strong>{{ $consulta->p_nom }} {{ $consulta->p_pat }} {{ $consulta->p_mat }}</strong></div>
                            </div>
                            
                            <div class="info-block">
                                <div class="info-label">Edad / Género</div>
                                <div class="info-value">{{ $consulta->edad }} años / {{ $consulta->genero }}</div>
                            </div>

                            <div class="info-block">
                                <div class="info-label">Fecha / Folio</div>
                                <div class="info-value">{{ date('d/m/Y', strtotime($consulta->fecha)) }} <span style="color: #1e3a8a; font-weight: bold; float: right;">#{{ str_pad($consulta->id, 5, '0', STR_PAD_LEFT) }}</span></div>
                            </div>

                            <div style="height: 5px;"></div>
                            
                            <div class="section-title">Somatometría</div>
                            <table width="100%">
                                <tr>
                                    <td width="50%" class="info-block"><div class="info-label">Peso</div><div class="info-value">{{ $consulta->peso }} kg</div></td>
                                    <td width="50%" class="info-block"><div class="info-label">Talla</div><div class="info-value">{{ $consulta->talla }} cm</div></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="info-block"><div class="info-label">T/A</div><div class="info-value">{{ $consulta->ta }}</div></td>
                                    <td width="50%" class="info-block"><div class="info-label">Temp</div><div class="info-value">{{ $consulta->temperatura }} °C</div></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="info-block" style="margin-bottom: 0;"><div class="info-label">Glucosa</div><div class="info-value">{{ $consulta->glucosa }} mg/dL</div></td>
                                </tr>
                            </table>
                        </td>

                        <td class="col-main">
                            <div class="rx-mark">Rx</div>

                            <table class="med-table">
                                @foreach($medicamentos as $med)
                                <tr>
                                    <td class="med-qty">{{ $med->cantidad }}</td>
                                    <td class="med-details">
                                        <div class="med-name">{{ $med->nombre }} <span style="font-weight: normal; font-size: 9.5pt; color: #64748b;">{{ $med->presentacion }}</span></div>
                                        <div class="med-instructions">{{ $med->tratamiento }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            <div class="section-title">Impresión Diagnóstica</div>
                            <p class="diag-text">{{ $consulta->diagnostico }}</p>

                            @if($consulta->observaciones)
                            <div class="section-title">Recomendaciones</div>
                            <p class="obs-text">{{ $consulta->observaciones }}</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="height: 65px; padding: 0;">
                <div class="footer-container">
                    <div class="signature-area">
                        <div class="signature-line"></div>
                        <div style="font-weight: bold; font-size: 10pt; color: #1e293b;">{{ $medico->nombre }} {{ $medico->ap_paterno }} {{ $medico->ap_materno }}</div>
                        <div style="font-size: 8pt; color: #64748b; margin-top: 1px;">Firma del Médico Autógrafo / Electrónica</div>
                    </div>

                    <div class="clinic-info">
                        Servicios Médicos San Agustín • San Agustín de las Juntas, Oaxaca • Tel: {{ $medico->celular }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    @if($i == 0)
    <div class="cut-line">✂ - - - - - - - - - - - - - Cortar por aquí - - - - - - - - - - - - -</div>
    @endif

    @endfor

</body>
</html>