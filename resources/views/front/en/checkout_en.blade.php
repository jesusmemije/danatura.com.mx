@extends('front.layout_en.app')

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

    p {
        margin-bottom: 0.5rem;
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

<!-- <div id="loading" class="text-center d-none" style="position: absolute; z-index: 3; margin-top: 25vh; margin-left: 68vh;">
    <div class="spinner-border"></div>
</div> -->

@include('front.layout_en.partials.menu')

@php
    // SDK de Mercado Pago
    require base_path('vendor/autoload.php');
    // Agrega credenciales
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    $shipments = new MercadoPago\Shipments();
    $shipments->cost = $_SESSION['gastoEnvio'];
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
        <a class="btn btn-light pull-right" href="{{route('carrito_en')}}">Cancel</a>
        <br>
    </div>
    <br>
    <hr>
    <div class="row clearfix">
        <div class="col-md-6 col-12 text-center-items">
            <?php
                $productos = DB::table('productos')->select('id', 'nombre', 'sabor','descripcion', 'gramos','precio','precio_mayorista','precio_nutriologo','fotografia')->get();

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

            <p class="text-center font-weight-bold h5 py-2" style="background:lightgreen;">Purchase detail</p>
            <br>
            <p class="font-weight-bold h5">Summary:</p>
            <p>Total number of products: {{$cantidad_carrito}} </p>
            <p>Shipping cost: <strong>${{ number_format($_SESSION['gastoEnvio'], 2, '.', ',') }}</strong></p>
            @isset($_SESSION['descuentoCupon'])
            <p>Discount: <strong>${{ number_format($_SESSION['descuentoCupon'], 2, '.', ',') }}</strong></p>
            @endisset
            <p>Total amount: <strong>${{ number_format($_SESSION['totalpagar'], 2, '.', ',') }}</strong></p>
            <p hidden>SubTotal: ${{ number_format($_SESSION['subtotal'], 2, '.', ',') }}</p>
            @if (!isset($_SESSION['descuentoCupon']))
            <form action="{{ route('applyCoupon') }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group mb-2">
                    <label for="codigo">Do you have a coupon? enter it</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="codigo" class="form-control" id="codigo" maxlength="20" onkeyup="mayusculas(this);" required>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Send</button>
            </form>
            @endif
            @if (session('success_cupon'))
                <div class="alert alert-success">
                    {{ session('success_cupon') }}
                </div>
            @endif
            @if (session('error_cupon'))
                <div class="alert alert-danger">
                    {{ session('error_cupon') }}
                </div>
            @endif
            <br>
            <br>
            <input id="cajamonto" type="hidden" value="{{($_SESSION['totalpagar'])}}">
            <p style="font-weight: bold;">Order details:</p>
            <table class="table table-hover product_item_list  mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="phone-hide" data-breakpoints="sm xs">Description</th>
                        <th data-breakpoints="xs">Quantity</th>
                        <th data-breakpoints="xs">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $producto) {

                        foreach ($carrito as $key) {

                            if ($producto->id == $key['producto_id']) {
                                $tipo_precio = 'normal';
                                $precio_usd = '';

                                if (auth()->user() != null) {

                                    $tipo = auth()->user()->tipo;
                                    $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

                                    $thetipo = $tipos->tipo;

                                    if ($thetipo == "Mayorista") {
                                        $tipo_precio = 'mayorista';
                                    }
                                    if ($thetipo == "Nutriologo") {
                                        $tipo_precio = 'nutriologo';
                                    }
                                }
                                //Para los precios.
                                if (strpos($producto->precio, '.') !== false) {
                                    $precio_usd = $producto->precio;
                                } else {
                                    $precio_usd = $producto->precio . ".00";
                                }

                                if ($tipo_precio == 'mayorista') {

                                    if (strpos($producto->precio_mayorista, '.') !== false) {
                                        $precio_usd = $producto->precio_mayorista;
                                    } else {
                                        $precio_usd = $producto->precio_mayorista . ".00";
                                    }

                                }

                                if ($tipo_precio == 'nutriologo') {
                                    if (strpos($producto->precio_nutriologo, '.') !== false) {
                                        $precio_usd = $producto->precio_nutriologo;
                                    } else {
                                        $precio_usd = $producto->precio_nutriologo . ".00";
                                    }

                                }

                                // Aqui es el final de precios

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
                                            <?php echo number_format($precio_usd, 2, '.', ',') ?>
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
                <button class="btn btn-success mb-4" data-toggle="modal" data-target="#modalenvio"> Data of
                    Shipping</button>
                <span class="badge bg-warning text-dark">Select the button to write your shipping details.</span>
            </div>
        </div>

        <div class="col-md-6 col-12 text-center-items">

            <div class="text-center">
                <label class="font-weight-bold h5"> Payment method </label><br>
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
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="mercadopago-tab" data-toggle="tab" href="#mercadopago" role="tab"
                            aria-controls="mercadopago" aria-selected="false">
                            <img src="/assets/icons/mercado-pago.png" width="80">
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="oxxopay-tab" data-toggle="tab" href="#oxxopay" role="tab"
                            aria-controls="mercadopago" aria-selected="false">
                            <img src="/assets/icons/oxxopay.png" width="80">
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Credit card / debit</h5>
                            </div>
                            <div class="form mt-3">
                                <form action="{{ route('payWithConektaEn') }}" method="POST" id="payment-form">
                                    <!-- Datos de envío -->
                                    <input type="hidden" id="id_envio" name="id_envio">
                                    <!--Input for Token-->
                                    <input type="hidden" id="token_id" name="token_id">

                                    <!-- Datos de la tarjeta-->
                                    <br>
                                    Cardholder Name
                                    <br>
                                    <input type="text" class="form-control" placeholder="Juan Pérez" class="w3-input"
                                        maxlength="50" data-conekta="card[name]" autocomplete="off" required><br>
                                    Card number
                                    <br>
                                    <input id="number_card" type="text" class="form-control"
                                        placeholder="0000 0000 0000 0000" class="w3-input" maxlength="16" minlength="16"
                                        data-conekta="card[number]" required>
                                    <div id="msg_number_card"></div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            Expiration date
                                            <br>
                                            <select class="form-control" class="w3-input"
                                                style="width:46%; float:left; margin-right:4%"
                                                data-conekta="card[exp_month]" required>
                                                <option disabled selected>[Month]</option>
                                                <?php
                                                $meses = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

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
                                                <option disabled selected>[Year]</option>

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
                                            <label>Transactions made via:</label>
                                            <img style="height:40px" src="{{asset('assets/images/conekta.png')}}"
                                                alt="">
                                        </div>
                                        <div class="secure col-xl-6">
                                            <br><br>
                                            Your payments are made securely with 256-bit encryption
                                            <img style="height:40px" src="{{asset('assets/images/security.png')}}"
                                                alt="">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-danger px-5" id="pay-button">
                                            Pay products
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Payment with paypal</h5>
                            </div>
                            <div class="my-4" id="paypal-button-container"></div>
                            <div class="text-center">
                                <span id="noPaypal" class="badge badge-danger">You must enter your shipping information to continue</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="mercadopago" role="tabpanel" aria-labelledby="mercadopago-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5>Payment with Market Payment</h5>
                                <div class="cho-container" id="mercado-pago-container"></div>
                                <div class="text-center">
                                    <span id="noMercadoPago" class="badge badge-danger">You must enter your shipping information to continue</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="oxxopay" role="tabpanel" aria-labelledby="oxxopay-tab">
                        <div class="mt-4 mx-4">
                            <div class="text-center">
                                <h5 class="my-0">Pay with OxxoPay</h5>
                                <button id="btnPayWithOxxoPay" class="btn btn-dark my-3">Generate Reference</button>
                                <!-- <div class="text-center">
                                    <span id="noOxxoPay" class="badge badge-danger">Debe escribir sus datos de envio para poder continuar</span>
                                </div> -->
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <br><br>
        </div>
    </div>
</div>

  <!-- Modal Reference oxxopay-->
  <div class="modal fade" id="modalReferenceOxxo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body p-0">
          @include('mails.reference-oxxopay')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok close</button>
        </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Shipping/billing data</h5>
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
                                <label for="">Name (Required)<sup class="supred">*</sup></label>
                                <input required id="nombreenvio" name="nombre" type="text" value="{{$nombre_envio}}" class="form-control"
                                    placeholder="">
                        </div>
                        <div class="col">
                            <label for="">last name (Required)<sup>*</sup></label>
                            <input required id="apellidosenvio" type="text" name="apellidos" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <label for="">Business (Optional)</label>
                    <input id="empresaenvio" type="text" class="form-control" name="empresa" placeholder="">

                    <label for="">Country (Required)<sup>*</sup></sup></label>
                    <input id="paisenvio" type="text" class="form-control" name="pais" placeholder="">

                    <label for="">Street address and number (Required)<sup>*</sup></label>
                    <input id="direccion1envio" type="text" class="form-control" name="direccion1"
                        placeholder="Dirección #1- número de la casa y nombre de la calle">
                    <br>
                    <input id="direccion2envio" type="text" class="form-control" name="direccion2"
                        placeholder="Continuación de la dirección">

                    <label for="">Town/City (Required)<sup>*</sup></label>
                    <input id="localidadenvio" type="text" class="form-control" name="localidad">

                    <label for="">Region/Province (Required)<sup>*</sup></label>
                    <input id="regionenvio" type="text" class="form-control" name="region">

                    <label for="">Zip Code (Required)<sup>*</sup></label>
                    <input id="cpenvio" maxlength="5" type="text" class="form-control" name="cp">

                    <label for="">Telephone / Cell (Required)<sup>*</sup></label>
                    <input id="telefonoenvio" type="text" class="form-control" name="telefono">

                    <label for="">Email (Required)<sup>*</sup></label>
                    <input id="emailenvio" type="text" class="form-control" value="{{$correo_envio}}" name="email" placeholder="">

                    <label for="">RFC (Optional)</label>
                    <input id="rfcenvio" type="text" class="form-control" name="rfc"
                        placeholder="*En caso de requerir factura">

                    <label for="">Reference (Optional)</label>
                    <input id="referenciaenvio" type="text" class="form-control" name="referencia"
                        placeholder="Referencia del lugar de envío del paquete">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="validarDatosEnvio()" type="button" class="btn btn-primary">Save</button>
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
<script src="https://www.paypal.com/sdk/js?currency=USD&client-id={{ env('PAYPAL_CLIENT_ID') }}" data-namespace="paypal_sdk"></script>
<!-- SDK MercadoPago.js V2 -->
<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    $(document).ready(function () {
        $("#btnPayWithOxxoPay").on( "click", function(event) {

            // Id de la dirección de envío
            var id_envio = $('#id_envio').val();

            if( id_envio == "" || id_envio == null ){
                msg_warning('Before making the purchase you must fill in the shipping information')
                return false;
            }

            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type  : 'POST',
                url   : '/payWithOxxoPay',
                data  : { id_envio : id_envio },
                success: function(response) {

                    if (response.ok) {
                        // Preparamos el modal con los datos
                        $('#modalReferenceOxxo').on('show.bs.modal', function (event) {
                            var modal = $(this)
                            modal.find('.modal-total').text(response.amount)
                            modal.find('.modal-reference').text(response.reference)
                        })
                        // Mostramos el modal (reference)
                        $('#modalReferenceOxxo').modal({
                            keyboard: false
                        })
                        // Evento que aparecerá depues de cerrar el modal
                        $('#modalReferenceOxxo').on('hidden.bs.modal', function (e) {
                            Swal.fire({
                                icon: 'success',
                                title:'Reference Sent!',
                                text: 'We have sent your reference to your email, we are waiting for your payment.'
                            }).then((result) => {
                                window.location.href = '/historial_pedidos_en';
                            })
                        })

                    } else {
                        msg_error(response.message)
                    }
                },
                error:  function (response) {
                    console.log( response );
                }
            });

        });
    });
</script>

<!-- Validate pago MercadoPago -->
@if (session()->has('statusPayMercadoPago'))
    @if ( session()->get('statusPayMercadoPago') == "success" )
        @php
            unset($_SESSION['carrito']);
            unset($_SESSION['gastoEnvio']);
            unset($_SESSION['descuentoCupon']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['totalpagar']);
        @endphp
        <script>
            Swal.fire({
                icon: 'success',
                title:'¡Successful payment!',
                text: 'We have sent an email with the details of your purchase. Thank you very much.'
            }).then((result) => {
                window.location.href = '/historial_pedidos_en';
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
        Conekta.setLanguage("en");

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
                msg_warning('Before making the purchase you must fill in the shipping information')
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
                            title:'¡Successful payment!',
                            text: 'We have sent an email with the details of your purchase. Thank you very much.'
                        }).then((result) => {
                            window.location.href = '/historial_pedidos_en';
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
                $("#msg_number_card").html("Only numbers are accepted").show().fadeOut("slow");
                return false;
            }
        });

        $("#number_cvv").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#msg_number_cvv").html("Only numbers are accepted").show().fadeOut("slow");
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
    // Funcion JavaScript para la conversion a mayusculas
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    }
    $("#codigo").keyup(function(){
        var ta  =  $("#codigo");
        letras  =  ta.val().replace(/ /g, "");
        ta.val(letras)
    });

    // Valida que solo se ingresen números en el CP
    $('#cpenvio').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    function validarDatosEnvio(){

        $('#paypal-button-container').hide();
        $('#noPaypal').show();

        $('#mercado-pago-container').hide();
        $('#noMercadoPago').show();

        if( $('#nombreenvio').val()=="" || $('#apellidosenvio').val()=="" || $('#paisenvio').val()=="" || $('#direccion1envio').val()==""
            || $('#localidadenvio').val()=="" || $('#regionenvio').val()=="" || $('#cpenvio').val()=="" || $('#telefonoenvio').val()=="" || $('#emailenvio').val()=="" ) {
            msg_warning('Some shipping data is missing')
            return false;
        } else {

            if ( !ValidateEmail( $('#emailenvio').val() ) ) {
                msg_warning('Email is invalid')
                return false;
            }

            if ( !ValidatePhone( $('#telefonoenvio').val() ) ) {
                msg_warning('Phone/cell phone is invalid');
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
                url: "{{ route('datos-envio_en') }}",
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
                        msg_error("We have had problems registering your shipping address")
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
            title:'Warning!',
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
            country: 'US',
            lang: 'en'
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
                            "currency_code": "USD",
                            value: cajamonto
                        }
                    }]
                });
            } else {
                msg_warning('Before making the purchase you must fill in the shipping information')
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
                        title:'¡Successful payment!',
                        text: 'We have sent an email with the details of your purchase. Thank you very much.'
                    }).then((result) => {
                        window.location.href = '/historial_pedidos_en';
                    })
                } else {
                    msg_error('There was a problem saving your purchase details')
                }
            },
            error:  function (response) {
                // window.open(JSON.stringify(response));
            }
        });

    }

</script>

@endsection
