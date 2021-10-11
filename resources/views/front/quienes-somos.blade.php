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
  }

  .card-header {
    border: 0px !important;
  }
</style>


@section('content')

@include('front.layout.partials.menu')

<div class="row row-principal" style="background:#FFEFD6;padding-left:6%; padding-right:6%;">
  <div class="quienes-somos-align" style="padding-top:5%; padding-bottom:5%;">
    <span style="font-size:4em; color:#73482C; font-family:COSMOPOLITAN SCRIPT MEDIUM;">Información de la empresa</span>
    <div class="row-contenido">
      <div class="card">
        <div class="card-header" style="background:#FFE4BB;">
          <h3 style="color:#fb985f; font-family:AmasisMTStd-Bold">¿Quiénes somos?</h3>
        </div>
        <div class="card-body" style="background:#FFEFD6">

          <p>
            Somos una empresa mexicana que nace de la búsqueda de ofrecer alimentos reales, simples y nutritivos, libres
            de azúcar añadido, libres de conservadores y aditivos químicos, alimentos que realmente van a contribuir un
            estado de bienestar general de todas las personas que los consuman.
            Nuestro sueño es contribuir a través de nuestros alimentos a la prevención de estados de enfermedad y a
            fortalecer la salud de todos nuestros clientes.
          </p>

          <p>En DaNatura creemos en el bienestar humano y natural. Es por eso que cada proceso se elabora con cuidado y
            tomando en cuenta las recomendaciones de un equipo de Nutriólogos y Health Coaches para alcanzar este
            propósito.
          </p>

          <p>Nuestros consumidores pueden tener la confianza de que nuestros productos sean basados en insumos
            naturales, libres de azúcar refinada y libres de químicos dañinos para el cuerpo. Ese es nuestro objetivo y
            estamos comprometidos al 100% para lograrlo. </p>
        </div>
      </div>
      <div class="card mt-4">
        <div class="card-header" style="background:#FFE4BB;">
          <h3 id="mision" style="color:#fb985f;">Misión</h3>
        </div>
        <div class="card-body" style="background:#FFEFD6">
          <p>Inspirar a las personas y familias a alimentarse de una manera más natural y deliciosa, promoviendo un
            estilo de vida saludable a través de alimentos innovadores y de calidad que sean la base para que cocinen en
            casa de una forma práctica y fácil, siempre ofreciendo alimentos libres de azúcar añadida, libres de
            aditivos y colorantes químicos y totalmente veganos que van a fortalecer su salud y sistema inmune.</p>
        </div>
      </div>
      <div class="card mt-4">
        <div class="card-header" style="background:#FFE4BB;">
          <h3 id="vision" style="color:#fb985f">Visión</h3>
        </div>
        <div class="card-body" style="background:#FFEFD6">
          <p>Contribuir en la preservación y conservación de un estado de bienestar y salud en las personas, siendo
            referentes a nivel global en alimentación sana, nutritiva y natural, una alimentación real.</p>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection