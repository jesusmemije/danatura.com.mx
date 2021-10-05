@extends('front.layout.app')


<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />


<style>

  
  .therow{
    font-family:'AmasisMTStd-Bold';
    padding:5%; background-color:#FFEFD6
  }
  .caja{
    background:#FFE4BB;
    padding: 5%;
    color: #73482C;
    border-radius: 1%;
  
  }
  .input-gris{
    background-color:white; height:50px; opacity:0.5; color:black;;
  }
  .hh{
    color: #F79860;
  }
  
</style>

@section('content') 

@include('front.layout.partials.secundario')


    
<div class="row therow">

  <div class="col-md-12 d-flex justify-content-center pb-4">
    
  <h3 style="color:#F79860; font-weight:bold;">Contacto</h3>
 
 


  </div>

 

 
         <div class="col-md-6 caja" style="padding-left:4%" >

      
       

          <p style=" font-family:'AmasisMTStd-Bold'">
            Teléfono: <span class="hh">+52 3330238418</span>
            </p>
            <p>Dirección: <span class="hh" >Zapopan Jalisco</span> </p>
            <p>Correo electrónico: <span class="hh">contacto@danatura.com.mx</span> </p>
    
           
            
    
    
           <p>
            <b>
              Redes Sociales
    
            </b></p>
    
            <p>Instagram <i class="fab fa-instagram-square"></i><br>
            <a class="hh" target="_blank" href="https://www.facebook.com/DaNaturaComidaReal">@danatura_comida_real</a>
            </p>
            
            <p>Facebook <i class="fab fa-facebook"></i><br>
            <a class="hh" target="_blank" href="https://www.instagram.com/Danatura_Comida_Real/">@danatura_comida_real</a>
            </p>
    
            <p>Whatsapp <i class="fab fa-whatsapp-square"></i><br>
            <a class="hh" target="_blank" href="https://api.whatsapp.com/send?phone=+523330238418&text=Hola%2C%20deseo%20adquirir%20información%20acerca%20de%20sus%20productos">+52 3330238418</a>
            </p>
        
     

        </div>

        <div class="col-md-6  caja" style="padding-right:4%">

          @if (\Session::has('error'))
          <div class="alert alert-danger alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
           <strong>Algo ha salido mal!</strong> {{ session('error') }}
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
       @endif

       @if (\Session::has('mensaje'))
          <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
           <strong>Hecho!</strong> {{ session('mensaje') }}
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
       @endif

            <form action="{{route("registrar_contacto")}}" method="post">

              @csrf

              <label for="">Tu Nombre:</label>
              
              <input required type="text" class="form-control input-gris" name="nombre">

              <label for="email">Tu Email:</label>
              <input required type="email" class="form-control input-gris" name="email">

              <label for="asunto">Asunto:</label>
              <input required type="asunto" class="form-control input-gris" name="asunto">

              <label for="mensaje">Mensaje:</label>
            

              <textarea required name="mensaje" class="form-control input-gris"></textarea>

              <div class="col d-flex justify-content-end">
                <button class="btn btn-light mt-4">Enviar mensaje</button>
              </div>

          



            </form>
          
       
  
          </div>

        </div>
  

  

  <script type="text/javascript">

  </script> 
@endsection