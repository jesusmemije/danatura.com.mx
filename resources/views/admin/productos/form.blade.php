@csrf
<label for="nombre">Nombre o producto</label>
<input class="form-control" type="text" id="nombre" name="nombre" value="{{old('nombre',$producto->nombre)}}">
<label for="sabor">Sabor</label>
<input class="form-control" type="text" id="sabor" name="sabor" value="{{old('sabor',$producto->sabor)}}">
<label for="descripcion">Descripción</label>
<input class="form-control" type="text" id="descripcion" name="descripcion" value="{{old('descripcion',$producto->descripcion)}}">
<label for="gramos">Gramos</label>
<input class="form-control" type="text" id="gramos" name="gramos" value="{{old('gramos', $producto->gramos)}}">

<div class="row">
    <div class="col-sm-4">
        <label for="">Precio Normal</label>
        <input class="form-control" type="number" step='0.01' value="{{old('precio', $producto->precio)}}" id="precio" name="precio">
    </div>

    <div class="col-sm-4">
        <label for="precio_nutriologo">Precio Nutriologo</label>
        <input class="form-control" type="number" step='0.01' value="{{old('precio', $producto->precio_nutriologo)}}" id="precio_nutriologo" name="precio_nutriologo">
    </div>
    <div class="col-sm-4">
        <label for="precio_mayorista">Precio Mayorista</label>
        <input class="form-control" type="number" step='0.01' value="{{old('precio', $producto->precio_mayorista)}}" id="precio_mayorista" name="precio_mayorista">
    </div>
</div>

<label for="stock">Stock</label>
<input class="form-control" type="text" id="stock" name="stock" value="{{old('stock', $producto->stock)}}">

<label for="categoria">Categoría</label>
<select class="form-control show-tick" required name="categoria" id="categoria">
    <option value="">Selecciona una</option>
    @foreach($categorias as $categoria)
    @if($categoria->id == $producto->id_categoria)
    <option selected value="{{$categoria->id}}">{{$categoria->tipo}}</option>
    @else
    <option value="{{$categoria->id}}">{{$categoria->tipo}}</option>
    @endif
    @endforeach
</select>

<label for="fotografia">Fotografía(s)</label>

<div class="input-images"></div>

<div class="form-check form-check-inline">
    @if($producto->nuevo==1)
        <input checked class="form-check-input" type="checkbox" id="inlineCheckbox1" name="nuevo">
    @else
        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="nuevo">
    @endif
    <label class="form-check-label" for="inlineCheckbox1">¿Nuevo Producto?</label>
</div>

<input hidden name="galeria" id="galeria" type="text" value="{{$producto->galeria}}">

<hr>
<div class="col-md-12 d-flex justify-content-end">
    @if(isset($up))
        <input class="btn btn-primary" type="submit" value="Actualizar">
    @else
        <input class="btn btn-primary" type="submit" value="Guardar">
    @endif
</div>