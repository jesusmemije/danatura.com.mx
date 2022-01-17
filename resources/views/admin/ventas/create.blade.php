@extends('admin.layout.app')

@section('title-page')
Crear pedido manualmente
@endsection

@section('styles')
<style>
    .card {
        border: 5px solid #fff;
        background: #fff;
    }
</style>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card shadow">
        @section('pagina-actual','Nuevo pedido')
        @section('breadcumb')
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">
                <i class="zmdi zmdi-home"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{route('pedidos.index')}}">Pedidos</a></li>
            <li class=" breadcrumb-item active">Nuevo</li>
        </ul>
        @endsection
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Seleccionar cliente <button id="btn-add-user" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalRegisterUser"><i class="zmdi zmdi-plus"></i> Agregar</button> </label>
                            <p id="show-user-register" style="display: none"></p>
                            <select id="select-customer" name="cliente" class="form-control" required>
                                <option disabled selected>No ha seleccionado cliente</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name .' - '.$user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dirección de envío</label><br>
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalenvio">
                                Datos de envío
                            </a><br>
                            <span class="badge bg-warning text-dark">Seleccione el botón para escribir sus datos de envío.</span>
                        </div>
                    </div>
                </div>
                <hr>
                <form id="formAddProduct" method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Seleciona el producto</label>
                                <select id="select-product" name="product_id" class="form-control">
                                    <option disabled selected>No ha seleccionado producto</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->nombre.' de '.$product->gramos.' - $'.$product->precio . '.00'  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cantidad de productos</label>
                                <select id="select-quantity" name="quantity" class="form-control">
                                    <option disabled selected>No ha seleccionado cantidad</option>
                                    @for ($i = 1; $i <= 30; $i++)
                                    @if ( $i == 1 )
                                    <option value="{{ $i }}">{{ $i }} pieza</option>
                                    @else
                                    <option value="{{ $i }}">{{ $i }} piezas</option>
                                    @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Acción</label>
                                <button type="button" onclick="addProductOrder()" class="btn btn-primary">
                                    <i class="zmdi zmdi-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    @php session_start() @endphp
                    @if ( isset($_SESSION['carrito']) && !empty($_SESSION['carrito']) )
                    <div class="col-lg-12">
                        <div class="card mt-4 mb-2" style="border: unset">
                            <div class="table-responsive">
                                <table class="table table-hover product_item_list mb-0">
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
                                        $productos = DB::table('productos')->select('id', 'nombre', 'sabor','descripcion', 'gramos','precio','fotografia','galeria')->get();
                                        $carrito = $_SESSION['carrito'];
                                        $totalPagar = 0;
                                        $_SESSION['gastoEnvio'] = 0; // Los gastosEnvio serán de 0 para registros manuales
                                        $_SESSION['subtotal'] = 0;
                                          
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
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card pb-1" style="border: unset">
                            <div class="body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                        </div>
                                        @php
                                            if ( strpos($totalPagar, '.') !== false ) {
                                                $totalPagar = $totalPagar;
                                            } else {
                                                $totalPagar = $totalPagar . ".00";
                                            }
                                            $_SESSION['subtotal']   = $totalPagar;
                                            $_SESSION['totalpagar'] = $totalPagar  + $_SESSION['gastoEnvio'];
                                        @endphp
                                        <div class="col-md-2"><b>Total de productos: </b><?php echo sizeof($carrito); ?></div>
                                        <div class="col-md-2"><b>Gastos de envio: </b>$<?php echo number_format($_SESSION['gastoEnvio'], 2, '.', ',') ?></div>
                                        <div class="col-md-2"><b>Total pago: </b><br>$<label id="totalPagar"><?php echo number_format($_SESSION['totalpagar'], 2, '.', ',') ?></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button type="button" onclick="saveOrder()" class="btn btn-success">Registrar pedido</button>
                            <a href="{{ route('pedidos.index') }}" class="btn btn-danger">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar User -->
<div id="modalRegisterUser" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form-register-user" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pb-5">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Nombre (requerido)<sup>*</sup></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Juan Pérez" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email">Email (requerido)<sup>*</sup></label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="mail@example.com" required>
                            </div>
                            <div class="col-md-12">
                                <label for="tipo">Tipo de usuario (requerido)<sup>*</sup></label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option selected disabled>Selecione un tipo</option>
                                    @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button onclick="registerCustomer()" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para los datos de envío -->
