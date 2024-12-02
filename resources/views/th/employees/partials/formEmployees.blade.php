<form class="px-8 py-4 bg-white"
            method="POST"
            @if ($accion == 'crear')
                action="{{ route('Employees.store') }}">
                @csrf
            @else
                action="{{ route('Employees.update', $employee) }}">
                @csrf @method('PATCH')
            @endif

            <div class="flex flex-row flex-wrap">

                <div class="flex-1 md:basis-1/3  px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}"
                                type="text"
                                name="DNI"
                                {{-- maxlength="10" --}}
                                onkeypress="return valideKey(event);"
                                value=" {{ old('DNI', $employee->DNI) }}" required/>
                        @error('DNI')
                            <br>
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
                            <br>
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
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>

            </div>

            <div class="flex flex-row flex-wrap">
                <div class="flex-1 md:basis-1/3 px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }} ">@lang('Birthdate')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} datePickerClass"
                                type="text"
                                id="birthdate"
                                name="birthdate"
                                value=" {{ old('birthdate', $employee->birthdate) }}" required/>
                        @error('birthdate')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>

                <div class="flex-1 md:basis-1/3 px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Gender')</span>
                        <select class="{{ Config::get('style.cajaTexto') }}"
                                type="text"
                                name="gender_catalog_id"
                                id="gender_catalog_id"
                                value=" {{ old('gender_catalog_id', $employee->gender_catalog_id) }}" required/>
                                <option value="">-- Seleccione --</option>
                            @foreach($gender as $id => $name)
                                <option value="{{ $id }}"
                                    @if($id == old('gender_catalog_id', $employee->gender_catalog_id)) selected @endif
                                >{{ __($name) }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="flex-1 md:basis-1/3 px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Civil Status')</span>
                        <select class="{{ Config::get('style.cajaTexto') }}"
                                type="text"
                                name="civil_status_catalog_id"
                                id="civil_status_catalog_id"
                                value=" {{ old('civil_status_catalog_id', $employee->civil_status_catalog_id) }}" required/>
                                <option value="">-- Seleccione --</option>
                            @foreach($civil_status as $id => $name)
                                <option value="{{ $id }}"
                                    @if($id == old('civil_status_catalog_id', $employee->civil_status_catalog_id)) selected @endif
                                >{{ __($name) }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>


            </div>

            <div class="flex flex-row">
                <div class="basis-3/4 px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} "
                                type="text"
                                name="address"
                                value=" {{ old('address', $employee->address) }}" required/>
                        @error('address')
                            <br>
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
                                onkeypress="return valideKey(event);"
                                value=" {{ old('phone', $employee->phone) }}" required/>
                        @error('phone')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>
            </div>

            <div class="flex flex-row">
                <div class="basis-3/4 px-4">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} "
                                type="text"
                                name="email"
                                value=" {{ old('email', $employee->email) }}" required/>
                        @error('email')
                            <br>
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
                            <br>
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