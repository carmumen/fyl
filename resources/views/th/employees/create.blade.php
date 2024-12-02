<x-app-layout {{-- title="Employees" meta-description="Employees" --}}>

    <x-slot name="title">
        @lang('Employees')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Create Employee')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white" >
        <div class="tabs flex text-sm -mb-0.5">
            <a id="tab1" class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg mx-0 activar" mostrar="#uno">Datos de Ingreso</a>
        </div>

        <div class="views">
            <div id="uno" class=" border-2 rounded-b-lg rounded-r-lg activar">
                <form class="px-8 py-4 bg-white"
                    method="POST"
                        action="{{ route('Employees.store') }}">
                        @csrf

                    <input type="hidden" name="tagName" value="1"/>

                    <div class="flex flex-row flex-wrap py-2">
                        <div class="flex-1 md:basis-1/3  px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                                <input class="{{ Config::get('style.cajaTexto') }}"
                                        type="text"
                                        name="DNI"
                                        minlength="8"
                                        maxlength="13"
                                        {{-- maxlength="10" --}}
                                        onkeypress="return valideKey(event);"
                                        value=" {{ old('DNI', $employee->DNI) }}" required/>
                                @error('DNI')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="flex-1 md:basis-1/3  px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                                <input class="{{ Config::get('style.cajaTexto') }}"
                                        type="text"
                                        name="surnames"
                                        value=" {{ old('surnames', $employee->surnames) }}" required/>
                                @error('surnames')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="flex-1 md:basis-1/3  px-4">
                            <label class="flex flex-col ">
                                <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                                <input class="{{ Config::get('style.cajaTexto') }}"
                                        type="text"
                                        name="names"
                                        value=" {{ old('names', $employee->names) }}" required/>
                                @error('names')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                    </div>



                    <div class="flex flex-row py-2">
                        <div class="basis-1/4 px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} "
                                        type="text"
                                        name="email"
                                        value=" {{ old('email', $employee->email) }}" required/>
                                @error('email')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="basis-1/4 px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} "
                                        type="text"
                                        name="phone"
                                        value=" {{ old('phone', $employee->phone) }}" required/>
                                @error('phone')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="basis-1/4 px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('User')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} "
                                        type="text"
                                        name="is_user"
                                        required/>
                                    <option value="NO"
                                        @if($employee->is_user =="NO") selected @endif
                                    >@lang('NO')</option>
                                    <option value="SI"
                                        @if($employee->is_user =="SI") selected @endif
                                    >@lang('SI')</option>
                                </select>
                                @error('is_user')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="basis-1/4  px-4">
                            <label class="flex flex-col">
                                <span class="{{ Config::get('style.label') }}">@lang('State')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} "
                                        type="text"
                                        name="status"
                                        required/>
                                    <option value="ACTIVE"
                                        @if($employee->status =="ACTIVE") selected @endif
                                    >@lang('ACTIVE')</option>
                                    <option value="INACTIVE"
                                        @if($employee->status =="INACTIVE") selected @endif
                                    >@lang('INACTIVE')</option>
                                </select>
                                @error('status')

                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                    </div>


                    <div class="flex items-center justify-between mt-4">
                        <a class="{{ Config::get('style.btnReturn') }}"
                            href="{{ route('Employees.index') }}" >@lang('To return')</a>
                        <button class="{{ Config::get('style.btnSave') }}"
                                type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	{{-- @include('th/Employees.form-fields', ['Employee' => new App\Models\TH\Employee]) --}}
	<div class="flex items-center justify-between mt-4">
		<a class="{{ Config::get('style.btnReturn') }}"
			href="{{ route('Employees.index') }}" >@lang('To return')</a>
		<button class="{{ Config::get('style.btnSave') }}"
				type="submit">Enviar</button>
	</div>

</x-app-layout>
<script>
    function valideKey(evt){
        var code = (evt.which) ? evt.which : evt.keyCode;

        if(code==8) { // backspace.
            return true;
        } else if(code>=48 && code<=57) { // is a number.
            return true;
        } else{ // other keys.
            return false;
        }
    }
</script>
