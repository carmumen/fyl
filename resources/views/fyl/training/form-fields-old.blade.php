<div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">
    
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" id="campus_id" name="campus_id"
            {{-- value=" {{ old('campus_id', $training->campus_id) }}" --}} required />
        <option value="">-- Seleccione --</option>
        @foreach ($campus as $campusData)
        <option value="{{ $campusData->id }}"
                    @if($campusData->id == old('campus_id', $training->campus_id)) selected @endif
                >{{ __($campusData->name) }}</option>

        @endforeach
        </select>
    </label>

    <label class="flex flex-col py-2">
        <span class="{{ Config::get('style.label') }}">@lang('Team Name')</span>
        <input type="text" id="team_name" name="team_name" class="text-xs"
        value="{{ old('team_name',$training->team_name) }}" required />
        @error('team_name')
            <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col w-32">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " type="text" id="status" name="status" required />
        <option value="ACTIVE">
            @lang('ACTIVE')</option>
        <option value="INACTIVE">
            @lang('INACTIVE')</option>
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
