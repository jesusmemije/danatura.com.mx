@extends('front.layout.app')


<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@section('content') 


<!--<button onclick="getallcookies()">Get all cookies</button>-->

  <div class="carousel-div">
    <div id="carouselExampleIndicators" class="carousel slide" s data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <!-- Slide One - Set the background image for this slide in the line below -->
        <div class="carousel-item active" style="background-image: url('assets/images/Banner Principal.jpg')"> 
        @include('front.layout.partials.menu') 
        <div style="position:relative; top: calc(16vw); left:8%;width:35%;">
       <span class="txt-banner">DELICIOSO</span><br>
       <span class="txt-banner2">SALUDABLE</span>
       <span class="txt-nutritivo">NUTRITIVO</span>
      <!--  <p class="txt-banner2" >NUTRITIVO</p> -->

        <br>
        <div class="div-match">

       
        <span class="txt-banner3" >El match perfecto!</span><br>
        
        </div>
        </div>

           <div  style="position: relative; left:8%; top:calc(2vw);">
           <button  type="button" class="col-xl-3 col-lg-4 col-md-3 col-sm-4 btn btn-primary comprar" data-toggle="modal" data-target="#exampleModal">
      COMPRAR
      </button>
           </div>    


        </div> <!-- Slide Two - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('assets/images/Image_Ig1.jpg')">
        @include('front.layout.partials.menu') 
        
          <div class="carousel-caption d-none d-md-block"> </div>
        </div> <!-- Slide Three - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('assets/images/Image_Ig2.jpg')">
        @include('front.layout.partials.menu') 
          <div class="carousel-caption d-none d-md-block"> </div>
        </div>
      </div> <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> -->
    </div>
  </div>
  <div class="container-fluid">
    <div class="row pt-5">
      <div class="col-md-12 " >
        <div class="row d-flex justify-content-center" style="color:#73472b;font-size: 2em;">PRODUCTOS</div>
        <div class="row d-flex justify-content-center" style="color:#fb985f; font-size:3em; font-family:AmasisMTStd-Bold; ">MÁS VENDIDOS</div>
      </div>

   
      <div class="col-md-12" >
        
        <ul id="lightSlider">
         
        @foreach($masvendidos as $vendido)
          <li>
          <div style="padding:4%;">
         
          

            


          <span class="nuevo-circle">NUEVO</span>

          <i id="fav{{$vendido->id}}" onclick="fav(this,'{{$vendido->id}}')" class="fas fa-heart corazon"></i>

            @php
                   $fotografia=$vendido->fotografia;
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
          <a  href="detalle-producto?producto={{$vendido->nombre}}">
           <img class="img-thumbnail" src="{{$foto_principal}}" alt="">
          </a>
           <br>
           <div style="padding:4%;">
           <a  href="detalle-producto?producto={{$vendido->nombre}}">
            <span style="color:#73472b; font-family:AmasisMTStd-Bold;">{{$vendido->nombre}}</span><br> 
            </a>
            <span class="cls2" >{{$vendido->sabor}}</span><br> 
            
            <!--
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked "></span>
            <span class="fa fa-star checked"></span>

            <br> 
            -->
            <span style="color:#73472b; font-weight: bold;">${{$precio}} MXN</span>
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
            <span class="span-bienestar">BIENESTAR</span> </div>
          <div class="row"> 
            <span class="span-general">GENERAL</span> </div>
          <div class="row" style="margin-top: 6%;"> 
            <span class="span-alimentos">Alimentos simples</span> 
            <span class="span-nutritivos">y nutritivos</span> </div>
        </div> <img class="img-fluid" width="925" src="{{asset('assets/images/Image1.jpg')}}" alt="">
      </div>
      <div class="col-md-6" >
        <div style="padding-top:12%; ">
          <div> 
            <span style="color:#73482C; font-size: 2em;font-family:AmasisMTStd-Bold;">EMPRESA 100% MEXICANA</span> </div>
        </div>
        <div style="padding-top: 2%; "> 
          <span style="color:#73482C; font-size: 18px; font-family:AmasisMTStd-Bold;"> Nuestro sueño es promover un estilo de vida más saludable, a través de una alimentación natural, nutritiva y real, libre de azúcar procesada, libre de aditivos y conservadores químicos, ofreciendo siempre alimentos innovadores y de calidad que van a contribuir en el bienestar y salud general de nuestros clientes.  </span> </div>
        <div> 
          <img class="img-fluid seccion3img " id="s3i1" src="{{asset('assets/images/Image2.jpg')}}" alt=""> 
          <img class="img-fluid seccion3img" id="s3i2"  src="{{asset('assets/images/Image3.jpg')}}" alt=""> </div>
      </div>
    </div>
    <div class="row" style="background:#FFEFD6; padding-top:2%; padding-bottom:4%; padding-left:15%; padding-right:15%">
      <div class="col-md-12 d-flex justify-content-center" style="padding-bottom: 5%;"> 
      
      <span class="divsec4">TODOS&nbsp;</span>
      
      <span class="divsec5"  >NUESTROS PRODUCTOS SON:</span> </div>
    </div>
    <div class="row" style="background:#FFEFD6; padding-left:10%; padding-right:10%;">

    
      <div class="col-lg-3 col-md-6"  >
        <div class="col  d-flex justify-content-center">
        <div class="circle"> <img width="200" src="{{asset('assets/icons/Icono1.png')}}" alt=""> </div></div>
        <div class="col" style="text-align: center"> 
          <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Insumos Órganicos</span><br> 
         
        
        </div>
     
      </div>
      <div class="col-lg-3 col-md-6" >
        <div class="col  d-flex justify-content-center">
        <div class="circle"><img width="200" src="{{asset('assets/icons/ICON2-13.png')}}" alt=""> </div></div>
        <div class="col" style="text-align: center"> 
          <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Naturalmente libres de Gluten</span><br> </div>
        
      </div>
      <div class="col-lg-3 col-md-6" >
        <div class="col  d-flex justify-content-center">
        <div class="circle" ><img width="200" src="{{asset('assets/icons/Icono3.png')}}" alt=""></div></div>
        <div class="col" style="text-align: center">
           <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Veganos</span><br> </div>
        
      </div>
      <div class="col-lg-3 col-md-6" >
        <div class="col  d-flex justify-content-center">
        <div class="circle" ><img width="200" src="{{asset('assets/icons/ICON6-13.png')}}" alt=""></div></div>
        <div class="col" style="text-align: center">
           <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Plant Based</span><br> </div>
       
      </div>
    </div>

    <div class="row div-tres">

    
      <div class="col-lg-4 col-md-6"  >
        <div class="col  d-flex justify-content-center">
        <div class="circle"> <img width="200" src="{{asset('assets/icons/ICON3-13.png')}}" alt=""> </div></div>
        <div class="col" style="text-align: center"> <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Sin aditivos artificiales</span><br> </div>
      </div> 
      <div class="col-lg-4 col-md-6" >
        <div class="col  d-flex justify-content-center">
        <div class="circle"><img width="200" src="{{asset('assets/icons/Icono2.png')}}" alt=""> 
        </div>
      </div>
        <div class="col" style="text-align: center"> 
          <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C">Sin azúcar refinada Añadida</span><br> </div>
     
      </div>
      <div class="col-lg-4 col-md-12" >
        <div class="col  d-flex justify-content-center">
        <div class="circle" ><img width="200" src="{{asset('assets/icons/ICON7-13.png')}}" alt="">
        </div>
        </div>
        <div class="col" style="text-align: center">
           <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C; margin-left:10%;">Alimentos Clean Label</span><br> </div>
      
          </div>
          
          <div class="col-md-12" >
           <div class="col  d-flex justify-content-center">
             <div class="circle"><img width="200" src="{{asset('assets/icons/ICON7-13.png')}}" alt=""></div>
          
           </div>
                <div class="col" style="text-align: center">
                  <span style="font-family:AmasisMTStd-Bold; font-size: 2em; color:#73482C;">Empaques amigables con el medio ambiente</span><br>
              

                </div>
              
              </div>
          
              </div>
    </div>



    <div class="row" style="background:#FFE4B8; padding-top:5%;">
      <div class="col-md-6" style="">
        <div class="row"> <span class="sec-txt">COMER</span> </div>
        <div class="row "> <span class="sec-txt2" >SALUDABLE</span> </div>
        <div class="row ">
           <span class='span-delicioso'>¡Es delicioso!</span> </div>
      </div>
      <div class="col-md-6 " style="">
        <div class="row"> <a target="_blank" href="https://youtube.com/channel/UCt-0ISeB7NilGmMRfs2mVKA"><i style="font-size:40px; position:absolute; left:70%; top:30%;" class="fab fa-youtube fa-sm circle-insta"></i></a> </div>
        <div style="margin-top: 10%;">
          <div style="padding-right: 30%;"> <span style="font-size: 1.8em;color:#73482C">Preparar platillos y menús saludables puede ser muy facil.</span> </div> <span style="font-size:240%; font-family:AmasisMTStd-Bold; color:#73482C">¡Sigue nuestras recetas!</span>
        </div>
      </div>
    </div>
    <div class="row" style="background:#FFE4B8;  padding-top:5%; padding-left:4%; padding-right:4%; padding-bottom:5%;">
      <div class="col-md-3 " style="display:inline-block;"> <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/Image_Ig1.jpg')}}" alt=""> </div>
      <div class="col-md-3"> <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/Image_Ig2.jpg')}}" alt=""> </div>
      <div class="col-md-3"> <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/Image_Ig3.jpg')}}" alt=""> </div>
      <div class="col-md-3"> <img style='max-height: 100%; max-width: 113%; object-fit: cover' src="{{asset('assets/images/Image_Ig4.jpg')}}" alt=""> </div>
    </div>
    <div class="row" style="height:300px; background:#F79860">
      <div class="col-md-12" style="padding-top: 4%;">
        <div style="display:flex; justify-content:center;"> <span style="color:#73482C; font-family:AmasisMTStd-Bold; font-size:2.5em;">Suscríbete a nuestro Newsletter</span> </div>
        <div class="" style="display:flex; justify-content:center;"> <span style="opacity:0.9; color:#73482C;  font-size: 1.5em;">¡Recibe promociones y nuestras mejores recetas! </span> </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-6 mt-3 ">
          <form id="form-news" action="">
            <div class="input-group"> 
              


             

              <input required type="email" name="correo" style="background-color:white; height:50px; opacity:0.5; color:black; border-radius:0px !important;" class="form-control  pr-5" type="search" placeholder="Introduce tu dirección de correo electrónico" id=""> <span class="input-group-append" style="background-color:#D7E9C0;"> <button onclick="registrarnew()" class="btn" type="button"> <span style="font-weight: bold;">REGISTRARSE</span> </button> </span> </div>
              </form>
          
            
          </div>
        </div>
      </div>
    </div>


  <style>
   

  </style>

        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    <div class="modal-content" style=" padding:5%;">
    

      <div class="container modal-div">


      <div class="row d-flex justify-content-center" style="padding-top:4%;">
  
    <span style=" font-size: 2em;" >¡KIT</span>
    <span style="font-size: 2em;">VIVE FELIZ!</span>
    </div>
    <div class="row d-flex justify-content-center">
    <span style="font-size:1em">¡Vive ORGÁNICO!</span>
    
    </div>
    
    <style>
      .this{
        background-image: url('assets/images/modalimg.jpg')
      }
    </style>
  
  <div class="row  d-flex justify-content-center" style="padding-top:10%">
      <img height="250" width="250" src="{{asset('assets/images/modalimg.jpg')}}" alt="">

      </div>

    <div class="cold-md-12 d-flex justify-content-center" style="margin-top: 30%;">
    <button class="btn btn-primary comprar" >¡LO QUIERO!</button>
  
    </div>
     

