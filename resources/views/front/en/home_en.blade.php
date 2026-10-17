@extends('front.layout_en.app')



@section('title')

Home

@endsection



<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>

  .bg-header-gris {

    background: unset!important;

  }

  

  .btn-video-youtube {

    font-size: 40px;

    position: absolute;

    left: 70%;

    top: 52%;

  }



  .hide-phone {

    display: block;

  }



  .buscador {

    position: absolute;

    display: inline-block;

    top: 5%;

    right: 5%;

    left: unset;

    transform: unset;

    z-index: 10;

  }



  @media screen and (max-width: 480px) {



    .btn-video-youtube {

      top: -12%;

    }



    .carousel-item {

      height: unset;

    }



    .hide-phone {

      display: none;

    }



    .carousel-div {

      height: unset;

    }



    .buscador {

      top: 45%;

      right: unset;

      left: 50%;

      transform: translateX(-50%);

    }



  }

</style>



@section('content')



<!--<button onclick="getallcookies()">Get all cookies</button>-->

<div class="carousel-div">

  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">

      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>

      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>

      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>

      <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>

    </ol>

    <div class="carousel-inner" role="listbox">



      <!-- Search superpocisión-->
      

      {{-- <div class="buscador">

      <form action="{{url('resultados-busqueda')}}" method="get">
        <input id="here" &lt;form autocomplete="off" class="form-control btn-slider-search px-2 py-2 rounded-pill mr-1 pr-md-5 pr-0" name="input_busqueda" type="search" placeholder="Buscar mi producto">
        <div class="dropdown-buscador" style="max-height: 500px;overflow-y: scroll;">
  
          <table class="contenido-buscador">
  
            <tbody id="myTable">
  
              @foreach ($productos as $producto)
  
                @php $nombre = $producto->nombre; @endphp
  
                <tr>
  
                  <td><a href="detalle-producto?producto={{$nombre}}">{{$producto->nombre}}</a></td>
  
                </tr>
  
              @endforeach
  
            </tbody>
  
          </table>
  
        </div>
      </form>


      </div> --}}



      <!-- Slide One - Set the background image for this slide in the line below -->

      <div class="carousel-item active" style="background-image: url('assets/images/banner-principal/1-principal.jpg')">

        @include('front.layout_en.partials.menu')

        <div class="container-slider-one text-md-left text-center hide-phone">

          <span class="txt-banner">DELICIOUS</span><br>

          <span class="txt-banner2">HEALTHY</span>

          <span class="txt-nutritivo">NUTRITIOUS</span>

          <br>

          <div class="div-match">

            <span class="txt-banner3">The perfect match!</span><br>

          </div>

        </div>

        <div class="btn-slider-comprar hide-phone">

          <button type="button" class="col-xl-3 col-lg-4 col-md-3 col-sm-4 btn btn-primary comprar" data-toggle="modal" data-target="#exampleModal">

            BUY

          </button>

        </div>

      </div>

      <div class="carousel-item" style="background-image: url('assets/images/banner-principal/2-carbon.jpg')">

        @include('front.layout_en.partials.menu')

        <div class="carousel-caption d-none d-md-block"> </div>

      </div>

      <div class="carousel-item" style="background-image: url('assets/images/banner-principal/3-malteada-rosa.jpg')">

        @include('front.layout_en.partials.menu')

        <div class="carousel-caption d-none d-md-block"> </div>

      </div>

      <div class="carousel-item" style="background-image: url('assets/images/banner-principal/4-jugo-verde.jpg')">

        @include('front.layout_en.partials.menu')

        <div class="carousel-caption d-none d-md-block"> </div>

      </div>

      <div class="carousel-item" style="background-image: url('assets/images/banner-principal/6-capsulas.jpg')">

        @include('front.layout_en.partials.menu')

        <div class="carousel-caption d-none d-md-block"> </div>

      </div>

    </div>

  </div>

</div>

