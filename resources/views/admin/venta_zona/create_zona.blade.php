@extends('admin.layout.app')



@section('page-title')

    Agregar zona

@endsection



@section('styles')

<link type="text/css" rel="stylesheet" href="{{asset('assets/uploader/image-uploader.min.css')}}">

<style>

    .bootstrap-select>.dropdown-toggle {

        display: none !important;

    }

</style>

@endsection



@section('content')



<div class="col-md-12">

    <div class="card shadow">

        <div class="card-header">

            @section('pagina-actual','Nueva zona')

            @section('breadcumb')

            <ul class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i>

                        Dashboard</a></li>

                <li class="breadcrumb-item"><a href="{{route('venta_zonas')}}">Zonas</a></li>

                <li class=" breadcrumb-item active">Nuevo</li>

            </ul>

            @endsection

        </div>



        @if (\Session::has('success'))

            <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;"

                role="alert">

                <strong>Guardado correctamente!</strong> La zona se guardó conrrectamente

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif

        <div class="card-body">

            <form id="phase1" action="{{route('store_zona')}}" method="post" >

                @csrf

                <label for="">Nombre zona</label>

                <input class="form-control" type="text" id="nombre_zona" name="nombre_zona">

                <label for="">Descripción</label>

                <!-- <input class="form-control" type="text" id="descripcion" name="descripcion"> -->
                <textarea class="form-control" id="descripcion_zona" name="descripcion_zona" rows="5"></textarea>


                <hr>

                <div class="col-md-12 d-flex justify-content-end">

                    <input class="btn btn-primary" type="submit" value="Guardar">

                </div>

                

            </form>

        </div>

    </div>

</div>

@endsection



@section('scripts')


@endsection