<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" required />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Nombre del autor</label>
      <input type="text" name="autor" required class="form-control" />
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Resumen (máximo 150 caracteres)</label>
      <textarea type="text" name="resumen" required class="form-control" maxlength="150" ></textarea>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Estatus</label>
      <select name="estatus" id="" required class="form-control">
        <option value="">Selecciona un estatus</option>
        <option value="pendiente">Pendiente</option>
        <option value="publicada">Publicada</option>
      </select>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label>Imagen de portada</label>
    <div id="myfile" class="input-images"></div>
  </div>
</div>
<br>
<div class="form-group">
  <label>Contenido</label>
  <textarea id="editor"  required name="contenido" rows="15" cols="40" class="form-control tinymce-editor"></textarea>
</div>

<div class="form-group text-center">
  <button type="submit" class="btn btn-success btn-sm">Guardar</button>
  <a type="submit" class="btn btn-sm btn-danger" href="{{ route('blogs.index') }}">Regresar</a>
</div>
