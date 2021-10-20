@extends('admin.layout.app')

@section('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/uploader/image-uploader.min.css')}}">
    <style>
        .tox-notification { display: none !important }
        .tox-statusbar__branding { display: none !important }
        .pull-left {
            float: left !important;
        }
        .pull-right {
            float: right !important;
        }
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
            <strong>Guardado correctamente!</strong> La publicación se ha guardado.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <form id="phase1" class="image-upload" method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.blogs.form')
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
console.log(not)

</script>

<script type="text/javascript" src="{{asset('assets/uploader/image-uploader.min.js')}}"></script>
<script>

$('.input-images').imageUploader({
    preloadedInputName: "assets/blogs/image.jpeg",
    imagesInputName: 'portada',
    label: "Arrastra tu imagen o da click para seleccionarla",
    maxSize: 616 * 425,
    maxFiles: 1,
});

$('#phase1').on('submit', function(event) {

    event.preventDefault();
    var numItems = $('.uploaded-image').length;

    if( numItems == 0 ){
        alert("Debes seleccionar al menos 1 imágen.");
    } else {
        event.currentTarget.submit();
    }

})

var _URL = window.URL || window.webkitURL;
$("#myfile").change(function (e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
            var wid = this.width;
            var ht = this.height;

            alert(this.width + " " + this.height);
            alert(wid);
            alert(ht);
        };

        img.src = _URL.createObjectURL(file);
    }
});

</script>
@endsection