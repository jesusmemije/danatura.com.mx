<style>
.danatura-logo{

width: 100%;
height: 175px;
}
.logo{
    width:560px;
    height:auto;
    padding-top:5%;
}

#here::placeholder { /* Most modern browsers support this now. */
   color:    white !important;
}

.mia a{
    color: white !important;
}

.mia a:hover{
    color: black !important;
}

.dropdown:hover>.dropdown-menu {
  display: block;
}

.dropdown>.dropdown-toggle:active {
  /*Without this, clicking will make it sticky*/
    pointer-events: none;
}




</style>

<div class="row">



<div class="danatura-logo col-md-5" style="padding-left: 3%;">

<img class="logo img-fluid" src="{{asset('assets/images/Logotipo-09.png')}}" alt="">


</div>

<div class="danatura-content col-md-7">



<div class="row d-flex justify-content-end"  style="padding-right:6%;">
        <div class="col-md-5 mt-5" >
        
            <div class="input-group" >
                
            <div class="buscador">
                <input id="here" style="background-color:#F79860; border:white; color:white"  class="form-control py-2 rounded-pill mr-1 pr-5" type="search" placeholder="Buscar mi producto" id="">
               
              
                <div class="dropdown-buscador">
  
                                <table class="contenido-buscador">
                                <tbody id="myTable">
                                        @foreach ($productos as $producto)
                                        @php $nombre=$producto->nombre; @endphp
                                        <tr>
                                            <td>
                                                <a  href="detalle-producto?producto={{$nombre}}">
                                                {{$producto->nombre}}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                </div>
            </div>
        </div>
    </div>


<div class="row" style="margin-top:8%;" >


<ul class="nav" style="font-size: 20px !important; color:white;">


<li class="nav-item px-4 mia"><a href="{{route('home')}}" >Inicio</a></li>
<li class="nav-item px-4 mia"><a href="{{route('quienes')}}">¿Quiénes somos?</a></li>
<li class="nav-item px-4 mia"><a href="{{route('productos')}}">Productos</a></li>
<li class="nav-item px-4 mia"><a href="{{route('puntos-venta')}}">Puntos de venta</li></a>
<li class="nav-item px-3 mia"><a href="{{route('contacto')}}">Contacto</li></a>
</ul>


</div>


</div>

</div>