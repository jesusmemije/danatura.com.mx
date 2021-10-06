@extends('admin.layout.app')


<link type="text/css" rel="stylesheet" href="{{asset('assets/uploader/image-uploader.min.css')}}">
 

@section('styles')
<link rel="stylesheet" href="{{asset('assets/js/dropify/css/dropify.min.css')}}">




<style>
    
    .table tbody{
            color:#212529;
        }
      
    .breadcrumb{
        background: #f8f9fc;
        margin-top:-3% !important;
        font-size: 14px;
    }
    .card{
        margin-top:-2% !important;
    }
        
    </style>
@endsection

@section('content')




<div class="col-md-12">
    <div class="card shadow"> 
            
        <div class="card-header">
            @section('pagina-actual','Actualizando producto')
            @section('breadcumb')
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('productos.index')}}">Productos</a></li>
                <li class="breadcrumb-item active">Actualizando</li>
            </ul>

            @endsection
         
           
                       </div>

                       @if (\Session::has('success'))
                       <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
                        <strong>Actualizado correctamente!</strong> El producto se ha actualizado.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif


        <div class="card-body">
            <form id="phase1" action="{{route('productos.update',$producto->id)}}" method="post" enctype="multipart/form-data" >
                
               @include('admin.productos.form')
               @method('put')

            </form>
          

        </div>

    </div>
</div>


@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('assets/uploader/image-uploader.min.js')}}"></script>

<script src="{{asset('assets/js/dropify/js/dropify.js')}}"></script>
<script>

var public_path="{{asset('assets')}}";

var galeria=$('#galeria').val();

var arr_galeria=galeria.split("|");

var preloaded=[];



for (let i in arr_galeria) {

    if(arr_galeria[i]!=""){
    
        preloaded.push({id:i,src:arr_galeria[i]})
}
}



var foto=public_path+"/productos/"+$('#primera_foto').val();






$('.input-images').imageUploader({

imagesInputName: 'fotografia',
preloaded:preloaded,
label: "Arrastra tus imagenes o da click para seleccionarlas",

preloadedInputName: 'old',


});


$(".delete-image").on('click', function(event){
    event.stopPropagation();
    event.stopImmediatePropagation();
    //(... rest of your JS code)
    parent=this.parentNode;
    img=parent.getElementsByTagName('img');
   // console.log(img[0].src);


    for (let i in arr_galeria) {

if(arr_galeria[i]==img[0].src){
    arr_galeria.splice(i, 1);
   
}
}

console.log(arr_galeria.toString());

$('#galeria').val(arr_galeria.join("|"));


});



$('#phase1').on('submit', function(event) {


event.preventDefault();

var numItems = $('.uploaded-image').length;


if(numItems==0){
  alert("Debes seleccionar al menos 1 imágen.");
}else{
  event.currentTarget.submit();
}





})


</script>
@endsection