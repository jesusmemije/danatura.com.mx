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
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Newsletter</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ul>
    
                @endsection
             

            </div>
            <div class="card-body col-md-12" >
            <div class="">
            
            <form action="{{route('newsletter_new')}}">

            <label for="">Correo electrónico</label>
            <input class="form-control" type="email" name="correo">

            <button  class="btn btn-primary" type="submit">Registrar</button>

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