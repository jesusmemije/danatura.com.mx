@extends('admin.layout.app')

@section('page-title')
    Admin - Descuentos
@endsection

@section('styles')

@endsection

@section('content')
    <div class="col-md-12">
        <div class="card shadow">
            @section('pagina-actual', 'Listado de pedidos')
            @section('breadcumb')
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Descuentos</a></li>
                <li class="breadcrumb-item active">Sección</li>
            </ul>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary mt-3">
                <i class="zmdi zmdi-plus"></i> Agregar cupón
            </a>
            @endsection
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Status</th>
                                <th>Fecha creación</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>#{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->titulo }}</td>
                                    <td>{{ $coupon->codigo }}</td>
                                    <td>{{ $coupon->tipo }}</td>
                                    <td>
                                        @if ($coupon->tipo == 'Porcentaje')
                                            {{ $coupon->cantidad }}%
                                        @else
                                            ${{ $coupon->cantidad }}.00
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->status == 'Activo')
                                            <span class="badge badge-success">{{ $coupon->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $coupon->status }}</span>
                                        @endif
                                    </td>
                                    <td class="f-s-12">{{ $coupon->creation }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6 text-center px-0">
                                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                    class="btn btn-warning btn-sm btn-circle my-0">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="col-6 text-center px-0">
                                                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST">
                                                    @method("DELETE")
                                                    @csrf
                                                    <button type="submit" id="button-delete"
                                                        class="btnDelet btn btn-danger btn-sm btn-circle my-0"
                                                        data-id="{{ $coupon->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if (session('status_rule'))
            <div class="alert alert-success">
                {{ session('status_rule') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card-body">
                <form class="form-inline" action="{{ route('rule.update', $rule) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group mb-2">
                        <div>No se cobrará el costo de envío a partir de ($):</div>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputPassword2" class="sr-only">Password</label>
                      <input type="text" class="form-control input-number" maxlength="4" name="cantidad" value="{{ old('cantidad') !== null ? old('cantidad') : $rule->cantidad }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('.input-number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });
    $('.btnDelet').on('click', function(event) {
        event.preventDefault();
        var parent = $(this).data('id');
        var form = $(this).parent();

        var result = confirm("¿Confirma eliminar este elemento y su contenido?");
        if (result) {
            form.submit();
        }
    });
</script>
@endsection
