@extends('front.layout.app')

@section('title')
    Checkout
@endsection

@section('styles')
    <style>
        sup {
            color: red;
        }

        #pagopaypal {
            margin: 10px 80px;
        }

        .text-center-items {
            text-align: unset;
        }

        @media screen and (max-width: 480px) {
            #pagopaypal {
                margin: 0;
            }
            .text-center-items {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')

<?php
    session_start();

    if(!(isset($_SESSION['carrito'])) || !(isset($_SESSION['totalpagar'])) || sizeof($_SESSION['carrito'])==0){
        header("/");
        die();
    }
 
?>

@include('front.layout.partials.menu')

<div class="container pt-4 pb-4">
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
            <p>Cantidad total de productos: {{$cantidad_carrito}} </p>
            <p>Monto total: ${{($_SESSION['totalpagar'])}} MXN</p>

            <input id="cajamonto" type="hidden" value="{{($_SESSION['totalpagar'])}}">
            <p style="font-weight: bold;">Detalles:</p>
            <table class="table table-hover product_item_list  mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="phone-hide" data-breakpoints="sm xs">Descripción</th>
                        <th data-breakpoints="xs">Precio</th>
                        <th data-breakpoints="xs">Cantidad</th>
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
                                        <h6><?php echo $producto->nombre; ?></h6>
                                    </td>
                                    <td class="phone-hide"><span class="text-muted"><?php echo $producto->descripcion;  ?></span></td>
                                    <td id="<?php echo $producto->id ?>"><?php echo $producto->precio;  ?></td>
                                    <td><?php echo $key['cantidad'];  ?></td>
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
            <form action="{{ route('payment') }}" method="POST" id="payment-form" name="form">

                <!-- datos de facturacion/ envio de producto -->
                <input hidden type="text" id="inp-envios">
                <input type="hidden" id="metodo-pago" name="metodopago">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <input type="hidden" name="tipo" value="1">
                <input type="hidden" name="paquete" id="paquete" value="0">
                <!--Input for Token-->
                <input type="hidden" name="token_id" id="token_id">
                <!-- Datos de la suscripción-->
                <!--<input type="hidden" name="idplan" value="">-->

                <!-- Datos del cliente -->

                <!-- Datos de la tarjeta-->
                <!-- <div id="pagotarjeta">
                    Método de pago<br>

                    <div class="form-row col-md-12">
                        <div class="form-group" style="margin-right:10px;"><strong class="txtrojo">Tarjeta de Crédito /
                                Débito</strong></div>
                        <div class="form-group" style="margin-right:10px;"><strong class="txtgrisc"
                                onClick="document.getElementById('pagotarjeta').style.display='none'; document.getElementById('pagopaynet').style.display='block';"
                                style="cursor:pointer">Efectivo en Oxxo</strong></div>
                        <div class="form-group" style="margin-left:10px;" onclick="validarDatosEnvio()"><strong
                                class="txtgrisc"
                                onClick="document.getElementById('pagotarjeta').style.display='none'; document.getElementById('pagopaynet').style.display='none'; document.getElementById('pagopaypal').style.display='block';"
                                style="cursor:pointer">PayPal</strong><br></div>
                    </div>

                    <br>
                    Nombre del Tarjetahabiente
                    <br>
                    <input type="text" class="form-control" name="nombretarjeta" class="w3-input" maxlength="50"
                        data-conekta="card[name]" autocomplete="off" required><br>

                    Número de Tarjeta
                    <br>
                    <input type="text" class="form-control" name="numtarjeta" class="w3-input" pattern="[0-9]+"
                        maxlength="16" minlength="16" data-conekta="card[number]" onkeypress="return numeros(event)"
                        required><br>

                    <div class="w3-row" style="width: 100%">
                        <div class="w3-col" style="width:68%;">
                            Fecha de Vencimiento
                            <br>
                            <select class="form-control" name="mes" class="w3-input"
                                style="width:46%; float:left; margin-right:4%" data-conekta="card[exp_month]" required>
                                <option disabled selected>[Mes]</option>
                                <?php
                                    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                                    for ($i = 1; $i <= sizeof($meses); $i++) { ?>
                                <?php if ($i <= 9) : ?>
                                <option value="<?php echo "0" . $i ?>"><?php echo "0" . $i . " - " . $meses[$i - 1] ?>
                                </option>
                                <?php else : ?>
                                <option value="<?php echo $i ?>"><?php echo $i . " - " . $meses[$i - 1] ?></option>
                                <?php endif ?>

                                <?php } ?>
                            </select>

                            <select class="form-control" name="anio" class="w3-input"
                                style="width:46%; float:left; margin-right:4%" data-conekta="card[exp_year]" required>
                                <option disabled selected>[Año]</option>

                                <?php for ($i = 19; $i <= 30; $i++) { ?>
                                <option value="<?php echo $i ?>"><?php echo $i . " - " . "20" . $i ?></option>
                                <?php } ?>

                            </select></div><br><br>
                        <p>CVV</p>
                        <div class="row col-lg-12 col-xs-4" id="borde">

                            <input class="form-control col-lg-4 col-4" type="text" name="CVV" class="w3-input"
                                pattern="[0-9]+" maxlength="4" minlength="3" placeholder="CVV" data-conekta="card[cvc]"
                                onkeypress="return numeros(event)" required>
                            <img style="margin-left:2%;" src="{{asset('assets/images/cvv.png')}}" alt="">

                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="conekta col-xl-6">
                            <label>Transacciones realizadas vía:</label>
                            <img style="height:40px" src="{{asset('assets/images/conekta.png')}}" alt="">
                        </div>
                        <div class="secure col-xl-6">
                            Tus pagos se realizan de forma segura con encriptación de 256 bits
                            <img style="height:40px" src="{{asset('assets/images/security.png')}}" alt="">
                        </div>
                    </div>

                    <br><button class="btn btn-danger" style="margin-left:25%;" id="pay-button"> &nbsp; &nbsp; Pagar
                        productos &nbsp; &nbsp; </button><br><br>
                </div> -->
            </form>

            <!-- <div id="pagopaynet" style="display:none; padding-bottom:4em">
                <label style="margin-left:35%;"> Método de pago </label><br>
                <div class="form-row col-md-12">
                    <div class="form-group" style="margin-right:10%;">
                        <strong style="cursor:pointer;" class="txtrojo" onClick="document.getElementById('pagotarjeta').style.display='block'; document.getElementById('pagopaynet').style.display='none'; document.getElementById('pagopaypal').style.display='none';" ">Tarjeta de Crédito / Débito</strong></div>
                    <div class=" form-group" style="margin-right:10px;">
                        <strong class="txtgrisc" style="cursor:pointer">Efectivo en Oxxo</strong>
                    </div>
                    <div class="form-group" style="margin-left:10px;" onclick="validarDatosEnvio()">
                        <strong class="txtgrisc" onClick="document.getElementById('pagotarjeta').style.display='none'; document.getElementById('pagopaynet').style.display='none'; document.getElementById('pagopaypal').style.display='block';" style="cursor:pointer">PayPal</strong><br>
                    </div>
                </div>

                <br><br>

                <div class="w3-row" style="text-align:center">
                    <img src="https://escueladeimagenymaquillaje.com/cursos_online/public/asset/img/oxxopay.png" style="width:250px;" class="imgmax"><br><br>
                    Paga en efectivo en tu Oxxo más cercano
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <input type="hidden" name="tipo" value="2">
                <input type="hidden" name="paquete" id="paquetep" value="0">

                <br>
                <div class="w3-row" style="text-align:center">
                    <input id="pay-oxxo" class="w3-btn frojo" type="submit" value=" &nbsp; &nbsp; Generar Referencia &nbsp; &nbsp;">
                </div>
                <br>
            </div> -->

            </form>

            <div id="pagopaypal" class="text-center mt-md-0 mt-5" style="padding-bottom:4em;">

                <label class="font-weight-bold h5"> Método de pago </label><br>

                <div class="form-row col-md-12">
                    <!-- <div class="form-group" style="margin-right:10%;">
                        <strong style="cursor:pointer;" class="txtrojo" onClick="document.getElementById('pagotarjeta').style.display='block'; document.getElementById('pagopaynet').style.display='none'; document.getElementById('pagopaypal').style.display='none';" ">Tarjeta de Crédito / Débito</strong>
                    </div>
                    <div class=" form-group" style="margin-right:10px;">
                        <strong class="txtgrisc" onClick="document.getElementById('pagotarjeta').style.display='none'; document.getElementById('pagopaynet').style.display='block'; document.getElementById('pagopaypal').style.display='none';" style="cursor:pointer">Efectivo en Oxxo</strong>
                    </div>
                    <div class="form-group" style="margin-left:10%;" onclick="validarDatosEnvio()">
                        <strong class="txtgrisc" onClick="document.getElementById('pagotarjeta').style.display='none'; document.getElementById('pagopaynet').style.display='none'; document.getElementById('pagopaypal').style.display='block';" style="cursor:pointer">PayPal</strong>
                    </div> -->
                </div>

                <div style="margin-top: 10%;" id="paypal-button-container"></div>
                <div style="margin-top: 30%;"><input type="hidden"></div>

                <span id="nopaypal" class="badge badge-danger">Debe escribir sus datos de envio para poder continuar</span>

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
                                <input required id="nombreenvio" name="nombre" type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col">
                            <label for="">Apellidos (Requerido)<sup>*</sup></label>
                            <input required id="apellidosenvio" type="text" name="apellidos" class="form-control" placeholder="">
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
                    <input id="rfcenvio" type="text" class="form-control" name="rfc" placeholder="*En caso de requerir factura">

                    <label for="">Referencia (Opcional)</label>
                    <input id="referenciaenvio" type="text" class="form-control" name="referencia" placeholder="Referencia del lugar de envío del paquete">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button onclick="validarDatosEnvio()" type="button" class="btn btn-primary">Listo</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script src="https://www.paypal.com/sdk/js?currency=MXN&client-id=AXIhxntAlr0Af7BvaMN6ypVNRqE7wpOh6tFXwVpk6uayEM1cuC4Jl0k2wGlFrNVKZBmV2yyFem4STVCQ"></script>

<script type="text/javascript">
    var formvalidado=false;

    $(document).ready(function() {
        // Conekta.setPublicKey('')
        //producción
        Conekta.setPublicKey('key_WtpsP5Uyz7QmMXCZxqzp8Ng');
                        
        Conekta.setLanguage("es");

        //jQuery para que genere el token después de dar click en submit
        $('#pay-button').on('click', function(event) {

            event.preventDefault();

            if(formvalidado){
                $("#pay-button").prop("disabled", true);
                var $form = $("#payment-form");
                $('#metodo-pago').val("card");
                // Previene hacer submit más de una vez
                //$form.find("button").prop("disabled", true);
                Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
            } else {
                alert("No ha escrito sus datos de envío y/o facturación");
            }
        });

        var conektaSuccessResponseHandler = function(token) {
            //var $form = $("#payment-form");
            //Inserta el token_id en la forma para que se envíe al servidor
            //$form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
            $('#token_id').val(token.id);
            $('#payment-form').submit(); //Hace submit
        };

        var conektaErrorResponseHandler = function(response) {
            //var $form = $("#payment-form");
            //$form.find(".card-errors").text(response.message_to_purchaser);
            //alert("ERROR [" + response.message_to_purchaser + "] ");
            Swal.fire({
                icon: 'error',
                title: 'Conekta dice...',
                text: response.message_to_purchaser
            })
            //$form.find("button").prop("disabled", false);
            $("#pay-button").prop("disabled", false);
        };

    });
</script>

<script>
    function enviarData(datos){
        console.log(datos[0]);
        $('#dato_id').val(datos[0].id_datosenvio);
        $('#nombreenvio').val(datos[0].nombre);
        $('#apellidosenvio').val(datos[0].apellidos);
        $('#empresaenvio').val(datos[0].empresa);
        $('#paisenvio').val(datos[0].pais);
        $('#direccion1envio').val(datos[0].direccion1);
        $('#direccion2nvio').val(datos[0].direccion2);
        $('#localidadenvio').val(datos[0].localidad);
        $('#regionenvio').val(datos[0].region);
        $('#cpenvio').val(datos[0].cp);
        $('#telefonoenvio').val(datos[0].telefono)
        $('#emailenvio').val(datos[0].email)
        $('#rfcenvio').val(datos[0].rfc)
        $('#referenciaenvio').val(datos[0].referencia)
    }    
</script>

@php
    $envio_user = DB::table('venta_productos')
    ->join('datos_envios','venta_productos.id_datosenvio','=','datos_envios.id')
    ->where('venta_productos.id_user','=', Auth::user()->id)->get();

    if( count($envio_user) >= 1 ){
        echo "<script>
            enviarData($envio_user); 
        </script>";
    }

@endphp

<script>
    function validarDatosEnvio(){

        if(antesdePagar()){
        
            formvalidado=true;
            $('#nopaypal').hide();

            $('#paypal-button-container').show();

            $('#modalenvio').modal('hide');
        } else {
            alert("Debe escribir los datos requeridos");
            $('#paypal-button-container').hide();
            $('#nopaypal').show();
        }

    }

    function antesdePagar(){

        if( $('#nombreenvio').val()=="" || $('#apellidosenvio').val()=="" || $('#paisenvio').val()=="" || $('#direccion1envio').val()==""
            || $('#localidadenvio').val()=="" || $('#regionenvio').val()=="" || $('#cpenvio').val()=="" || $('#telefonoenvio').val()=="" || $('#emailenvio').val()=="" ) {
            return false;
        } else {
            var form = $('#form-envios')[0];
            var fileform = new FormData(form); // <-- 'this' is your form element
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

                    console.log(resp) ;    
                    $("#inp-envios").val(resp['id']);
                                
                    // $("#resultado").html("Carrito: "+response);
                },
                error:  function (response) { 
                    console.log( response );
                    // window.open(JSON.stringify(response));
                }
            });
            
            return true;
        }
    }

    var cajamonto = document.getElementById('cajamonto').value;

    paypal.Buttons({
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

            if ( !antesdePagar() ) {
                Swal.fire({
                    icon: 'warning',
                    title:'Info',
                    text: 'Antes de realizar la compra debe llenar los datos de envío'
                })
                return false;
            }

            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: cajamonto
                    }
                }]
            });
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
    
    function alerta(mensaje){
        Swal.fire({
            icon: 'error',
            title: 'Hay un error en su compra...',
            text: mensaje
        })
    }
                                        
    function showSelected(valorF){
        var cod = document.getElementById("msi").value;
             
        switch( cod ){
            case '0':
                if(valorF<300){
                    alerta("El pago minímo es de 300 MXN para 3 meses sin intereses ")
                }
                break;
            case '1': 
                if( valorF < 600 ){
                    alerta("El pago minímo es de 600 MXN para 6 meses sin intereses ")
                }
                break;
            case '2':
                if(valorF<900){
                    alerta("El pago minímo es de 900 MXN para 9 meses sin intereses ")
                }
                break;
            case '3':
                if(valorF<1200){
                    alerta("El pago minímo es de 1200 MXN para 12 meses sin intereses ")
                }
                break;    
        }
    }

    // var checkbox = document.getElementById('mic');
    $( document ).ready(function() {
        if ($('#mic').prop('checked') ) {
            var el=document.getElementById('dmsi');
            el.style.display='block';
        }
    });
         
    //checkbox.addEventListener("change", validaCheckbox, false);
    function validaCheckbox(){
        var checked = checkbox.checked;
        if(!checked){
        
            var el=document.getElementById('dmsi');
            el.style.display='none';

        }
    }

    function savePayPalData(data){
        
        var id_envio = $('#inp-envios').val();

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "data": data,
                "id_envio": id_envio,
            },
            url: 'procesa-paypal',
            type:  'post',
            success:  function (response) {
                console.log( response );
                // $("#resultado").html("Carrito: "+response);
                Swal.fire({
                    icon: 'success',
                    title:'Transacción existosa',
                    text: 'Hemos enviado un email con los detalles de su compra. Muchas gracias.'
                }).then((result) => {
                    window.location.href = '/';
                })
            },
            error:  function (response) {
                // window.open(JSON.stringify(response));
            }
        });

    }

</script>

@endsection