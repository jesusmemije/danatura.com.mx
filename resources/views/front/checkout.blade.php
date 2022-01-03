@extends('front.layout.app')

@section('title')
Checkout
@endsection

@section('styles')
<style>
    sup {
        color: red;
    }

    .text-center-items {
        text-align: unset;
    }

    .pull-left {
        float: left !important;
    }

    .pull-right {
        float: right !important;
    }

    @media screen and (max-width: 480px) {
        .text-center-items {
            text-align: center;
        }
    }
</style>

<link href="{{asset('assets/css/checkout.css')}}" rel="stylesheet" />

@endsection

@section('content')

@include('front.layout.partials.menu')

@php
    // SDK de Mercado Pago
    require base_path('vendor/autoload.php');
    // Agrega credenciales
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    $shipments = new MercadoPago\Shipments();
    $shipments->cost = 170;
    $shipments->mode = "not_specified";

    $preference->shipments = $shipments;

    $carrito  = $_SESSION['carrito'];
    foreach ($carrito as $product) {
        // Crea un ítems en la preferencia
        $item = new MercadoPago\Item();
        $item->title      = $product['nombre'];
        $item->quantity   = floatval( $product['cantidad'] );
        $item->unit_price = (int) $product['precio_unit'];

        $products[] = $item;
    }

    $preference->back_urls = array(
        "success" => route('payWithMercadoPago')
    );
    $preference->auto_return = "approved";
    $preference->items       = $products;

    $preference->binary_mode = true;
    $preference->statement_descriptor = "Danatura - comida real";

    $preference->save();

@endphp

