@extends('front.layout_en.app')

@section('title')
Contact
@endsection

@section('styles')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />
<style>
  .therow {
    font-family: 'AmasisMTStd-Bold';
    padding: 5%;
    background-color: #FFEFD6
  }

  .caja {
    background: #FFE4BB;
    padding: 5%;
    color: #73482C;
    border-radius: 1%;

  }

  .input-gris {
    background-color: white;
    height: 50px;
    opacity: 0.5;
    color: black;
    ;
  }

  .hh {
    color: #F79860;
  }
</style>

@endsection

@section('content')

@include('front.layout_en.partials.menu')

<div class="row therow" style="background-image: url('/assets/images/background.png');">

  <div class="col-md-12 d-flex justify-content-center pb-4">
    <h3 style="color:#F79860; font-weight:bold;">Contact</h3>
  </div>

  <div class="col-md-6 caja" style="padding-left:4%">
    <p>Telephone &amp; Whatsapp: <i class="fab fa-whatsapp-square"></i><br>
      <a class="hh" target="_blank"
        href="https://api.whatsapp.com/send?phone=+3339566141&text=Hola%2C%20deseo%20adquirir%20información%20acerca%20de%20sus%20productos">
        +33 3956 6141
      </a>
    </p>
    {{-- <p style=" font-family:'AmasisMTStd-Bold'">
      Telephone &amp; Whatsapp: <span class="hh">+33 3956 6141</span>
    </p> --}}
    <p>Address: <span class="hh">Av. El campanario 1846 -C, Cp. 45234. Zapopan, Jalisco</span> </p>
    <p>Email: <span class="hh">contactodanatura@gmail.com</span> </p>
    {{-- <p><b>Redes Sociales</b></p> --}}

    <p>Facebook <i class="fab fa-facebook"></i><br>
      <a class="hh" target="_blank" href="https://www.facebook.com/DarinkaQuintanaNutriendotuvida/">@danatura_comida_real</a>
    </p>
    <p>Instagram <i class="fab fa-instagram-square"></i><br>
      <a class="hh" target="_blank" href="https://www.instagram.com/Danatura_Comida_Real/">@danatura_comida_real</a>
    </p>


    
  </div>

  <div class="col-md-6  caja" style="padding-right:4%">

    @if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
      <strong>Something has gone wrong!</strong> {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if (\Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
      <strong>Success!</strong> {{ session('mensaje') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    <form action="{{route("registrar-contacto_en")}}" method="post">

      @csrf
      <label for="">Your name:</label>

      <input required type="text" class="form-control input-gris" name="nombre">
      <label for="email">Your email:</label>
      <input required type="email" class="form-control input-gris" name="email">
      <label for="asunto">Affair:</label>
      <input required type="asunto" class="form-control input-gris" name="asunto">
      <label for="mensaje">Message:</label>

      <textarea required name="mensaje" class="form-control input-gris"></textarea>
      <div class="g-recaptcha" data-sitekey="6Ldp7NIgAAAAAMJizePuJLD7H13CJ1Td8oz2kzB8" style="float: right;margin-top: 10px">

      </div>
      <div class="col d-flex justify-content-end">
        <button class="btn btn-light mt-4">Send Message</button>
      </div>
    </form>
  </div>
</div>

@endsection