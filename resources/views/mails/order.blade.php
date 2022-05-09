@extends('mails.layout.default')
@section('content')

<tr>
    <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
        <table class="table-center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
            <tr>
                <td align="center" style="font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                    <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                        ¡Gracias por su compra!
                    </h2>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-weight: 400; line-height: 24px; padding-top: 10px;">
                    <p style="font-weight: 400; line-height: 24px; color: #777777;">
                        Estimado <strong>{{ $data['nombre'] }}</strong>,
                        a continuación le detallamos la compra que acaba de realizar en nuestra página eCommerce
                    </p>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding-top: 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="font-folio" width="70%" align="left" bgcolor="#eeeeee"> Resumen de compra</td>
                            <td class="font-folio" width="30%" align="left" bgcolor="#eeeeee"> </td>
                        </tr>
                        <?php
                            $carrito = $data['carrito'];
                            for ($i = 0; $i < sizeof($carrito); $i++) {
                        ?>
                        <tr>
                            <td class="font-productos" width="70%" align="left">
                                <?php echo $carrito[$i]['nombre'] ?>
                            </td>
                            <td class="font-productos" width="30%" align="left">
                                <?php echo $carrito[$i]['cantidad'] . ' x ' . $carrito[$i]['precio_unit'] . ' = $' .  number_format($carrito[$i]['cantidad'] * $carrito[$i]['precio_unit'], 2, '.', ','); ?>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                        <tr>
                            <td class="font-productos" width="70%" align="left">Envío</td>
                            <td class="font-productos" width="30%" align="left">${{ number_format(170, 2, '.', ',') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding-top: 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="font-total" width="70%" align="left"> TOTAL </td>
                            <td class="font-total" width="30%" align="left">${{ number_format($data['total'], 2, '.',
                                ',') }} </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="center" height="100%" valign="top" width="100%" style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
        <table class="table-center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
            <tr>
                <td align="center" valign="top" style="font-size:0;">
                    <div class="container-info-extra">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                            <tr>
                                <td align="left" valign="top" style="font-weight: 400; line-height: 24px;">
                                    <p style="font-weight: 800;">Datos del cliente:</p>
                                    <p>
                                        <div><span style="font-weight: 600;">Nombre: </span>{{ $data['nombre'] }}</div>
                                        <div><span style="font-weight: 600;">Email: </span>{{ $data['email'] }}</div>
                                    </p>
                                    <p style="font-weight: 800;">Datos del envío:</p>
                                    <p>
                                        <div><span style="font-weight: 600;">Nombre completo: </span>{{ $data['nombre_envio'] }}</div>
                                        <div><span style="font-weight: 600;">Dirección: </span>{{ $data['direccion_envio'] }}</div>
                                        <div><span style="font-weight: 600;">Teléfono: </span>{{ $data['telefono_envio'] }}</div>
                                        <div><span style="font-weight: 600;">Email: </span>{{ $data['email_envio'] }}</div>
                                    </p>
                                    <p style="font-weight: 800;">Datos del pago: <span></span></p>
                                    <p>
                                        <div><span style="font-weight: 600;">Método: </span>{{ $data['method'] }}</div>
                                        <div><span style="font-weight: 600;">Status: </span>{{ $data['status'] }}</div>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection
