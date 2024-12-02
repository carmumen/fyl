<x-app-layout>
    @php
        if (session('entidad') == 'LifeParticipants') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'LifeParticipants']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A���ade 5px de espacio alrededor del contenido */
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Life Participants')
        </h2>
    </x-slot>

    @php
        $pagos = 0;
        $total = 0;
    @endphp


    <header>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-sky-700">
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Participante Jornadas</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Asisti���</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Desert���</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">No asisti���</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" colspan="2">Resumen llamadas
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" colspan="2">Filtro llamadas
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        @if (isset($training) && count($training) > 0)
                            <form id="focus" method="POST" action="{{ route('ReportsPlane.enrollerForTeam') }}">
                                @csrf
                                <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id"
                                    id="training_id" value="" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($training as $trainings)
                                    <option value="{{ $trainings->id }}" {{-- @if ($trainings->id == old('training_id', $participants->training_id)) selected @endif --}}>
                                        {{ __($trainings->name) }}</option>
                                @endforeach
                                </select>
                                @error('training_id')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                                <button class="icon-upload text-2xl text-sky-800 hover:underline"
                                    type="submit"></button>
                            </form>
                        @endif
                    </td>
                    <td class="text-center"><span id="countAsistio"></span></td>
                    <td class="text-center"><span id="countDeserto"></span></td>
                    <td class="text-center"><span id="countNoAsistio"></span></td>
                    <td class="text-center">
                        {{-- @if (isset($follow) && count($follow) > 0)
                            <button id="showPopup" class="text-xl text-sky-800 hover:underline">
                                <span class="icon-image "></span> B
                            </button>
                        @endif --}}
                    </td>
                    <td class="text-center">
                        {{-- @if (isset($follow) && count($follow) > 0)
                            <button id="showPopup1" class="text-xl text-sky-800 hover:underline">
                                <span class="icon-image"></span> L
                            </button>
                        @endif --}}
                    </td>
                    <td class="text-center">
                        {{-- <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                            id="confirm_assistance_B" name="confirm_assistance_B" onchange="submitData()" required />
                        <option value="%">-- Bienvenida --</option>
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            @foreach ($call_B->toArray() as $acronym => $name)
                                <option value="{{ $acronym }}" @if ($acronym == old('confirm_assistance_B', $call_id_B)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        @endif
                        </select> --}}
                    </td>
                    <td class="text-center">
                        {{-- <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                            id="confirm_assistance_L" name="confirm_assistance_L" onchange="submitData()" required />
                        <option value="%">-- Logistica --</option>
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            @foreach ($call_L->toArray() as $acronym => $name)
                                <option value="{{ $acronym }}" @if ($acronym == old('confirm_assistance_L', $call_id_L)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                        @endif --}}
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">

        {{-- @dump($lifeParticipants[0]->level) --}}
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                @if (isset($lifeParticipants) && count($lifeParticipants) > 0)
                    @foreach ($lifeParticipants as $theLifeParticipants)
                        @php
                            $total++;
                            if ($theLifeParticipants->payment_status_focus === 'PAGO TOTAL') {
                                $pagos++;
                            }
                        @endphp
                    @endforeach
                @endif

                <div class="mx-4 py-2">
                    <span class="py-2">Total Fichas: {{ $total }}</span>
                    <br>
                    <span class="py-2">Total Pagos: {{ $pagos }}</span>
                </div>


                <div class="overflow-x-auto">
                    <div id="conResultados">
                        @if (isset($lifeParticipants) && count($lifeParticipants) > 0)

                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="sticky top-0 bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerSequential') }}">
                                            @lang('No.')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Team')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Enroller')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Tel. Enrolador')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('DNI')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Surnames')
                                        </th>
                                        <th scope="col"
                                            class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                            @lang('Names')
                                        </th>
                                        <th scope="col"
                                            class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                            @lang('Nickname')
                                        </th>

                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Estado Pago')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">

                                    @foreach ($lifeParticipants as $theLifeParticipants)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowSequential') }}">
                                                {{ $theLifeParticipants->secuencial }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}">
                                                {{ $theLifeParticipants->equipo }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->ENROLADOR }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theLifeParticipants->phone_enroller }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->DNI }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->surnames }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->names }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->nickname }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->payment_status_focus }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                {{-- {{ $lifeParticipants->links() }} --}}
                            </div>
                        @endif
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>



    <script></script>

</x-app-layout>
