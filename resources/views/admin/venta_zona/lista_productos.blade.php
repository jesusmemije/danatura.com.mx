@extends('admin.layout.app')



@section('page-title')

    Lista productos en la zona

@endsection



@section('content')



<div class="card shadow">

  <div class="card-header">

    @section('pagina-actual','Listado de prodcutos')

    @section('breadcumb')

    <ul class="breadcrumb">

      <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>

      {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Usuarios</a></li>

      <li class="breadcrumb-item active">Listado</li> --}}
      <li class="breadcrumb-item"><a href="{{route('venta_zonas')}}">Zonas</a></li>
        <li class=" breadcrumb-item active">Lista productos en zona</li>

    </ul>
    

    @endsection

  </div>
  
    <div class="card-body col-md-12">
        @if (\Session::has('success'))

            <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;"

                role="alert">

                <strong>Eliminado correctamente!</strong>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif
        <a class="btn btn-warning btn-sm" href=""  style="float: right" data-toggle="modal" data-target="#agregarProductoModal" data-id="0" data-name="{{$nombre_zona}}">
                    
            AGREGAR PRODUCTOS
        </a>
        {{-- <button class="btn btn-warning btn-sm" style="float: right">AGREGAR USUARIOS</button> --}}
        <h3> 
            <b>
                Venta de {{$nombre_zona}} 
            </b>
        </h3>
        <hr>
        <div class="">
    
        <table class="table table-bordered" id="dataTable">
    
            <thead>
    
            <tr>
    
                <th>#</th>
                <th>Producto</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Acciones</th>
    
            </tr>
    
            </thead>
    
            <tbody>
                @if (!empty($zonas_productos))
                    
                    @foreach ($zonas_productos as $zona_producto)
                        <tr>

                            <td>{{$zona_producto->id_zona_producto}}</td>
                            <td>{{$zona_producto->nombre_producto}}</td>
                            <td>
                                <small>
                                    {{$zona_producto->descripcion}}
                                </small>
                            </td>
                            <td>
                                <small>
                                    $ {{number_format($zona_producto->precio,2)}}
                                </small>
                            </td>
                            <td>
                                <center>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteZonaProductoModal" data-id="{{ $zona_producto->id_zona_producto}}" data-name="{{ $zona_producto->nombre_producto }}">
                    
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </center>
                            </td>
                        </tr>
                    
            
                    @endforeach
                @endif
            {{-- @if (!empty($usuarios))
                @foreach ($usuarios as $usuario)
                    <tr>

                        <td>{{$usuario->id}}</td>
                        <td>{{$usuario->name}}</td>
                        <td>
                            <center>
                                <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#deleteZonaModal" data-id="{{ $usuario->id}}" data-name="{{ $usuario->name }}">
                
                                    <i class="fa fa-trash"></i>
                                </a>
                            </center>
                        </td>
                    </tr>
                
        
                @endforeach
            @endif
     --}}
            </tbody>
    
        </table>
    
        </div>
    
    </div>
  </div>


</div>



<div class="modal fade" data-bs-backdrop="static" id="agregarProductoModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="ModalLabel"></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">
        <table class="table table-bordered" id="dataTable">
    
            <thead>
    
            <tr>
    
                <th>#</th>
                <th>Producto</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Acciones</th>
    
            </tr>
    
            </thead>
    
            <tbody>

            @if (!empty($productos))
                @foreach ($productos as $producto)
                    <tr>

                        <td>{{$producto->id}}</td>
                        <td>{{$producto->nombre}}</td>
                        <td>
                            <small>
                                {{$producto->descripcion}}</td>
                            </small>
                        <td>
                            <small>
                                
                                $ {{number_format($producto->precio,2)}}</td>
                            </small>
                        <td>
                            <center>
                                <button class="btn btn-success btn-sm" id="boton{{$producto->id}}" onclick="agregar_producto({{$id_zona}},{{$producto->id}})">
                
                                    Agregar
                                </button>
                            </center>
                        </td>
                    </tr>
                
        
                @endforeach
            @endif
            </tbody>
        </table>
    

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-sm btn-secondary shadow-sm" onclick="recargar()" data-dismiss="modal">

          

          Salir

        </button>

        <form id="formDelete" action="{{ route('zona_destroy', 0) }}" data-action="{{ route('zona_destroy', 0) }}"

          method="POST">

         
        </form>

      </div>

    </div>

  </div>

</div>

<div class="modal fade" id="deleteZonaProductoModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

    <div class="modal-dialog">
  
      <div class="modal-content">
  
        <div class="modal-header">
  
          <h5 class="modal-title" id="ModalLabel"></h5>
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  
            <span aria-hidden="true">&times;</span>
  
          </button>
  
        </div>
  
        <div class="modal-body">
  
          <p>¿Seguro que desea eliminar el producto <strong><span class="name"></span></strong>?</p>
  
        </div>
  
        <div class="modal-footer">
  
          <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
  
            <i class="fas fa-times fa-sm text-white-50"></i>
  
            No, salir
  
          </button>
  
          <form id="formDeleteProducto" action="{{ route('productos_zona_destroy', 0) }}" data-action="{{ route('productos_zona_destroy', 0) }}"
  
            method="POST">
  
            @method('POST')
  
            @csrf
  
            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
  
              <i class="fas fa-trash fa-sm text-white-50"></i>
  
              Si, eliminar
  
            </button>
  
          </form>
  
        </div>
  
      </div>
  
    </div>
  
</div>

@endsection



@section('scripts')

<!-- Page level plugins -->

<script src="{{asset('admin_assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->

<script src="{{asset('admin_assets/js/demo/datatables-demo.js')}}"></script>



<script>

  $('#agregarProductoModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget)

    var id = button.data('id')

    var name = button.data('name')

    action = $('#formDelete').attr('data-action').slice(0, -1)

    action += id

       

    console.log(id);

    $('#formDelete').attr('action', action)



    var modal = $(this)

    modal.find('.modal-title').text('Productos sin agregar a la zona venta de ' +name) 

    modal.find('.name-zona').text(name)

  })

function agregar_producto(id_zona_venta,id_producto){
    // console.log(id_zona_venta,id_usuario)
    let boton = document.getElementById("boton"+id_producto);

    
    $.ajax({
        data: {
            "_token": "{{ csrf_token() }}",
            "id_zona_venta": id_zona_venta,
            "id_producto": id_producto,
        },
        url: "{{route('productos_zona_store')}}",
        type:  'post',
        success:  function (response) {

            console.log("Response ya estamos esperando ") ;
            

            if (response.ok) {
                
                boton.textContent="Agregado";
                boton.style.backgroundColor= "gray";
                window.location.reload();
                // Swal.fire({
                //     icon: 'success',
                //     title:'¡Registro exitoso!',
                //     text: 'Usuario agregado.'
                // }).then((result) => {
                //     // window.location.href = '/historial_pedidos';
                // })
            } else {
                msg_error('Hubo un problema al agregar producto')
            }
        },
        error:  function (response) {
            // window.open(JSON.stringify(response));
        }
    });

}

function recargar(){
    window.location.reload()
}


$('#deleteZonaProductoModal').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget)

var id = button.data('id')

var name = button.data('name')



// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

action = $('#formDeleteProducto').attr('data-action').slice(0, -1)

action += id

   

console.log(id);

$('#formDeleteProducto').attr('action', action)



var modal = $(this)

modal.find('.modal-title').text('Confirmar eliminación') 

modal.find('.name').text(name)

})


</script>






@endsection