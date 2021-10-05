@extends('front.layout.app')

@section('styles')

<link rel="stylesheet" href="{{asset('assets/css/productos.css')}}">

<style>

svg{
  display: none;
}

</style>

@endsection

@section('content')


@include('front.layout.partials.secundario')

<div class="container-fluid">

<div class="row">

<div class="col-md-12" >
<!--

<div class="row center-badge">
<div class="mybadge col-md-1">
  <a>Superfoods</a>
  </div>

  <div class="mybadge col-md-1">
  <a>Bebidas</a>
  </div>
  
  <div class="mybadge col-md-1">
  <a>Cápsulas</a>
  </div>
  
  <div class="mybadge active col-md-auto">
  <a>Todos los filtros</a>
  </div>
</div>
-->
<h2 style="padding-left: 2%; padding-top:2%; font-family:'AmasisMTStd-Bold';">Mis favoritos</h2>


</div>







@foreach ($favoritos as $favorito)
    

    <div class="col-md-4 spc">
    
    <li style="">
          <div  style="padding:2%;">
         
          <span class="nuevo-circle">Nuevo</span>

          @php
                   $fotografia=$favorito->fotografia;
        $source="assets/productos/".$fotografia;
        $source=$fotografia;
   
        if ($fotografia=="") {
           
         $source=asset("assets/productos/goldenmilk.png");
        }

        if (strpos($source, 'https') !== false) {
          $source=$source;
        }else{
          $source=asset("assets/productos")."/".$fotografia;
        }

        if (strpos($favorito->precio, '.') !== false) {
            
            $precio=$favorito->precio;
        
        }else{
            $precio=$favorito->precio.".00";
        }

        $array_galeria=explode('|',$favorito->galeria);
        
        $foto_principal=$array_galeria[0];
        

            
            @endphp

           <img class="img-thumbnail" src="{{$foto_principal}}" alt="">
           <br>
           <div style="padding:4%;">
            <span style="color:#73472b; font-family:AmasisMTStd-Bold;">{{$favorito->nombre}}</span><br> 
            <span class="cls2" >{{$favorito->sabor}}</span><br> 

             <!--
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <br> 
            -->
            <span style="color:#73472b; font-weight: bold;">{{$precio}} MXN</span>
            <br>
            <div class="d-flex justify-content-end">
              @php
              //$cleaname=str_replace(" ","-",$favorito->nombre);
              @endphp

            <a class="btn btn-secondary comprar"  href="detalle-producto?producto={{$favorito->nombre}}">COMPRAR</a>

            </div>
            
           </div> 
          </div>
          </li>
          </div>

          @endforeach




</div><!--main row-->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>

</div>

@endsection
