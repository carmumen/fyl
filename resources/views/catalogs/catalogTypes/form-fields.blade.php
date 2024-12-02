<div class="space-y-4">

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Catalog Type')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="name" 
                value=" {{ old('name', $catalogType->name) }}" required/>
        @error('name')
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
                 @if($catalogType->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($catalogType->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>