</div>


      </div>



   
   
  </div>
</div>

 
  
  </div>
  <!--contenedor principal --> @endsection 
  
  @section('scripts')
   <script src="{{asset('assets/js/lightslider.js')}}"></script>
   <script src="sweetalert2.all.min.js"></script>
  <script type="text/javascript">

$("#here").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
  

    
      function registrarnew(thedata){
        //$("#form-news").validate();
        var form = $('#form-news')[0];
    var fileform = new FormData(form); // <-- 'this' is your form element
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
                //alert("El correo ya se encuentra registrado en nuestro newsletter");

                      Swal.fire({
                    title: 'Error',
                    text: 'El correo ya se encuentra registrado en nuestro newsletter',
                    icon: 'error',
                    confirmButtonText: 'Hecho'
                    })
              }else{
                //alert("Su correo se ha registrdo correctamente");

                Swal.fire({
                    title: '¡Felicidades!',
                    text: 'Su correo se ha registrdo correctamente',
                    icon: 'success',
                    confirmButtonText: 'Hecho'
                    })
              }

              
                     
                     // $("#resultado").html("Carrito: "+response);
              },
              error:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //alert('Ha escrito un dato inválido')
                 // window.open(JSON.stringify(response));
                 Swal.fire({
                    title: '¡oops!',
                    text: 'Ha escrito un dato inválido. Vuelva a intentarlo.',
                    icon: 'warning',
                    confirmButtonText: 'Hecho'
                    })
                 
              }
      });
      }



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
          console.log(ckie);
        }
      }

    

  
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
  </script> 
@endsection