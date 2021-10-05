@extends('admin.layout.app')

@section('content')

<style>

.table tbody{
        color:#212529;
    }
  
.breadcrumb{
    background: #f8f9fc;
    padding-top: 0% !important;
}
    
</style>


        <div class="card shadow"> 
            <div class="card-header">
                @section('pagina-actual','Categorías de productos')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Categorías</a></li>
                    <li class="breadcrumb-item active">Listado</li>
                </ul>
                <button data-toggle="modal" data-target="#modalcategoria" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Añadir nueva</button>
                @endsection


                @if (\Session::has('success'))
                       <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
                      <span> {{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif
             

            </div>
            <div class="card-body col-md-12" >
            <div class="">
            <table class="table table-bordered" id="dataTable"  >
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach($categorias as $categoria)
                                           
                                            <tr>

                                                <td>{{$categoria->tipo}}</td>
                                              
                                                <td>
                                                    <center>
                                                   <button 
                                                   data-toggle="modal" data-target="#editarcategoria" data-id="{{ $categoria->id}}" data-oldnombre="{{ $categoria->tipo }}"
                                                   class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                                   <button class="btn btn-sm btn-danger btn-circle shadow-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="{{ $categoria->id}}" data-name="{{ $categoria->tipo }}">
                                                    <i class="fas fa-trash fa-sm text-white-50"></i>
                                                  
                                                  </button> 
                                                </center>
                                                </td>


                                            </tr>


                                        @endforeach


                                    </tbody>
                                </table>
</div>
            </div>
        </div>




<!-- Modal -->
<div  id="modalcategoria" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nueva categoría</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="pb-5">
            <form action="{{route('nueva_categoria')}}" method="post">

                @csrf
           
                           <div class="row">
                              <div class="col">
  
                              <form  id="form-envios" method="post">
                              <label for="">Nombre de la categoría </label>
                              <input required id="nombrecategoria" name="nombrecategoria" type="text" class="form-control" placeholder="">
                              </div>
                            
                          </div>
                          
       
                      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         
          <button  type="submit"  class="btn btn-primary">Guardar</button>
      </form>
        </div>
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
          <p>¿Seguro que desea eliminar la categoría <strong><span class="name-user"></span></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
            <i class="fas fa-times fa-sm text-white-50"></i>
            No, salir
          </button>
          <form id="formDelete" action="{{ route('destroy_categoria') }}"  method="POST">
           
            @csrf
            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                <input hidden type="text" name="id" id="id">
              <i class="fas fa-trash fa-sm text-white-50"></i>
              Si, eliminar
            </button>
            
          </form>
        </div>
      </div>
    </div>
  </div>

  
<!-- Modal -->
<div  id="editarcategoria" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="pb-5">
          <form action="{{route('editar_categoria')}}" method="post">

              @csrf
         
                         <div class="row">
                            <div class="col">

                              <input hidden type="text" id="idedit" name="idedit">

                            <form  id="form-envios" method="post">
                            <label for="">Nombre de la categoría </label>
                            <input readonly id="nombreedit" name="nombrecategoria" type="text" class="form-control" placeholder="">

                            <label for="">Nuevo nombre</label>
                            <input required id="nuevonombre" name="nuevonombre" type="text" class="form-control" placeholder="">
                            </div>
                          
                        </div>
                        
     
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
       
        <button  type="submit"  class="btn btn-primary">Actualizar</button>
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
        console.log(id);
        $('#id').val(id);
        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name)
      })


      $('#editarcategoria').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('oldnombre')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        console.log(name);
        $('#idedit').val(id);
        $('#nombreedit').val(name);
        var modal = $(this)
        modal.find('.modal-title').text('Editar categoría') 
        modal.find('.name-user').text(name)
      })

    </script>

@endsection