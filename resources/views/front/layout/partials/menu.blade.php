<div class="container-fluid pb-3 bg-header-gris">
    <div class="row">
        <div class="danatura-logo col-md-5 col-12 text-center" style="padding-left: 3%;">
            <a href="{{route('home')}}">
                <img class="logo img-fluid pt-md-4 pt-5" src="{{asset('assets/images/Logotipo-09.png')}}" alt="">
            </a>
        </div>
        <div class="danatura-content col-md-7">
            <!-- Search old -->
            <div class="row" style="margin-top: 20%;">
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
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('blog')}}">Blog</li></a>
                                <li class="nav-item px-4 px-md-3 mia"><a href="{{route('contacto')}}">Contacto</li></a>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>