@extends('admin.layout.app')

@section('page-title')
    Agregar cupón
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
                    <li class=" breadcrumb-item active">Nuevo</li>
                </ul>
            @endsection
        </div>
        <div class="card-body" style="padding: 4% 8%">
            <form id="form-cupon" action="{{ route('coupons.store') }}" method="post">
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
