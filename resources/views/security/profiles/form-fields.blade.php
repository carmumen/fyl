<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Aplication')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="aplication_id" id="aplication_id"
            value=" {{ old('aplication_id', $profile->aplication_id) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($aplication as $id => $name)
            <option value="{{ $id }}" @if ($id == old('aplication_id', $profile->aplication_id)) selected @endif>{{ __($name) }}
            </option>
        @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="font-serif text-slate-600">@lang('Name')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="name" id="name" value=" {{ old('name', $profile->name) }}" required />
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="state" required />
        <option value="ACTIVE" @if ($profile->state == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($profile->state == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>
        @error('state')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
</div>
