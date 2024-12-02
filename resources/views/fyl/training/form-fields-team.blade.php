<div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id" id="training_id"
            value=" {{ old('training_id', $participants->training_id) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($training as $trainings)
            <option value="{{ $trainings->id }}" @if ($trainings->id == old('training_id', $participants->training_id)) selected @endif>
                {{ __($trainings->team_name) }}</option>
        @endforeach
        </select>
        @error('training_id')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="DNI" value=" {{ old('DNI', $participants->DNI) }}"
            required />
        @error('DNI')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names" value=" {{ old('names', $participants->names) }}"
            required oninput="this.value = this.value.toUpperCase();" />
        @error('names')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="surnames"
            value=" {{ old('surnames', $participants->surnames) }}" required oninput="this.value = this.value.toUpperCase();" />
        @error('surnames')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('Nickname')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="nickname"
            value=" {{ old('nickname', $participants->nickname) }}" required oninput="this.value = this.value.toUpperCase();" />
        @error('nickname')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="email" value=" {{ old('email', $participants->email) }}"
            required oninput="this.value = this.value.toLowerCase();" />
        @error('email')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone" value=" {{ old('phone', $participants->phone) }}"
            required />
        @error('phone')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col mx-2 py-1">
        <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status" required />
        <option value="ACTIVE" @if ($participants->status == 'ACTIVE') selected @endif>@lang('ACTIVE')
        </option>
        <option value="INACTIVE" @if ($participants->status == 'INACTIVE') selected @endif>@lang('INACTIVE')
        </option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <br />
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