<div class="container-fluid">

  <div class="row pt-5">

    <div class="col-md-12">

      <div class="text-center">

        <div style="color:#73472b; font-size:4em; font-family: COSMOPOLITAN SCRIPT MEDIUM; line-height:1;">Products</div>

        <div style="color:#fb985f; font-size:3em; font-family:AmasisMTStd-Bold; line-height:1;">BEST SELLERS</div>

      </div>

    </div>

    <div class="col-md-12">

      <ul id="lightSlider">



        @foreach($masvendidos as $vendido)

        <li>

          <div style="padding:5%;">

            <span class="nuevo-circle">NEW</span>

            <i id="fav{{$vendido->id}}" onclick="fav(this,'{{$vendido->id}}')" class="fas fa-heart corazon"></i>

            @php

            $tipo_precio = 'normal';
            $precio_usd = '';

            if (auth()->user() != null) {

                $tipo = auth()->user()->tipo;
                $tipos = DB::table('tiposuario')->where('id', '=', $tipo)->first();

                $thetipo = $tipos->tipo;

                if ($thetipo == "Mayorista") {
                    $tipo_precio = 'mayorista';
                }
                if ($thetipo == "Nutriologo") {
                    $tipo_precio = 'nutriologo';
                }
            }
            //Para los precios.
            if (strpos($vendido->precio, '.') !== false) {
                $precio_usd = $vendido->precio;
            } else {
                $precio_usd = $vendido->precio . ".00";
            }

            if ($tipo_precio == 'mayorista') {

                if (strpos($vendido->precio_mayorista, '.') !== false) {
                    $precio_usd = $vendido->precio_mayorista;
                } else {
                    $precio_usd = $vendido->precio_mayorista . ".00";
                }

            }

            if ($tipo_precio == 'nutriologo') {
                if (strpos($vendido->precio_nutriologo, '.') !== false) {
                    $precio_usd = $vendido->precio_nutriologo;
                } else {
                    $precio_usd = $vendido->precio_nutriologo . ".00";
                }

            }

            // Aqui es el final de precios

            $fotografia = $vendido->fotografia;

            $source = $fotografia;



            if ( $fotografia=="" ) {

            $source = asset("assets/productos/goldenmilk.png");

            }

            if (strpos($source, 'https') !== false) {

            $source = $source;

            } else {

            $source = asset("assets/productos")."/".$fotografia;

            }



            // if (strpos($vendido->precio_usd, '.') !== false) {

            // $precio=$vendido->precio_usd;

            // } else {

            // $precio=$vendido->precio_usd.".00";

            // }



            $array_galeria = explode('|',$vendido->galeria);

            $foto_principal = $array_galeria[0];



            @endphp

            <a href="products-detail?product={{$vendido->nombre}}">

              <img class="img-thumbnail" src="{{$foto_principal}}" alt="">

            </a>

            <br>

            <div style="padding:4%;">

              <a href="products-detail?product={{$vendido->nombre}}">

                <span style="color:#73472b; font-family:AmasisMTStd-Bold;">{{$vendido->nombre}}</span><br>

              </a>

              <span class="cls2">{{$vendido->sabor}}</span><br>

              <span style="color:#73472b; font-weight: bold;">${{$precio}} USD</span>

            </div>

          </div>

        </li>

        @endforeach

      </ul>

    </div>

  </div>

  <div class="row seccion3">

    <div class="col-md-6" style="font-family:AmasisMTStd-Bold;">

      <div class="divsec3">

        <div class="row">

          <span class="span-bienestar">WELLNESS</span> </div>

        <div class="row">

          <span class="span-general">GENERAL</span> </div>

        <div class="row" style="margin-top: 6%;">

          <span class="span-alimentos">Simple foods</span>

          <span class="span-nutritivos">and nutritious</span> </div>

      </div> <img class="img-fluid" width="925" src="{{asset('assets/images/Image1.jpg')}}" alt="">

    </div>

    <div class="col-md-6">

      <div style="padding-top:12%; ">

        <div>

          <span style="color:#73482C; font-size: 2em;font-family:AmasisMTStd-Bold;">BUSINESS 100% MEXICAN</span> </div>

      </div>

      <div style="padding-top: 2%; ">

        <span style="color:#73482C; font-size: 18px; font-family:AmasisMTStd-Bold;"> Promote in people a healthier lifestyle through a natural, nutritious, and real diet, free of
          processed sugar, additives, and chemical preservatives, always offering innovative and
          quality products that will contribute to the well-being and health of our clients. </span> </div>

      <div>

        <img class="img-fluid seccion3img " id="s3i1" src="{{asset('assets/images/Image2.jpg')}}" alt="">

        <img class="img-fluid seccion3img" id="s3i2" src="{{asset('assets/images/Image3.jpg')}}" alt=""> </div>

    </div>

  </div>

  <div class="row" style="background:#FFEFD6; padding-top:2%; padding-bottom:4%; padding-left:15%; padding-right:15%">

    <div class="col-md-12 d-flex justify-content-center" style="padding-bottom: 5%;">

      <span class="divsec4">EVERYBODY&nbsp;</span>

      <span class="divsec5">OUR PRODUCTS ARE:</span> </div>

  </div>







  <div class="row px-md-4 px-0" style="background:#FFEFD6;">

    <div class="col-lg-3 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"> <img width="200" src="{{asset('assets/icons/Icono1.png')}}" alt=""> </div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">Organic Inputs</span><br>

      </div>

    </div>

    <div class="col-lg-3 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/ICON2-13.png')}}" alt=""> </div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">

          Naturally Gluten Free

        </span><br>

      </div>

    </div>

    <div class="col-lg-3 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/Icono3.png')}}" alt=""></div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">Vegans</span><br> </div>

    </div>

    <div class="col-lg-3 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/ICON6-13.png')}}" alt=""></div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">Plant Based</span><br> </div>

    </div>

  </div>

  <div class="row div-tres">

    <div class="col-lg-4 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"> <img width="200" src="{{asset('assets/icons/ICON3-13.png')}}" alt=""> </div>

      </div>

      <div class="col" style="text-align: center"> <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">No artificial additives</span><br>

      </div>

    </div>

    <div class="col-lg-4 col-md-6 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/Icono2.png')}}" alt="">

        </div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">No Added Refined Sugar</span><br>

      </div>

    </div>

    <div class="col-lg-4 col-md-12 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/ICON7-13.png')}}" alt="">

        </div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold; margin-left:10%;">

          Clean Label Foods

        </span><br>

      </div>

    </div>

    <div class="col-md-12 col-6 px-0">

      <div class="col  d-flex justify-content-center">

        <div class="circle"><img width="200" src="{{asset('assets/icons/ICON7-13.png')}}" alt=""></div>

      </div>

      <div class="col" style="text-align: center">

        <span class="icons-text-description" style="font-family:AmasisMTStd-Bold;">

          Environmentally friendly packaging

        </span><br>

      </div>

    </div>

  </div>

