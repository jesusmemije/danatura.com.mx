@extends('front.layout.app')

@php
$host = "http:";
$url = $host."//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$array_galeria=explode('|',$producto->galeria);
$foto_principal=$array_galeria[0];
@endphp

@section('title')
Detalle producto
@endsection

@section('headers')
<meta property="og:url" content="{{$url}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Danatura" />
<meta property="og:description" content="Detalle de productos" />
<meta property="og:image" content="assets/productos/1625084725Sello_DANATURA.png" />
@endsection

@section('styles')
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<style>
  .pluginCountButton {
    color: #000;
    font-size: 16px;
  }

  li {
    list-style-type: none;
  }

  .checked {
    color: #F79860;
  }

  .nuevo-circle {
    display: flex;
    justify-content: center;
    border-radius: 100%;
    width: calc(5vw);
    height: calc(5vw);
    background: #FFE4BB;
    font-family: "AmasisMTStd-Bold";
    font-size: calc(1.2vw);
    position: relative;
    top: calc(5vw);
    left: calc(1.5vw);
    padding-top: calc(1.5vw);
  }

  .img-detail img {
    width: 99%;
  }

  .img-thumbnail {
    border: 0px !important;

    margin-left: calc(3vw + .2cm) !important;
  }

  .title {
    font-family: "AmasisMTStd-Bold";
    color: #73472b;
  }

  .subtitle {
    color: #73472b;
    font-weight: 500;

  }

  .price {
    color: #73472b;
    font-weight: 600;
  }

  .price-n {
    margin-top: 50px;
    color: #73472b;
    font-size: 1.5em;
    font-weight: bold;

  }

  .add {
    color: white;
    background: #F79860;
    border: 0px !important;
    border-radius: 0px !important;
    font-size: 22px;
    font-weight: bold;
  }

  #lightSlider {

    height: calc(50vw) !important;
  }

  .corazon {
    cursor: pointer;
    color: #aaa;
    position: relative;
    top: calc(4vw);
    left: calc(25.5vw);
  }

  .corazon:hover {
    color: #666;
  }

  .press {
    animation: size .4s;
    color: #fb985f !important;
  }

  @media (max-width: 900px) {
    .nuevo-circle {
      border-radius: 100%;
      width: calc(6vw) !important;
      height: calc(6vw) !important;
      font-size: calc(1.5vw) !important;
      position: relative;
      top: 15px !important;
      left: 5px !important;
      padding-top: 8%;

    }

    #lightSlider {

      height: calc(60vw) !important;
    }
  }

  @media (max-width:550px) {

    .corazon {
      cursor: pointer;
      color: #aaa;
      position: relative;
      top: calc(4vw);
      left: calc(24vw);
    }
  }

  @media (max-width:400px) {

    .corazon {
      cursor: pointer;
      color: #aaa;
      position: relative;
      top: calc(4vw);
      left: calc(20vw);
    }
  }

  @media (max-width:555px) {
    #lightSlider {

      height: calc(100vw) !important;
    }
  }

  @media (max-width:389px) {
    #lightSlider {

      height: calc(130vw) !important;
    }
  }

  @media (max-width:379px) {
    #lightSlider {

      height: calc(130vw) !important;
    }
  }

  @media (max-width:301px) {
    #lightSlider {

      height: calc(141vw) !important;
    }

    .nuevo-circle {
      border-radius: 100%;
      width: calc(14vw) !important;
      height: calc(14vw) !important;
      font-size: calc(3.6vw) !important;
      position: relative;
      top: 15px !important;
      left: 5px !important;
      padding-top: 11%;
    }
  }

  @media (max-width:280px) {
    #lightSlider {

      height: calc(171vw) !important;
    }

    .nuevo-circle {

      padding-top: 6%;
    }
  }
</style>
@endsection

@section('content')

@include('front.layout.partials.menu')

