@extends('admin.layout.app')



@section('page-title')

    Números Whatsapp

@endsection



@section('content')



<div class="card shadow">

  <div class="card-header">

    @section('pagina-actual','Listado de números de atención')

    @section('breadcumb')

    <ul class="breadcrumb">

      <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>

      {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Usuarios</a></li>

      <li class="breadcrumb-item active">Listado</li> --}}

    </ul>
    <a  style="background:#F79860" class="d-none d-sm-inline-block btn btn-primary shadow-sm" href="" data-toggle="modal" data-target="#agregarNumeroModal" data-id="0" data-name="0">
            
        <i class="fas fa-plus fa-sm text-white-50"></i> Añadir nuevo
    </a>
    <a href="https://create.wa.link/" target="_link" class=" btn btn-info btn-sm" style="float: right" >Generar link de whatsapp</a>

    @endsection
  </div>


  <div class="card-body col-md-12">
    
    <div class="">

      <table class="table table-bordered" id="dataTable">

        <thead>

          <tr>

            <th>#</th>
            <th>Área de atención</th>
            <th>Descripción</th>
            <th>Link</th>
            <th>Acciones</th>

          </tr>

        </thead>

        <tbody>
            
            @if (!empty($numeros_atencion))
                @foreach ($numeros_atencion as $numero_atencion)
                    <tr>

                        <td>{{$numero_atencion->id}}</td>
                        <td>{{$numero_atencion->area_whatsapp}}</td>
                        <td>{{$numero_atencion->descripcion_whatsapp}}</td>
                        <td>{{$numero_atencion->link_whatsapp}}</td>
                        
                        <td>

                            <a class="btn btn-warning btn-sm" href="" data-toggle="modal" data-target="#modificarNumeroModal" data-id="{{ $numero_atencion->id}}" data-name="{{ $numero_atencion->area_whatsapp }}" data-descripcion="{{ $numero_atencion->descripcion_whatsapp }}" data-link="{{ $numero_atencion->link_whatsapp }}">
            
                                <i class="fa fa-edit"></i>
                            </a>
                            @if ($numero_atencion->id==6)
                                
                            @elseif ($numero_atencion->id==7)

                            @else
                              <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#deleteNumeroModal" data-id="{{ $numero_atencion->id}}" data-name="{{ $numero_atencion->area_whatsapp }}">
              
                                  <i class="fa fa-trash"></i>
                              </a>
                                
                            @endif
                        </td>
                    </tr>
                
        
                @endforeach
            @endif

        </tbody>

      </table>

    </div>

  </div>

</div>



<div class="modal fade" id="deleteNumeroModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="ModalLabel"></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <p>¿Seguro que desea eliminar el número de whatsapp para <strong><span class="name-zona"></span></strong>?</p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">

          <i class="fas fa-times fa-sm text-white-50"></i>

          No, salir

        </button>

        <form id="formDelete" action="{{ route('destroy_numeros_whatsapp', 0) }}" data-action="{{ route('destroy_numeros_whatsapp', 0) }}"

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

<div class="modal fade" id="agregarNumeroModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

    <div class="modal-dialog">
  
      <div class="modal-content">
  
        <div class="modal-header">
  
          <h5 class="modal-title" id="ModalLabel"></h5>
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  
            <span aria-hidden="true">&times;</span>
  
          </button>
  
        </div>
  
        <div class="modal-body">
            <form id="formAgregar" action="{{ route('agregar_numeros_whatsapp') }}" method="POST">
  
                @csrf
                <div class="col-md-12">
                    <label for="">Área de atención</label>
                    <input type="text" class="form-control" name="area_whatsapp" placeholder="Ej. Asesoría" required>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Descripción</label>
                    <input type="text" class="form-control" name="descripcion_whatsapp" placeholder="Ej. Te ayudamos con información detallado">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Link de whatsapp</label>
                    <input type="url" class="form-control" name="link_whatsapp" required>
                </div>
                <div class="col-md-12 mt-4" >
                    <center>
                        <button type="submit" style="float: right;" class="btn btn-primary">Agregar</button>
                    </center>
                </div>
            
            </form>
        </div>
  
      </div>
  
    </div>
  
</div>

<div class="modal fade" id="modificarNumeroModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">

    <div class="modal-dialog">
  
      <div class="modal-content">
  
        <div class="modal-header">
  
          <h5 class="modal-title" id="ModalLabel"></h5>
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  
            <span aria-hidden="true">&times;</span>
  
          </button>
  
        </div>
  
        <div class="modal-body">
            <form id="formUpdate" action="{{ route('update_numeros_whatsapp') }}" method="POST">
  
                @csrf
                <div class="col-md-12">
                    <label for="">Área de atención</label>
                    <input type="hidden"  id="id" name="id">
                    <input type="text" class="form-control " id="name" name="area_whatsapp"  placeholder="Ej. Asesoría" required>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Descripción</label>
                    <input type="text" class="form-control " id="descripcion" name="descripcion_whatsapp"  placeholder="Ej. Te ayudamos con información detallado">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Link de whatsapp</label>
                    <input type="url" class="form-control " id="link" name="link_whatsapp"  required>
                </div>
                <div class="col-md-12 mt-4" >
                    <center>
                        <button type="submit" style="float: right;" class="btn btn-primary">Actualizar</button>
                    </center>
                </div>
            
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

  $('#deleteNumeroModal').on('show.bs.modal', function (event) {

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

$('#agregarNumeroModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget)

    var id = button.data('id')

    var name = button.data('name')

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.




    var modal = $(this)

    modal.find('.modal-title').text('AGREGAR NUEVO NÚMERO DE WHATSAPP') 

    modal.find('.name-zona').text(name)

})

  
$('#modificarNumeroModal').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget)

var id = button.data('id')

var name = button.data('name')
var descripcion = button.data('descripcion')
var link = button.data('link')

// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
console.log(name,descripcion,link);



var modal = $(this)

modal.find('.modal-title').text('Actualizar datos de número de whatsapp') 

modal.find('#id').val(id)
modal.find('#name').val(name)
modal.find('#descripcion').val(descripcion)
modal.find('#link').val(link)

})


</script>



@endsection