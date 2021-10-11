<div class="container-fluid pb-3" style="background: #b4c6a0;">
    <div class="row">
        <div class="danatura-logo col-md-5 col-12 text-center" style="padding-left: 3%;">
            <a href="{{route('home')}}">
                <img class="logo img-fluid pt-md-4 pt-5" src="{{asset('assets/images/Logotipo-09.png')}}" alt="">
            </a>
        </div>
        <div class="danatura-content col-md-7">
            <div class="row d-flex justify-content-end pr-md-3 pr-0">
                <div class="col-md-5 mt-5">
                    <div class="input-group justify-content-center">
                        <div class="buscador">
                            <input id="here" class="form-control btn-slider-search px-2 py-2 rounded-pill mr-1 pr-md-5 pr-0"
                                type="search" placeholder="Buscar mi producto" id="">
                            <div class="dropdown-buscador">
                                <table class="contenido-buscador">
                                    <tbody id="myTable">
                                        @foreach ($productos as $producto)
                                        @php $nombre = $producto->nombre; @endphp
                                        <tr>
                                            <td>
                                                <a href="detalle-producto?producto={{$nombre}}">
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
            <div class="row" style="margin-top:8%;">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="#"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
        
                        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('home')}}">Inicio</a></li>
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('quienes')}}">¿Quiénes somos?</a></li>
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('productos')}}">Productos</a></li>
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('puntos-venta')}}">Puntos de venta</li></a>
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('contacto')}}">Contacto</li></a>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>