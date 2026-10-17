@extends('admin.layout.app')



@section('page-title')

    Zonas

@endsection



@section('content')



<div class="card shadow">

  <div class="card-header">

    @section('pagina-actual','Listado de usuarios')

    @section('breadcumb')

    <ul class="breadcrumb">

      <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>

      {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Usuarios</a></li>

      <li class="breadcrumb-item active">Listado</li> --}}

    </ul>
    <a href="{{route('create_zona')}}" style="background:#F79860" class="d-none d-sm-inline-block btn btn-primary shadow-sm">

        <i class="fas fa-plus fa-sm text-white-50"></i> Añadir nuevo
  
    </a>

    @endsection

  </div>

  <div class="card-body col-md-12">

    <div class="">

      <table class="table table-bordered" id="dataTable">

        <thead>

          <tr>

            <th>#</th>
            <th>Zona</th>
            <th>Descripción zona</th>
            <th>Usuarios agregados</th>
            <th>Productos agregados</th>

            <th>Acciones</th>

          </tr>

        </thead>

        <tbody>
            
            @if (!empty($zonas))
                @foreach ($zonas as $zona)
                    @php

                        $zonas_usuarios = DB::table('venta_zonas')
                          ->join('zona_usuario','venta_zonas.id','zona_usuario.id_zona_venta')
                          ->join('users','zona_usuario.id_usuario','users.id')
                          ->select('users.name','venta_zonas.nombre_zona','venta_zonas.id','zona_usuario.id as id_zona_usuario')
                          ->where('venta_zonas.id','=',$zona->id)
                          ->count();

                        $zonas_productos = DB::table('venta_zonas')
                        ->join('zona_producto','venta_zonas.id','zona_producto.id_zona_venta')
                        ->join('productos','zona_producto.id_producto','productos.id')
                        ->select('productos.nombre as nombre_producto','productos.descripcion','productos.precio','venta_zonas.nombre_zona','venta_zonas.id','zona_producto.id as id_zona_producto')
                        ->where('venta_zonas.id','=',$zona->id)
                        ->count();
                        
                    @endphp
                    <tr>

                        <td>{{$zona->id}}</td>
                        <td>{{$zona->nombre_zona}}</td>
                        <td>{{$zona->descripcion_zona}}</td>
                        <td>
                          <a title="Clic para ver el listado de usuarios agregados en esta zona" href="{{url('admin/usuarios-zona/'.$zona->id)}}" style="width: 80px;" class="btn btn-info btn-sm">{{$zonas_usuarios}} 
                            {{-- <i class="fa fa-eye"></i> --}}
                          </a>
                        </td>
                        <td>
                          <a title="Clic para ver el listado de prodcutos agregados en esta zona" href="{{url('admin/productos-zona/'.$zona->id)}}" style="width: 80px;" class="btn btn-info btn-sm">{{$zonas_productos}} 
                            {{-- <i class="fa fa-eye"></i> --}}
                          </a>
                        </td>
                        <td>

                            <a class="btn btn-warning btn-sm" href="{{url('admin/edit-zona/'.$zona->id)}}">
            
                                <i class="fa fa-edit"></i>
                            </a>
            
                            <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#deleteZonaModal" data-id="{{ $zona->id}}" data-name="{{ $zona->nombre_zona }}">
            
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                
        
                @endforeach
            @endif

        </tbody>

      </table>

    </div>

  </div>

</div>



<div class="modal fade" id="deleteZonaModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="ModalLabel"></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <p>¿Seguro que desea eliminar la zona <strong><span class="name-zona"></span></strong>?</p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">

          <i class="fas fa-times fa-sm text-white-50"></i>

          No, salir

        </button>

        <form id="formDelete" action="{{ route('zona_destroy', 0) }}" data-action="{{ route('zona_destroy', 0) }}"

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

  $('#deleteZonaModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget)

    var id = button.data('id')

    var name = button.data('name')

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    action = $('#formDelete').attr('data-action').slice(0, -1)

    action += id

       

    console.log(id);

    $('#formDelete').attr('action', action)



    var modal = $(this)

    modal.find('.modal-title').text('Confirmar eliminación') 

    modal.find('.name-zona').text(name)

  })

</script>



@endsection