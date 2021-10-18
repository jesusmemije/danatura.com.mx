<div class="form-group">
  <label>Título</label>
  <input type="text" name="titulo" class="form-control" />
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Nombre del autor</label>
      <input type="text" name="autor" class="form-control" />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Estatus</label>
      <select name="estatus" id="" class="form-control">
        <option value="">Selecciona un estatus</option>
        <option value="pendiente">Pendiente</option>
        <option value="publicada">Publicada</option>
      </select>
    </div>
  </div>
</div>

<div class="form-group">
  <label>Contenido</label>
  <textarea id="editor" name="contenido" rows="15" cols="40" class="form-control tinymce-editor"></textarea>
</div>

<div class="form-group text-center">
  <button type="submit" class="btn btn-success btn-sm">Guardar</button>
</div>

<style>
  .tox-notification { display: none !important }
  .tox-statusbar__branding { display: none !important }
</style>

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