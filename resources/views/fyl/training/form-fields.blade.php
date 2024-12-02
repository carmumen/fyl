<div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">
    <div class="tabs flex text-sm -mb-0.5">
        <a id="tab1"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg mx-0 activar"
            mostrar="#uno">@lang('Training')</a>
        <a id="tab2"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#dos">@lang('Focus')</a>
        <a id="tab3"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#tres">@lang('Your')</a>
        <a id="tab7"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#siete">@lang('Life')</a>
        <!--
        <a id="tab4"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#cuatro">@lang('Calendar Life')</a>
        -->
        <a id="tab5"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#cinco">@lang('Team and Motto')</a>
        <a id="tab6"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#seis">@lang('Files')</a>
    </div>

    <div class="views">
        <div id="uno" class="hidden border-2 rounded-b-lg rounded-r-lg activar">
            <form id="formUno" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.update', $training->id) }}">
                @csrf @method('PATCH')

                <input type="hidden" name="tagName" value="1" />

                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="campus_id"
                        value=" {{ old('campus_id', $training->campus_id) }}" required />
                    <option value="">-- Seleccione --</option>
                    @foreach ($campus as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('campus_id', $training->campus_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>


                <div class="flex flex-wrap ">
                    <div class="mt-2">
                        <label class="flex flex-col w-16">
                            <span class="{{ Config::get('style.label') }}">@lang('Number')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="number"
                                onkeypress="return valideKey(event);" value=" {{ old('number', $training->number) }}"
                                required />
                            @error('number')
                                <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>


                <div class="flex flex-wrap ">


                    <div class="mr-4 mt-2">
                        <label class="flex flex-col w-32">
                            <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status"
                                required />
                            <option value="ACTIVE" @if ($training->status == 'ACTIVE') selected @endif>
                                @lang('ACTIVE')</option>
                            <option value="INACTIVE" @if ($training->status == 'INACTIVE') selected @endif>
                                @lang('INACTIVE')</option>
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
                        href="{{ route('Training.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 1)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formUno">Enviar</button>
                </div>
            </form>
        </div>

        <div id="dos" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">

            <form id="formDos" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.update', $training->id) }}">
                @csrf @method('PATCH')

                <input type="hidden" name="tagName" value="2" />
                <input type="hidden" name="form" value="fechaFocus" />
                <input type="hidden" id="id4" name="id" value=" {{ old('id', $training->id) }}" />

                <label class="flex flex-col px-4">
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' FOCUS ' . $training->number . ' ' . $training->team_name }}</span>
                </label>

                <div class="flex flex-row flex-wrap  py-2">

                    <div class="w-40 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="start_date_focus" name="start_date_focus"
                                value=" {{ old('start_date_focus', $training->start_date_focus) }}" />
                            @error('start_date_focus')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="w-40 pl-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="end_date_focus" name="end_date_focus"
                                value=" {{ old('end_date_focus', $training->end_date_focus) }}" />
                            @error('end_date_focus')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formDos">Actualizar
                            Fechas</button>
                    </div>
                </div>
                @if (session()->has('tab') && !$errors->any() && session('tab') === 2 && session('form') === 'fechaFocus')
                    <div class="text-green-600 h-3 text-xs px-4">
                        Fechas actualizadas
                    </div>
                @endif
            </form>

            <div class="flex items-center justify-between mt-4 mb-4">
                <a class="{{ Config::get('style.btnReturn') }}"
                    href="{{ route('Training.index') }}">@lang('To return')</a>
            </div>

            <fieldset class="mx-4 px-8 py-4 border border-solid border-gray-300 p-3">
                <legend class="text-sm">@lang('Team')</legend>
                <form id="formTres" class="bg-white" method="POST"
                    action="{{ route('Training.update', $training->id) }}">
                    @csrf @method('PATCH')

                    <input type="hidden" name="tagName" value="2" />
                    <input type="hidden" name="form" value="teamFocus" />
                    <input type="hidden" name="program" value="Focus" />

                    <input type="hidden" id="training_id" name="training_id"
                        value=" {{ old('training_id', $training->id) }}" />

                    <div class="flex flex-wrap ">
                        <div class="px-4 mr-4">
                            <label class="flex flex-col mt-2 w-48">
                                <span class="{{ Config::get('style.label') }}">@lang('Rol')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} " type="text" id="rolFocus"
                                    name="rol" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($rol as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('rol', $training->rol)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('rol')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="mr-4 mt-2 flex flex-1">
                            <label class="flex flex-col flex flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Member')</span>
                                <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                    id="member_DNI_focus" name="member_DNI"
                                    value=" {{ old('member_DNI', $training->member_DNI) }}" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($member as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('member_DNI', $training->member_DNI)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('member_DNI')
                                    @if (session('form') === 'teamFocus')
                                        <small class="font-bold text-red-500/80 text-xs px-4">{{ $message }}</small>
                                    @endif
                                @enderror
                            </label>
                        </div>
                        <div class="flex items-center justify-between mt-4 px-4">
                            <button class="{{ Config::get('style.btnSave') }}" type="submit"
                                form="formTres">Agregar</button>
                        </div>
                    </div>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 2 && session('form') === 'teamFocus')
                        <div class="text-green-600 h-3 text-xs px-4">
                            Team Creado
                        </div>
                    @endif

                </form>

                <div class="flex flex-col mt-6 mb-8 px-4">
                    <main class="border border-gray-200 md:rounded-lg">
                        <div id="conResultados">
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('DNI')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Rol')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Names')
                                        </th>
                                        @auth
                                            <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($focusTeam as $focusTeams)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $focusTeams->member_DNI }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $focusTeams->rol }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $focusTeams->names }}
                                            </td>
                                            @auth
                                                <td class="w-24 inline-flex text-center py-1.5">
                                                    <form
                                                        action="{{ route('Training.destroyFocusTeam', $focusTeams->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="{{ Config::get('style.btnDelete') }}"
                                                            type="submit"
                                                            onclick="return confirm('¿Seguro que deseas eliminar al {{ $focusTeams->rol }}  {{ $focusTeams->names }}?')">
                                                            <span
                                                                class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @error('teamFocus')
                            <small class="font-bold text-red-500/80 text-xs">{{ $message }}</small>
                        @enderror
                    </main>
                </div>

            </fieldset>
        </div>

        <div id="tres" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">

            <form id="formCuatro" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.update', $training->id) }}">
                @csrf @method('PATCH')

                <input type="hidden" name="tagName" value="3" />
                <input type="hidden" name="form" value="fechaYour" />
                <input type="hidden" name="id" value=" {{ old('id', $training->id) }}" />

                <label class="flex flex-col px-4">
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' YOUR ' . $training->number . ' ' . $training->team_name }}</span>
                </label>

                <div class="flex flex-row flex-wrap  py-2">

                    <div class="w-40 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="start_date_your" name="start_date_your"
                                value=" {{ old('start_date_your', $training->start_date_your) }}" />
                            @error('start_date_your')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="w-40 pl-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="end_date_your" name="end_date_your"
                                value=" {{ old('end_date_your', $training->end_date_your) }}" />
                            @error('end_date_your')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" type="submit"
                            form="formCuatro">Actualizar
                            Fechas</button>
                    </div>
                </div>
                @if (session()->has('tab') && !$errors->any() && session('tab') === 3 && session('form') === 'fechaYour')
                    <div class="text-green-600 h-3 text-xs px-4">
                        Fechas actualizadas
                    </div>
                @endif
            </form>

            <div class="flex items-center justify-between mt-4 mb-4">
                <a class="{{ Config::get('style.btnReturn') }}"
                    href="{{ route('Training.index') }}">@lang('To return')</a>
            </div>

            <fieldset class="mx-4 px-8 py-4 border border-solid border-gray-300 p-3">
                <legend class="text-sm">@lang('Team')</legend>
                <form id="formCinco" class="bg-white" method="POST"
                    action="{{ route('Training.update', $training->id) }}">
                    @csrf @method('PATCH')

                    <input type="hidden" name="tagName" value="3" />
                    <input type="hidden" name="form" value="teamYour" />
                    <input type="hidden" name="program" value="Your" />

                    <input type="hidden" id="training_id" name="training_id"
                        value=" {{ old('training_id', $training->id) }}" />

                    <div class="flex flex-wrap ">
                        <div class="px-4 mr-4">
                            <label class="flex flex-col mt-2 w-48">
                                <span class="{{ Config::get('style.label') }}">@lang('Rol')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} " type="text" id="rolYour"
                                    name="rol" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($rol as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('rol', $training->rol)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('rol')
                                    <small class="font-bold text-red-500/80 text-xs px-4">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="mr-4 mt-2 flex flex-1">
                            <label class="flex flex-col flex flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Member')</span>
                                <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                    id="member_DNI_your" name="member_DNI"
                                    value=" {{ old('member_DNI', $training->member_DNI) }}" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($member as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('member_DNI', $training->member_DNI)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('member_DNI')
                                    @if (session('form') === 'teamYour')
                                        <small class="font-bold text-red-500/80 text-xs px-4">{{ $message }}</small>
                                    @endif
                                @enderror
                            </label>
                        </div>
                        <div class="flex items-center justify-between mt-4 px-4">
                            <button class="{{ Config::get('style.btnSave') }}" type="submit"
                                form="formCinco">Agregar</button>
                        </div>
                    </div>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 3 && session('form') === 'teamYour')
                        <div class="text-green-600 h-3 text-xs px-4">
                            Team Creado
                        </div>
                    @endif

                </form>

                <div class="flex flex-col mt-6 mb-8 px-4">
                    <main class="border border-gray-200 md:rounded-lg">
                        <div id="conResultados">
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('DNI')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Rol')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Names')
                                        </th>
                                        @auth
                                            <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($yourTeam as $yourTeams)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $yourTeams->member_DNI }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $yourTeams->rol }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $yourTeams->names }}
                                            </td>
                                            @auth
                                                <td class="w-24 inline-flex text-center py-1.5">
                                                    <form
                                                        action="{{ route('Training.destroyYourTeam', $yourTeams->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="{{ Config::get('style.btnDelete') }}"
                                                            type="submit"
                                                            onclick="return confirm('¿Seguro que deseas eliminar al {{ $yourTeams->rol }}  {{ $yourTeams->names }}?')">
                                                            <span
                                                                class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @error('teamYour')
                            <small class="font-bold text-red-500/80 text-xs">{{ $message }}</small>
                        @enderror
                    </main>
                </div>

            </fieldset>
        </div>

        <div id="cuatro" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">

            <form id="formSeis" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.calendarLife') }}">
                @csrf

                <input type="hidden" id="tagN4" name="tagName" value="4" />
                <input type="hidden" name="training_id" value="{{ $training->id }}" />

                <label class="flex flex-col px-4">
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' LIFE ' . $training->number . ' ' . $training->team_name }}</span>
                </label>

                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Activity')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="life_template_id"
                        value=" {{ old('life_template_id', $training->life_template_id) }}" required />
                    <option value="">-- Seleccione --</option>
                    @foreach ($lifeTemplate as $id => $activity)
                        <option value="{{ $id }}" @if ($id == old('life_template_id', $training->life_template_id)) selected @endif>
                            {{ __($activity) }}</option>
                    @endforeach
                    </select>
                </label>

                <div class="flex flex-row flex-wrap  py-2">

                    <label class="flex flex-col w-1/4">
                        <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
                        <input type="text" name="start_date" class="w-32 rounded-md datePickerClass"
                            value="{{ old('start_date') }}" />
                        @error('start_date')
                            <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col w-1/4">
                        <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
                        <input type="text" name="end_date" class="w-32 rounded-md datePickerClass"
                            value="{{ old('end_date') }}" />
                        @error('end_date')
                            <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col w-1/4">
                        <span class="{{ Config::get('style.label') }}">@lang('Start Hour')</span>
                        <input type="time" name="start_hour" class="w-32 rounded-md "
                            value="{{ old('start_hour') }}" />
                        @error('start_hour')
                            <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col w-1/4">
                        <span class="{{ Config::get('style.label') }}">@lang('End Hour')</span>
                        <input type="time" name="end_hour" class="w-32 rounded-md "
                            value="{{ old('end_hour') }}" />
                        @error('end_hour')
                            <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                        @enderror
                    </label>

                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Training.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 4)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit"
                        form="formSeis">Enviar</button>
                </div>
            </form>

            <div class="{{ Config::get('style.containerIndex') }}">
                <div class="flex flex-col mt-2 mb-8">
                    <main class="border border-gray-200 md:rounded-lg">
                        <div id="conResultados">
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('Activity')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('Start Date')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('End Date')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('Start Hour')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('End Hour')
                                        </th>
                                        @auth
                                            <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($lifeCalendar as $index => $lifeCalendars)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowLeftSmall') }} h-8">
                                                @if (Str::contains($lifeCalendars->activity, '*'))
                                                    <b>{{ $lifeCalendars->activity }}</b>
                                                @else
                                                    {{ $lifeCalendars->activity }}
                                                @endif
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterSmall') }}">
                                                {{ $lifeCalendars->start_date }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterSmall') }}">
                                                {{ $lifeCalendars->end_date }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterSmall') }}">
                                                {{ $lifeCalendars->start_hour }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterSmall') }}">
                                                {{ $lifeCalendars->end_hour }}
                                            </td>
                                            @auth
                                                <td class="w-24 inline-flex text-center py-1.5">
                                                    <form
                                                        action="{{ route('Training.destroyCalendar', $lifeCalendars->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="{{ Config::get('style.btnDelete') }}"
                                                            type="submit"
                                                            onclick="return confirm('¿Seguro que deseas eliminar la actividad?')">
                                                            <span
                                                                class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                {{-- {{ $training->links() }} --}}
                            </div>
                        </div>
                        <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                        </div>
                    </main>
                </div>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        </div>

        <div id="cinco" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">
            <form id="formSiete" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.update', $training->id) }}">
                @csrf @method('PATCH')


                <input type="hidden" id="tagN5" name="tagName" value="5" />
                <input type="hidden" name="id" value="{{ $training->id }}" />

                <label class="flex flex-col px-4">
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' LIFE ' . $training->number . ' ' . $training->team_name }}</span>
                </label>

                <label class="flex flex-col flex-1 py-2">
                    <span class="{{ Config::get('style.label') }}">@lang('Team Name')</span>
                    <input type="text" name="team_name" class="rounded-md"
                        value="{{ old('team_name', $training->team_name) }}" />
                    @error('team_name')
                        <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                    @enderror
                </label>

                <label class="flex flex-col flex-1 py-2">
                    <span class="{{ Config::get('style.label') }}">@lang('Team Motto')</span>
                    <input type="text" name="team_motto" class="rounded-md"
                        value="{{ old('team_motto', $training->team_motto) }}" />
                    @error('team_motto')
                        <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                    @enderror
                </label>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Training.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 5)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit"
                        form="formSiete">Enviar</button>
                </div>
            </form>
        </div>

        <div id="seis" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">

            <div class="flex flex-wrap">
                <div class="w-1/4">

                    <form id="formNueve" class="px-8 py-4 bg-white" method="POST"
                        action="{{ route('Training.update', $training->id) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        <input type="hidden" name="tagName" value="6" />
                        <input type="hidden" name="form" value="photo" />
                        <input type="hidden" name="id" value=" {{ old('id', $training->id) }}" />

                        <label class="flex flex-col px-4">
                            <span
                                class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' LIFE ' . $training->number . ' ' . $training->team_name }}</span>
                        </label>

                        <label class="flex flex-col py-2">
                            <span class="{{ Config::get('style.label') }}">@lang('Team Photo')</span>
                            <input type="file" name="team_photo" class="text-xs" accept="image/*"
                                value="{{ old('team_photo') }}" />
                            @error('team_photo')
                                <small
                                    class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formNueve">To
                            Register</button>

                        @if (session()->has('tab') && !$errors->any() && session('tab') === 6 && session('form') === 'photo')
                            <div class="text-green-600 h-3 text-xs">
                                Foto registrada
                            </div>
                        @endif
                    </form>
                    <form id="formDiez" class="px-8 py-4 bg-white" method="POST"
                        action="{{ route('Training.update', $training->id) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        <input type="hidden" name="tagName" value="6" />
                        <input type="hidden" name="form" value="deletePhoto" />
                        <input type="hidden" name="id" value=" {{ old('id', $training->id) }}" />
                        @if (str_contains($training->team_photo, 'default'))
                        @else
                            <button class="{{ Config::get('style.btnDelete') }} mb-2" type="submit"
                                onclick="return confirm('¿Seguro que deseas eliminar la Foto?')"
                                form="formDiez">Eliminar</button>
                        @endif
                    </form>
                </div>
                <div class="w-3/4">

                    <div class="w-full  py-2 border-2 flex justify-center">
                        <img width="80%" class=" py-2" src="{{ Storage::url($training->team_photo) }}" />
                    </div>
                </div>
            </div>

            <div class="h-2"></div>

            <div class="flex flex-wrap">
                <div class="w-1/4">
                    <form id="formOcho" class="px-8 py-4 bg-white" method="POST"
                        action="{{ route('Training.update', $training->id) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        <input type="hidden" name="tagName" value="6" />
                        <input type="hidden" name="form" value="directory" />
                        <input type="hidden" name="id" value=" {{ old('id', $training->id) }}" />

                        <label class="flex flex-col py-2">
                            <span class="{{ Config::get('style.label') }}">@lang('Team Directory')</span>
                            <input type="file" name="team_directory" class="text-xs" accept="application/pdf"
                                value="{{ old('team_directory') }}" />
                            @error('team_directory')
                                <small
                                    class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formOcho">To
                            Register</button>

                        @if (session()->has('tab') && !$errors->any() && session('tab') === 5)
                            <div class="text-green-600 h-3 text-xs">
                                Directorio registrado
                            </div>
                        @endif
                    </form>
                    <form id="formOnce" class="px-8 py-4 bg-white" method="POST"
                        action="{{ route('Training.update', $training->id) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        <input type="hidden" name="tagName" value="6" />
                        <input type="hidden" name="form" value="deleteDirectory" />
                        <input type="hidden" name="id" value=" {{ old('id', $training->id) }}" />
                        @if (str_contains($training->team_directory, 'public'))
                            <button class="{{ Config::get('style.btnDelete') }} mb-2" type="submit"
                                onclick="return confirm('¿Seguro que deseas eliminar el Directorio?')"
                                form="formOnce">Eliminar</button>
                        @endif
                    </form>
                </div>
                <div class="w-3/4">
                    <div class="w-full  py-2 border-2 flex justify-center">
                        <iframe src="{{ Storage::url($training->team_directory) }}"
                            style="width: 100%; height: 500px;"></iframe>
                    </div>
                </div>
            </div>

        </div>

        <div id="siete" class="hidden px-8 py-4  border-2 rounded-b-lg rounded-r-lg">
            <form id="formDoce" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Training.update', $training->id) }}">
                @csrf @method('PATCH')

                <input type="hidden" name="tagName" value="7" />
                <input type="hidden" name="form" value="fechaLife" />
                <input type="hidden" id="id7" name="id" value=" {{ old('id', $training->id) }}" />

                <label class="flex flex-col px-4">
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $training->campus . ' LIFE ' . $training->number . ' ' . $training->team_name }}</span>
                </label>
                <p style="text-align:center; color:#FF0000; margin-bottom: 20px">El entrenamiento LIFE inicia el primer día del primer fin de semana y termina el último día del cuarto fin de semana.</p>

                <div class="flex flex-row flex-wrap  py-2">
                    
        

                    <div class="w-40 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="start_date_life" name="start_date_life"
                                value=" {{ old('start_date_life', $training->start_date_life) }}" />
                            @error('start_date_life')
                                <small
                                    class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="w-40 pl-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="end_date_life" name="end_date_life"
                                value=" {{ old('end_date_life', $training->end_date_life) }}" />
                            @error('end_date_life')
                                <small
                                    class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" type="submit"
                            form="formDoce">Actualizar
                            Fechas</button>
                    </div>
                </div>
                @if (session()->has('tab') && !$errors->any() && session('tab') === 7 && session('form') === 'fechaLife')
                    <div class="text-green-600 h-3 text-xs px-4">
                        Fechas actualizadas
                    </div>
                @endif
            </form>

            <div class="flex items-center justify-between mt-4 mb-4">
                <a class="{{ Config::get('style.btnReturn') }}"
                    href="{{ route('Training.index') }}">@lang('To return')</a>
            </div>

            <fieldset class="mx-4 px-8 py-4 border border-solid border-gray-300 p-3">
                <legend class="text-sm">@lang('Team')</legend>
                <form id="formTrece" class="bg-white" method="POST"
                    action="{{ route('Training.update', $training->id) }}">
                    @csrf @method('PATCH')

                    <input type="hidden" name="tagName" value="7" />
                    <input type="hidden" name="form" value="teamLife" />
                    <input type="hidden" name="program" value="Life" />

                    <input type="hidden" id="training_id" name="training_id"
                        value=" {{ old('training_id', $training->id) }}" />

                    <div class="flex flex-wrap ">
                        <div class="px-4 mr-4">
                            <label class="flex flex-col mt-2 w-48">
                                <span class="{{ Config::get('style.label') }}">@lang('Rol')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} " type="text" id="rolLife"
                                    name="rol" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($rol as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('rol', $training->rol)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('rol')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                        <div class="mr-4 mt-2 flex flex-1">
                            <label class="flex flex-col flex flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Member')</span>
                                <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                    id="member_DNI_life" name="member_DNI"
                                    value=" {{ old('member_DNI', $training->member_DNI) }}" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($member as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('member_DNI', $training->member_DNI)) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                                @error('member_DNI')
                                    @if (session('form') === 'teamLife')
                                        <small class="font-bold text-red-500/80 text-xs px-4">{{ $message }}</small>
                                    @endif
                                @enderror
                            </label>
                        </div>
                        <div class="flex items-center justify-between mt-4 px-4">
                            <button class="{{ Config::get('style.btnSave') }}" type="submit"
                                form="formTrece">Agregar</button>
                        </div>
                    </div>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 7 && session('form') === 'teamLife')
                        <div class="text-green-600 h-3 text-xs px-4">
                            Team Creado
                        </div>
                    @endif

                </form>

                <div class="flex flex-col mt-6 mb-8 px-4">
                    <main class="border border-gray-200 md:rounded-lg">
                        <div id="conResultados">
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('DNI')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Rol')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                            @lang('Names')
                                        </th>
                                        @auth
                                            <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($lifeTeam as $lifeTeams)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $lifeTeams->member_DNI }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $lifeTeams->rol }}
                                            </td>
                                            <td class="{{ Config::get('style.rowInt') }}">
                                                {{ $lifeTeams->names }}
                                            </td>
                                            @auth
                                                <td class="w-24 inline-flex text-center py-1.5">
                                                    <form
                                                        action="{{ route('Training.destroyLifeTeam', $lifeTeams->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="{{ Config::get('style.btnDelete') }}"
                                                            type="submit"
                                                            onclick="return confirm('¿Seguro que deseas eliminar al {{ $lifeTeams->rol }}  {{ $lifeTeams->names }}?')">
                                                            <span
                                                                class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @error('teamLife')
                            <small class="font-bold text-red-500/80 text-xs">{{ $message }}</small>
                        @enderror
                    </main>
                </div>

            </fieldset>
        </div>
    </div>

