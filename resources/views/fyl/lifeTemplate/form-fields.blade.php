<div class="space-y-4">

    <div class="flex flex-row flex-wrap">
        <div class="flex-1 pr-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Activity')</span>
                <input class="{{ Config::get('style.cajaTexto') }}"
                        type="text"
                        name="activity"
                        value=" {{ old('activity', $lifeTemplate->activity) }}" required/>
                @error('activity')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="w-16">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Order')</span>
                <input class="{{ Config::get('style.cajaTexto') }}"
                        type="text"
                        name="order" onkeypress="return valideKey(event);"
                        value=" {{ old('order', $lifeTemplate->order) }}" required/>
                @error('order')
                    <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} "
                type="text"
                name="status"
                required/>
            <option value="ACTIVE"
                 @if($lifeTemplate->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE"
                 @if($lifeTemplate->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

</div>
<script>
   $(document).ready(function()
   {
        $('input').val(function(_, value) {
            return $.trim(value);
        });
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
