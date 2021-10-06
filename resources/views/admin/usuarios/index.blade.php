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
                @section('pagina-actual','Listado de usuarios')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Usuarios</a></li>
                    <li class="breadcrumb-item active">Listado</li>
                </ul>
    
                @endsection
             

            </div>
            <div class="card-body col-md-12" >
            <div class="">
            <table class="table table-bordered" id="dataTable"  >
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Fecha de registro</th>
                                            <th>Tipo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach($usuarios as $usuario)
                                            @php
                                           
                                            $tipousuario=DB::table('tiposuario')->where('id','=',$usuario->tipo)->first();

                                            @endphp
                                            <tr>

                                                <td>{{$usuario->name}}</td>
                                                <td>{{$usuario->email}}</td>
                                                <td>{{$usuario->created_at}}</td>
                                                <td>{{$tipousuario->tipo}}</td>
                                                <td>
                                                <a class="btn btn-warning btn-sm" href="{{route('usuario.edit',$usuario->id)}}">
                                                    <i class="fa fa-edit"></i>
                                                    <a class="btn btn-danger btn-sm" href=""
                                                    data-toggle="modal" data-target="#deleteUserModal" data-id="{{ $usuario->id}}" data-name="{{ $usuario->name }}"
                                                    >
                                                    <i class="fa fa-trash"></i>
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
          <p>¿Seguro que desea eliminar el usuario <strong><span class="name-user"></span></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal">
            <i class="fas fa-times fa-sm text-white-50"></i>
            No, salir
          </button>
          <form id="formDelete" action="{{ route('usuario.destroy', 0) }}"  data-action="{{ route('usuario.destroy', 0) }}" method="POST">
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
        var name = button.data('name')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        action = $('#formDelete').attr('data-action').slice(0, -1)
        action += id
       
        console.log(id);
        $('#formDelete').attr('action', action)

        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name)
      })


     


  </script>


@endsection