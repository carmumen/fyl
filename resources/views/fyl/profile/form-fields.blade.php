<div class="space-y-4">
    {{-- <input type="hidden" id="user_id" name="user_id"
                        value=" {{ old('user_id', auth()->id()) }}" /> --}}
                        
                        sdfafasd

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('City')</span>
        <select class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="city_id"
                value=" {{ old('city_id', $campus->city_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($city->toArray() as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('city_id', $campus->city_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="name"
                value=" {{ old('name', $campus->name) }}" required/>
        @error('name')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="address"
                value=" {{ old('address', $campus->address) }}" required/>
        @error('address')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="phone"
                onkeypress="return valideKey(event);"
                value=" {{ old('phone', $campus->phone) }}" required/>
        @error('phone')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        
        <span class="{{ Config::get('style.label') }}">@lang('Facturación')</span>
        
        <div>
        <label style="display: inline-block; margin-right: 10px;">
            <input type="radio" name="facturacion" value="SI" {{ old('facturacion', $campus->facturacion) == 'SI' ? 'checked' : ($campus->facturacion == 'SI' ? 'checked' : '') }}> SI
        </label>
        <label style="display: inline-block;">
            <input type="radio" name="facturacion" value="NO" {{ old('facturacion', $campus->facturacion) == 'NO' || $campus->facturacion != 'SI' ? 'checked' : '' }}> NO
        </label>
        <span style="display: inline-block; color:maroon; font-size: 1rem">Activar para generar facturas para Contifico, solo para ECUADOR</span>
        </div>
        @error('facturacion')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Botón de Pagos')</span>
        <div>
        <label style="display: inline-block; margin-right: 10px;">
            <input type="radio" name="botonPagos" value="SI" {{ old('botonPagos', $campus->botonPagos) == 'SI' ? 'checked' : ($campus->botonPagos == 'SI' ? 'checked' : '') }}> SI
        </label>
        <label style="display: inline-block;">
            <input type="radio" name="botonPagos" value="NO" checked {{ old('botonPagos', $campus->botonPagos) == 'NO' || $campus->botonPagos != 'SI' ? 'checked' : '' }}> NO
        </label>
        <span style="display: inline-block; color:maroon; font-size: 1rem">Activar solo si esta contratado el botón de pagos y previo a confirmar con el área de sistemas</span>
        </div>
        @error('botonPagos')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>


    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} "
                type="text"
                name="status"
                required/>
            <option value="ACTIVE"
                 @if($campus->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE"
                 @if($campus->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

</div>
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


