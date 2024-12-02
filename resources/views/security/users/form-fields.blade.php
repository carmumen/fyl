{{-- @dump($User) --}}
<div class="space-y-4">
    <span style="color:red; padding:5px">Despu&eacute;s de crear un usuario debes solicitar que ingrese con reestablecimiento de contrase&ntilde;a.</span>
    <label class="flex flex-col">
        <span class="font-serif text-slate-600">@lang('Name')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="name" id="name" value=" {{ old('name', $User->name) }}" required />
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="font-serif text-slate-600">@lang('Email')</span>
        <input
            class="rounded-md shadow-sm border-slate-300 text-slate-600 focus:ring focus:ring-slate-300 focus:ring-opacity-50 focus:border-slate-300"
            type="text" name="email" id="email" value=" {{ old('email', $User->email) }}" required />
        @error('email')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="status" id="status" required />
        <option value="ACTIVE" @if ($User->status == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($User->status == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>

        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