<div class="container pt-4 pb-4">
    <div class="container col-sm-12">
        <a class="btn btn-light pull-right" href="{{url('carrito')}}">Cancelar</a>
        <br>
    </div>
    <br>
    <hr>
    <div class="row clearfix">
        <div class="col-md-6 col-12 text-center-items">
            <?php 
                $productos = DB::table('productos')->select('id', 'nombre', 'sabor','descripcion', 'gramos','precio','fotografia')->get();

                $carrito = $_SESSION['carrito'];
                $cantidad_carrito=0;
                foreach ($carrito as $key => $value) {
                    //print_r($value['cantidad']);
                    $cantidad_carrito=$cantidad_carrito+$value['cantidad'];
                }
                //  print_r($carrito);
                $i=0;
                $totalPagar = 0;
            ?>

            <p class="text-center font-weight-bold h5 py-2" style="background:lightgreen;">Detalle de la compra</p>
            <br>
            <p class="font-weight-bold h5">Resumen:</p>
            <p>Cantidad total de productos: {{$cantidad_carrito}} </p>
            <p>Costo por envio: ${{ number_format($_SESSION['gastoEnvio'], 2, '.', ',') }}</p>
            <p>Monto total: ${{ number_format($_SESSION['totalpagar'], 2, '.', ',') }}</p>
            <p hidden>SubTotal: ${{ number_format($_SESSION['subtotal'], 2, '.', ',') }}</p>
            <br>
            <br>
            <input id="cajamonto" type="hidden" value="{{($_SESSION['totalpagar'])}}">
            <p style="font-weight: bold;">Detalles de pedido:</p>
            <table class="table table-hover product_item_list  mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="phone-hide" data-breakpoints="sm xs">Descripción</th>
                        <th data-breakpoints="xs">Cantidad</th>
                        <th data-breakpoints="xs">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $producto) {

                        foreach ($carrito as $key) {
                            if ($producto->id == $key['producto_id']) {
                                $totalPagar = $producto->precio + $totalPagar;
                                ?>
                    <tr>
                        <td>
                            <h6>
                                <?php echo $producto->nombre; ?>
                            </h6>
                        </td>
                        <td class="phone-hide"><span class="text-muted">
                                <?php echo $producto->descripcion;  ?>
                            </span></td>
                        <td>
                            <?php echo $key['cantidad'];  ?>
                        </td>
                        <td id="<?php echo $producto->id ?>">$
                            <?php echo number_format($producto->precio, 2, '.', ',') ?>
                        </td>
                    </tr>
                    <?php
                                $i++;
                            }
                        }
                    } ?>
                </tbody>
            </table>
            <div class="col-md-6 ">
                <hr>
                <button class="btn btn-success mb-4" data-toggle="modal" data-target="#modalenvio"> Datos de
                    envío</button>
                <span class="badge bg-warning text-dark">Seleccione el botón para escribir sus datos de envío.</span>
            </div>
        </div>

        <div class="col-md-6 col-12 text-center-items">

            <div class="text-center">
                <label class="font-weight-bold h5"> Método de pago </label><br>
            </div>

            <div class="tabs mt-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="visa-tab" data-toggle="tab" href="#visa" role="tab"
                            aria-controls="visa" aria-selected="true">
                            <img src="/assets/icons/credit-card.png" width="80">
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab"
                            aria-controls="paypal" aria-selected="false">
                            <img src="/assets/icons/paypal.png" width="80">
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="mercadopago-tab" data-toggle="tab" href="#mercadopago" role="tab"
                            aria-controls="mercadopago" aria-selected="false">
                            <img src="/assets/icons/mercado-pago.png" width="80">
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Tarjeta de crédito / débito</h5>
                            </div>
                            <div class="form mt-3">
                                <form action="{{ route('payWithConekta') }}" method="POST" id="payment-form">
                                    <!-- Datos de envío -->
                                    <input type="hidden" id="id_envio" name="id_envio">
                                    <!--Input for Token-->
                                    <input type="hidden" id="token_id" name="token_id">

                                    <!-- Datos de la tarjeta-->
                                    <br>
                                    Nombre del Tarjetahabiente
                                    <br>
                                    <input type="text" class="form-control" placeholder="Juan Pérez" class="w3-input"
                                        maxlength="50" data-conekta="card[name]" autocomplete="off" required><br>
                                    Número de Tarjeta
                                    <br>
                                    <input id="number_card" type="text" class="form-control"
                                        placeholder="0000 0000 0000 0000" class="w3-input" maxlength="16" minlength="16"
                                        data-conekta="card[number]" required>
                                    <div id="msg_number_card"></div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            Fecha de Vencimiento
                                            <br>
                                            <select class="form-control" class="w3-input"
                                                style="width:46%; float:left; margin-right:4%"
                                                data-conekta="card[exp_month]" required>
                                                <option disabled selected>[Mes]</option>
                                                <?php
                                                $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                                
                                                for ($i = 1; $i <= sizeof($meses); $i++) { ?>
                                                <?php if ($i <= 9) : ?>
                                                <option value="<?php echo "0" . $i ?>">
                                                    <?php echo "0" . $i . " - " . $meses[$i - 1] ?>
                                                </option>
                                                <?php else : ?>
                                                <option value="<?php echo $i ?>">
                                                    <?php echo $i . " - " . $meses[$i - 1] ?>
                                                </option>
                                                <?php endif ?>

                                                <?php } ?>
                                            </select>

                                            <select class="form-control" class="w3-input"
                                                style="width:46%; float:left; margin-right:4%"
                                                data-conekta="card[exp_year]" required>
                                                <option disabled selected>[Año]</option>

                                                <?php for ($i = 21; $i <= 30; $i++) { ?>
                                                <option value="<?php echo $i ?>">
                                                    <?php echo $i . " - " . "20" . $i ?>
                                                </option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="row" id="borde">
                                        <div class="col-md-6">
                                            <br>
                                            <input id="number_cvv" class="form-control" type="text" class="w3-input"
                                                maxlength="4" minlength="3" placeholder="CVV" data-conekta="card[cvc]"
                                                required>
                                            <div id="msg_number_cvv"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <br>
                                            <img src="{{asset('assets/images/cvv.png')}}" alt="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="conekta col-xl-6">
                                            <br><br>
                                            <label>Transacciones realizadas vía:</label>
                                            <img style="height:40px" src="{{asset('assets/images/conekta.png')}}"
                                                alt="">
                                        </div>
                                        <div class="secure col-xl-6">
                                            <br><br>
                                            Tus pagos se realizan de forma segura con encriptación de 256 bits
                                            <img style="height:40px" src="{{asset('assets/images/security.png')}}"
                                                alt="">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-danger px-5" id="pay-button">
                                            Pagar productos
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Pago con PayPal</h5>
                            </div>
                            <div class="my-4" id="paypal-button-container"></div>
                            <div class="text-center">
                                <span id="noPaypal" class="badge badge-danger">Debe escribir sus datos de envio para poder continuar</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="mercadopago" role="tabpanel" aria-labelledby="mercadopago-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Pago con Mercado Pago</h5>
                                <div class="cho-container" id="mercado-pago-container"></div>
                                <div class="text-center">
                                    <span id="noMercadoPago" class="badge badge-danger">Debe escribir sus datos de envio para poder continuar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
        </div>
    </div>
</div>

<!-- modal para los datos de envío -->
<!-- Modal -->
<div id="modalenvio" class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos de envío/facturación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pb-5">
                    <div class="row">
                        <div class="col">
                            <form id="form-envios" method="post">
                                <input hidden type="text" id="dato_id" name="dato_id">
                                <label for="">Nombre (Requerido)<sup class="supred">*</sup></label>
                                <input required id="nombreenvio" name="nombre" type="text" class="form-control"
                                    placeholder="">
                        </div>
                        <div class="col">
                            <label for="">Apellidos (Requerido)<sup>*</sup></label>
                            <input required id="apellidosenvio" type="text" name="apellidos" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <label for="">Empresa (Opcional)</label>
                    <input id="empresaenvio" type="text" class="form-control" name="empresa" placeholder="">

                    <label for="">País (Requerido)<sup>*</sup></sup></label>
                    <input id="paisenvio" type="text" class="form-control" name="pais" placeholder="">

                    <label for="">Dirección de la calley número (Requerido)<sup>*</sup></label>
                    <input id="direccion1envio" type="text" class="form-control" name="direccion1"
                        placeholder="Dirección #1- número de la casa y nombre de la calle">
                    <br>
                    <input id="direccion2envio" type="text" class="form-control" name="direccion2"
                        placeholder="Continuación de la dirección">

                    <label for="">Localidad/Ciudad (Requerido)<sup>*</sup></label>
                    <input id="localidadenvio" type="text" class="form-control" name="localidad">

                    <label for="">Región/Provincia (Requerido)<sup>*</sup></label>
                    <input id="regionenvio" type="text" class="form-control" name="region">

                    <label for="">Código Postal (Requerido)<sup>*</sup></label>
                    <input id="cpenvio" type="text" class="form-control" name="cp">

                    <label for="">Teléfono/Celular (Requerido)<sup>*</sup></label>
                    <input id="telefonoenvio" type="text" class="form-control" name="telefono">

                    <label for="">Correo electrónico (Requerido)<sup>*</sup></label>
                    <input id="emailenvio" type="text" class="form-control" name="email" placeholder="">

                    <label for="">RFC (Opcional)</label>
                    <input id="rfcenvio" type="text" class="form-control" name="rfc"
                        placeholder="*En caso de requerir factura">

                    <label for="">Referencia (Opcional)</label>
                    <input id="referenciaenvio" type="text" class="form-control" name="referencia"
                        placeholder="Referencia del lugar de envío del paquete">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button onclick="validarDatosEnvio()" type="button" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<!-- Paypal SDK -->
<script src="https://www.paypal.com/sdk/js?currency=MXN&client-id={{ env('PAYPAL_CLIENT_ID') }}" data-namespace="paypal_sdk"></script> 
<!-- SDK MercadoPago.js V2 -->
<script src="https://sdk.mercadopago.com/js/v2"></script>

<!-- Validate pago MercadoPago -->
@if (session()->has('statusPayMercadoPago'))
    @if ( session()->get('statusPayMercadoPago') == "success" )
        @php
            unset($_SESSION['carrito']);
            unset($_SESSION['totalpagar']);
        @endphp
        <script>
            Swal.fire({
                icon: 'success',
                title:'¡Pago exitoso!',
                text: 'Hemos enviado un email con los detalles de su compra. Muchas gracias.'
            }).then((result) => {
                window.location.href = '/historial_pedidos';
            })
        </script>        
    @else
        <script>
            msg_error('{{ session()->get('statusPayMercadoPago') }}')
        </script>   
    @endif
@endif

<script>
    // Agrega credenciales de SDK
    const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
        locale: 'es-MX'
    });

    console.log('id_preference: ' + '{{ $preference->id }}');
    
    // Inicializa el checkout
    mp.checkout({
        preference: {
            id: '{{ $preference->id }}'
        },
        render: {
            container: '.cho-container', // Indica el nombre de la clase donde se mostrará el botón de pago
            label: 'Pagar ahora', // Cambia el texto del botón de pago (opcional)
        },
        theme: {
            elementsColor: '#F79860',
            headerColor: '#D7E9C0',
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        Conekta.setPublicKey('{{ env('CONEKTA_PUBLIC_KEY') }}');
        Conekta.setLanguage("es");

        //jQuery para que genere el token después de dar click en submit
        $('#pay-button').on('click', function(event) {
            event.preventDefault();

            var id_envio = $('#id_envio').val();

            if( id_envio != "" && id_envio != null ){
                var $form = $("#payment-form");
                // Previene hacer submit más de una vez
                $("#pay-button").prop("disabled", true);
                Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
            } else {
                msg_warning('Antes de realizar la compra debe llenar los datos de envío')
            }
        });

        var conektaSuccessResponseHandler = function(token) {

            // Enviar al input
            $('#token_id').val(token.id);
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type  : $('#payment-form').attr('method'),
                url   : $('#payment-form').attr('action'),
                data  : $('#payment-form').serialize(),
                cache : false,
                success: function(response) {

                    console.log("Response the payment Card: ") ; 
                    console.log(response);

                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title:'¡Pago exitoso!',
                            text: 'Hemos enviado un email con los detalles de su compra. Muchas gracias.'
                        }).then((result) => {
                            window.location.href = '/historial_pedidos';
                        })
                    } else {
                        msg_error(response.message)
                        $("#pay-button").prop("disabled", false);
                    }

                },
                error:  function (response) { 
                    console.log( response );
                }
            });

        };

        var conektaErrorResponseHandler = function(response) {
            msg_error(response.message_to_purchaser)
            $("#pay-button").prop("disabled", false);
        };

    });
