<div class="space-y-4">

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Job Title')</span>
		<input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="name" 
                value=" {{ old('name', $jobTitle->name) }}" required/>
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
                value=" {{ old('description', $jobTitle->description) }}" required/>
        @error('description')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Minimum Salary')</span>
		<input class="{{ Config::get('style.cajaTexto') }} decimales" 
                type="text" 
                name="minimum_salary" 
                value=" {{ old('minimum_salary', $jobTitle->minimum_salary) }}" required/>
        @error('minimum_salary')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Maximum Salary')</span>
		<input class="{{ Config::get('style.cajaTexto') }} decimales" 
                type="text" 
                name="maximum_salary" 
                value=" {{ old('maximum_salary', $jobTitle->maximum_salary) }}" required/>
        @error('maximum_salary')
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
                 @if($jobTitle->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($jobTitle->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>

<script>
    $('.decimales').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
</script>