</div>

<div class="row" style="background:#FFE4B8; padding-top:5%;">

  <div class="col-md-6" style="">

    <div class="row"> <span class="sec-txt">TO EAT</span> </div>

    <div class="row "> <span class="sec-txt2">HEALTHY</span> </div>

    <div class="row ">

      <span class='span-delicioso'>It's delicious!</span> </div>

  </div>

  <div class="col-md-6 " style="">

    <div class="row">

      <a target="_blank" href="https://youtube.com/channel/UCt-0ISeB7NilGmMRfs2mVKA">

        <i class="fab fa-youtube circle-insta btn-video-youtube"></i>

      </a>

    </div>

    <div class="text-md-left text-center" style="margin-top: 10%;">

      <div class="pr-md-5 pr-0"> <span style="font-size: 1.8em;color:#73482C">Prepare dishes and menus

          healthy can be very easy.</span> </div> <span

        style="font-size:240%; font-family:AmasisMTStd-Bold; color:#73482C">Follow our recipes!</span>

    </div>

  </div>

</div>

<div class="row py-0 px-0 py-md-5 px-md-0" style="background:#FFE4B8;">

  <div class="col-md-3 col-6 mb-1" style="display:inline-block;">

    <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/web_03.png')}}">

  </div>

  <div class="col-md-3 col-6 mb-1">

    <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/web_01.png')}}">

  </div>

  <div class="col-md-3 col-6">

    <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/web_02.png')}}">

  </div>

  <div class="col-md-3 col-6">

    <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/web_04.png')}}">

  </div>

</div>

