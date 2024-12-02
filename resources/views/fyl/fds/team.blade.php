<x-app-layout title="FDS" meta-description="FDS">

    <x-slot name="title">
        @lang('FDS')
    </x-slot>

    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit FDS')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('FdsTeam.teamsRegister') }}">
        @csrf
        
        <input type="hidden" name="fds_id" value="{{ $fds->id }}">
        <div class="space-y-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-sky-800">
                    <tr>
                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('FDS')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Training')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Coach')
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100">
                    @if($count > 0)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <span class="mx-2">1er. FDS</span>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="training_id_1FDS"
                                name="training_id_1FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($training as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('training_id_1FDS', optional($fdsTeam->first())->training_id_1FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="DNI_coach_1FDS"
                                name="DNI_coach_1FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($coach as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('DNI_coach_1FDS', optional($fdsTeam->first())->DNI_coach_1FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endif
                    @if($count > 1)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <span class="mx-2">2do. FDS</span>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                id="training_id_2FDS" name="training_id_2FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($training as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('training_id_2FDS', optional($fdsTeam->first())->training_id_2FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="DNI_coach_2FDS"
                                name="DNI_coach_2FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($coach as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('DNI_coach_2FDS', optional($fdsTeam->first())->DNI_coach_2FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endif
                    @if($count > 2)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <span class="mx-2">3er. FDS</span>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                id="training_id_3FDS" name="training_id_3FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($training as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('training_id', optional($fdsTeam->first())->training_id_3FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="DNI_coach_3FDS"
                                name="DNI_coach_3FDS" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($coach as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('DNI_coach_3FDS', optional($fdsTeam->first())->DNI_coach_3FDS)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endif
                    @if($campus_id == 1)
                        <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <span class="mx-2">Academia</span>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <input type="hidden" name="academia" value="14">
                            <span>ENTRENADORES</span>
                            
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}">
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="DNI_coach_academia"
                                name="DNI_coach_academia" >
                                <option value="">-- Seleccione --</option>
                                @foreach ($coach as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('DNI_coach_academia', optional($fdsTeam->first())->DNI_coach_academia)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>


        </div>
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Fds.index', $fds) }}">@lang('To return')</a>

            @error('error')
                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
            @enderror

            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