</div>

<style>
    .tabs a.activar {
        background: #ffffff;
        color: #0469A0;
        border-bottom: 1px solid #ffffff;
        font-weight: bold;
    }

    .views .activar {
        display: block !important;
    }
</style>

<script>
    $(document).ready(function() {
        var tab = @php echo json_encode(session('tab', false)); @endphp;

        if (tab) {
            cambiaTab(tab);
        }

        $(".tabs a").on("click", function() {
            var id = $(this).attr("mostrar");

            $(this).addClass("activar").siblings().removeClass("activar");
            $(".views>div").removeClass("activar").siblings(id).addClass("activar");

        });

        var currentDate = new Date();

        $(".datePickerClass").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            minDate: currentDate,
            firstDay: 1
        });

        $('input').val(function(_, value) {
            return $.trim(value);
        });

        $('#rolFocus').on('change', onSelectRolFocusChange);
        $('#rolYour').on('change', onSelectRolYourChange);
        $('#rolLife').on('change', onSelectRolLifeChange);

    });


    function onSelectRolFocusChange() {
        var rolFocus = $('#rolFocus').val();
        var url = '/rolTraining/' + rolFocus;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#member_DNI_focus').empty();
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].DNI + '">' + data[i].name + '</option>';
            $('#member_DNI_focus').html(html_select);
        });
    }

    function onSelectRolYourChange() {
        var rolYour = $('#rolYour').val();
        var url = '/rolTraining/' + rolYour;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#member_DNI_your').empty();
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].DNI + '">' + data[i].name + '</option>';
            $('#member_DNI_your').html(html_select);
        });
    }



    function onSelectRolLifeChange() {
        var rolLife = $('#rolLife').val();
        var url = '/rolTraining/' + rolLife;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#member_DNI_life').empty();
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].DNI + '">' + data[i].name + '</option>';
            $('#member_DNI_life').html(html_select);
        });
    }


    function cambiaTab(id) {
        $('#tab1').removeClass("activar");
        $('#tab2').removeClass("activar");
        $('#tab3').removeClass("activar");
        $('#tab4').removeClass("activar");
        $('#tab5').removeClass("activar");
        $('#tab6').removeClass("activar");
        $('#tab7').removeClass("activar");
        switch (id) {
            case 1:
                $('#tab1').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#uno').addClass("activar");
                break;
            case 2:
                $('#tab2').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#dos').addClass("activar");
                break;
            case 3:
                $('#tab3').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#tres').addClass("activar");
                break;
            case 4:
                $('#tab4').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#cuatro').addClass("activar");
                break;
            case 5:
                $('#tab5').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#cinco').addClass("activar");
                break;
            case 6:
                $('#tab6').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#seis').addClass("activar");
                break;
            case 7:
                $('#tab7').addClass("activar").siblings().removeClass("activar");
                $(".views>div").removeClass("activar").siblings('#siete').addClass("activar");
                break;
        }

    }


    $('.decimales').on('input', function() {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
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
    //employee ocupation
</script>