<div class="row" style="height:300px; background:#F79860">

  <div class="col-md-12" style="padding-top: 4%;">

    <div class="text-md-left text-center" style="display:flex; justify-content:center;">

      <span style="color:#73482C; font-family:AmasisMTStd-Bold; font-size:2.5em;">

        Subscribe to our Newsletter

      </span>

    </div>

    <div class="text-md-left text-center" style="display:flex; justify-content:center;">

      <span style="opacity:0.9; color:#73482C;  font-size: 1.5em;">

        Receive promotions and our best recipes!

      </span>

    </div>

    <div class="row d-flex justify-content-center px-3">

      <div class="col-md-6 mt-3 ">

        <form id="form-news" action="">

          <div class="input-group">

            <input required type="email" name="correo"

              style="background-color:white; height:50px; opacity:0.5; color:black; border-radius:0px !important;"

              class="form-control  pr-5" type="search" placeholder="Enter your email" id="">

            <span class="input-group-append" style="background-color:#D7E9C0;"> <button onclick="registrarnew()"

                class="btn" type="button"> <span style="font-weight: bold;">CHECK IN</span> </button> </span> </div>

        </form>

      </div>

    </div>

  </div>

</div>
<style>

  .overlay{
    background: rgb(0, 0, 0,.3);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    align-items: center;
    justify-content: center;
    display: flex;
    z-index: 2000;
    visibility: hidden;
  }
  .overlay.active {
    visibility: visible;
  }
  .popup {
    background: #F8F8F8;
    box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3);
    border-radius: 5px;
    font-family: 'Montserrat', sans-serif;
    /* padding: 40px; */
    text-align: center;
    width: 600px;
    
    transition: .3s ease all;
    transform: scale(0.7);
    opacity: 0;
    overflow: hidden;

  }
  .popup .btn-cerrar-popup {
    font-size: 16px;
    line-height: 16px;
    display: block;
    text-align: center;
    transition: .3s ease all;
    color: #ffffff;
    padding: 10px 0px;
    background: #F79860;
    width: 100px;
    position: absolute;
    left: 250px;
    bottom:10px ;
    border-radius: 20px;

  }
  .popup .btn-cerrar-popup:hover {
    color: #000;
  }
  .popup .btn-cerrar-popup:hover {
    color: #000;
  }
  .popup h3 {
    font-size: 36px;
    /* font-weight: 600; */
    margin-bottom: 10px;
    opacity: 0;
    position: absolute;
    top: 100px;
    font-size: 80;
    left: 17%;
    font-weight: bold;
    color: #ff8942;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  }
  
/* ------------------------- */
/* ANIMACIONES */
/* ------------------------- */
.popup.active {	transform: scale(1); opacity: 1; }
.popup.active h3 { animation: entradaTitulo .8s ease .2s forwards; }
/* .popup.active h4 { animation: entradaSubtitulo .8s ease .5s forwards; } */
/* .popup.active .contenedor-inputs { animation: entradaInputs 1s linear 1s forwards; } */

@keyframes entradaTitulo {
	from {
		opacity: 0;
		transform: translateY(-25px);
	}

	to {
		transform: translateY(65px);
		opacity: 1;
	}
}

@media screen and (max-width:480px){
    .popup h3 {
      font-size: 36px;
      /* font-weight: 600; */
      margin-bottom: 10px;
      opacity: 0;
      position: absolute;
      /* top: 100px; */
      font-size: 55px;
      left: 90px;
      font-weight: bold;
      color: #ff8942;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .popup .btn-cerrar-popup {
      font-size: 16px;
      line-height: 16px;
      display: block;
      text-align: center;
      transition: .3s ease all;
      color: #ffffff;
      padding: 5px 0px;
      background: #F79860;
      width: 100px;
      position: absolute;
      left: 160px;
      bottom:10px ;
      border-radius: 20px;

    }

    @keyframes entradaTitulo {
      from {
        opacity: 0;
        transform: translateY(-25px);
      }

      to {
        transform: translateY(40px);
        opacity: 1;
      }
    }
}

</style>
    @php
        $descuento = DB::table('rules')
        ->where('id','=',2)
        ->get();
    @endphp

    <!--
<div class="overlay" id="overlay">
    <div class="popup" id="popup">
      <img src="assets/images/banner-principal/Danatura_ingles.jpg" width="100%" alt="">
      
      {{-- <h3> --}}
        {{-- ¡Compras mayores a  <br> --}}
        @if (count($descuento)==0)
          
          <span style="position: absolute;top: 0;">
              $ 0.00 USD

          </span>
        @else
          @foreach ($descuento as $des)
          <center>
            <h3>
              $ {{number_format($des->cantidad,2)}} <span style="font-size: 70%">USD </span>
  
          </h3>
          </center>
          @endforeach
        @endif
        
        {{-- el envío es totalmente gratis! --}}
      {{-- </h3> --}}
      <center>
        <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup">Ok</a>
      </center>
    </div>
</div>

-->
<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

  aria-hidden="true">

  <div class="modal-dialog" role="document">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      <span aria-hidden="true">&times;</span>

    </button>

    <div class="modal-content" style=" padding:5%;">

      <div class="container modal-div">

        <div class="row d-flex justify-content-center" style="padding-top:4%;">

          <span style=" font-size: 2em;">¡KIT</span>

          <span style="font-size: 2em;">kit LIVE HAPPY!</span>

        </div>

        <div class="row d-flex justify-content-center">

          <span style="font-size:1em">¡Live ORGANIC!</span>

        </div>

        <style>

          .this {

            background-image: url('assets/images/modalimg.jpg')

          }

        </style>

        <div class="row  d-flex justify-content-center" style="padding-top:10%">

          <img height="250" width="250" src="{{asset('assets/images/modalimg.jpg')}}" alt="">

        </div>

        <div class="cold-md-12 d-flex justify-content-center" style="margin-top: 30%;">

          <button class="btn btn-primary comprar">¡I LOVE YOU!</button>

        </div>

      </div>

    </div>

  </div>

</div>

</div>

@endsection



@section('scripts')
<script>
  // var btnAbrirPopup = document.getElementById('btn-abrir-popup'),
	overlay = document.getElementById('overlay'),
	popup = document.getElementById('popup'),
	btnCerrarPopup = document.getElementById('btn-cerrar-popup');

 function btnAbrirPopup(){
    overlay.classList.add('active');
    popup.classList.add('active');
  }

  btnCerrarPopup.addEventListener('click', function(e){
    e.preventDefault();
    overlay.classList.remove('active');
    popup.classList.remove('active');
  });
</script>


<script src="{{asset('assets/js/lightslider.js')}}"></script>



<script type="text/javascript">



$("#here").on("keyup", function() {

var value = $(this).val().toLowerCase();

$("#myTable tr").filter(function() {

  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

});

});



  function registrarnew(thedata){

    var form = $('#form-news')[0];

    var fileform = new FormData(form);

    var token = $('meta[name="csrf-token"]').attr('content');



    $.ajax({

      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

      },

      cache: false,

      contentType: false,

      processData: false,

      url: "{{ route('newsletter-front') }}",

      data: fileform,

      type: 'POST',   

      dataType:'json',

      success: function(resp) {



        console.log(resp);



        if(resp['mensaje']=="ya existe"){



          Swal.fire({

            title: 'Danger',

            text: 'The mail is already registered in our newsletter',

            icon: 'error',

            confirmButtonText: 'Ok'

          })

        } else {

          Swal.fire({

            title: '¡Congratulations!',

            text: 'Your email has been successfully registered',

            icon: 'success',

            confirmButtonText: 'Ok'

          })

        }

      },

      error:  function (response) {

        Swal.fire({

          title: '¡oops!',

          text: 'You have entered invalid data. Try again.',

          icon: 'warning',

          confirmButtonText: 'Hecho'

        })

      }

    });

  }



  var misfav=[];

  var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

      

  if(cookieValor!=null || cookieValor!=""){

    ckie = cookieValor.split(',');

    misfav = ckie;

  }



  function getallcookies(){



    var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

      

    if(cookieValor!=null || cookieValor!=""){

      ckie= cookieValor.split(',');



      ckie.forEach(element => {

        $('#fav'+element).addClass("press");

      });

      

      // console.log(ckie);

    }

  }



  function fav(dato, id){

      

    $(dato).toggleClass( "press", 1000 );



    if( $(dato).hasClass('press') ){

      misfav.push(id);

      document.cookie="thecookie="+misfav;

    } else {

        

      for (let index = 0; index < misfav.length; index++) {

          

        if(misfav[index]==id){

          misfav.splice(index,1);

        }



      }



      document.cookie="thecookie="+misfav;

    }

  }

  

  $(document).ready(function() {

    getallcookies();



    $("#lightSlider").lightSlider({

      controls: true,

      pager: false,

      addClass: 'heightsldier',

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

  $(window).load(btnAbrirPopup());

</script>

@endsection