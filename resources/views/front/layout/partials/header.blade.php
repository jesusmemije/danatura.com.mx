<style type="text/css">
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
    #menu{
        width: 100%;
        margin: 0;
        padding: 10px 0 0 0;
        list-style: none;  
        background: #F79860;
        -moz-border-radius: 50px;
        border-radius: 50px;
        -moz-box-shadow: 0 2px 1px #9c9c9c;
        -webkit-box-shadow: 0 2px 1px #9c9c9c;
        box-shadow: 0 2px 1px #9c9c9c;
    }

    #menu li{
        float: left;
        padding: 0 0 10px 0;
        position: relative;
    }

    #menu a{
        float: left;
        height: 25px;
        padding: 0 25px;
        color: #111111;
        text-transform: uppercase;
        font: bold 12px/25px Arial, Helvetica;
        text-decoration: none;
        text-shadow: 0 1px 0 #000;
    }

    #menu li:hover > a{
        color: #fafafa;
    }

    *html #menu li a:hover{ /* IE6 */
        color: #fafafa;
    }

    #menu li:hover > ul{
        display: block;
    }

    /* Sub-menu */

    #menu ul{
        list-style: none;
        margin: 0;
        padding: 0;    
        display: none;
        position: absolute;
        top: 35px;
        left: 0;
        z-index: 99999;    
        background: #F79860;   
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    #menu ul li{
        float: none;
        margin: 0;
        padding: 0;
        display: block;  
        -moz-box-shadow: 0 1px 0 #111111, 0 2px 0 #777777;
        -webkit-box-shadow: 0 1px 0 #111111, 0 2px 0 #777777;
        box-shadow: 0 1px 0 #111111, 0 2px 0 #777777;
    }

    #menu ul li:last-child{   
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none;    
    }

    #menu ul a{    
        padding: 10px;
        height: auto;
        line-height: 1;
        display: block;
        white-space: nowrap;
        float: none;
        text-transform: none;
    }

    *html #menu ul a{ /* IE6 */   
        height: 10px;
        width: 150px;
    }

    *:first-child+html #menu ul a{ /* IE7 */    
        height: 10px;
        width: 150px;
    }

    #menu ul a:hover{
            background: #0186ba;
    }

    #menu ul li:first-child a{
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }

    #menu ul li:first-child a:after{
        content: '';
        position: absolute;
        left: 30px;
        top: -8px;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 8px solid #444;
    }

    #menu ul li:first-child a:hover:after{
        border-bottom-color: #04acec; 
    }

    #menu ul li:last-child a{
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
    }

    /* Clear floated elements */
    #menu:after{
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }

    * html #menu             { zoom: 1; } /* IE6 */
    *:first-child+html #menu { zoom: 1; } /* IE7 */

    #menu ul li:first-child a:after{
        content: '';
        position: absolute;
        left: 30px;
        top: -8px;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 8px solid #444;
    }

    #menu ul li:first-child a:hover:after{
        border-bottom-color: #04acec; 
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
          
                <ul id="menu">
                    <li>
                        <a href="#">Hola, {{Auth::user()->name}}</a>
                        <ul>
                            <li><a href="{{route('dashboard')}}">
                            <p style="font-size: 13px">Hola, {{Auth::user()->name}} 
                                <i style="color:#F79860; " class="fas fa-house-user"></i></p>
                            </a>
                            </li>
                            <li><a href="{{route('historial_pedidos.index')}}">
                                <p style="font-size: 13px">
                                    Historial de pedidos
                                    <i style="color:#F79860;"></i>
                                </p>
                            </a></li>
                            <li><a href="#">Otro ejemplo</a></li>
                            <li><a href="{{route('milogout')}}">
                                <p style="font-size: 13px">Cerrar sesión 
                                    <i style="color:#F79860; " class="fas fa-sign-out-alt"></i>
                                </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                @else
                <a href="{{route('login')}}">
        
                    <p>Iniciar sesión  <i style="color:#F79860; " class="fas fa-sign-in-alt"></i></p>
                    </a>
                    
                @endif
            </div>
        </div>
    </div>
</div>