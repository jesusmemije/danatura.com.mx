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

@include('front.layout.partials.secundario')
<div class="container pt-4 pb-4">
    <div class="row clearfix">
        <div class="col-lg-12 card-header">

            <?php
            session_start();

            if (isset($_SESSION['carrito'])) {

                $productos = DB::table('productos')->select('id', 'nombre', 'sabor','descripcion', 'gramos','precio','fotografia','galeria')->get();

                $carrito = $_SESSION['carrito'];

                foreach ($carrito as $key=>$value) {
                   // $aux_cantidad_total=$aux_cantidad_total+
                }

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
                                <th>Nombre o producto</th>
                                <th data-breakpoints="sm xs">Descripción</th>
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
                                   
                                    if ($producto->id == $key['cursoID']) {
                                        // echo $curso->imgCurso;
                                        // echo $curso->nombreCurso;
                                        // $cadena = "https://escueladeimagenymaquillaje.com/cursos_online/public/asset/img/inicio/" . $curso->imgCurso;
                                        // echo $cadena;   
                                        $fotografia=$producto->fotografia;
                                        $source="assets/productos/".$fotografia;
                                        $source=$fotografia;
                        
                                        if ($fotografia=="") {
                                            $source=asset("assets/productos/goldenmilk.png");
                                        }
                                
                                        if (strpos($source, 'https') !== false) {
                                            $source=$source;
                                        } else {
                                            $source=asset("assets/productos")."/".$fotografia;
                                        }

                                        $array_galeria=explode('|',$producto->galeria);
        
                                        $foto_principal=$array_galeria[0];
                                        ?>

                                        <tr>
                                            <td><img src="<?php echo $foto_principal;  ?>" width="48" alt="Product img"></td>
                                            <td>
                                                <h5><?php echo $producto->nombre; ?></h5>
                                            </td>
                                            <td><span class="text-muted"><?php echo $producto->descripcion;  ?></span></td>
                                            <td id="<?php echo $producto->id ?>"><?php echo $producto->precio;  ?></td>
                                            <td><?php echo $carrito[$i]['cantidad'];  ?></td>
                                            <td>
                                                <?php  $totalPagar = $carrito[$i]['cantidad'] * $producto->precio+ $totalPagar;
                                                echo $carrito[$i]['cantidad'] * $producto->precio;  ?></td>
                                            <td>
                                                <!--  <a href="javascript:void(0);" class="btn btn-warning waves-effect waves-float btn-sm waves-green"><i class="fas fa-pencil-alt"></i></a> -->
                                                <a onclick="remove('{{$producto->id}}')"
                                                class="btn btn-danger waves-effect waves-float btn-sm waves-red"><i class="fas fa-trash-alt"></i></a>
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
            <div class="card pt-3">
                <div class="body">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            @php
                                if (strpos($totalPagar, '.') !== false) {
                                    $totalPagar=$totalPagar;
                                } else {
                                    $totalPagar=$totalPagar.".00";
                                }
                            @endphp

                            <div class="col-md-3"><b>Total de productos: </b><?php echo sizeof($carrito); ?></div>
                            <div class="col-md-3"><b>Total pago: </b>$<label
                                    id="totalPagar"><?php echo $totalPagar . " MXN"; ?></label></div>

                            <div class="col-md-3">
                                <?php $_SESSION['totalpagar']=$totalPagar;   ?>
                                <a href="{{route('checkout')}}" class="btn btn-success"> Pagar ahora <i
                                        style="color:white" class="fas fa-credit-card"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<span id="resultado"  onclick="ver()">Ver carrito</span>   -->

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
            }, //datos que se envian a traves de ajax
            url: 'actualizarModulos', //archivo que recibe la peticion
            type: 'post', //método de envio

            success: function(response) { 
                //una vez que el archivo recibe el request lo procesa y lo devuelve
                // window.location="{{ url('contenido-carrito') }}"; 
                // $("#resultado").html("Carrito: " + response);
                // alert(response);
            },
            error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

                window.open(JSON.stringify(response));
            }
        });
    }

    function ver() {

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "remove": "remove"
            }, //datos que se envian a traves de ajax
            url: 'vercarrito', //archivo que recibe la peticion
            type: 'post', //método de envio

            success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                // window.location="{{ url('contenido-carrito') }}"; 
                $("#resultado").html("Carrito: " + response);
            },
            error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

                window.open(JSON.stringify(response));
            }
        });

    }

    function remove(remove) {

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "remove": remove
            }, //datos que se envian a traves de ajax
            url: 'procesa', //archivo que recibe la peticion
            type: 'post', //método de envio

            success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            
                window.location = "{{ route('carrito') }}";
                // $("#resultado").html("Carrito: "+response);

              //  alert(response);
            },
            error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                window.open(JSON.stringify(response));
            }
        });

    }
</script>

@endsection