<div id="modalenvio" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="form-envios" method="post">
                @csrf
                <input type="hidden" id="dato_id" name="dato_id">
                <input type="hidden" id="id_user" name="id_user">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos de envío/facturación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pb-5">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Nombre (Requerido)<sup class="supred">*</sup></label>
                                <input required id="nombreenvio" name="nombre" type="text" class="form-control">
                            </div>
    
                            <div class="col-md-6">
                                <label for="">Apellidos (Requerido)<sup>*</sup></label>
                                <input required id="apellidosenvio" type="text" name="apellidos" class="form-control">
                            </div>
                        </div>
                            
                        <label for="">Empresa (Opcional)</label>
                        <input id="empresaenvio" type="text" class="form-control" name="empresa">

                        <label for="">País (Requerido)<sup>*</sup></sup></label>
                        <input id="paisenvio" type="text" class="form-control" name="pais">

                        <label for="">Dirección de la calley número (Requerido)<sup>*</sup></label>
                        <input id="direccion1envio" type="text" class="form-control" name="direccion1" placeholder="Dirección #1- número de la casa y nombre de la calle">
                        <br>
                        <input id="direccion2envio" type="text" class="form-control" name="direccion2" placeholder="Continuación de la dirección">

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
                    <button onclick="validarDatosEnvio()" type="button" class="btn btn-primary">Guardar</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    function registerCustomer() {

        var name  = $('#name').val();
        var email = $('#email').val();
        var tipo  = $('#tipo').val();

        if ( name == '' ) {
            msg_warning('El nombre es requerido')
            return false;
        }

        if ( email == '' ) {
            msg_warning('El E-mail es requerido')
            return false;
        } else {
            if ( !ValidateEmail( email ) ) {
                msg_warning('El correo electrónico es inválido')
                return false;
            }
        }

        if ( tipo == null ) {
            msg_warning('No ha selecionado el tipo de cliente')
            return false;
        }

        $.ajax({
            data: {
                "_token" : '{{ csrf_token() }}',
                "name"  : name,
                "email" : email,
                "tipo"  : tipo,
            },
            dataType: 'json',
            url: '/admin/pedidos/saveUserManually',
            type: 'POST',
            success:  function (data) {
                // Validate It´s ok.
                if ( data.ok ) {

                    limpiarDatosEnvio();

                    // Enviar id user (registrar datos envío y order)
                    $('#id_user').val(data.user_id)

                    // Enviar nombre registrado y mostrar div
                    $('#show-user-register').text(data.name)
                    $('#show-user-register').show()
                    
                    // Ocultar div select
                    $('#select-customer').hide()

                    Swal.fire({
                        title: '¡Bien!',
                        text: "Usuario registrado con éxito",
                        icon: 'success'
                    }).then((result) => {
                        $('#modalRegisterUser').modal('hide');
                    })
                } else {
                    msg_error(data.message)
                }    
            },
            error:  function (response) { 
                window.open(JSON.stringify(response));
            }
        });

    }

    function saveOrder() {

        var id_user = '';
        var id_envio = $("#dato_id").val();

        if ( $('#id_user').val() == '' ) {
            if ( $('#select-customer').val() == null ) {
                msg_warning('No ha selecionado al cliente')
                return false;
            } else {
                id_user = $('#select-customer').val();
            }
        } else {
            id_user = $('#id_user').val();
        }

        if ( id_envio == '' ) {
            msg_warning('Aún no tiene una dirección de envío')
            return false;
        }

        $.ajax({
            data: {
                "_token"   : "{{ csrf_token() }}",
                "id_user"  : id_user,
                "id_envio" : id_envio
            },
            dataType: 'json',
            url: '/admin/pedidos/saveOrderManually',
            type: 'POST',
            success:  function (data) {

                // Validate It´s ok.
                if (data.ok) {
                    Swal.fire({
                        title: '¡Bien!',
                        text: "Se ha registrado el pedido exitosamente",
                        icon: 'success'
                    }).then((result) => {
                        window.location.replace("/admin/pedidos");
                    })
                } else {
                    msg_error(data.message)
                }
                            
            },
            error:  function (response) { 
                window.open(JSON.stringify(response));
            }
        });

    }

    function addProductOrder(){

        if ( $('#select-product').val() == null) {
            msg_info('Debe seleccionar un producto')
            return false;
        }

        if ( $('#select-quantity').val() == null) {
            msg_info('Debe seleccionar la cantidad')
            return false;
        }

        var id = $("#select-product").val();
        var cantidad = $("#select-quantity").val();

        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "id" : id,
                "cantidad" : cantidad
            },
            url: '/procesa',
            type: 'POST',
            success:  function (response) {

                response = JSON.parse(response);
                
                if(response['operacion'] == "excede"){

                    msg_warning('La cantidad de productos supera el stock!')

                    if(response['cantidad'] <= 0){
                        $("#select-quantity").val(0);
                    } else {
                        $("#select-quantity").val(response["cantidad"]);
                    }
                }

                if(response['operacion'] == "zero"){
                    msg_warning('La cantidad de producto agregada no puede ser igual o menor a cero')
                }

                if(response['operacion'] == "doble"){
                    msg_warning('El producto ya se encuentra añadido al carrito')
                }

                if(response['operacion'] == "bien"){
                    location.reload();
                }
                            
            },
            error:  function (response) { 
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
            url: '/procesa',
            type: 'POST',
            success: function(response) {
                location.reload();
            },
            error: function(response) {
                window.open(JSON.stringify(response));
            }
        });
    }
</script>

<script>
    $('#select-customer').on('change', function() {
        var idcustomer = this.value;
        $('#id_user').val(idcustomer)
        $.ajax({
            url: '/admin/pedidos/get-direccion-customer',
            method: 'POST',
            dataType: 'json',
            data: {
                idcustomer : idcustomer,
                _token : $('input[name="_token"]').val()
            }
        }).then(function(data){

            data = data.datos_envio;
            
            if ( data != null) {
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
            } else {
                limpiarDatosEnvio();
            }
        })
    });

    function limpiarDatosEnvio() {
        $('#dato_id').val('');
        $('#nombreenvio').val('');
        $('#apellidosenvio').val('');
        $('#empresaenvio').val('');
        $('#paisenvio').val('');
        $('#direccion1envio').val('');
        $('#direccion2nvio').val('');
        $('#localidadenvio').val('');
        $('#regionenvio').val('');
        $('#cpenvio').val('');
        $('#telefonoenvio').val('')
        $('#emailenvio').val('')
        $('#rfcenvio').val('')
        $('#referenciaenvio').val('')
    }

    function validarDatosEnvio(){

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

            $.ajax({
                url: "{{ route('datos-envio') }}",
                data: fileform,
                type: 'POST',   
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {

                    if ( resp['ok'] ) {
                        $("#dato_id").val(resp['id']);
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

    function msg_success(mensaje) {
        Swal.fire({
            icon: 'success',
            title:'¡Bien!',
            text: mensaje
        })
    }
</script>

@endsection