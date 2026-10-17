@extends('front.layout.app')



@section('title')

Wholesale distributor

@endsection



@section('styles')

<style>

    .font-contenido {

        color: #73482C;

        font-family: 'AmasisMTStd-Bold';

        padding: 60px 150px;

    }



    .ul-list {

        padding: unset;

        padding-left: 14px!important;

    }



    .ul-list li {

        color: #000;

    }



    .ul-list li::marker {

        color: #F79860;

    }



    .btn-mayorista {

        color: #fff;

        background-color: #F79860;

        padding: .25rem 3rem;

        border-radius: 5rem;

    }



    .btn.focus, .btn:focus {

        box-shadow: unset;

    }



    @media screen and (max-width: 620px) {

        .font-contenido {

            padding: 30px 30px;

        }

    }



</style>

@endsection



@section('content')



@include('front.layout.partials.menu')



<div style="background-image: url('/assets/images/background.png');">

    <div class="row mx-0">

        <img src="{{ asset('assets/images/distribuidor/banner.png') }}" class="img-fluid" alt="">

    </div>

    <div class="container font-contenido">

        <div class="row">

            <div class="col-md-12">

                <p class="pb-2" style="font-size: 18px; border-bottom: 4px #F4D0B0 solid;">

                    Become a wholesaler and supplement your income. If you are a nutritionist, doctor or just

                    want to grow your inventory with new and healthy products, the products

                    Danatura are for you.

                </p>

            </div>

            <div class="col-md-12">

                <h2>Our plans</h2>

            </div>

            <div class="col-md-6 mt-2">

                <h4 style="color: #F79860;">Base Distribution</h4>

                <ul class="ul-list">

                    <li>Purchases greater than or equal to $184.93 USD.</li>

                    <li>Initial purchase: 6 free stevia extracts.</li>

                    <li>Subsequent purchases, from $119.23 USD.</li>

                    <li>Free shipping.</li>

                    <li>Profit of 28% with respect to the "Suggested Public" price.</li>

                </ul>

                <h4 style="color: #F79860;">Premium Distribution</h4>

                <ul class="ul-list">

                    <li>Purchases of $413.65 USD.</li>

                    <li>Initial purchase: 5% of the purchase in samples.</li>

                    <li>Subsequent purchases, from $236.02 USD.</li>

                    <li>Free shipping.</li>

                    <li>Profit of 35% with respect to the "Suggested Public" price.</li>

                </ul>         

            </div>

            <div class="col-md-6 mt-2">

                <h4 style="color: #F79860;">Special Price Nutritionists</h4>

                <ul class="ul-list">

                    <li>Initial purchase of $166.43 USD.</li>

                    <li>Initial purchase: 5 free stevia extracts.</li>

                    <li>Subsequent purchases, from $109.50 USD.</li>

                    <li>Free shipping.</li>

                    <li>Profit of 37% with respect to the "Suggested Public" price.</li>

                </ul>

                <h4 style="color: #F79860;">Get started with DaNatura</h4>

                <ul class="ul-list">

                    <li>Initial purchase of $138.69 USD.</li>

                    <li>Initial purchase: 3 free stevia extracts.</li>

                    <li>Subsequent purchases, from $96.36 USD.</li>

                    <li>Free shipping.</li>

                    <li>Profit of 25% with respect to the "Suggested Public" price.</li>

                </ul>         

            </div>

            <div class="col-md-12 text-center mt-3">
                @php
                    $numeros_mayoristas = DB::table('numeros_whatsapp')
                    ->whereIn('id',[6,7])
                    ->get();
                    // dd($numeros_mayoristas);
                @endphp
                @if (count($numeros_mayoristas)==0)
                    
                @else
                    @foreach ($numeros_mayoristas as $numeros_may)
                        @if ($numeros_may->id==6)
                            <a href="mailto:{{$numeros_may->descripcion_whatsapp}}?subject={{$numeros_may->area_whatsapp}}" class="btn btn-mayorista mb-2">
                                <img width="30px" src="{{asset('assets/images/gmail.png')}}" style="background: #fff;border-radius: 100%" alt="">
                                {{$numeros_may->area_whatsapp}}
                            </a>
                            
                        @elseif($numeros_may->id==7)
                            <a href="{{$numeros_may->link_whatsapp}}" class="btn btn-mayorista mb-2">
                                {{$numeros_may->area_whatsapp}}
                                <img width="30px" src="{{asset('assets/images/whastlogo.png')}}" alt="">
                            </a>
                            
                        @endif
                        
                    @endforeach
                @endif

            </div>

        </div>

    </div>

</div>



@endsection