@extends('mails.layout.default')
@section('content')

<tr>
    <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
        <table class="table-center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
            <tr>
                <td align="center" style="font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                    <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                        ¡Orden pagada!
                    </h2>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-weight: 400; line-height: 24px; padding-top: 10px;">
                    <p style="font-weight: 400; line-height: 24px; color: #777777;">
                        Hemos recibido su <strong>pago de OxxoPay</strong>, su orden esta en proceso de entrega. <br>
                        Gracias por confiar en nosotros.
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection

