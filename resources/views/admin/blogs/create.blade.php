@extends('admin.layout.app')

@section('content')

<div class="col-md-12">
    <div class="card shadow">
        <div class="card-header">
            @section('pagina-actual','Nueva publicación')
            @section('breadcumb')
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">
                    <i class="zmdi zmdi-home"></i>Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('blogs.index')}}">Publicaciones</a></li>
                <li class=" breadcrumb-item active">Nuevo</li>
            </ul>
            @endsection
        </div>

        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <strong>Guardado correctamente!</strong> La publicación se ha guardado.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <form class="image-upload" method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.blogs.form')
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

<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>

@endsection