<div class="container-fluid">
  <div class="card mb-12" style="padding-top: 8%; padding-bottom:8%;">
    <div class="row g-0">
      <div id="principal-img" class="col-md-6 img-detail" style="padding-left: 6%;">

        @php
        $fotografia=$producto->fotografia;
        $source="assets/productos/".$fotografia;
        $source= $source=$fotografia;

        if ($fotografia=="") {

        $source=asset("assets/productos/goldenmilk.png");
        }

        if (strpos($source, 'https') !== false) {
        $source=$source;
        }else{
        $source=asset("assets/productos")."/".$fotografia;
        }

        if (strpos($producto->precio, '.') !== false) {

        $precio=$producto->precio;

        }else{
        $precio=$producto->precio.".00";
        }

        @endphp

        @php
        $array_galeria=explode('|',$producto->galeria);
        $foto_principal=$array_galeria[0];
        @endphp

        <img id="img-principal" src="{{$foto_principal}}" alt="...">
      </div>

      <div class="col-md-6">
        <div class="card-body">
          <h1 class="card-title title">{{$producto->nombre}}</h1>
          <h2 class="subtitle">{{$producto->sabor}}</h2>
          <h4 class="price">${{$precio}} MXN</h4>
          <div style="margin-top: 10%;">
            <div>
              <div class="form-row">
                <div class="col-md-5 col-xl-3 col-lg-4">
                  <span class="price-n">Cantidad</span>
                </div>
                <div class="col-md-2 ">
                  <input id="cantidad" class="form-control" type="number" min="1" value="1">
                </div>
              </div>
            </div>
            <br><br>
            @if($producto->stock==0)
            <a class="btn btn-danger agotado">AGOTADO</a>
            @else
            <a class="btn btn-warning add" onclick="add('{{$producto->id}}')">Añadir al carrito</a>
            @endif
          </div>
          <br><br>
          <div>
            <span style="font-size:20px; color:#73482C">Compartir</span><br>
            <ul class="nav">
              <div id="fb-root" style="margin-top:8%"></div>

              <script>
                (function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  
                  js.src = "https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.0";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
              </script>

              <!-- Your share button code -->
              <div class="fb-share-button" data-href="{{$url}}" data-layout="button_count">
              </div>
              <li class="nav-item" style="margin-top:-1%; margin-left: 2%;">
                <a href="mailto:contacto@danatura.com.mx?subject=Danatura%20-%20Productos" target="_blank" class="icon-instagram">
                  <i style="font-size:20px;" class="far fa-envelope fa-sm ri-face"></i>
                </a>
              </li>
            </ul>
          </div>
          <div>
            <hr>
            <p class="card-text" style="color: #73482C;">{{$producto->descripcion}}</p>
            <p class="card-text" style="color:#73482C; font-weight:bold">Contenido:{{$producto->gramos}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <ul class="lightSlider">
          @for ($i = 1; $i < sizeof($array_galeria); $i++) @if ($array_galeria[$i]!="" ) <li>
            <div style="padding:4%;">
              <img onclick="changeimg(this);" style="cursor:pointer" class="img-thumbnail" src="{{$array_galeria[$i]}}"
                alt="">
            </div>
            </li>
            @endif
            @endfor
        </ul>
      </div>
    </div>
  </div>

  <div class="row pt-5" style="">
    <div class="col-md-12 ">
      <div class="row d-flex justify-content-center" style="color:#73472b;font-size: 2em;">PRODUCTOS</div>
      <div class="row d-flex justify-content-center"
        style="color:#fb985f; font-size:3em; font-family:AmasisMTStd-Bold; ">MÁ S VENDIDOS</div>
    </div>
    <style>
      .cls2 {
        color: #73472b;
        font-weight: 500;
      }
    </style>
    <div class="col-md-12" style="padding-left:5%; padding-right:5%;">

      <ul id="lightSlider">

        @foreach($masvendidos as $vendido)

        <li>
          <div style="padding:4%;">

            <span class="nuevo-circle">Nuevo</span>
            <i id="fav{{$vendido->id}}" onclick="fav(this,'{{$vendido->id}}')" class="fas fa-heart corazon"></i>

            @php
            $fotografia=$vendido->fotografia;
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

            if (strpos($vendido->precio, '.') !== false) {

            $precio=$vendido->precio;

            }else{
            $precio=$vendido->precio.".00";
            }
            $array_galeria=explode('|',$vendido->galeria);

            $foto_principal=$array_galeria[0];

            @endphp
            <a href="detalle-producto?producto={{$vendido->nombre}}">
              <img class="img-thumbnail" src="{{$foto_principal}}" alt="">
            </a>
            <br>
            <div style="padding:4%;">
              <a href="detalle-producto?producto={{$vendido->nombre}}">
                <span style="color:#73472b; font-family:AmasisMTStd-Bold;">{{$vendido->nombre}}</span>
              </a>
              <br>
              <span class="cls2">{{$vendido->sabor}}</span><br>
            </div>
          </div>
        </li>

        @endforeach

      </ul>
    </div>
  </div>

</div>

@section("scripts")

<script src="{{asset('assets/js/lightslider.js')}}"></script>
<script>
  //script para el el scroll de las imagenes.
window.smoothScroll = function(target) {
  var scrollContainer = target;
  do { //find scroll container
      scrollContainer = scrollContainer.parentNode;
      if (!scrollContainer) return;
      scrollContainer.scrollTop += 1;
  } while (scrollContainer.scrollTop == 0);
  
  var targetY = 0;
  do {
      //find the top of target relatively to the container
      if (target == scrollContainer) break;
      targetY += target.offsetTop;
  } while (target = target.offsetParent);
  
  scroll = function(c, a, b, i) {
      i++; if (i > 30) return;
      c.scrollTop = a + (b - a) / 30 * i;
      setTimeout(function(){ scroll(c, a, b, i); },100);
  }
  // start scrolling
  scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
}

//script para almacenar productos favoritos: se repite en, home, productos y detalle producto.
var misfav=[];

var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

if(cookieValor!=null || cookieValor!=""){
  ckie= cookieValor.split(',');
  misfav=ckie;
}

function getallcookies(){

  var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

  if(cookieValor!=null || cookieValor!=""){
    ckie= cookieValor.split(',');

    ckie.forEach(element => {
     $('#fav'+element).addClass("press");
     
    });
    //console.log(ckie);
  }
}

//script favoritos.
function fav(dato, id){

  $(dato).toggleClass( "press", 1000 );

  if($(dato).hasClass('press')){
    misfav.push(id);
    //console.log(misfav);
    document.cookie="thecookie="+misfav;
  }else{
  
   for (let index = 0; index < misfav.length; index++) {
      if(misfav[index]==id){
        misfav.splice(index,1);
      }
   }
   document.cookie="thecookie="+misfav;
  }
 
}

//script para añadir un producto al carrito, se utiliza en : detalle producto.

 function add(id){

  cantidad= $("#cantidad").val();

  $.ajax({
    data: {
      "_token": "{{ csrf_token() }}",
      "id":id,
      "cantidad":cantidad
    },
    url: 'procesa',
    type: 'post',
    success:  function (response) {
      console.log(response);  
      response=JSON.parse(response);
      if(response['operacion']=="excede"){

        alert("La cantidad de productos supera el stock!");

        if(response['cantidad']<=0){
          $("#cantidad").val(0);
        }else{
          $("#cantidad").val(response["cantidad"]);
        }

      }

      if(response['operacion']=="zero"){
        alert("ZERO");
      }

      if(response['operacion']=="doble"){
        alert("El producto ya se encuentra añadido al carrito");
      }

      if(response['operacion']=="bien"){
        window.location="{{route('productos')}}"; 
      }
                     
    },
    error:  function (response) { 
      window.open(JSON.stringify(response));
    }
  });

}

 //script para cambiar de imagen "principal" a las demás que utiliza el producto.
function changeimg(ruta){
  
  smoothScroll(document.getElementById('principal-img'));
  principal=document.getElementById('img-principal');
  aux_principal=principal.src;
  principal.src=ruta.src;
  ruta.src=aux_principal;
  console.log(nuevo);

}

//scritp que inicializa el carrusel de productos más vendidos.

$(document).ready(function() {

  let fb=document.getElementsByClassName('inlineBlock')

  console.log(fb);

  getallcookies();

  $(".lightSlider").lightSlider({
    item:2,
    controls: true,
    pager: false,
    addClass: 'heightsldier',
    enableDrag:false,
    loop:false
  });

  $("#lightSlider").lightSlider({
    item:3,
    controls: true,
    pager: false,
    addClass: 'heightsldier',
      
    loop:false,
    responsive : [
      {
        breakpoint:501,
        settings: {
          item:2,
          slideMove:1
        }
      },
      {
        breakpoint:301,
        settings: {
          item:1,
          slideMove:1
        }
      }
    ]
  });
});

</script>

@endsection

@endsection