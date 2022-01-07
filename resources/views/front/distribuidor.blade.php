@extends('front.layout.app')

@section('title')
Distribuidor mayorista
@endsection

@section('styles')
<style>
    .font-contenido {
        color: #73482C;
        font-family: 'AmasisMTStd-Bold';
        padding: 60px 150px;
    }

    ul {
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
                    Conviértete en mayorista y complementa tus ingresos. Si eres nutriólogo, médico o sólo
                    quieres hacer crecer tu inventario con productos novedosos y saludables, los productos
                    Danatura son para ti.
                </p>
            </div>
            <div class="col-md-12">
                <h2>Nuestros planes</h2>
            </div>
            <div class="col-md-6 mt-2">
                <h4 style="color: #F79860;">Distribución Base</h4>
                <ul class="ul-list">
                    <li>Compras superiores o iguales a $3,800 pesos.</li>
                    <li>Compra inicial: 6 extractos de stevia de obsequio.</li>
                    <li>Compras posteriores, desde $2,450 pesos.</li>
                    <li>Envío sin costo.</li>
                    <li>Ganancia del 28% con respecto al precio "Público Sugerido".</li>
                </ul>
                <h4 style="color: #F79860;">Distribución Premium</h4>
                <ul class="ul-list">
                    <li>Compras de $8,500 pesos.</li>
                    <li>Compra inicial: 5% de la compra en muestras.</li>
                    <li>Compras posteriores, desde $4,850 pesos.</li>
                    <li>Envío sin costo.</li>
                    <li>Ganancia del 35% con respecto al precio "Público Sugerido".</li>
                </ul>         
            </div>
            <div class="col-md-6 mt-2">
                <h4 style="color: #F79860;">Precio Especial Nutriólogos</h4>
                <ul class="ul-list">
                    <li>Compra inicial de $3,420 pesos.</li>
                    <li>Compra inicial: 5 extractos de stevia de obsequio.</li>
                    <li>Compras posteriores, desde $2,250 pesos.</li>
                    <li>Envío sin costo.</li>
                    <li>Ganancia del 37% con respecto al precio "Público Sugerido".</li>
                </ul>
                <h4 style="color: #F79860;">Empréndete con DaNatura</h4>
                <ul class="ul-list">
                    <li>Compra inicial de $2,850 pesos.</li>
                    <li>Compra inicial: 3 extractos de stevia de obsequio.</li>
                    <li>Compras posteriores, desde $1,980 pesos.</li>
                    <li>Envío sin costo.</li>
                    <li>Ganancia del 25% con respecto al precio "Público Sugerido".</li>
                </ul>         
            </div>
            <div class="col-md-12 text-center mt-3">
                <a href="mailto:distribuidores@danatura.com.mx?subject=Quiero%20ser%20distribuidor" class="btn btn-mayorista">Quiero ser mayorista</a>
            </div>
        </div>
    </div>
</div>

@endsection