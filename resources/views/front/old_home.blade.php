@extends('front.layout.app')


<style>


.seccion2{
    
    background-image: url('assets/images/Banner Principal.jpg');
    background-repeat: no-repeat;
    background-size: contain;
    border:1px solid red;
    height: 1436px;
    width: 100%;
    font-family: "AmasisMTStd-Bold";

}
.danatura-logo{

    width: 100%;
    height: 175px;
}

.logo{
    width:560px;
     height:auto;
}


::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    white !important;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    white !important;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    white !important;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    white !important;
}
::-ms-input-placeholder { /* Microsoft Edge */
   color:   white !important;
  
}

::placeholder { /* Most modern browsers support this now. */
   color:    white !important;
}


</style>

@section('content')


<div class="container-fluid seccion2">

<div class="row">



<div class="danatura-logo col-md-5" style="padding-left: 3%;">

<img class="logo" src="{{asset('assets/images/Logotipo-09.png')}}" alt="">


</div>

<div class="danatura-content col-md-7" style="border:1px solid yellow; ">


<div>

<div class="row d-flex justify-content-end" >
        <div class="col-md-5 mt-5" >
            <div class="input-group" >
                <input style="background-color:#F79860; border:white; color:white"  class="form-control py-2 rounded-pill mr-1 pr-5" type="search" placeholder="Buscar mi producto" id="">
                <span class="input-group-append">
                    <button class="btn rounded-pill border-0 ml-n5" type="button">
                        <i style="color:white" class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>

</div>

<div class="row" style="margin-top:8%;" >


<ul class="nav" style="font-size: 20px !important; color:white;">


<li class="nav-item px-4">Inicio</li>
<li class="nav-item px-4">¿Quiénes somos?</li>
<li class="nav-item px-4">Productos</li>
<li class="nav-item px-4">Puntos de venta</li>
<li class="nav-item px-3">Contacto</li>
</ul>


</div>


</div>

</div>
</div>


@endsection