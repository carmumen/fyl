<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Aplication')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="name" value=" {{ old('name', $Aplication->name) }}" required />
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Description')</span>
        <textarea
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            {{-- type="text"  --}} name="description" required>{{ __(old('description', $Aplication->description)) }}</textarea>
        @error('description')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Icon')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="icon" value=" {{ old('icon', $Aplication->icon) }}" required />
        @error('icon')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Start Path')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="start_path" value=" {{ old('start_path', $Aplication->start_path) }}" required />
        @error('start_path')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Order')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="order" value=" {{ old('order', $Aplication->order) }}" required />
        @error('order')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="state" required />
        <option value="ACTIVE" @if ($Aplication->state == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($Aplication->state == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>
        @error('state')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
</div>
