<div class="space-y-4">

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Department')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="name" 
                value=" {{ old('name', $department->name) }}" required/>
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Description')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="description" 
                value=" {{ old('description', $department->description) }}" required/>
        @error('description')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " 
                type="text" 
                name="status" 
                required/>
            <option value="ACTIVE" 
                 @if($department->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($department->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>
