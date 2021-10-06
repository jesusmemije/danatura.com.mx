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
                @section('pagina-actual','Subscriptores del sitio')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Subscriptores</a></li>
                    <li class="breadcrumb-item active">Listado</li>
                </ul>
    
                @endsection
             

            </div>
            <div class="card-body col-md-12 border" >
                @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
               <span> {{ session('success') }}</span>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
             @endif
            <table class="table table-bordered" id="dataTable"  >
                                    <thead>
                                        <tr>
                                            <th>Correo</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach($newsletter as $new)
                                       
                                            <tr>
                                              
                                                <td>{{$new->correo}}</td>
                                              
                                                <td>
                                                    <center>
                                                   
                                                        <button class="btn btn-danger btn-sm" data-id="{{$new->id}}" data-nombre="{{$new->correo}}" data-toggle="modal" data-target="#deleteUserModal">
                                                            <i class="fa fa-trash"></i>
                                                            </button>
                                                </center>
                                                </td>
                                           

                                            </tr>


                                        @endforeach


                                    </tbody>
                                </table>

            </div>
        </div>

        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Confirmar eliminación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>¿Seguro que desea eliminar el correo <strong><span class="name-user"></span></strong> del newsletter?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn  btn-secondary shadow-sm" data-dismiss="modal">
                    <i class="fas fa-times fa-sm text-white-50"></i>
                    No, salir
                  </button>
                  <form id="formDelete" action="{{ route('nl_correo_destroy', 0) }}" data-action="{{ route('nl_correo_destroy', 0) }}" method="POST">
                    
                    @csrf
                    <input type="hidden" name="id" id="id">
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
        console.log(name)

        $('#formDelete').attr('action', action)

        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name);
        modal.find('#id').val(id) 

})
    </script>

@endsection