@extends('front.layout.app')

@section('styles')

<link rel="stylesheet" href="{{asset('assets/css/productos.css')}}">


@endsection

@section('content')


@include('front.layout.partials.secundario')

<div class="container-fluid">

<div class="row">

<div class="col-md-12" >
  <div class="row center-badge">

@foreach ($categorias as $index=>$categoria)
    
<div id="filtro{{$index}}" class="mybadge col-md-1" onclick="filtar({{$categoria->id}},this.id)"> 
  <a >{{$categoria->tipo}}</a>
  </div>

@endforeach

<div id="all" onclick="load_data('','','todos')" class="mybadge active col-md-auto">
  <a>Todos los filtros</a>
  </div>

</div>

  
 



</div>



<div  class="col-md-12" >
  <div id="post_data" class="row "  >
    
    
         
          
  
  
  
  </div>
      
</div>
         
       















</div><!--main row-->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>




</div>


@endsection

@section('scripts')


<script>
  
  function filtar(id,elemento){

    filtro=$('#all');

    //aux.
    $("#filtro0").removeClass('active');
    $("#filtro1").removeClass('active');
    $("#filtro2").removeClass('active');
    $("#filtro3").removeClass('active');
    $("#filtro4").removeClass('active');
    $("#filtro5").removeClass('active');
    $("#all").removeClass('active');

    $("#"+elemento).addClass('active');

    //filtro.removeClass('active');

    $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            }, //datos que se envian a traves de ajax
            url: 'filtrar_productos', //archivo que recibe la peticion
            type: 'post', //método de envio

            success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          
              $('#post_data').empty();
              $('#post_data').append(response);

              
              getallcookies();
            },
            error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

               
            }
        });
      
  }

    var theresponse="";
 
   var contador=0;
   var _token = $('input[name="_token"]').val();
  
   load_data('', _token,'none');
  
   function load_data(id="", _token,filtro)
   {

    //aux.
    $("#filtro0").removeClass('active');
    $("#filtro1").removeClass('active');
    $("#filtro2").removeClass('active');
    $("#filtro3").removeClass('active');
    $("#filtro4").removeClass('active');
    $("#filtro5").removeClass('active');
    $("#all").addClass('active');

  

    

    if(filtro=="todos"){
      getallcookies();
      $('#post_data').empty();
      $('#post_data').append(theresponse);
    }

    
    if(filtro=="boton" || filtro=="none"){
      //si
 

  
      $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            }, //datos que se envian a traves de ajax
            url: 'loadmore', //archivo que recibe la peticion
            type: 'post', //método de envio

            success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
              
          

                $('#load_more_button').remove();
              $('#showpp').remove();
              $('#showpro').remove();
            
              $('#post_data').append(response);

          
              theresponse=response;
              
              
      
              getallcookies();
             
            },
            error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

               
            }
        });
      }
     

    }
    

    
   
    

   
  
   $(document).on('click', '#load_more_button', function(){
    var id = $(this).data('id');
    $('#load_more_button').html('<b>Loading...</b>');
    load_data(id, _token,'boton');
   });
  

  </script>


<script>

var misfav=[];

var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

if(cookieValor!=null || cookieValor!=""){
  ckie= cookieValor.split(',');
  misfav=ckie;
}



function getallcookies(){

var cookieValor = document.cookie.replace(/(?:(?:^|.*;\s*)thecookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");

if(cookieValor!=null || cookieValor!=""){
  ckie= cookieValor.split(',');

  ckie.forEach(element => {
   $('#fav'+element).addClass("press");
   
  });
  console.log(ckie);
}
}

  function fav(dato, id){
      
      $(dato).toggleClass("press", 1000 );

      if($(dato).hasClass('press')){
        misfav.push(id);
        console.log('add');
        document.cookie="thecookie="+misfav;
      }else{
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