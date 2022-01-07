@extends('front.layout.app')

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<style>
  .row-contenido {
    color: #73482C;
    font-family: AmasisMTStd-Bold;
  }

  .card {
    border: 0px !important;
    background-color: transparent !important;
  }

  .card-header {
    border: 0px !important;
    background: #D7E9C0 !important;
    text-align: center;
  }

  .card-body {
    text-align: justify;
  }

  .subtitle-quienes-somos {
    font-size: 1.4em;
    color: #F79860;
    font-family: 'AmasisMTStd-Bold';
  }

  .topics-quienes-somos {
    font-size: 28px;
    font-family: 'AmasisMTStd-Bold';
  }

  .with-video {
    width: unset;
  }

  .with-logo {
    width: 50%;
  }

  @media screen and (max-width: 480px) {
    .subtitle-quienes-somos {
      font-size: 1.2em;
    }

    .with-video {
      width: 100%;
    }

    .with-logo {
      width: 80%;
    }
  }
</style>

@section('content')

@include('front.layout.partials.menu')

<div style="background-image: url('/assets/images/background.png');">
  <div class="container">
    <div class="row row-principal">

      <div class="col-md-12 text-center my-4">
        <img src="{{ asset('assets/images/quienes-somos/danatura.png') }}" class="img-fluid with-logo">
        <div class="subtitle-quienes-somos my-3">INFORMACIÓN DE LA EMPRESA</div>
      </div>

    </div>

    <div class="row row-contenido">
      <div class="col-md-6 px-md-5 px-3">
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">¿QUIÉNES SOMOS?</div>
          </div>
          <div class="card-body px-0">
            <p>
              Somos una empresa mexicana que nace de la búsqueda de ofrecer alimentos reales, simples y nutritivos,
              libres
              de azúcar añadido, libres de conservadores y aditivos químicos, alimentos que realmente van a contribuir
              un
              estado de bienestar general de todas las personas que los consuman.
              Nuestro sueño es contribuir a través de nuestros alimentos a la prevención de estados de enfermedad y a
              fortalecer la salud de todos nuestros clientes.
            </p>
            <p>En DaNatura creemos en el bienestar humano y natural. Es por eso que cada proceso se elabora con
              cuidado y
              tomando en cuenta las recomendaciones de un equipo de Nutriólogos y Health Coaches para alcanzar este
              propósito.
            </p>
            <p>Nuestros consumidores pueden tener la confianza de que nuestros productos sean basados en insumos
              naturales, libres de azúcar refinada y libres de químicos dañinos para el cuerpo. Ese es nuestro
              objetivo y
              estamos comprometidos al 100% para lograrlo.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/darinka.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
      </div>

      <div class="col-md-6 px-md-5 px-3">
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">MISIÓN</div>
          </div>
          <div class="card-body px-0">
            <p>
              Inspirar a las personas y familias a alimentarse de una manera más natural y deliciosa, promoviendo un
              estilo de vida saludable a través de alimentos innovadores y de calidad que sean la base para que
              cocinen en
              casa de una forma práctica y fácil, siempre ofreciendo alimentos libres de azúcar añadida, libres de
              aditivos y colorantes químicos y totalmente veganos que van a fortalecer su salud y sistema inmune.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/img-1.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">VISIÓN</div>
          </div>
          <div class="card-body px-0">
            <p>
              Contribuir en la preservación y conservación de un estado de bienestar y salud en las personas, siendo
              referentes a nivel global en alimentación sana, nutritiva y natural, una alimentación real.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/img-2.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
      </div>

      <div class="col-md-12 px-md-5 px-3 text-center my-5">
        <video class="with-video" src="{{ asset('assets/images/quienes-somos/danatura-presentacion.mp4') }}" controls>
          Lo sentimos. Este vídeo no puede ser reproducido en tu navegador.<br>
          La versión descargable está disponible en <a
            href="{{ asset('assets/images/quienes-somos/danatura-presentacion.mp4') }}">Enlace</a>.
        </video>
      </div>
      <br>

    </div>

  </div>
</div>

@endsection