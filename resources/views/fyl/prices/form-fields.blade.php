<div class="space-y-4">

    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1; margin-right: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                <select class="{{ Config::get('style.cajaTexto') }} w-full" type="text" name="campus_id" value="{{ old('campus_id', $prices->campus_id) }}" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($campus as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('campus_id', $prices->campus_id)) selected @endif>{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Program')</span>
                <select class="{{ Config::get('style.cajaTexto') }} w-full" type="text" name="program_id" value="{{ old('program_id', $prices->program_id) }}" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($programs as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('program_id', $prices->program_id)) selected @endif>{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1; margin-right: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Description')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="description"
                    value=" {{ old('description', $prices->description) }}" required />
                @error('description')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Programs')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="programs_included"
                    value=" {{ old('programs_included', $prices->programs_included) }}" required />
                @error('programs_included')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Currency')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="catalogo_id_currency"
            value=" {{ old('catalogo_id_currency', $prices->catalogo_id_currency) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($currency->toArray() as $id => $name)
            <option value="{{ $id }}" @if ($id == old('catalogo_id_currency', $prices->catalogo_id_currency)) selected @endif>{{ __($name) }}
            </option>
        @endforeach
        </select>
    </label>

    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1; margin-right: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Price Type')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="catalogo_id_price_type"
                    value=" {{ old('catalogo_id_price_type', $prices->catalogo_id_price_type) }}" required />
                <option value="">-- Seleccione --</option>
                @foreach ($price_type->toArray() as $id => $name)
                    <option value="{{ $id }}" @if ($id == old('catalogo_id_price_type', $prices->catalogo_id_price_type)) selected @endif>{{ __($name) }}
                    </option>
                @endforeach
                </select>
            </label>
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Price')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" type="text" id="price" name="price"
                    value=" {{ old('price', $prices->price) }}"  oninput="validateInput(this)" required/>
                @error('price')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>
    
    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1; margin-right: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Relación Contífico')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="id_contifico" id="id_contifico">
                    <option value="">-- Seleccione --</option>
                    @foreach ($contifico as $id => $nombre)
                        <option value="{{ $id }}" @if($id == old('id_contifico', $prices->id_contifico)) selected @endif>
                            {{ __($nombre) }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        
        <div style="flex: 1; margin-left: 10px;">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Precio Contífico')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" id="pvp_contifico" name="pvp_contifico">
                    <option value="">-- Seleccione --</option>
                </select>
            </label>
        </div>
    </div>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status" required />
        <option value="ACTIVE" @if ($prices->status == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($prices->status == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        contificoChange(); // Llama a la función para que se ejecute al cargar la página
        
        $('#id_contifico').change(function() {
            contificoChange(); // Llama a la función cuando haya un cambio en el select #id_contifico
        });
        
        $('#pvp_contifico').change(function() {
            var pvp_contifico = $(this).find('option:selected').text();
            var valores = pvp_contifico.split(': ');
            var pvp = valores[1];
            $('#price').val(pvp);
        });
    });
    
    function contificoChange()
    {
        var id_contifico = $('#id_contifico').val();
        $.ajax({
            url: "{{ route('Contifico.ConsultaPrecios', ['id' => '__id__']) }}".replace('__id__', id_contifico),
            method: 'GET',
            data: {id_contifico: id_contifico},
            success: function(response) {
                $('#pvp_contifico').empty();
                
                // Añadimos la opción por defecto
                $('#pvp_contifico').append('<option value="">-- Seleccione --</option>');
                
                // Iteramos sobre el array y creamos las opciones
                $.each(response, function(key, value) {
                    $('#pvp_contifico').append('<option value="' + key + '">' + key + ': ' + value + '</option>');
                });
                
                // Si hay un valor seleccionado previamente, seleccionarlo nuevamente
                var selectedValue = "{{ old('pvp_contifico', $prices->pvp_contifico) }}";
                if (selectedValue !== '' && id_contifico == "{{ $prices->id_contifico }}") {
                    $('#pvp_contifico').val(selectedValue);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>


<script>
    $('.validador').on('input', function() {
        this.value = this.value.replace(/[^0-9()\/]/g, '');
    });

    $('input').val(function(_, value) {
        return $.trim(value);
    });

    function validateInput(input) {
        // Eliminar todos los caracteres excepto números y el punto decimal
        input.value = input.value.replace(/[^0-9.]/g, '');

        // Si hay más de un punto decimal, eliminar los extras
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, '');
        }
    }

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
