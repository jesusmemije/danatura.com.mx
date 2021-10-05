                              <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="titulo" class="form-control"/>
                            </div>  
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea id="editor" name="cotenido" rows="15" cols="40" class="form-control tinymce-editor">
                                
                                </textarea>
                            </div>  
                            <div class="form-group">
                                <label>Author Name</label>
                                <input type="text" name="autor" class="form-control"/>                           

                            </div>

                            <div class="form-group">
                          

                                <label>Estatus</label>
                                <select name="estatus" id="" class="form-control">
                                <option value="">Selecciona un estatus</option>

                                <option value="pendiente">Pendiente</option>
                                <option value="publicada">Publicada</option>


                                </select>
                            

                            </div>
                            
                            



                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                            </div>


                            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  
    <script type="text/javascript">

   

   // not.item(0).style.display="none"
    
   tinymce.init({
  selector: '#editor',
  plugins: 'image code',

  /* enable title field in the Image dialog*/
  image_title: true,
  /* enable automatic uploads of images represented by blob or data URIs*/
  automatic_uploads: true,
  /*
    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
    images_upload_url: 'postAcceptor.php',
    here we add custom filepicker only to Image dialog
  */
  file_picker_types: 'image',
  /* and here's our custom image picker*/
  file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

    /*
      Note: In modern browsers input[type="file"] is functional without
      even adding it to the DOM, but that might not be the case in some older
      or quirky browsers like IE, so you might want to add it to the DOM
      just in case, and visually hide it. And do not forget do remove it
      once you do not need it anymore.
    */

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

not=document.getElementsByClassName('tox-notifications-container');
    console.log(not)

    </script>