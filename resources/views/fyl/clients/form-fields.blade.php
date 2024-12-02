<div class="space-y-4">
    {{-- <input type="hidden" id="user_id" name="user_id"
                        value=" {{ old('user_id', auth()->id()) }}" /> --}}

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('CC / RUC')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="CC_RUC"
        onkeypress="return valideKey(event);"
            value=" {{ old('CC_RUC', $clients->CC_RUC) }}" required />
        @error('CC_RUC')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Business Name')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names_razon_social"
            value=" {{ old('names_razon_social', $clients->names_razon_social) }}" required />
        @error('names_razon_social')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="address"
            value=" {{ old('address', $clients->address) }}" required />
        @error('address')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="email"
            value=" {{ old('email', $clients->email) }}" required oninput="this.value = this.value.toLowerCase();"/>
        @error('email')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>


    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone"
            onkeypress="return valideKey(event);" value=" {{ old('phone', $clients->phone) }}" required />
        @error('phone')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

</div>
<script>
    $('.validador').on('input', function() {
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
