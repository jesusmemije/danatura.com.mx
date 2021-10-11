<style>
    @font-face {
        font-family: 'amasis';
        src: url('assets/fonts/amasis.otf') format("opentype");
        font-display: block;
    }

    @font-face {
        font-family: 'AmasisMTStd-Bold';
        src: url('assets/fonts/aa.ttf') format('truetype');
        font-display: block;
    }

    @font-face {
        font-family: 'AmasisMTStd-Black';
        src: url('assets/fonts/AmasisMTStd-Black.otf');
        font-display: block;
    }

    @font-face {
        font-family: 'AmasisMTStd';
        src: url('assets/fonts/AmasisMTStd.otf');
    }

    @font-face {
        font-family: 'COSMOPOLITAN SCRIPT MEDIUM';
        src: url('assets/fonts/COSMOPOLITAN-SCRIPT-MEDIUM.OTF');
    }

    @font-face {
        font-family: 'Roboto-Bold';
        src: url('assets/fonts/Roboto-Bold.otf');
    }

    @font-face {
        font-family: 'Roboto-Regular';
        src: url('assets/fonts/Roboto-Regular.otf');
    }

    .head-barra {



        padding-bottom: 4%;
        background-color: #D7E9C0;
        font-family: "AmasisMTStd-Bold";

    }

    .head-sections {}

    .head-sections-p {}

    .ri-face {

        justify-content: center;

        background-color: #F79860;
        border-radius: 50%;
        font-size: 17px !important;
        color: #fff;
        width: 32px;
        height: 32px;

    }

    .f {
        padding-top: 8px !important;
        padding-left: 10px !important;
    }

    .ii {
        padding-top: 8px !important;
        padding-left: 6px !important;

    }

    .iw {
        padding-top: 7px !important;
        padding-left: 8px !important;

    }

    .id {
        padding-top: 6px !important;
        padding-left: 6px !important;

    }

    /* buscador */
    .buscador {
        position: relative;
        display: inline-block;
    }

    .buscador:hover .dropdown-buscador {
        display: block;
    }

    .dropdown-buscador {
        display: none;
        position: absolute;
        padding: 0;
        z-index: 10;
    }

    .dropdown-buscador table {
        background: #e7e7e7ce;
        width: 100%;
        padding: 0;
        /* padding-bottom: 10px; */
        margin: 0;
        /* margin-top: 40px; */
        box-shadow: 1px 2px 4px rgb(170, 170, 170);
        z-index: 100;
    }

    .dropdown-buscador table tr td a {
        color: rgb(22, 22, 22);
    }
</style>
<div class="container-fluid head-barra">
    <div class="row">
        <div class="col-md-3 col-12 text-center pt-md-4 pt-3">
            <span class="pl-md-4 pl-0" style="color:#4c5444; font-weight:bold">
                <a target="_blank"
                    href="https://api.whatsapp.com/send?phone=+523330238418&text=Hola%2C%20deseo%20adquirir%20información%20acerca%20de%20sus%20productos">Contáctanos
                    (33) 39566141</a>
            </span>
        </div>
    </div>
    <div class="head-sections row">
        <div style="padding-left: 4%;" class="col-md-3 col-12 pt-md-0 pt-3">
            <ul class="nav align-items-center justify-content-center">
                <li class="nav-item" style="margin-right: 2%;"><a href="https://www.facebook.com/DaNaturaComidaReal"
                        target="_blank" class="icon-facebook">
                        <i style="" class="fab fa-facebook-f fa-sm ri-face f"></i></a></li>
                <li class="nav-item" style="margin-right: 2%;"><a href="https://www.instagram.com/Danatura_Comida_Real/"
                        target="_blank" class="icon-instagram">
                        <i style="" class="fab fa-instagram fa-sm ri-face"></i></a></li>
                <li class="nav-item" style="margin-right: 2%;"><a href="" target="_blank" class="icon-instagram">
                        <i style="" class="fab fa-twitter fa-sm ri-face"></i></a></li>
                <li class="nav-item" style="margin-right: 2%;"><a
                        href="https://www.youtube.com/channel/UCt-0ISeB7NilGmMRfs2mVKA" target="_blank"
                        class="icon-instagram">
                        <i style="" class="fab fa-youtube fa-sm ri-face ii"></i></a></li>
                <li class="nav-item" style="margin-right: 2%;"><a
                        href="https://api.whatsapp.com/send?phone=+523330238418&text=Hola%2C%20deseo%20adquirir%20información%20acerca%20de%20sus%20productos"
                        target="_blank" class="icon-instagram">
                        <i style="" class="fab fa-whatsapp fa-sm ri-face iw"></i></a></li>
            </ul>
        </div>
        <div class="col-md-4 col-12 pt-md-0 pt-3" style="color:#4c5444;">
            <ul class="nav align-items-center justify-content-center">
                <li class="nav-item ml-md-auto"><img height="35" src="{{asset('assets/icons/Carrito.png')}}" alt="">
                </li>
                <li class="nav-item" style="padding-top: 6px; font-size:18px;"><a href="{{route('carrito')}}">Mi
                        compra</a></li>
                <li style="padding-left:6%" class="nav-item"><img height="35"
                        src="{{asset('assets/icons/Corazón.png')}}" alt=""></li>
                <li class="nav-item" style="padding-top: 6px; font-size:18px;"><a href="{{route('mis-favoritos')}}">Mis
                        favoritos</a></li>
            </ul>
        </div>
        <div style="color:white; padding-left:5%; " class="col-md-3 col-12 d-flex justify-content-center pt-md-0 pt-3">
            <div class="btn-descarga-catalogo">
                <p>Descarga nuestro catálogo</p>
            </div>
        </div>
        <div class="col-md-2 col-12 d-flex justify-content-center pt-md-0 pt-3">
            <div class="row">
                @if (Auth::user()!=null)
                <a href="{{route('dashboard')}}">
                    <div style="font-size: 13px">Hola, {{Auth::user()->name}} <i style="color:#F79860; "
                            class="fas fa-house-user"></i></div>
                </a>
                <a href="{{route('milogout')}}">
                    <div style="font-size: 13px">Cerrar sesión <i style="color:#F79860; " class="fas fa-sign-out-alt"></i>
                    </div>
                </a>
                @else
                <a href="{{route('login')}}">
                    <div>Iniciar sesión <i style="color:#F79860; " class="fas fa-sign-in-alt"></i></div>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>