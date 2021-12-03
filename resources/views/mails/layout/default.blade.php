<!DOCTYPE html>
<html>

<head>
    <title>Danatura</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mails css -->
    <style>
        * {
            font-family: Open Sans, Helvetica, Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }

        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        @media screen and (max-width: 480px) {
            .mobile-hide {
                display: none !important;
            }

            .mobile-center {
                text-align: center !important;
            }
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        .icon-danatura {
            width: 100%;
            min-width: 100%;
            height: auto;
        }

        .body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #eeeeee;
        }

        .td-content {
            text-align: center;
            background-color: #eeeeee;
        }

        .table-container {
            text-align: center;
            border: 0;
            max-width: 600px;
        }

        .w-100 {
            width: 100% !important;
        }

        .text-center {
            text-align: center !important;
        }

        .td-head {
            font-size: 0;
            padding: 35px;
            background-color: #B5C7A1;
        }

        .logo-tienda-container {
            display: inline-block;
            max-width: 50%;
            min-width: 100px;
            vertical-align: top;
            width: 100%;
        }

        .td-logo-tienda {
            font-size: 36px;
            font-weight: 800;
            line-height: 48px;
        }

        .btn-buy-again {
            font-size: 18px;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            background-color: #B5C7A1;
            padding: 15px 30px;
            display: block;
        }

        .table-center {
            margin-left: auto;
            margin-right: auto;
        }

        .font-folio {
            font-weight: 800;
            line-height: 24px;
            padding: 10px;
        }

        .font-productos {
            font-weight: 400;
            line-height: 24px;
            padding: 15px 10px 5px 10px;
        }

        .font-total {
            font-weight: 800;
            line-height: 24px;
            padding: 10px;
            border-top: 3px solid #eeeeee;
            border-bottom: 3px solid #eeeeee;
        }

        .container-info-extra {
            display: inline-block;
            vertical-align: top;
            width: 100%;
        }

        .container-footer {
            font-size: 14px;
            font-weight: 400;
            line-height: 24px;
        }

        .font-aviso-privacidad {
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            color: #777777;
        }

        .font-dudas {
            font-size: 14px;
            font-weight: 800;
            line-height: 18px;
            color: #333333;
        }
    </style>

</head>

<body class="body">

    <table class="w-100" cellpadding="0" cellspacing="0">
        <tr>
            <td class="td-content">
                <table class="table-container w-100 table-center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" class="td-head">
                            <div class="logo-tienda-container">
                                <table cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;"
                                    align="left" border="0">
                                    <tr>
                                        <td valign="top" class="mobile-center td-logo-tienda" align="left">
                                            <img src="http://danatura.com.mx/assets/images/Logotipo-09.png"
                                                class="icon-danatura" alt="">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="logo-tienda-container" class="mobile-hide">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="right" valign="top" class="td-logo-tienda">
                                            <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                <tr>
                                                    <td style="font-size: 18px; font-weight: 400;">
                                                        <p
                                                            style="font-size: 18px; font-weight: 400; margin: 0; color: #ffffff;">
                                                            <a href="#" target="_blank" style="color: #ffffff; text-decoration: none;">Tienda &nbsp;</a>
                                                        </p>
                                                    </td>
                                                    <td style="font-size: 18px; font-weight: 400; line-height: 24px;">
                                                        <a href="#" target="_blank" style="color: #ffffff; text-decoration: none;">
                                                            <img src="https://img.icons8.com/color/48/000000/small-business.png" width="30" height="26" style="display: block; border: 0px;" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    @yield('content')

                    <tr>
                        <td style="padding: 35px; background-color: #D7E9C0;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center" style="font-weight: 400; line-height: 24px; padding-top: 25px;">
                                        <h2 style="font-size: 24px; font-weight: 800; line-height: 30px; color: #ffffff; margin: 0;">
                                            ¡No te pierdas de increíbles productos!
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 25px 0 15px 0;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 5px; background: #66b3b7;">
                                                    <a href="http://danatura.com.mx/" target="_blank" class="btn-buy-again">Ir a la tienda</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px; background-color: #ffffff;">
                            <table class="table-center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center"> <img src="http://danatura.com.mx/assets/icons/Manos-15.png" width="140" style="display: block; border: 0px;" /> </td>
                                </tr>
                                <tr>
                                    <td align="center" class="container-footer" style="padding: 5px 0 10px 0;">
                                        <p class="font-dudas">
                                            Dudas y/o aclaraciones <a href="tel:3339566141" style="color: #777777; text-decoration: none;">(33)39566141</a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" class="container-footer">
                                        <p class="font-aviso-privacidad">
                                            Aviso de privacidad | Términos y condiciones © 2021, Todos los derechos reservados.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>