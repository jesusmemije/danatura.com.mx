@extends('admin.layout.app')



@section('page-title')

    Agregar producto

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

            @section('pagina-actual','Nuevo producto')

            @section('breadcumb')

            <ul class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i>

                        Dashboard</a></li>

                <li class="breadcrumb-item"><a href="{{route('productos.index')}}"">Productos</a></li>

                <li class=" breadcrumb-item active">Nuevo</li>

            </ul>

            @endsection

        </div>



        @if (\Session::has('success'))

        <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;"

            role="alert">

            <strong>Guardado correctamente!</strong> El producto se ha guardado.

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

        @endif

        <div class="card-body">

            <form id="phase1" action="{{route('productos.store')}}" method="post" enctype="multipart/form-data">

                @csrf
                <label for="">¿Para qué idioma será ?</label>

                
                <select class="form-control" name="idioma" onclick="cambiar_idioma(this.value)" id="">
                    <option value="es">Español</option>
                    <option value="en">Ingles</option>
                </select>
                <label for="">Nombre o producto</label>

                <input class="form-control" type="text" id="nombre" name="nombre">

                <label for="">Sabor</label>

                <input class="form-control" type="text" id="sabor" name="sabor">

                <label for="">Descripción</label>

                <!-- <input class="form-control" type="text" id="descripcion" name="descripcion"> -->
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5"></textarea>

                <label for="">Gramos</label>

                <input class="form-control" type="text" id="gramos" name="gramos">

                <div class="row mt-3 mb-3">

                    <div class="col-sm-4" style="border-right:1px solid gray;">

                        <label for="">Precio Normal</label>

                        <div class="d-flex">
                            <input class="form-control" type="number" step='0.01' value='' id="precio" name="precio">
                            <span id="precio_span" style="margin-top:7px;margin-left:2px;margin-right:10px;">
                                MXN
                            </span>
                            {{-- <input class="form-control" type="number" step='0.01' value='' id="precio_usd" name="precio_usd"> --}}
                            {{-- <span style="margin-top:7px;margin-left:2px; ">
                                USD
                            </span> --}}
                        </div>

                    </div>
                    <div class="col-sm-4" style="border-right:1px solid gray;">
                        <label for="precio_nutriologo">Precio Nutriologo</label>
                        <div class="d-flex">

                            <input class="form-control" type="number" step='0.01' value='' id="precio_nutriologo" name="precio_nutriologo">
                            <span id="precio_n" style="margin-top:7px;margin-left:2px;margin-right:10px;">
                                MXN
                            </span>
                            {{-- <input class="form-control" type="number" step='0.01' value='' id="precio_nutriologo_usd" name="precio_nutriologo_usd">
                            <span style="margin-top:7px;margin-left:2px; ">
                                USD
                            </span> --}}
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="precio_mayorista">Precio Mayorista</label>
                        <div class="d-flex">
                            <input class="form-control" type="number" step='0.01' value='' id="precio_mayorista" name="precio_mayorista">
                            <span id="precio_m" style="margin-top:7px;margin-left:2px;margin-right:10px;">
                                MXN
                            </span>
                            {{-- <input class="form-control" type="number" step='0.01' value='' id="precio_mayorista_usd" name="precio_mayorista_usd">
                            <span style="margin-top:7px;margin-left:2px; ">
                                USD
                            </span> --}}
                        </div>
                    </div>

                </div>

                <label for="">Stock</label>

                <input class="form-control" type="number" id="stock" name="stock">

                <label for="categoria">Categoría</label>

                <select class="form-control show-tick" required name="categoria" id="categoria">

                    <option value="">Selecciona una</option>

                    @foreach($categorias as $categoria)

                    <option value="{{$categoria->id}}">{{$categoria->tipo}}</option>

                    @endforeach

                </select>

                <label for="">Fotografía(s)</label>

                <div class="input-images"></div>

                <hr>

                <div class="col-md-12 d-flex justify-content-end">

                    <input class="btn btn-primary" type="submit" value="Guardar">

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="nuevo">

                    <label class="form-check-label" for="inlineCheckbox1">¿Nuevo Producto?</label>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection



@section('scripts')



<script type="text/javascript" src="{{asset('assets/uploader/image-uploader.min.js')}}"></script>

<script>

    $('.input-images').imageUploader({

        imagesInputName: 'fotografia',

        label: "Arrastra tus imagenes o da click para seleccionarlas"

    });



    $('#phase1').on('submit', function(event) {

        event.preventDefault();

        

        var numItems = $('.uploaded-image').length;



        if( numItems == 0 ){

            alert("Debes seleccionar al menos 1 imágen.");

        } else {

            event.currentTarget.submit();

        }

    })

    function cambiar_idioma(idioma){
        
        if (idioma=='es') {
            document.getElementById('precio_span').innerHTML = 'MXN'; 
            document.getElementById('precio_m').innerHTML = 'MXN'; 
            document.getElementById('precio_n').innerHTML = 'MXN';  
            console.log(idioma)
        } else if (idioma=='en') {

            document.getElementById('precio_span').innerHTML = 'USD'; 
            document.getElementById('precio_m').innerHTML = 'USD'; 
            document.getElementById('precio_n').innerHTML = 'USD';  
            
        }


    }

</script>

@endsection