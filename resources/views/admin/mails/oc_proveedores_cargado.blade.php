<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>OC Proveedores cargada - Proyecto {{ $proyecto->nombre_proyecto }}</title>
</head>

<body>
    <div class="es-wrapper-color" style="background-color:#f9f9f9">
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"
            style="border-collapse:collapse;width:100%;height:100%;background-color:#f9f9f9;">
            <tbody>
                <tr>
                    <td align="center" style="background-color: #f9f9f9">
                        <table class="es-header" width="100%" cellspacing="0" cellpadding="0" align="center"
                            style="border-collapse:collapse;background-color:#f9f9f9;">
                            <tbody>
                                <tr>
                                    <td align="center">
                                        <table class="es-header-body" width="600" cellspacing="0" cellpadding="0" align="center"
                                            style="background-color:#f9f9f9;">
                                            <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="padding:20px 10px 10px 10px;">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="580" align="center">
                                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                                        <tr></tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="es-content" cellspacing="0" cellpadding="0" align="center"
                            style="border-collapse:collapse;width:100%;">
                            <tbody>
                                <tr>
                                    <td align="center" bgcolor="#f9f9f9">
                                        <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center"
                                            style="background-color:transparent;">
                                            <tbody>
                                                <tr>
                                                    <td align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="600" align="center">
                                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                                                        style="background-color:#ffffff;border-radius:4px;">
                                                                        <tr>
                                                                            <td align="center"
                                                                                style="padding:35px 30px 5px 30px;">
                                                                                <img src="{{ asset("storage/logo-ohffice-azul.jpeg") }}"
                                                                                    alt="" width="250">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td bgcolor="#ffffff" align="left"
                                                                                style="padding:20px 30px 15px 30px;">
                                                                                <p style="font-size:20px;line-height:27px;color:#000000;text-align:center;">
                                                                                    Estimado equipo, <br>
                                                                                    Se han cargado documentos en la sección <strong>OC ILESA</strong>
                                                                                    del proyecto <strong>{{ $proyecto->nombre_proyecto }}</strong>.
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left"
                                                                                style="padding:20px 30px 0 30px;">
                                                                                <ul style="font-size:18px;line-height:1.5;color:#000000;">
                                                                                    <li>
                                                                                        <strong>Proyecto:</strong>
                                                                                        {{ $proyecto->nombre_proyecto }}
                                                                                    </li>
                                                                                    <li>
                                                                                        <strong>ID Proyecto:</strong>
                                                                                        {{ $proyecto->id }}
                                                                                    </li>
                                                                                    <li>
                                                                                        <strong>Fecha de carga:</strong>
                                                                                        {{ now() }}
                                                                                    </li>
                                                                                    <li>
                                                                                        <strong>Link directo:</strong>
                                                                                        <a href="{{ url('admin/proyectos/' . $proyecto->id) }}">Ver Proyecto</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left"
                                                                                style="padding:20px 30px 30px 30px;">
                                                                                <p style="font-size:20px;text-align:center;color:#000000;">
                                                                                    ¡Gracias por utilizar Ohffice!
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="es-header" cellspacing="0" cellpadding="0" align="center"
                            style="width:100%;background-color:#f9f9f9;">
                            <tbody>
                                <tr>
                                    <td align="center">
                                        <table class="es-header-body" width="600" cellspacing="0" cellpadding="0" align="center"
                                            style="background-color:#f9f9f9;">
                                            <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="padding:20px 10px 10px 10px;">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="580" align="center">
                                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                                        <tr></tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
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
