<html>

<head>
    <style>
        /* OPPS --------------------------------------------------------------------- */
        #reference-oxxopay h3 {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }

        #reference-oxxopay .opps {
            width: 496px;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            color: #4f5365;
        }

        #reference-oxxopay .opps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        #reference-oxxopay .opps-info {
            margin-top: 26px;
            position: relative;
        }

        #reference-oxxopay .opps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        #reference-oxxopay .opps-brand {
            width: 45%;
            float: left;
        }

        #reference-oxxopay .opps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        #reference-oxxopay .opps-ammount {
            width: 55%;
            float: right;
        }

        #reference-oxxopay .opps-ammount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        #reference-oxxopay .opps-ammount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        #reference-oxxopay .opps-ammount p {
            font-size: 10px;
            line-height: 14px;
        }

        #reference-oxxopay .opps-reference {
            margin-top: 14px;
        }

        #reference-oxxopay h1 {
            font-size: 27px;
            color: #000000;
            text-align: center;
            margin-top: -1px;
            padding: 6px 0 7px;
            border: 1px solid #b0afb5;
            border-radius: 4px;
            background: #f8f9fa;
        }

        #reference-oxxopay .opps-instructions {
            margin: 32px -45px 0;
            padding: 32px 45px 45px;
            border-top: 1px solid #b0afb5;
            background: #f8f9fa;
        }

        #reference-oxxopay .opps-footnote {
            margin-top: 22px;
            padding: 22px 20 24px;
            color: #108f30;
            text-align: center;
            border: 1px solid #108f30;
            border-radius: 4px;
            background: #ffffff;
        }

    </style>
</head>

<body id="reference-oxxopay">
    <div class="opps m-0">
        <div class="opps-header">
            <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
            <div class="opps-info">
                <div class="opps-brand"><img src="https://danatura.com.mx/assets/img/brand.png" alt="OXXOPay"></div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2>$ <span class="modal-total">{{ isset($total) ? $total : '' }}</span> <sup>MXN</sup></h2>
                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h1 class="modal-reference">{{ isset($reference) ? $reference : '' }}</h1>
            </div>
        </div>
        <div class="opps-instructions">
            <h3>Instrucciones</h3>
            <ol>
                <li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank" style="color: #1155cc;">Encuéntrala aquí</a>.</li>
                <li>Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                <li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                <li>Realiza el pago correspondiente con dinero en efectivo.</li>
                <li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
            </ol>
            <div class="opps-footnote">
                Al completar estos pasos recibirás un correo de <strong>Danatura.com.mx</strong>
                confirmando tu pago.
            </div>
        </div>
    </div>
</body>

</html>
