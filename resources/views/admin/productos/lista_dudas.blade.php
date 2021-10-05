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
                @section('pagina-actual','Dudas y comentarios')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dudas y comentarios</a></li>
                    <li class="breadcrumb-item active">Listado</li>
                </ul>
    
                @endsection
             

            </div>
            <div class="card-body " >
            <div class="">
            <table class="table table-bordered" id="dataTable"  >
                                    <thead>
                                        <tr>
                                            <th>Dudas o comentarios</th>
                                            <th>Respuesta</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach($dudas as $duda)
                                           @php 

                                           //print_r($duda);

                                           @endphp
                                            <tr>

                                                <td>{{$duda->duda_comentario}}</td>

                                                @if($duda->respuesta=="" || empty($duda->respuesta))
                                                    <td><a class="badge badge-danger">No ha respondido</a></td>
                                                @else
                                              
                                                <td>{{$duda->respuesta}}</td>

                                                 
                                                

                                                @endif
                                              
                                                <td>
                                                    <a class="btn btn-info" href="" data-id="{{$duda->id}}" data-nombre="{{$duda->duda_comentario}}"  data-respuesta="{{$duda->respuesta}}" data-toggle="modal" data-target="#updateDuda">Responder</a>
                                                 
                                                    <button class="btn btn-danger btn-sm" data-id="{{$duda->id}}" data-nombre="{{$duda->duda_comentario}}" data-toggle="modal" data-target="#deleteUserModal">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                </td>


                                            </tr>


                                        @endforeach


                                    </tbody>
                                </table>
</div>
            </div>
        </div>



        <div class="modal fade" id="updateDuda" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Respondiendo duda</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form id="formDelete" action="{{ route('respuesta_duda') }}" method="POST">
                       @csrf
                <input type="hidden" name="id" id="id">
                 <label for="">Duda/Comentario</label>
                 <input class="form-control" type="text" readonly id="dudamodal">
                 <label for="">Respuesta</label>
                 <textarea class="form-control" name="respuesta" id="respuestamodal"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn  btn-secondary shadow-sm" data-dismiss="modal">
                    <i class="fas fa-times fa-sm text-white-50"></i>
                    Salir
                  </button>
                  
                    
                 
                    
                    <button type="submit" class="btn  btn-primary shadow-sm">
                      <i class="fas fa-save fa-sm text-white-50"></i>
                      Responder
                    </button>
                    
                  </form>
                </div>
              </div>
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
                  <p>¿Seguro que desea eliminar la duda/comentario?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn  btn-secondary shadow-sm" data-dismiss="modal">
                    <i class="fas fa-times fa-sm text-white-50"></i>
                    No, salir
                  </button>
                  <form id="formDelete" action="{{ route('dudas_destroy', 0) }}" data-action="{{ route('dudas_destroy', 0) }}" method="POST">
                    
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
        
        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name);
        modal.find('#id').val(id) 

})

$('#updateDuda').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('nombre')
        var respuesta = button.data('respuesta')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

      
        console.log(respuesta);
        var modal = $(this)
        modal.find('.modal-title').text('Confirmar eliminación') 
        modal.find('.name-user').text(name);
        modal.find('#id').val(id) 
        modal.find('#dudamodal').val(name) 
        
        modal.find('#respuestamodal').text(respuesta) 


})

    </script>
@endsection