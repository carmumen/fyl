<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Program')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="name"
                value=" {{ old('name', $programs->name) }}" required/>
        @error('name')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Life Stage')</span>
        <select class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="life_stage"
                value=" {{ old('life_stage', $programs->life_stage) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($life_stages as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('life_stage', $programs->life_stage)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Level')</span>
        <input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="level"
                onkeypress="return valideKey(event);"
                value=" {{ old('level', $programs->level) }}" required/>
        @error('level')
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
                 @if($programs->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE"
                 @if($programs->status =="INACTIVE") selected @endif
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