</script>

<script>
    $(document).ready(function () {
        //called when key is pressed in textbox
        $("#number_card").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#msg_number_card").html("Sólo se aceptan números").show().fadeOut("slow");
                return false;
            }
        });

        $("#number_cvv").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#msg_number_cvv").html("Sólo se aceptan números").show().fadeOut("slow");
                return false;
            }
        });

    });
</script>

<script>
    function enviarData( data ){
        // console.log(data);
        $("#id_envio").val(data.id);
        $('#dato_id').val(data.id);
        $('#nombreenvio').val(data.nombre);
        $('#apellidosenvio').val(data.apellidos);
        $('#empresaenvio').val(data.empresa);
        $('#paisenvio').val(data.pais);
        $('#direccion1envio').val(data.direccion1);
        $('#direccion2nvio').val(data.direccion2);
        $('#localidadenvio').val(data.localidad);
        $('#regionenvio').val(data.region);
        $('#cpenvio').val(data.cp);
        $('#telefonoenvio').val(data.telefono)
        $('#emailenvio').val(data.email)
        $('#rfcenvio').val(data.rfc)
        $('#referenciaenvio').val(data.referencia)
    }    
</script>

@php

    $envio_user = DB::table('datos_envios')
    ->where('datos_envios.id_user','=', Auth::user()->id)->latest('created_at')->first();

    $data = json_encode( $envio_user );

    if( $envio_user ){
        echo "<script>
            $('#paypal-button-container').show();
            $('#noPaypal').hide();
            
            $('#mercado-pago-container').show();
            $('#noMercadoPago').hide();
            
            enviarData( $data ); 
        </script>";
    } else {
        echo "<script>
            $('#paypal-button-container').hide();
            $('#noPaypal').show();

            $('#mercado-pago-container').hide();
            $('#noMercadoPago').show();
        </script>";
    }

