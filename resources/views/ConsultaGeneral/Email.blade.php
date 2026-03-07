<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta Médica - Clínica San Agustín</title>
</head>

<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f1f5f9; padding: 40px 20px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

                    <tr>
                        <td align="center" style="background-color: #1e3a8a; padding: 30px 20px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; letter-spacing: 1px; font-family: 'Times New Roman', Times, serif;">
                                Servicios Médicos San Agustín
                            </h1>
                            <p style="color: #93c5fd; margin: 5px 0 0 0; font-size: 13px; text-transform: uppercase; letter-spacing: 2px;">
                                Expediente Clínico Electrónico
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px;">

                            <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #0f172a;">Aviso de Sistema</h2>

                            <p style="margin: 0 0 25px 0; font-size: 16px; line-height: 1.6; color: #334155;">
                                {{ $mensaje }}
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border-left: 4px solid #1e3a8a; border-radius: 4px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 15px; font-size: 14px; color: #475569; line-height: 1.5;">
                                        <strong style="color: #1e3a8a;">Instrucciones:</strong><br>
                                        Encuentra el archivo PDF de tu receta médica adjunto a este correo. Puedes descargarlo, imprimirlo o mostrarlo directamente desde tu dispositivo en la farmacia de tu preferencia.
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 15px; color: #64748b; line-height: 1.6;">
                                Sin más por el momento, quedamos a tus apreciables órdenes.<br>
                                <strong style="color: #1e293b;">El equipo de Servicios Médicos "San Agustín"</strong>
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 25px 30px; text-align: center;">
                            <p style="margin: 0 0 10px 0; font-size: 11px; color: #94a3b8; line-height: 1.5; text-align: justify;">
                                <strong>Aviso de Confidencialidad:</strong> Este correo electrónico y cualquier archivo adjunto son confidenciales y están destinados únicamente para el uso del individuo o entidad a la que están dirigidos. Si usted ha recibido este correo por error, por favor notifique al remitente inmediatamente y elimine este mensaje de su sistema.
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #cbd5e1;">
                                &copy; {{ date('Y') }} MCSystem v2.0
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>