@extends('front.layout.app')


<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<style>

.pregunta{
  color: #F79860;
  font-size: 18px;
  
}


.respuesta{
  color: #73482C;
  font-size: 14px;
}

.enviar{
  background: #F79860 !important;
  color: white !important;
}

</style>


@section('content') 

@include('front.layout.partials.secundario')

  <div class="row" style="background:#FFEFD6; padding:5%; text-align:justify; font-family:'AmasisMTStd-Bold';">
    

  
  <div class="col-md-12" >

        <h3 style="color:#F79860; font-weight:bold;">Preguntas frecuentes</h3>
    <h5 style="font-weight:bold; padding-bottom:2%;">Sobre nuestros Productos </h5>

      <p class="pregunta">¿Donde puedo conseguir DaNatura? </p>
    <p class="respuesta">Tienda en línea Danatura 
    Distribuidores Oficiales (Físicos y tiendas en Línea)
    <a style="color:#F79860; font-weight:bold;" href="https://www.amazon.com.mx/"> Amazon México</a>, 
    <a  style="color:#F79860; font-weight:bold;" href="https://www.amazon.com/"> Amazon USA</a>,  
    <a  style="color:#F79860; font-weight:bold;" href="https://www.mercadolibre.com.mx/">Mercado Libre México</a>,  
    <a  style="color:#F79860; font-weight:bold;" href="https://wakkalmarket.com/"> WaKKal USA </a>
    </p>
    <p class="pregunta">Qué permisos y registros tienen los productos DaNatura? </p>
    <p class="respuesta">Todos nuestros productos están dados de alta en COFEPRIS (Comisión Federal para la protección sobre Riesgos Sanitarios que es donde todos los alimentos y suplmentos deben estar inscritos y regulados en México. De igual forma, contamos con registro FDA (Food and Drug Administration) para nuestras ventas en USA. </p>

    <p class="pregunta">¿Todos los productos DaNatura son Veganos?  <br>
<span class="respuesta">Si, todos son libres de todo componenete animal, amigables y en armonía con la naturaleza y el medio ambiente.</span>  
</p>

<p class="pregunta">¿Los productos Danatura son libres de gluten? <br><span  class="respuesta">
Si, son libres de gluten y aptos para personas que tengan intolerancia a la misma (somos aptos para. Celiacos) 
</p>

<p class="pregunta">Con qué certiicaciones cuenta DaNatura? <br><span  class="respuesta">
La gran mayoría de los insumos y superfoods con las que elaboramos nuestros alimentos son certificados orgánicos.  Nuestro registro como marca orgánica está en trámite. Nuestro objetivo sobretodo es priorizar la cualidad natural y real de nuestros alimentos y suplementos, más allá de cualquier certificación. 
</span>
</p>

<p class="pregunta">Es posible conocer la información nutrimental de cada producto? <br><span  class="respuesta">
Por supuesto, todos nuestros alimentos y suplementos cuentan con la tabla nutrimental en la parte de atrás del empaque.</span>
</p>


<p class="pregunta">Cual es la vida de anaquel de los productos DaNatura? <br><span  class="respuesta">
Nuestros Alimentos y Suplementos son deshidratados en polvo a través de una técnica innovadora en conservación de alimentos que elimina o evapora el agua (actividad de agua aw) y conserva los nutrientes intactos. Esto ayuda en la vida de anaquel, que en la gran mayoría de nuestros productos es de 2 y 3 años en óptimas condiciones. 
</span>
</p>

<h5 style="font-weight:bold; padding-bottom:2%; padding-top:2%;">Sobre los pedidos y envíos </h5>
<p class="pregunta">¿Cuales son las opciones de pago de los pedidos? <br>

  <ul>
    <li class="respuesta">Tarjeta de Crédito y/o débito</li>
    <li class="respuesta">Pago en efectivo en Oxxo</li>
    <li class="respuesta">	Transferencia bancaria</li>
  </ul>

</p>

<p class="pregunta">
¿En cuanto tiempo me llegará el pedido? <br><span  class="respuesta">
Tu pedido es enviado en un plazo no mayor a 24 horas una vez validado internamente el pago. Las paqueterías que tenemos contratadas, entregarán el pedido en el domicilio indicado en un plazo de 3 a 5 días hábiles.  
</span>
</p>
<p class="respuesta">
Tienes alguna duda adicional en especial? <span  class="respuesta">Contáctanos!!!</span> <a class="btn btn-light enviar" href="mailto:contacto@danatura.com.mx" >Enviar correo</a>
</p>

      
        </div>

  
  </div>

  <script type="text/javascript">

  </script> 
@endsection