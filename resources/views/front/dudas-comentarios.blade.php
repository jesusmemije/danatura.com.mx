@extends('front.layout.app')



@section('title')

Dudas y comentarios

@endsection



@section('styles')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />



<style>

  .input-gris {

    background-color: white;

    height: 50px;

    opacity: 0.5;

    color: black !important;

    border-radius: 0px !important;

  }

</style>

@endsection



@section('content')



@include('front.layout.partials.menu')



<div class="row" style="padding:4%; background:#FFE4BB;">



  <div class="col-md-12">



    @if (\Session::has('error'))

    <div class="alert alert-danger alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">

      <strong>Algo ha salido mal!</strong> Tu duda no ha podido ser guardada correctamente, intentalo de nuevo.

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

        <span aria-hidden="true">&times;</span>

      </button>

    </div>

    @endif



    @if (\Session::has('mensaje'))

    <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">

      <strong>Hecho!</strong> Su duda ha sido enviada a nuestro equipo de trabajo.

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

        <span aria-hidden="true">&times;</span>

      </button>

    </div>

    @endif



    <h5 style="color:#F79860; font-weight:bold; font-family:'AmasisMTStd-Bold';">Dudas y comentarios</h5>



    <form style="font-family:'AmasisMTStd-Bold';" action="{{route('dudas')}}" method="post">

      @csrf
      <div class="row">
        <div class="col-md-4">
          <label for="">Tu nombre</label>
          <input name="nombre" type="text" class="form-control input-gris" >
        </div>
        <div class="col-md-4">
          <label for="">Tu correo para recibir nuestra respuesta</label>
          <input name="correo" type="email" class="form-control input-gris" >
        </div>
      </div>
      <br>
      <label for="">Escríbenos aquí tu duda y con gusto te contestamos</label>

      <input name="duda" type="text" class="form-control input-gris">

      <br>
      <div class="g-recaptcha" data-sitekey="6Ldp7NIgAAAAAMJizePuJLD7H13CJ1Td8oz2kzB8" style="float: right;margin-top: 10px">

      </div>

      <div class="col-md-12 d-flex justify-content-end">

        <button class="btn btn-light" type="submit">Enviar</button>

      </div>

    </form>



  </div>

</div>



@endsection