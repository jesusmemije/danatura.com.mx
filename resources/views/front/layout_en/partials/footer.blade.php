<div class="container-fluid" style="height:340px; background:#D7E9C0; padding-top:5%; height:auto">
  <div class="row">
    <div class="col-md-2 col-12 text-md-left text-center"> <img width="180" src="{{asset('assets/icons/Manos-15.png')}}" alt=""> </div>
    <style>
      .ri-face {
        background-color: #F79860;
        border-radius: 50%;
        padding: 8px;
        color: #fff;
        width: 32px;
        height: 32px;
      }
    </style>
    <div style="padding-left: 2%;  padding-top:3%;" class="col-md-2">
      <ul class="nav align-items-center justify-content-center">
        <li class="nav-item" style="margin-right: 2%; "><a href="https://www.facebook.com/DaNaturaComidaReal"
            target="_blank" class="icon-facebook"> <i style="font-size:22px;"
              class="fab fa-facebook-f fa-sm ri-face f"></i></a></li>
        <li class="nav-item" style="margin-right: 2%;"><a href="https://www.instagram.com/Danatura_Comida_Real/"
            target="_blank" class="icon-instagram"> <i style="font-size:20px;"
              class="fab fa-instagram fa-sm ri-face"></i></a></li>
        <li class="nav-item" style="margin-right: 2%;"><a 
              href="https://vm.tiktok.com/ZM8YSFf8H/" target="_blank" class="icon-instagram"> <i
              style="font-size:20px;" class="fab fa-tiktok fa-sm ri-face"></i></a></li>
        <li class="nav-item" style="margin-right: 2%;"><a
            href="https://www.youtube.com/channel/UCt-0ISeB7NilGmMRfs2mVKA" target="_blank" class="icon-instagram"> <i
              style="font-size:17px;" class="fab fa-youtube fa-sm ri-face ii"></i></a></li>
        <li class="nav-item" style="margin-right: 2%;"><a
            href="https://api.whatsapp.com/send?phone=+523320561776&text=Hola%2C%20deseo%20adquirir%20información%20acerca%20de%20sus%20productos"
            target="_blank" class="icon-instagram">
            <i style="" class="fab fa-whatsapp fa-sm ri-face iw"></i></a></li>
      </ul>
      <div class="row d-flex justify-content-center" style="margin-top:8%; font-family:AmasisMTStd-Bold;">
        <div class="text-center" onclick="location.href='/distributor'" style="cursor: pointer;position: relative;">
          Do you want to be a distributor?  <img height="35" src="{{asset('assets/icons/corazon_blanco.png')}}" style="position: absolute;right:30px;top: 15px;"><br>
          <a href="{{ route('distribuidor_en') }}">
            <i class="far fa-id-card fa-sm ri-face id"></i>
          </a>
        </div>
      </div>
    </div>

    <style>
      .cls8 {
        color: #4c5444;
      }
    </style>

    <div style=" padding-top:1%; " class="col-md-2">
      <ul class="cls8" style="list-style: none; font-family:AmasisMTStd-Bold; font-weight:900;">
        <a href="{{route('home_en')}}">
          <li>Home</li>
        </a>
        <a href="{{route('quienes_en')}}">
          <li>Mission and vision</li>
        </a>
        <li>Programs and courses</li>
      </ul>
    </div>
    <div style="padding-top:1%;" class="col-md-2">
      <ul class="cls8" style="list-style: none; font-family:AmasisMTStd-Bold;">
        <a href="{{route('politicas_en')}}">
          <li>Phipping policy</li>
        </a>
        <a href="{{route('FQA_en')}}">
          <li>Frequent questions</li>
        </a>
        <a href="{{route('dudas-comentarios_en')}}">
          <li>Doubts and comments</li>
        </a>
      </ul>
    </div>
    <div style="padding-top:1%;" class="col-md-2">
      <ul class="cls8" style="list-style: none; font-family:AmasisMTStd-Bold;">
        <a href="{{route('puntos-venta_en')}}">
          <li>Points of sale</li>
        </a>
        <li>Blog</li>
      </ul>
    </div>
    <style>
      .contenido_whatsapp{
        position: fixed;
        background: red;
        bottom: 130px;
        right: 90px;
        z-index: 10;
      }
      .contenido_w, .button, .nav-w {
        position: absolute;

      }
      .contenido_w {
        margin: auto;
        right: 40px;
        /* top: 10%;
        left: 10%;
        margin-left: -20px; */
      }
      #toggle{
        display: none;
      }
      .button{
        z-index: 1500;
        width: 80px;
        height: 80px;
        /* background: #f28482; */
        /* border-radius:100%; */
        transition: all 0.5s ease-in-out; 
        /* box-shadow: 1px 3px 10px 0 rgba(0,0,0,0.3); */
        cursor: pointer;
      }
      /* .button::before{
        position: absolute;
        top: 20px;
        left:  9px;
        content: '';
        width: 25px;
        height: 2px;
        background: #fff;
        transform: rotate(90deg);
      }
      .button::after{
        position: absolute;
        top: 20px;
        right:9px;
        content:'';
        width: 25px;
        height: 2px;
        background: #fff;
      } */
      .nav-w{
        transform: translateY(10%);
        opacity: 0;
        top: 13px;
        left: -140px;
        transition: all 0.5s ease-in-out;
        background: #fff;
        width: 250px;
        border-radius: 5px;
        transform: translateY(0%);
        box-shadow: -4px 4px 10px 1px rgba(0,0,0,0.1);
        padding: 15px;
        z-index: 50;
      }
      .nav-w a{
        text-align: left;
        display: block;
        margin-top: 8px;
        color: #fff;
        text-decoration: none;
        font-family: sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 20px;
        background: #F79860;
        font-family:AmasisMTStd-Bold;
        position: relative;

      }
      
      #toggle:checked ~ .nav-w{
        opacity: 1;
        transform: translateY(-110%);
      }
      #toggle:checked ~ .button{
        transform: rotate(135deg);
        box-shadow: 0 0 0 0 transparent;
      }

      
    
    </style>

    @php
        $numeros_atencion = DB::table('numeros_whatsapp')
        ->whereNotIn('id',[6,7])
        ->get();
    @endphp
    <div class="contenido_whatsapp">
      <div class="contenido_w">
        <input type="checkbox" id="toggle">
        <label for="toggle" class="button">
            <img width="100%" src="{{asset('assets/images/whastlogo.png')}}" alt="">
        </label>
        <nav class="nav-w">
          <center>
            <p style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; line-height:95%;">Can
              specify or assemble your order with our advice by whatsapp</p>
          </center>
          <hr style="background: #000;margin: 2px;width: 100%;">
          @if (count($numeros_atencion)==0)
            No options
          @else
            @foreach ($numeros_atencion as $numero_atencion)
              <span style="width: 95%;">
                <a href="{{$numero_atencion->link_whatsapp}}" target="_blank">
                  {{$numero_atencion->area_whatsapp}}
                </a>
                <p style="color: #000;font-size: 11px; line-height: 120%; margin-right: 3px;text-align: right">{{$numero_atencion->descripcion_whatsapp}}</p>
              </span>
                
            @endforeach
              
          @endif
  
        </nav>

      </div>
    </div>

    <div class="col-md-12 d-flex justify-content-end">
      <div class="contenedor-imagenes">
        <img src="{{asset('assets/images/mercadopago.png')}}" class="img-fluid" style="height: 46px">
        <img src="{{asset('assets/images/capmedios.png')}}" class="img-fluid w-100">
      </div>
    </div>
    <div class="col-md-12 text-center" style="margin-top:4%; height:70px; background:#b3c6a0; display:flex; justify-content:center;">
      <span style="padding-top:2%; color:#4c5444; font-family:AmasisMTStd-Bold; ">
        Privacy Notice | Terms and conditions © 2021, All rights reserved.
      </span>
    </div>
  </div>
</div>