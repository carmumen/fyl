<div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">
    <div class="tabs flex text-sm -mb-0.5">
        <a id="tab1"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg mx-0 activar"
            mostrar="#uno">Datos de Ingreso</a>
        <a id="tab2"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#dos">Datos Laborales</a>
        <a id="tab3"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#tres">Información Personal</a>
        <a id="tab4"
            class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg"
            mostrar="#cuatro">Formación Académica</a>
    </div>

    <div class="views">
        <div id="uno" class="hidden border-2 rounded-b-lg rounded-r-lg activar">
            <form id="formUno" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Employees.update', $employee->id) }}">
                @csrf @method('PATCH')

                <input id="tab1" type="hidden" name="tagName" value="1" />
                <div class="flex flex-row flex-wrap py-2">
                    <div class="flex-1 md:basis-1/3  px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="DNI"
                                minlength="8" maxlength="13" {{-- maxlength="10" --}}
                                onkeypress="return valideKey(event);" value=" {{ old('DNI', $employee->DNI) }}"
                                required />
                            @error('DNI')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="flex-1 md:basis-1/3  px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="surnames"
                                value=" {{ old('surnames', $employee->surnames) }}" required />
                            @error('surnames')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="flex-1 md:basis-1/3  px-4">
                        <label class="flex flex-col ">
                            <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names"
                                value=" {{ old('names', $employee->names) }}" required />
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
                            <input class="{{ Config::get('style.cajaTexto') }} " type="text" name="email"
                                value=" {{ old('email', $employee->email) }}" required />
                            @error('email')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Phome')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone"
                                minlength="8" maxlength="13" onkeypress="return valideKey(event);"
                                value=" {{ old('phone', $employee->phone) }}" required />
                            @error('phone')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('User')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="is_user"
                                required />
                            <option value="NO" @if ($employee->is_user == 'NO') selected @endif>@lang('NO')
                            </option>
                            <option value="SI" @if ($employee->is_user == 'SI') selected @endif>@lang('SI')
                            </option>
                            </select>
                            @error('email')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/4  px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('State')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status"
                                required />
                            <option value="ACTIVE" @if ($employee->status == 'ACTIVE') selected @endif>@lang('ACTIVE')
                            </option>
                            <option value="INACTIVE" @if ($employee->status == 'INACTIVE') selected @endif>
                                @lang('INACTIVE')</option>
                            </select>
                            @error('status')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Employees.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 1)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formUno">Enviar</button>
                </div>
            </form>
        </div>
        <div id="dos" class="hidden border-2 rounded-b-lg rounded-r-lg">
            <form id="formDos" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Employees.update', $employee->id) }}">

                @csrf @method('PATCH')

                <input id="tab2" type="hidden" name="tagName" value="2" />


                <label class="flex flex-col px-4">
                    <input type="hidden" id="employee_id2" name="id"
                        value=" {{ old('id', $employee->id) }}" />
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $employee->names . ' ' . $employee->surnames }}</span>
                </label>

                <label class="flex flex-col px-4 py-2">
                    <span class="{{ Config::get('style.label') }}">@lang('Department')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="department_id"
                        id="department_id" value=" {{ old('department_id', $employee->department_id) }}" required />
                    <option value="">-- Seleccione --</option>
                    @foreach ($department as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('department_id', $employee->department_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>

                <label class="flex flex-col px-4 py-2">
                    <span class="{{ Config::get('style.label') }}">@lang('Job Title')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="job_title_id"
                        id="job_title_id" value=" {{ old('job_title_id', $employee->job_title_id) }}" required />
                    <option value="">-- Seleccione --</option>
                    @foreach ($jobTitle as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('job_title_id', $employee->job_title_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>

                <div class="flex flex-row flex-wrap  py-2">
                    <div class="basis-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Evaluator')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="evaluator" />
                            <option @if ((isset($employee->evaluator) ?: '') == 'NO') selected @endif value="NO">@lang('NO')
                            </option>
                            <option @if ((isset($employee->evaluator) ?: '') == 'SI') selected @endif value="SI">@lang('SI')
                            </option>
                            </select>
                            @error('evaluator')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Entry Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="entry_date" name="entry_date"
                                value=" {{ old('entry_date', $employee->entry_date) }}" />
                            @error('entry_date')
                                <small class="font-bold text-red-500/80 py-0">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="flex-1 md:basis-1/4  px-4">
                        <label class="flex flex-col ">
                            <span class="{{ Config::get('style.label') }}">@lang('Salary')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} decimales" type="text"
                                name="salary" value=" {{ old('salary', $employee->salary) }}" />
                            @error('salary')
                                <br>
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Departure Date')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                name="departure_date"
                                value=" {{ old('departure_date', $employee->departure_date) }}" />
                            @error('departure_date')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>


                <div class="flex flex-row flex-wrap  py-2">
                    <div class="basis-1/2 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Referred By')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} " type="text" name="referred_by"
                                value=" {{ old('referred_by', $employee->referred_by) }}" />
                            @error('referred_by')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/2 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Reference Phome')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="reference_phone" minlength="8" maxlength="13"
                                onkeypress="return valideKey(event);"
                                value=" {{ old('reference_phone', $employee->reference_phone) }}" />
                            @error('reference_phone')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Employees.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 2)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit" form="formDos">Enviar</button>
                </div>
            </form>
        </div>
        <div id="tres" class="hidden border-2 rounded-b-lg rounded-r-lg ">
            <form id="formTres" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Employees.update', $employee->id) }}">

                @csrf @method('PATCH')

                <input id="tab3" type="hidden" name="tagName" value="3" />


                <label class="flex flex-col px-4">
                    <input type="hidden" id="employee_id3" name="id"
                        value=" {{ old('id', $employee->id) }}" />
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $employee->names . ' ' . $employee->surnames }}</span>
                </label>

                <div class="flex flex-row flex-wrap  py-2">
                    <div class="w-1/3 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Birthdate')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                name="birthdate" value=" {{ old('birthdate', $employee->birthdate) }}" required />
                            @error('birthdate')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="w-1/3 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Gender')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="gender_catalog_id" id="gender_catalog_id"
                                value=" {{ old('gender_catalog_id', $employee->gender_catalog_id) }}" required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($gender as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('gender_catalog_id', $employee->gender_catalog_id)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="w-1/3 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Civil Status')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="civil_status_catalog_id" id="civil_status_catalog_id"
                                value=" {{ old('civil_status_catalog_id', $employee->civil_status_catalog_id) }}"
                                required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($civil_status as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('civil_status_catalog_id', $employee->civil_status_catalog_id)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap  py-2">
                    <div class="w-1/3 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('City of Residence')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="city_of_residence" id="city_of_residence"
                                value=" {{ old('city_of_residence', $employee->city_of_residence) }}" required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($city_of_residence as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('city_of_residence', $employee->city_of_residence)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="w-2/3">
                        <label class="flex flex-col px-4 ">
                            <span class="{{ Config::get('style.label') }}">@lang('Home Address')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="address"
                                id="address" value=" {{ old('address', $employee->address) }}" required />
                            @error('address')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap  py-2">
                    <div class="basis-1/2 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact Name')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="emergency_contact"
                                value=" {{ old('emergency_contact', $employee->emergency_contact) }}" required />
                            @error('emergency_contact')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="basis-1/2 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact Phone')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="emergency_contact_phone" minlength="8" maxlength="13"
                                onkeypress="return valideKey(event);"
                                value=" {{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}"
                                required />
                            @error('emergency_contact_phone')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Employees.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 3)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit"
                        form="formTres">Enviar</button>
                </div>
            </form>
        </div>

        <div id="cuatro" class="hidden border-2 rounded-b-lg rounded-r-lg ">
            <form id="formCuatro" class="px-8 py-4 bg-white" method="POST"
                action="{{ route('Employees.update', $employee->id) }}">
                @csrf @method('PATCH')

                <input id="tab4" type="hidden" name="tagName" value="4" />
                <label class="flex flex-col px-4">
                    <input type="hidden" id="employee_id4" name="employee_id"
                        value=" {{ old('id', $employee->id) }}" />
                    <span
                        class="{{ Config::get('style.nameTag') }} ">{{ $employee->names . ' ' . $employee->surnames }}</span>
                </label>
                <div class="flex flex-row flex-wrap py-2">
                    <div class="w-1/3 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Level of study')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="education_level" id="education_level"
                                value=" {{ old('education_level', $employee->education_level) }}" required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($education_level as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('education_level', $employee->education_level)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="flex-1 w-2/3  px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Obtained title')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="specialty"
                                value=" {{ old('specialty', $employee->specialty) }}" required />
                            @error('specialty')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap py-2">
                    <div class="w-full px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('institution')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="institution"
                                value=" {{ old('institution', $employee->institution) }}" required />
                            @error('institution')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap py-2">
                    <div class="w-3/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Country and city')</span>
                            <input class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="country_and_city" value=" {{ old('title', $employee->title) }}" required />
                            @error('title')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <div class="w-1/4  px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }} ">@lang('Ending year')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="ending_year"
                                id="ending_year" value=" {{ old('ending_year', $employee->ending_year) }}"
                                required />
                            <option value="">-- Seleccione --</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 40;
                            @endphp

                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                            </select>
                            @error('ending_year')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="{{ Config::get('style.btnReturn') }}"
                        href="{{ route('Employees.index') }}">@lang('To return')</a>
                    @if (session()->has('tab') && !$errors->any() && session('tab') === 4)
                        <div class="text-green-600 h-3 text-xs">
                            Información actualizada
                        </div>
                    @endif
                    <button class="{{ Config::get('style.btnSave') }}" type="submit"
                        form="formCuatro">Enviar</button>
                </div>
            </form>

            <div class="flex flex-col mt-6 mb-8 px-4">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                        @lang('Level of study')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                        @lang('Obtained title')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                        @lang('institution')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                        @lang('Country and city')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                        @lang('Ending year')
                                    </th>
                                    @auth
                                        <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($academicTraining as $academicTrainings)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowInt') }}">
                                            {{ $academicTrainings->name }}
                                        </td>
                                        <td class="{{ Config::get('style.rowInt') }}">
                                            {{ $academicTrainings->specialty }}
                                        </td>
                                        <td class="{{ Config::get('style.rowInt') }}">
                                            {{ $academicTrainings->institution }}
                                        </td>
                                        <td class="{{ Config::get('style.rowInt') }}">
                                            {{ $academicTrainings->country_and_city }}
                                        </td>
                                        <td class="{{ Config::get('style.rowInt') }}">
                                            {{ $academicTrainings->ending_year }}
                                        </td>
                                        @auth
                                            <td class="w-24 inline-flex text-center py-1.5">
                                                <form
                                                    action="{{ route('AcademicTraining.destroyAcademicTraining', $academicTrainings->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                        onclick="return confirm('¿Seguro que deseas eliminar la formación académica?')">
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
                </main>
            </div>
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

        $(".datePickerClass").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });

        $('input').val(function(_, value) {
            return $.trim(value);
        });

    });

    function cambiaTab(id) {
        $('#tab1').removeClass("activar");
        $('#tab2').removeClass("activar");
        $('#tab3').removeClass("activar");
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
