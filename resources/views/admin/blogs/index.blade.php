@extends('admin.layout.app')

@section('content')


<style>





</style>


    <div class="col-md-12">

    <a href="{{route('blogs.create')}}">Nueva entrada</a>


    <table>

    <thead>
        <th>Título</th>
        <th>Contenido</th>
        <th>Fecha</th>
        <th>Estado</th>
    </thead>

    <tbody>

        @foreach($blogs as $blog)

            <tr>
            <td>{{$blog->titulo}}</td>
            </tr>

        @endforeach


    </tbody>

    </table>
  
     
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