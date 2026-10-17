@extends('front.layout_en.app')



@section('title')

    Search results

@endsection



@section('styles')

<link rel="stylesheet" href="{{asset('assets/css/productos.css')}}">

<style>

  .mybadge {

    line-height: 1.3;

    padding: 10px;

  }

</style>

@endsection



@section('content')

@include('front.layout_en.partials.menu')

<div class="container-fluid">
    

  <div class="row pt-5">

    <div class="col-md-12">

        <div class="text-center">

            <div style="color:#73472b; font-size:4em; font-family: COSMOPOLITAN SCRIPT MEDIUM; line-height:1;">Search results</div>

            <div style="color:#fb985f; font-size:3em; font-family:AmasisMTStd-Bold; line-height:1;">"{{$palabra_busqueda}}"</div>

        </div>

    </div>

    <?php echo $output ?>

  </div>
  <br><br>
  <br><br>

  <!--main row-->

</div>




@endsection



@section('scripts')

<script>
    var misfav=[];

var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

    

if(cookieValor!=null || cookieValor!=""){

  ckie = cookieValor.split(',');

  misfav = ckie;

}



function getallcookies(){



  var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

    

  if(cookieValor!=null || cookieValor!=""){

    ckie= cookieValor.split(',');



    ckie.forEach(element => {

      $('#fav'+element).addClass("press");

    });

    

    // console.log(ckie);

  }

}



function fav(dato, id){

    

  $(dato).toggleClass( "press", 1000 );



  if( $(dato).hasClass('press') ){

    misfav.push(id);

    document.cookie="thecookie="+misfav;

  } else {

      

    for (let index = 0; index < misfav.length; index++) {

        

      if(misfav[index]==id){

        misfav.splice(index,1);

      }



    }



    document.cookie="thecookie="+misfav;

  }

}

</script>



@endsection