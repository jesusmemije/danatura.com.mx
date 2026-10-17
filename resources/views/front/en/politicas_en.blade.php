@extends('front.layout_en.app')


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
@include('front.layout_en.partials.menu')

  <div class="container" style="margin-top:3%; margin-bottom:2%">

  <h3 style="font-family:'AmasisMTStd-Bold'; margin-bottom:3%; color:#f79860">SHIPPING POLICY </h3>



  <ul style="font-family:'AmasisMTStd-Bold'; margin-bottom:4%; font-size:18px;">

  <li>Shipping from one piece. The larger your order, the lower the cost of shipping. Quote and you will see!!!  </li>
  <li>If your purchase is over $1,200 pesos, shipping is on us.  </li>
  <li>The shipment will go to the indicated address, 24 hours after the payment deposit is confirmed.</li>
  <li>Shipping through certified and recognized parcels in the market.  </li>

  </ul>
  <div>
  <img class="img-patron"src="{{asset('assets/images/Patron_DANATURA-1.jpg')}}" height="500" alt="">

  </div>
  

    

  </div>

  <script type="text/javascript">

	

  </script> 
@endsection