@extends('admin.layout.app')

@section('page-title')
    Editar cupón
@endsection

@section('styles')

@endsection

@section('content')
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
            @section('pagina-actual', 'Nuevo cupón')
            @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('discounts.index') }}">Cupones</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ul>
            @endsection
        </div>
        <div class="card-body" style="padding: 4% 8%">
            <form id="form-cupon" action="{{ route('coupons.update', $coupon) }}" method="post">
                @method('PUT')
                @include('admin.discounts.form')
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Funcion JavaScript para la conversion a mayusculas
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    }

    $("#codigo").keyup(function(){
        var ta  =  $("#codigo");
        letras  =  ta.val().replace(/ /g, "");
        ta.val(letras)
    });

</script>
@endsection
