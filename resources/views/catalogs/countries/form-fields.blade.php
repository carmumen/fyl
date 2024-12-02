<div class="space-y-4">

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Acronym')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="acronym" 
                value=" {{ old('acronym', $country->acronym) }}" required/>
        @error('acronym')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Area Code')</span>
		<input class="{{ Config::get('style.cajaTexto') }} validador" 
                type="text" 
                name="area_code" 
                value=" {{ old('area_code', $country->area_code) }}" required/>
        @error('area_code')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Name')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="name" 
                value=" {{ old('name', $country->name) }}" required/>
        @error('name')
            <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Tax Haven')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " 
                type="text" 
                name="tax_haven" 
                required/>
            <option value="NO" 
                 @if($country->tax_haven =="NO") selected @endif
            >@lang('NO')</option>
            <option value="SI" 
                 @if($country->tax_haven =="SI") selected @endif
            >@lang('SI')</option>
        </select>
        @error('tax_haven')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " 
                type="text" 
                name="status" 
                required/>
            <option value="ACTIVE" 
                 @if($country->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($country->status =="INACTIVE") selected @endif
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
</script>