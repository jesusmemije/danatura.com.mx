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
                @section('pagina-actual','Newsletter')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Newsletter</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ul>
    
                @endsection
             

            </div>
            <div class="card-body col-md-12" >

            @if (\Session::has('error'))
                       <div class="alert alert-danger alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
                        <strong>Dato repetido!</strong> El correo ya se encuentra en el newsletter.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif

                    @if (\Session::has('mensaje'))
                       <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
                        <strong>Guardado correctamente!</strong> El correo se ha registrado en el newsletter.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif


            <div class="">
            
            <form action="{{route('newsletter_new')}}" method="post">
            @csrf
            <label for="">Correo electrónico</label>
            <input required class="form-control" type="email" name="correo">
            <hr>
            <div class="col-md-12 d-flex justify-content-end">
              
            <button  class="btn btn-primary" type="submit">Registrar</button>
            </div>
           

            </form>
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