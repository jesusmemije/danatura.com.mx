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
                @section('pagina-actual','Contactos')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Contacto</a></li>
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
                                            <th>Asunto</th>
                                            <th>Mensaje</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach($contactos as $contacto)
                                           
                                            <tr>

                                                <td>{{$contacto->nombre}}</td>
                                                <td>{{$contacto->email}}</td>
                                                <td>{{$contacto->asunto}}</td>
                                                <td>{{$contacto->mensaje}}</td>
                                                <td>

                                                    <i class="fa fa-edit"></i>

                                                    <i class="fa fa-trash"></i>
                                                
                                                </td>
                                              
                                            

                                            </tr>


                                        @endforeach


                                    </tbody>
                                </table>
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

@endsection