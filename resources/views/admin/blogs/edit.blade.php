@extends('admin.layout.app')

 
@section('styles')
<link type="text/css" rel="stylesheet" href="{{asset('assets/uploader/image-uploader.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/dropify/css/dropify.min.css')}}">
  <style>
    .tox-notification { display: none !important }
    .tox-statusbar__branding { display: none !important }
  </style>
@endsection

@section('content')

<div class="col-md-12">
    <div class="card shadow">
        <div class="card-header">
            @section('pagina-actual','Nueva publicación')
            @section('breadcumb')
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">
                    <i class="zmdi zmdi-home"></i>Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('blogs.index')}}">Publicaciones</a></li>
                <li class=" breadcrumb-item active">Nuevo</li>
            </ul>
            @endsection
        </div>

        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <strong>Actualizado correctamente!</strong> La publicación se ha guardado.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <form id="phase1" method="POST" action="{{ url('admin/blogs/' .$blogs->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Título</label>
                      <input type="text" name="titulo" class="form-control" value="{{ $blogs->titulo}}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="portada">Portada</label>
                      <div class="input-images"></div>

                      <input hidden name="galeria" id="galeria" type="text" value="{{$blogs->portada}}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nombre del autor</label>
                      <input type="text" name="autor" value="{{ $blogs->autor}}" class="form-control" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Estatus</label>
                      <select name="estatus" id="" class="form-control">
                        <option value="{{ $blogs->estatus}}">{{ $blogs->estatus}}</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="publicada">Publicada</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label>Resumen</label>
                  <input type="text" name="resumen" value="{{ $blogs->resumen}}" class="form-control" maxlength="160" />
                </div>

                <div class="form-group">
                  <label>Contenido</label>
                  <textarea id="editor" name="contenido" rows="15" cols="40" class="form-control tinymce-editor">
                      {{ $blogs->contenido}}
                  </textarea>
                </div>

                <div class="form-group text-center">
                  <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                  <a type="submit" class="btn btn-sm btn-danger" href="{{ route('blogs.index') }}">Regresar</a>
                </div>
            </form>
        </div>
    </div>   
</div>

@endsection
@section('scripts')

<!-- Page level plugins -->
<script src="{{asset('admin_assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('admin_assets/js/demo/datatables-demo.js')}}"></script>

<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>

<script src="https://cdn.tiny.cloud/1/dv3q5uytgmcxyuvxiicg1zsje98bzg2t5x5l98qypkizjawo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="{{asset('assets/uploader/image-uploader.min.js')}}"></script>

<script src="{{asset('assets/js/dropify/js/dropify.js')}}"></script>

<script type="text/javascript">
  // not.item(0).style.display="none"
  tinymce.init({
  selector: '#editor',
  language : 'es',
  height: 500,
  plugins: 'print preview tinymcespellchecker searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
  toolbar: 'spellchecker | formatselect | bold italic strikethrough forecolor backcolor | link | insert | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | print',
  toolbar_mode: 'floating',
  browser_spellcheck: true,
  spellchecker_language: 'es',
  image_title: true,
  /* enable automatic uploads of images represented by blob or data URIs*/
  automatic_uploads: true,
  file_picker_types: 'image',
  file_picker_callback: function (cb, value, meta) {
  var input = document.createElement('input');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/*');
  input.onchange = function () {
  var file = this.files[0];
  var reader = new FileReader();
  reader.onload = function () {
  /*
    Note: Now we need to register the blob in TinyMCEs image blob
    registry. In the next release this part hopefully won't be
    necessary, as we are looking to handle it internally.
  */
  var id = 'blobid' + (new Date()).getTime();
  var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
  var base64 = reader.result.split(',')[1];
  var blobInfo = blobCache.create(id, file, base64);
  blobCache.add(blobInfo);
  /* call the callback and populate the Title field with the file name */
  cb(blobInfo.blobUri(), { title: file.name });
  };
  reader.readAsDataURL(file);
  };
  input.click();
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  });
  not = document.getElementsByClassName('tox-notifications-container');
  console.log(not);

</script>
  

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



var foto=public_path+"/blogs/"+$('#primera_foto').val();






$('.input-images').imageUploader({

imagesInputName: 'portada',
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
   console.log(img[0].src);


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