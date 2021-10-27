@extends('admin.layout.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<style>

.table tbody{
        color:#212529;
    }
  
.breadcrumb{
    background: #f8f9fc;
    padding-top: 0% !important;
}
.card{
    border:5px solid #fff;
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


        
         
            <div class="card-body" >
            <div class="table-responsive" >
            <table class="table table-bordered table-hover" id="dataTable"  >
                                    <thead class="">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>T. usuario</th>
                                            <th>C. envio</th>
                                            <th>Subtotal</th>
                                            <th>P. total</th>
                                            <th>Estatus</th>
                                            <th>Método</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>

                                        @foreach($compra as $venta)

                                        @php 

                                        $trcolor="";
                                        
                                        if ($venta->status == 'paid') {
                                            $status = 'Pagado';
                                            $status = "<span class='badge badge-success'>$status</span>";
                                        } else {
                                            $status = "<span class='badge badge-danger'>$venta->status</span>";
                                        }

                                        switch($venta->estado_entrega){

                                          case "sin":
                                          $trcolor="";
                                          break;

                                          case "entregado":
                                          $trcolor="table-success";
                                          break;
                                          case "pendiente":
                                          $trcolor="table-warning";
                                          break;                                         
                                          case "cancelado":
                                          $trcolor="table-danger";
                                          break;
                                         

                                        }


                                        @endphp

                                            <tr class="{{$trcolor}}">
                                                <td>{{$venta->id}}</td>
                                                <td>{{$venta->name}}</td>
                                                <td>{{$venta->tipo}}</td>
                                                <td>{{$venta->costo_envio}}</td>
                                                <td>{{$venta->subtotal}}</td> 
                                                <td>{{$venta->preciototal}}</td>
                                                <td>@php echo $status; @endphp</td>
                                                <td>{{$venta->method}}</td>

                                                <td>
                                                    <div class="row">

                                                      <div class="col-md-1 mr-3">
                                                        <a class="btn btn-info btn-sm btn-circle"
                                                        <?php
                                                        foreach($datosdirection as $direccion) {
                                                          if($venta->id_datosenvio == $direccion->id){
                                                            $fullname=$direccion->nombre .' '. $direccion->apellidos;
                                                            $fulldireccion=$direccion->direccion1 .', '. $direccion->localidad  .', '. $direccion->region  .', '. $direccion->cp;
                                                        ?>
                                                         data-email='{{$direccion->email}}' data-telefono='{{$direccion->telefono}}'  data-nombre='{{$fullname}}' data-direccion='{{$fulldireccion}}'
                                                         <?php
                                                          }
                                                         }
                                                       ?>
                                                          href="" data-toggle="modal" data-target="#detallesModal">
                                                          <i class="fas fa-street-view"></i>
                                                        </a>
            
                                                    </div>

                                                      <div class="col-md-1 mr-3">
                                                        <a class="btn btn-success btn-sm btn-circle ie"
                                                        <?php
                                                          foreach($compra_item as $item) {
                                                            if($venta->id == $item->compra_id) {
                                                        ?>
                                                        data-id_venta='{{$venta->id}}'
                                                        data-estadopagoventa='{{$venta->status}}' data-metodoventa='{{$venta->method}}' data-estadoentregaventa='{{$venta->estado_entrega}}'
                                                        data-cargoventa='{{$venta->chargeid}}'
                                                        data-cantidadventa='{{$item->cantidad}}' data-precioventa='{{$venta->preciototal}}'
                                                           data-tipoventa='{{$venta->tipo}}' data-productoventa='{{$item->nombre}}'
                                                          data-nombre='{{$fullname}}'
                                                          <?php
                                                            }
                                                          }
                                                          ?>
                                                          href="" data-toggle="modal" data-target="#detallesPedidoModal">
                                                          <i class="fa fa-eye"></i>
                                                        </a>
            
                                                      </div>
                                                      <div class="col-md-1 mr-3">
                                                        <a class='btn btn-secondary btn-sm btn-circle ie' data-toggle="modal" data-target="#idModal-{{$venta->id}}">
                                                          <i class='fa fa-eye'></i>
                                                        </a>                                                        
                                                      </div>


                                                        <div class="col-md-1 mr-3">
                                                            {{-- <a class="btn btn-warning btn-sm btn-circle" href="{{route('pedidos.edit',$venta->idventa)}}">
                                                                <i class="fa fa-edit"></i>
                                                                </a> --}}
                                                              <button class="btn btn-warning btn-sm btn-circle" data-toggle="modal" data-target="#ModalAlert">
                                                                <i class="fa fa-edit"></i>
                                                              
                                                              </button> 
                                                        </div>

                                                         <div class="col-md-1 mr-3">
                                                          <button class="btn btn-sm btn-danger btn-circle shadow-sm" data-toggle="modal" data-target="#ModalAlert">
                                                                <i class="fas fa-trash fa-sm text-white-50"></i>
                                                              </button> 
                                                            {{-- <button class="btn btn-sm btn-danger btn-circle shadow-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="{{ $venta->idventa}}" data-name="{{ $venta->nombre }}">
                                                                <i class="fas fa-trash fa-sm text-white-50"></i>
                                                              
                                                              </button>  --}}
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
  <div class="modal-dialog modal-lg">
    <div id="contenidomodal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Detalles del pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div  class="modal-body">
      
        

                <form method="post" action="{{route('cambiarEstadoEntrega')}}">
                @csrf
                <input type="hidden" name="id_venta" id="id_venta">
          <div class="form-row">
            <div class="col-md-6">
              <label for="">Cliente</label>
              <input id="clienteventa" type="text" class="form-control" readonly>
            </div>
            <div class="col-md-6">
            <label for="">Tipo</label>
              <input id="tipoventa" type="text" class="form-control" readonly>
            </div>


            <div class="col-md-4">
            <label for="">Producto</label>
            <input id="productoventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="">Cantidad</label>
            <input id="cantidadventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="">Precio total</label>
            <input id="precioventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="">Estatus de pago</label>
            <input id="estadopagoventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="">ID Cargo</label>
            <input id="cargoventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="">Método de pago:</label>
            <input id="metodoventa" type="text"  class="form-control" readonly>
          </div>

          <div class="col-md-6">
            <label for="">Estado de entrega:</label>
            <select required name="estado_entrega" id="estadoentregaventa" class="form-control">
            <option value="">Seleccione uno</option>
            <option value="sin">Sin estado</option>
            <option value="entregado">Entregado</option>
            <option value="pendiente">Pendiente</option>
            <option value="cancelado">Cancelado</option>
            
            </select>
          </div>


          </div>

         
      




        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
          <i class="fas fa-times fa-sm text-white-50"></i>
          Cerrar
        </button>

        <button type="submit" class="btn btn-sm btn-primary shadow-sm" >
          <i class="fas fa-save fa-sm text-white-50"></i>
          Cambiar estado de entrega
        </button>
        </form>
      </div>
    </div>
  </div>

</div>



<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="contenidomodal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Detalles de envio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div  class="modal-body">
        <label for="" style="font-size: 20px;">Persona</label>
        <p id="nombremodal"></p>
        <label for="" style="font-size: 20px;">Direccion completa</label>
        <p id="direccionmodal"></p>
        <label for=""style="font-size: 20px;">Telefono</label>
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
        <div  class="modal-body">
          <p>¿Seguro que desea eliminar la venta <strong><span class="name-user"></span></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
            <i class="fas fa-times fa-sm text-white-50"></i>
            No, salir
          </button>
          <form id="formDelete" action="{{ route('pedidos.destroy', 0) }}" data-action="{{ route('pedidos.destroy', 0) }}" method="POST">
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
      <div  class="modal-body">
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
    <div class="modal fade" id="idModal-{{$registros->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLongTitle">Folio #00{{$registros->id}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #fafafa;">
                    <div class="col-md-12 table-responsive">
                        @if (!empty($compra_item))
                        <table class="table js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Folio</th>
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
                                        <td>#00{{$item->id}}</td>
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
                    </div>
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
        var button = $(event.relatedTarget) // Button that triggered the modal

        var control = button.data('control')

      
        var id = button.data('id')
        var name = button.data('nombre')
     
        $('#id_venta').val( button.data('id_venta'));
        $('#clienteventa').val(name);
        $('#tipoventa').val( button.data('tipoventa'));
        $('#productoventa').val( button.data('productoventa'));
        $('#cantidadventa').val( button.data('cantidadventa'));
        $('#precioventa').val( button.data('precioventa'));
        $('#estadopagoventa').val(button.data('estadopagoventa'));
        $('#cargoventa').val( button.data('cargoventa'));
        $('#metodoventa').val( button.data('metodoventa'));
        $('#estadoentregaventa').val( button.data('estadoentregaventa'));
     

      


     
      })


  </script>

@endsection