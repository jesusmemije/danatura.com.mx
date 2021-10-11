@extends('front.layout.app')


<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<style>

.img-patron{
 
    -webkit-border-radius: 20px;
    width: 100%;
    object-fit: cover;
    box-shadow: 0px 0px 5px rgb(51, 51, 51);
}

</style>


@section('content') 
@include('front.layout.partials.menu')

  <div class="container" style="margin-top:3%; margin-bottom:2%">

  <h3 style="font-family:'AmasisMTStd-Bold'; margin-bottom:3%; color:#f79860">POLÍTICA DE ENVÍOS </h3>



  <ul style="font-family:'AmasisMTStd-Bold'; margin-bottom:4%; font-size:18px;">

  <li>Envío a partir de una pieza. Mientras mayor sea tu pedido, el envío baja de costo. Cotiza y lo verás!!!  </li>
  <li>Si tu compra es superior a $1,200 pesos, el envío va por nuestra cuenta.  </li>
  <li>El envío saldrá al domicilio señalado, 24 horas después de confirmado el depósito del pago</li>
  <li>Envío a través de paqueterías certificadas y reconocidas en el mercado.  </li>

  </ul>
  <div>
  <img class="img-patron"src="{{asset('assets/images/Patron_DANATURA-1.jpg')}}" height="500" alt="">

  </div>
  

    

  </div>

  <script type="text/javascript">

	

  </script> 
@endsection