<div class="space-y-4">
    {{-- <input type="hidden" id="user_id" name="user_id"
                        value=" {{ old('user_id', auth()->id()) }}" /> --}}

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('City')</span>
        <select class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="city_id"
                value=" {{ old('city_id', $focusParticipants->city_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($city->toArray() as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('city_id', $focusParticipants->city_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('focusParticipants')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="name"
                value=" {{ old('name', $focusParticipants->name) }}" required/>
        @error('name')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="address"
                value=" {{ old('address', $focusParticipants->address) }}" required/>
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
                value=" {{ old('phone', $focusParticipants->phone) }}" required/>
        @error('phone')
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
                 @if($focusParticipants->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE"
                 @if($focusParticipants->status =="INACTIVE") selected @endif
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


