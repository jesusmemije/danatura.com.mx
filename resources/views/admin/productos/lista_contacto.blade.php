@extends('admin.layout.app')

@section('page-title')
    Mensajes de contactos
@endsection

@section('content')

<div class="card shadow">
    <div class="card-header">
        @section('pagina-actual', 'Contactos')
        @section('breadcumb')
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Contacto</a></li>
            <li class="breadcrumb-item active">Listado</li>
        </ul>
        @endsection
    </div>
    <div class="card-body col-md-12">
        <div class="">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th style="width: 20%">Nombre</th>
                        <th style="width: 20%">Email</th>
                        <th style="width: 20%">Asunto</th>
                        <th style="width: 40%">Mensaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contactos as $contacto)
                    <tr>
                        <td>{{$contacto->nombre}}</td>
                        <td>{{$contacto->email}}</td>
                        <td>{{$contacto->asunto}}</td>
                        <td>{{$contacto->mensaje}}</td>
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