@endphp

<script>
    function validarDatosEnvio(){

        $('#paypal-button-container').hide();
        $('#noPaypal').show();

        $('#mercado-pago-container').hide();
        $('#noMercadoPago').show();

        if( $('#nombreenvio').val()=="" || $('#apellidosenvio').val()=="" || $('#paisenvio').val()=="" || $('#direccion1envio').val()==""
            || $('#localidadenvio').val()=="" || $('#regionenvio').val()=="" || $('#cpenvio').val()=="" || $('#telefonoenvio').val()=="" || $('#emailenvio').val()=="" ) {
            msg_warning('Faltan algunos datos de envío')
            return false;
        } else {

            if ( !ValidateEmail( $('#emailenvio').val() ) ) {
                msg_warning('El correo electrónico es inválido')
                return false;
            }

            if ( !ValidateCP( $('#cpenvio').val() ) ) {
                msg_warning('El Código Postal es inválido');
                return false;
            }

            if ( !ValidatePhone( $('#telefonoenvio').val() ) ) {
                msg_warning('El Teléfono/celular es inválido');
                return false;
            }

            var form = $('#form-envios')[0];
            var fileform = new FormData(form);
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                url: "{{ route('datos-envio') }}",
                data: fileform,
                type: 'POST',   
                dataType:'json',
                success: function(resp) {

                    console.log(resp);   
                    
                    if ( resp['ok'] ) {
                        $("#id_envio").val(resp['id']);
            
                        $('#paypal-button-container').show();
                        $('#noPaypal').hide();

                        $('#mercado-pago-container').show();
                        $('#noMercadoPago').hide();

                        $('#modalenvio').modal('hide');
                    } else {
                        msg_error("Hemos tenido problemas al registar su dirección de envío")
                    }
                    
                },
                error:  function (response) { 
                    console.log( response );
                }
            });   
        }
    }

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){
            return true;
        } else {
            return false;
        }
    }

    function ValidateCP(cp) {
        if (/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/.test(cp)){
            return true;
        } else {
            return false;
        }
    }

    function ValidatePhone(phone) {
        if (/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(phone)){
            return true;
        } else {
            return false;
        }
    }

    function msg_error(mensaje) {
        Swal.fire({
            icon: 'error',
            title:'¡Error!',
            text: mensaje
        })
    }

    function msg_warning(mensaje) {
        Swal.fire({
            icon: 'warning',
            title:'¡Advertencia!',
            text: mensaje
        })
    }

    function msg_info(mensaje) {
        Swal.fire({
            icon: 'info',
            title:'Info.',
            text: mensaje
        })
    }

    var cajamonto = document.getElementById('cajamonto').value;

    window.paypal_sdk.Buttons({
        locale: {
            country: 'MX',
            lang: 'es'
        },
        style: {
            size: 'small',
            color:  'blue',
            shape:  'pill',
            label:  'pay',
            tagline: 'false',
            layout: 'horizontal',
            size: 'responsive'
        },
        createOrder: function(data, actions) {

            var id_envio = $('#id_envio').val();

            if ( id_envio != "" && id_envio != null ) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            "currency_code": "MXN",
                            value: cajamonto
                        }
                    }]
                });
            } else {
                msg_warning('Antes de realizar la compra debe llenar los datos de envío')
                return false;
            }
            
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                console.log( details )
                savePayPalData(details);
                //alert('Transaction completed by ' + details.payer.name.given_name);
            });
        }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
</script>

<script>
    function savePayPalData(data){
        
        var id_envio = $('#id_envio').val();

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "data": data,
                "id_envio": id_envio,
            },
            url: '/payWithPaypal',
            type:  'post',
            success:  function (response) {

                console.log("Response to save data Paypal: ") ; 
                console.log(response);

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title:'¡Pago exitoso!',
                        text: 'Hemos enviado un email con los detalles de su compra. Muchas gracias.'
                    }).then((result) => {
                        window.location.href = '/historial_pedidos';
                    })
                } else {
                    msg_error('Hubo un problema al guardar sus datos de compra')
                }
            },
            error:  function (response) {
                // window.open(JSON.stringify(response));
            }
        });

    }

</script>

@endsection