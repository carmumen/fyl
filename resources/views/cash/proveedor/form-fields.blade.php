<div class="p-3">
    <div class="form-group-sm">
        <label for="campus_id" class="form-label">Sede:</label>
        <div class="input-group mb-3">
            <input type="hidden" 
                            id="id" 
                            name="id" 
                            value="{{ old('id', $proveedor ? $proveedor->id : '') }}"
                            />
            <select class="form-control form-control-sm"  
                    id="campus_id" 
                    name="campus_id" 
                    required />
                <option value="">-- Seleccione --</option>
                @foreach ($campus as $id => $name)
                    <option value="{{ $id }}" @if ($id == old('campus_id', $proveedor ? $proveedor->campus_id: '')) selected @endif>
                        {{ __($name) }}</option>
                @endforeach
            </select>
            @error('tipo_identidad')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="tipo_identidad" class="form-label">Tipo de Identidad:</label>
        <div class="input-group mb-3">
            <select class="form-control form-control-sm"  
                    id="tipo_identidad" 
                    name="tipo_identidad" 
                    required />
                <option value="1" @if ($proveedor->tipo_identidad == '1') selected @endif>@lang('CÉDULA')</option>
                <option value="2" @if ($proveedor->tipo_identidad == '2') selected @endif>@lang('RUC')</option>
            </select>
            @error('tipo_identidad')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="identidad" class="form-label">Identidad:</label>
        <div class="input-group mb-3">
            <input type="text" 
                    class="form-control form-control-sm" 
                    id="identidad" 
                    name="identidad" 
                    minlength="10"
                    maxlength="13" 
                    onkeypress="return valideKey(event);" 
                    value="{{ old('identidad', $proveedor ? $proveedor->identidad : '') }}"
                    required />
            @error('identidad')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="nombre_comercial" class="form-label">Nombre Comercial:</label>
        <div class="input-group mb-3">
            <input type="text" 
                    class="form-control form-control-sm" 
                    id="nombre_comercial" 
                    name="nombre_comercial"
                    value="{{ old('nombre_comercial', $proveedor ? $proveedor->nombre_comercial : '') }}"
                    required />
            @error('nombre_comercial')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="direccion" class="form-label">Dirección:</label>
        <div class="input-group mb-3">
            <input type="text" 
                    class="form-control form-control-sm" 
                    id="direccion" 
                    name="direccion"  
                    value="{{ old('direccion', $proveedor ? $proveedor->direccion : '') }}"
                     />
            @error('direccion')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="email" class="form-label">Correo Electrónico:</label>
        <div class="input-group mb-3">
            <input type="email" 
                    class="form-control form-control-sm" 
                    id="email" 
                    name="email"  
                    value="{{ old('email', $proveedor ? $proveedor->email : '') }}"
                    oninput="this.value = this.value.toLowerCase();"
                    pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
                    title="Por favor, introduce una dirección de correo electrónico válida"
                     />
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="telefono" class="form-label">Teléfono:</label>
        <div class="input-group mb-3">
            <input type="text" 
                    class="form-control form-control-sm" 
                    id="telefono" 
                    name="telefono"
                    value="{{ old('telefono', $proveedor ? $proveedor->telefono : '') }}"
                    onkeypress="return valideKey(event);"
                     />
            @error('telefono')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group-sm">
        <label for="estado" class="form-label">Estado:</label>
        <div class="input-group mb-3">
            <select class="form-control form-control-sm"  
                    id="estado" 
                    name="estado" 
                    required />
                <option value="ACTIVO" @if ($proveedor->estado == 'ACTIVO') selected @endif>@lang('ACTIVO')</option>
                <option value="INACTIVO" @if ($proveedor->estado == 'INACTIVO') selected @endif>@lang('INACTIVO')</option>
            </select>
            @error('estado')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>


        
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Script de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
<script>

    $('.validador').on('input', function () {
        this.value = this.value.replace(/[^0-9()\/]/g, '');
    });

    $('input').val(function(_, value) {
        return $.trim(value);
    });

    function valideKey(evt) {
        var code = (evt.which) ? evt.which : evt.keyCode;

        if (code == 8) { // backspace.
            return true;
        } else if (code >= 48 && code <= 57) { // is a number.
            return true;
        } else { // other keys.
            return false;
        }
    }

</script>


