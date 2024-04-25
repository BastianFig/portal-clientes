<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Su Proyecto {{ $nombre_proyecto }}, ha cambiado de Fase.</title>
    </head>

    <body>
        

        <div class="es-wrapper-color" style="background-color:#f9f9f9">
            <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
                <tbody>
                    <tr style="border-collapse:collapse">
                        <td style="padding:0;Margin:0;background-color: #f9f9f9" bgcolor="#f9f9f9" align="center">
                            <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#f9f9f9;background-repeat:repeat;background-position:center top">
                                <tbody>
                                    <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0">
                                            <table class="es-header-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#f9f9f9;width:600px">
                                                <tbody>
                                                    <tr style="border-collapse:collapse">
                                                        <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
                                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                <tbody>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                                <tbody>
                                                                                    <tr style="border-collapse:collapse">
                                                                                        
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                <tbody>
                                    <tr style="border-collapse:collapse">
                                        <td style="padding:0;Margin:0;background-color: #f9f9f9" bgcolor="#f9f9f9" align="center">
                                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
                                                <tbody>
                                                    <tr style="border-collapse:collapse">
                                                        <td align="left" style="padding:0;Margin:0">
                                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                <tbody>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                                            <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#ffffff;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
                                                                                <tbody>
                                                                                    <tr style="border-collapse:collapse">
                                                                                        <td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px">
                                                                                        <img src="{{ asset("storage/logo-ohffice-azul.jpeg")}}" alt="" width="250">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="border-collapse:collapse">
                                                                                        <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-bottom:15px;padding-top:20px;padding-left:30px;padding-right:30px">
                                                                                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#000000;font-size:20px;text-align:center !important;">Estimado {{ $name }}, <br> Comunicamos que su Proyecto ({{$nombre_proyecto}}) ha cambiado de fase, dejamos el detalle a continuación.<br>
                                                                                            </p> 
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="border-collapse:collapse">
                                                                                        <td class="es-m-txt-l" align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px">
                                                                                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#000000;font-size:24px">
                                                                                                <ul>
                                                                                                    @if($fase_actual == "Fase de Postventa")
                                                                                                        <li style="font-size: 24px;">Su Proyecto ha llegado a la Fase de Postventa, por favor complete la encuesta en el siguiente Link: <strong><a href="{{ url('encuesta/responder/') . '/' .$id_proyecto}}">Responder Encuesta</a></strong></li>
                                                                                                    @else
                                                                                                        <li style="font-size: 24px;"><strong>Fase Anterior Completada: </strong> {{$fase_anterior}}</li>
                                                                                                        <li style="font-size: 24px;"><strong>Fase Actual: </strong> {{$fase_actual}}</li>
                                                                                                        <li style="font-size: 24px;"><strong>Fecha de Cambio: </strong> {{now()}}</li>
                                                                                                    @endif
                                                                                                </ul>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="border-collapse:collapse">
                                                                                        <td class="es-m-txt-l" align="left" style="padding-bottom:30px;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px">
                                                                                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#000000;font-size:20px; text-align: center;">
                                                                                                    ¡Gracias por confiar en Ohffice! 
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#f9f9f9;background-repeat:repeat;background-position:center top">
                                <tbody>
                                    <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0">
                                            <table class="es-header-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#f9f9f9;width:600px">
                                                <tbody>
                                                    <tr style="border-collapse:collapse">
                                                        <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
                                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                <tbody>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                                            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                                <tbody>
                                                                                    <tr style="border-collapse:collapse">
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>