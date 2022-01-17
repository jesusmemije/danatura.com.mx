@extends('admin.layout.app')

@section('page-title')
Informe de ventas
@endsection

@section('styles')
@endsection

@section('content')
<div class="col-md-12">
    <div class="card shadow">
        @section('pagina-actual','Informe de ventas')
        @section('breadcumb')
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
            <li class="breadcrumb-item active">Informe de ventas</li>
        </ul>
        @endsection
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Familia</th>
                            <th>Cantidad</th>
                            <th>Dinero</th>
                            <th>Origen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($compras as $compra)
                                <td>#000{{ $compra->id }}</td>
                                <td>{{  }}</td>
                                <td>Natural</td>
                                <td>120</td>
                                <td>Manulamente</td>
                                <td>Manulamente</td>
                            @endforeach
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
@endsection