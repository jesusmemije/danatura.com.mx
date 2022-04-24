@csrf
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Nombre del descuento"
            value="{{ isset($coupon->titulo) ? $coupon->titulo : old('titulo') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="codigo">Código del cupón</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><strong>#</strong></span>
            </div>
            <input type="text" name="codigo" class="form-control" id="codigo" placeholder="MIPRIMERAVEZ"
                onkeyup="mayusculas(this);" value="{{ isset($coupon->codigo) ? $coupon->codigo : old('codigo') }}" required {{ isset($coupon->codigo) ? 'disabled': '' }}>
            @error('codigo')
                <div class="msg-error">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label for="tipo">Tipo de descuento</label>
        <select name="tipo" id="tipo" class="form-control">
            @php $clt_by_cantidad = false; @endphp
            @if (isset($coupon->tipo))
                @if ($coupon->tipo == 'Cantidad')
                    @php $clt_by_cantidad = true; @endphp
                @endif
            @endif
            <option value="Porcentaje">Por porcentaje (%)</option>
            <option value="Cantidad" {{ $clt_by_cantidad ? 'selected' : '' }}>Por cantidad ($)</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" min="0" class="form-control" id="cantidad" placeholder="Descuento (num)"
            value="{{ isset($coupon->cantidad) ? $coupon->cantidad : old('cantidad') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="status">Status del cupón</label>
        <select name="status" id="status" class="form-control">
            @php $clt_by_inactivo = false; @endphp
            @if (isset($coupon->status))
                @if ($coupon->status == 'Inactivo')
                    @php $clt_by_inactivo = true; @endphp
                @endif
            @endif
            <option value="Activo">Activo - Habilitado</option>
            <option value="Inactivo" {{ $clt_by_inactivo ? 'selected' : '' }}>Inactivo - Inhabilitado</option>
        </select>
    </div>
</div>
<div class="text-center">
    <button class="btn btn-primary" type="submit">
        @if (isset($coupon->id))
            Editar cupón
        @else
            Crear cupón
        @endif
    </button>
</div>
