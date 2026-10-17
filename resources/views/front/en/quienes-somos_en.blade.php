@extends('front.layout_en.app')

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

@include('front.layout_en.partials.menu')

<div style="background-image: url('/assets/images/background.png');">
  <div class="container">
    <div class="row row-principal">

      <div class="col-md-12 text-center my-4">
        <img src="{{ asset('assets/images/quienes-somos/danatura.png') }}" class="img-fluid with-logo">
        <div class="subtitle-quienes-somos my-3">COMPANY INFORMATION</div>
      </div>

    </div>

    <div class="row row-contenido">
      <div class="col-md-6 px-md-5 px-3">
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">ABOUT US?</div>
          </div>
          <div class="card-body px-0">
            <p>
              We are a Mexican company that was born from the search to offer real, simple, and
              nutritious food; free of added sugar, preservatives, and chemical additives, products
              that are truly going to contribute to a state of general well-being for all of those who
              consume them.
            </p>
            <p>Our dream is to contribute through our products to the prevention of diseases and to
              strengthen the health of all our customers.
            </p>
            <p>Did you know that we are the first place in obesity and overweight worldwide in children
              and teenagers? And the second place in obesity and overweight in adults?
            </p>
            <p>Obesity and overweight are the preludes to insulin resistance, metabolic syndrome,
              type two diabetes, and countless other diseases, all of which are preventable through a
              healthy diet, free of added sugar, and processed foods.
            </p>
            <p>At DaNatura Comida Real we are active promoters of a simple, healthy, and nutritious
              diet, where our vegan and natural foods are combined with fruits, vegetables, which
              are easily prepared at home and that strengthen the general health of our customers.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/darinka.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
      </div>

      <div class="col-md-6 px-md-5 px-3">
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">MISSION</div>
          </div>
          <div class="card-body px-0">
            <p>
              Our mission is to inspire individuals and families to eat in a more natural, healthy, and
              delightful way through innovative and quality foods that are the basis for them to cook
              at home in a practical and easy way. Always offering sugar-free food, free of additives
              and chemical dyes, which will strengthen your health and immune system.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/img-1.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="topics-quienes-somos">VISION</div>
          </div>
          <div class="card-body px-0">
            <p>
              Contribute to the preservation and conservation of a state of well-being and health in
              people, being global benchmarks in healthy, nutritious, and natural food. Real food.
            </p>
            <img src="{{ asset('assets/images/quienes-somos/img-2.jpg') }}" class="img-fluid mt-4">
          </div>
        </div>
      </div>

      <div class="col-md-12 px-md-5 px-3 text-center my-5">
        <video class="with-video" src="{{ asset('assets/images/quienes-somos/danatura-presentacion.mp4') }}" controls>
          We're sorry. This video cannot be played in your browser.<br>
          The downloadable version is available at <a
            href="{{ asset('assets/images/quienes-somos/danatura-presentacion.mp4') }}">Link</a>.
        </video>
      </div>
      <br>

    </div>

  </div>
</div>

@endsection