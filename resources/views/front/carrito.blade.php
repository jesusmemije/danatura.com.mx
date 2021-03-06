@extends('front.layout.app')

@section('title')
    Productos del carrito
@endsection

@section('styles')
    <style>
        .seguir {
            color: white;
            background: #F79860 !important;
        }
    </style>
@endsection

@section('content')

@include('front.layout.partials.menu')
<div class="container pt-4 pb-4">
    <div class="row clearfix">
        <div class="col-lg-12 card-header">

            <?php
            session_start();

            // Reset cambios cupón
            if (isset($_SESSION['totalpagar']) && isset($_SESSION['descuentoCupon'])) {
                $_SESSION['totalpagar'] = $_SESSION['totalpagar'] + $_SESSION['descuentoCupon'];
                unset($_SESSION['descuentoCupon']);
            }

            if (isset($_SESSION['carrito'])) {

                $productos = DB::table('productos')->select('id', 'nombre', 'sabor','descripcion', 'gramos','precio','fotografia','galeria')->get();

                $carrito = $_SESSION['carrito'];

                foreach ($carrito as $key=>$value) {
                   // $aux_cantidad_total=$aux_cantidad_total+
                }
                $_SESSION['subtotal'] = 0;
                $totalPagar = 0;

            } else {
                return redirect()->to('/')->send();
            }

            ?>

            <div class="row">
                <div class="col-md-6">
                    <h3> <b><?php

                        if (sizeof($carrito) == 0) {
                            return redirect()->to('/')->send();
                        }

                        if (sizeof($carrito) > 1 || sizeof($carrito) == 0) {
                            echo sizeof($carrito) . " PRODUCTOS AL CARRITO";
                        } else {
                            echo sizeof($carrito) . " PRODUCTO AL CARRITO";
                        }

                        ?></b>
                    </h3>
                </div>

                <div class="col-md-6 d-flex justify-content-end">
                    <a class="btn btn-light seguir" href="{{route('productos')}}">Seguir comprando</a>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover product_item_list  mb-0">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th class="phone-hide" data-breakpoints="sm xs">Descripción</th>
                                <th data-breakpoints="xs">Precio</th>
                                <th data-breakpoints="xs">Cantidad</th>
                                <th data-breakpoints="xs">Total</th>
                                <th data-breakpoints="sm xs md">Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 0;

                            foreach ($productos as $producto) {

                                foreach ($carrito as $key) {

                                    if ($producto->id == $key['producto_id']) {

                                        $fotografia = $producto->fotografia;
                                        $source     = "assets/productos/".$fotografia;
                                        $source     = $fotografia;

                                        if ( $fotografia == "" ) {
                                            $source = asset("assets/productos/goldenmilk.png");
                                        }

                                        if ( strpos($source, 'https') !== false ) {
                                            $source = $source;
                                        } else {
                                            $source = asset("assets/productos")."/".$fotografia;
                                        }

                                        $array_galeria = explode('|',$producto->galeria);
                                        $foto_principal = $array_galeria[0];
                                        ?>

                                        <tr>
                                            <td><img src="<?php echo $foto_principal;  ?>" width="48" alt="Product img"></td>
                                            <td>
                                                <h5><?php echo $producto->nombre; ?></h5>
                                            </td>
                                            <td class="phone-hide"><span class="text-muted"><?php echo $producto->descripcion;  ?></span></td>
                                            <td id="<?php echo $producto->id ?>"><?php echo '$' . number_format($producto->precio, 2, '.', ',')  ?></td>
                                            <td><?php echo $key['cantidad'] ?></td>
                                            <td>
                                                <?php  $totalPagar = $key['cantidad'] * $producto->precio + $totalPagar;
                                                echo '$' . number_format($key['cantidad'] * $producto->precio, 2, '.', ',');  ?>
                                            </td>
                                            <td>
                                                <a onclick="remove('{{$producto->id}}')" class="btn btn-danger waves-effect waves-float btn-sm waves-red">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <?php

                                        $i++;
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card pt-3 pb-1">
                <div class="body">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            @php
                                // Cantidad previamente registrada para el descuento del envío
                                if($totalPagar > $rule->cantidad){
                                    $_SESSION['gastoEnvio'] = 0;
                                } else {
                                    $_SESSION['gastoEnvio'] = 170;
                                }
                                if ( strpos($totalPagar, '.') !== false ) {
                                    $totalPagar = $totalPagar;
                                } else {
                                    $totalPagar = $totalPagar . ".00";
                                }
                            @endphp
                            <div class="col-md-2"><b>Total de productos: </b><?php echo sizeof($carrito); ?></div>
                            <div class="col-md-2"><b>Gastos de envio: </b>$<?php echo number_format($_SESSION['gastoEnvio'], 2, '.', ',') ?></div>
                            <div class="col-md-2"><b>Total pago: </b><br>$<label id="totalPagar"><?php echo number_format($totalPagar + $_SESSION['gastoEnvio'], 2, '.', ',') ?></label></div>
                            <div class="col-md-2">
                                <?php $_SESSION['totalpagar'] = $totalPagar  + $_SESSION['gastoEnvio'];   ?>
                                <a href="{{route('checkout')}}" class="btn btn-success"> Pagar ahora
                                    <i style="color:white" class="fas fa-credit-card"></i>
                                </a>
                            </div>
                            <div hidden>
                                <b>
                                <?php echo $_SESSION['subtotal'] = $totalPagar ?>
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $("input[type=checkbox]").prop("checked", true);

    function cambio(idmodulo, costo, tdtotalcostocurso) {

        var x= document.getElementById(idmodulo).checked;

        var tp=$("#totalPagar").html();

        if (x){
            actualizarModulos(idmodulo,costo,"agregar");
            var final=$("#"+tdtotalcostocurso).html();

           final=parseInt(final,10)
           final=final+costo;

           $("#"+tdtotalcostocurso).html(final+".00");
           tp=parseInt(tp,10);
            tp=tp+costo;

           $("#totalPagar").html(tp+".00");

        } else {
            actualizarModulos(idmodulo,costo,"quitar");
            var final=$("#"+tdtotalcostocurso).html();
            final=final-costo;
            $("#"+tdtotalcostocurso).html(final+".00");

            tp=parseInt(tp,10);
            tp=tp-costo;
            $("#totalPagar").html(tp+".00");
        }

    }

    function actualizarModulos(idmodulo,costo,operacion){
       // alert(idmodulo);
        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "idmodulo": idmodulo,
                'costoModulo': costo,
                "operacion": operacion
            },
            url: 'actualizarModulos',
            type: 'post',

            success: function(response) {
                // window.location="{{ url('contenido-carrito') }}";
                // $("#resultado").html("Carrito: " + response);
                // alert(response);
            },
            error: function(response) {
                window.open(JSON.stringify(response));
            }
        });
    }

    function remove(remove) {

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "remove": remove
            },
            url: 'procesa',
            type: 'post',
            success: function(response) {
                window.location = "{{ route('carrito') }}";
                // $("#resultado").html("Carrito: "+response);
            },
            error: function(response) {
                window.open(JSON.stringify(response));
            }
        });

    }
</script>

@endsection
