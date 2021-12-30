@extends('admin.layout.app')

@section('page-title')
    Listado de productos
@endsection

@section('styles')
<style>
  .card {
    border: 5px solid #fff;
  }
</style>
@endsection

@section('content')

<div class="col-md-12">
  <div class="card shadow">

    @section('pagina-actual', 'Listado de productos')

    @section('breadcumb')
    <ul class="breadcrumb">
      <li style="color:#F79860" class="breadcrumb-item">
        <a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a>
      </li>
      <li class="breadcrumb-item"><a href="javascript:void(0);">Productos</a></li>
      <li class="breadcrumb-item active">Listado</li>
    </ul>
    <a href="{{route('productos.create')}}" style="background:#F79860" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
      <i class="fas fa-plus fa-sm text-white-50"></i> Añadir nuevo
    </a>
    @endsection

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Sabor</th>
              <th>Descripcion</th>
              <th>Gramos</th>
              <th>Precio</th>
              <th>Fotografía</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Sabor</th>
              <th>Descripcion</th>
              <th>Gramos</th>
              <th>Precio</th>
              <th>Fotografía</th>
              <th>Acciones</th>
            </tr>
          </tfoot>
          <tbody>

            @foreach($productos as $producto)

            @php
            $foto = "";
            if (strpos($producto->fotografia, 'https') !== false) {
              $foto = $producto->fotografia;
            }else{
              $foto = "../assets/productos/".$producto->fotografia;
            }
            @endphp

            <tr>
              <td>{{$producto->nombre}}</td>
              <td>{{$producto->sabor}}</td>
              <td>{{$producto->descripcion}}</td>
              <td>{{$producto->gramos}}</td>
              <td>{{$producto->precio}}</td>
              <td>
                <center>
                  <a class='btn btn-success btn-sm  redondo ie' target="_blank" href="{{$foto}}">
                    <i class='fa fa-eye'></i>
                  </a>
                </center>
              </td>

              <td>
                <a class="btn btn-warning btn-sm redondo" href="{{route('productos.edit',$producto->id)}}">
                  <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-sm btn-danger btn-circle shadow-sm redondo" data-toggle="modal"
                  data-target="#deleteUserModal" data-id="{{ $producto->id}}" data-name="{{ $producto->nombre }}">
                  <i class="fas fa-trash fa-sm text-white-50"></i>
                </button>
              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Seguro que desea eliminar el producto <strong><span class="name-user"></span></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn  btn-secondary shadow-sm" data-dismiss="modal">
            <i class="fas fa-times fa-sm text-white-50"></i>
            No, salir
          </button>
          <form id="formDelete" action="{{ route('productos.destroy', 0) }}"
            data-action="{{ route('productos.destroy', 0) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn  btn-danger shadow-sm">
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
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('nombre')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        action = $('#formDelete').attr('data-action').slice(0, -1)
        action += id
        console.log(action)

        $('#formDelete').attr('action', action)

        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name)
      })
  </script>

  @endsection