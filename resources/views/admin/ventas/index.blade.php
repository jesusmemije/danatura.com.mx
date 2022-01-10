@extends('admin.layout.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}" />
<style>
  .table tbody {
    color: #212529;
  }

  .breadcrumb {
    background: #f8f9fc;
    padding-top: 0% !important;
  }

  .card {
    border: 5px solid #fff;
  }

  .f-s-10 {
    font-size: 10px !important;
  }

  .f-s-12 {
    font-size: 12px !important;
  }

  .f-s-14 {
    font-size: 14px !important;
  }

  .badge-dark {
    background-color: #343a40 !important;
  }

</style>


<div class="col-md-12">

  <div class="card shadow">

    @section('pagina-actual','Listado de pedidos')
    @section('breadcumb')

    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0);">Pedidos</a></li>
      <li class="breadcrumb-item active">Listado</li>
    </ul>

    @endsection

    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable">
          <thead class="">
            <tr>
              <th>Folio</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Pago</th>
              <th>Creado</th>
              <th>Status</th>
              <th>Entrega</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>

          <tbody>

            @foreach($compra as $venta)

            @php

            if ($venta->status == 'paid') {
              $status = 'Pagado';
              $status = "<span class='badge badge-success'>$status</span>";
            } else {
              $status = "<span class='badge badge-danger'>$venta->status</span>";
            }

            @endphp

            <tr>
              <td>#00{{$venta->id}}</td>
              <td>{{$venta->name}}</td>
              <td>${{$venta->preciototal}}</td>
              <td><span class="badge badge-primary">{{$venta->method}}</span></td>
              <td class="f-s-12">{{$venta->created_at}}</td>
              <td>@php echo $status; @endphp</td>
              <td>
                  <a class="badge badge-dark" data-id_venta='{{$venta->id}}' data-estadoentregaventa='{{$venta->estado_entrega}}'
                    href="" data-toggle="modal" data-target="#detallesPedidoModal">
                    <i class="fa fa-edit"></i>
                    {{$venta->estado_entrega}}
                  </a>
              <td>
                <div class="row">
                  <div class="col-md-6 px-0 text-right">
                    <a class="btn btn-info btn-sm btn-circle" <?php foreach($datosdirection as $direccion) {
                      if($venta->id_datosenvio == $direccion->id){
                        $fullname=$direccion->nombre .' '. $direccion->apellidos;
                        $fulldireccion=$direccion->direccion1 .', '. $direccion->localidad .', '. $direccion->region .', '. $direccion->cp;
                      ?>
                        data-email='{{$direccion->email}}' data-telefono='{{$direccion->telefono}}'
                        data-nombre='{{$fullname}}' data-direccion='{{$fulldireccion}}'
                      <?php
                      }
                    }
                    ?>
                      href="" data-toggle="modal" data-target="#detallesModal">
                      <i class="fas fa-street-view"></i>
                    </a>
                  </div>

                  <div class="col-md-6 px-0 text-left">
                    <a class='btn btn-warning btn-sm btn-circle ie' data-toggle="modal"
                      data-target="#verProductos-{{$venta->id}}">
                      <i class='fa fa-eye'></i>
                    </a>
                  </div>

                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="detallesPedidoModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="contenidomodal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Actualizar estatus de entrega</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('cambiarEstadoEntrega')}}">
          @csrf
          <input type="hidden" name="id_venta" id="id_venta">
          <div class="col-md-10 offset-md-1">
            <label for="">Estado de entrega:</label>
            <select required name="estado_entrega" id="estadoentregaventa" class="form-control">
              <option value="">Seleccione uno</option>
              <option value="pendiente">Pendiente</option>
              <option value="entregado">Entregado</option>
              <option value="cancelado">Cancelado</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
          <i class="fas fa-times fa-sm text-white-50"></i>
          Cerrar
        </button>
        <button type="submit" class="btn btn-sm btn-primary shadow-sm">
          <i class="fas fa-save fa-sm text-white-50"></i>
          Actualizar
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>

<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="contenidomodal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Detalles de envío</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="" style="font-size: 20px;">Persona quien recibe</label>
        <p id="nombremodal"></p>
        <label for="" style="font-size: 20px;">Direccion completa</label>
        <p id="direccionmodal"></p>
        <label for="" style="font-size: 20px;">Telefono</label>
        <p id="telefonomodal"></p>
        <label for="" style="font-size: 20px;">Correo electronico</label>
        <p id="emailmodal"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
          <i class="fas fa-times fa-sm text-white-50"></i>
          Hecho
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="contenidomodal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Seguro que desea eliminar la venta <strong><span class="name-user"></span></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
          <i class="fas fa-times fa-sm text-white-50"></i>
          No, salir
        </button>
        <form id="formDelete" action="{{ route('pedidos.destroy', 0) }}" data-action="{{ route('pedidos.destroy', 0) }}"
          method="POST">
          @method('DELETE')
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

<div class="modal fade" id="ModalAlert" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="contenidomodal" class="modal-content bg-red">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Alerta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="" style="font-size: 30px;">Por el momento esta función no esta disponible.</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
          <i class="fas fa-times fa-sm text-white-50"></i>
          Cerrar
        </button>
      </div>
    </div>
  </div>

</div>

@foreach ($compra as $registros)
<!-- Modal -->
<div class="modal fade" id="verProductos-{{$registros->id}}" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 560px; width: 950px;">
      <div class="modal-header text-center">
        <h5 class="modal-title" id="exampleModalLongTitle">Folio #00{{$registros->id}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background: #fafafa;">
        <div class="col-md-12">
          @if (!empty($compra_item))
          <table class="table js-basic-example dataTable">
            <thead>
              <tr>
                <th></th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            <?php
                foreach ($compra_item as $item){
                  if($item->compra_id == $registros->id){
            ?>
                <tr>
                  <td><img height="30" src="{{asset('assets/icons/Carrito.png')}}"></td>
                  <td>{{$item->nombre}}</td>
                  <td>{{$item->cantidad}} pzas.</td>
                  <td>${{$item->precio}} MXN</td>
                  <td>${{$item->total}} MXN</td>
                </tr>
            <?php
                }
              }
            ?>
            </tbody>
          </table>
          @else
          <p>No hay registro en la base de datos</p>
          @endif
        </div><br>
        <div>Precio de envío: $170 MXN</div>
        <h5>Total de la compra: <strong>${{ $registros->preciototal }} MXN</strong></h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection
@section('scripts')

<!-- Page level plugins -->
<script src="{{asset('admin_assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('admin_assets/js/demo/datatables-demo.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script>

$('#deleteUserModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var control = button.data('control')
      
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

$('#detallesModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var control = button.data('control')

  var id = button.data('id') // Extract info from data-* attributes
  var name = button.data('nombre')
  var direccion = button.data('direccion')
  var telefono = button.data('telefono')

  $('#nombremodal').text(name);
  $('#direccionmodal').text(direccion);
  $('#telefonomodal').text(telefono);
  $('#emailmodal').text(button.data('email'));
})

$('#detallesPedidoModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
    
  $('#id_venta').val( button.data('id_venta'));
  $('#estadoentregaventa').val( button.data('estadoentregaventa'));
     
})


</script>

@endsection