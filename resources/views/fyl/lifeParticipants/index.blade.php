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
            /* Añade 5px de espacio alrededor del contenido */
        }
        .focus-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Life Participants')
        </h2>
    </x-slot>



    <header>
        <div class="flex flex-wrap justify-between">
            <div class=" p-1">
                @if (isset($trainingNext) && count($trainingNext) > 0)
                    <form id="focusNext" method="POST" class="flex items-center space-x-2"
                        action="{{ route('LifeParticipants.storeNext') }}">
                        @csrf
                        <select class="{{ Config::get('style.cajaTexto') }} focus-select" name="training_id_next"
                            id="training_id_next" required>
                            <option value="">--Seleccione FOCUS en Juego--</option>
                            @foreach ($trainingNext as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id_next', $trainingIdNext)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <div class=" p-1">
                @if (isset($training) && count($training) > 0)
                    <form id="life" method="POST" class="flex items-center space-x-2"
                        action="{{ route('LifeParticipants.store') }}">
                        @csrf
                        <input type="hidden" name="training_id_next" value="{{ $trainingIdNext }}" />
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="training_id"
                            id="training_id" required>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                        <button class="icon-upload text-2xl text-sky-800 hover:underline" type="submit"
                            form="life"></button>
                    </form>
                @endif
                <div class="px-2 mt-2">
                    @if (isset($rezagados) && count($rezagados) > 0)
                        <form  method="POST" action="{{ route('LifeParticipants.left_over') }}">
                            @csrf
                            
                            <input type="hidden" name="training_in_game" value="{{ $trainingIdNext }}" />
                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />

                            <select class="{{ Config::get('style.cajaTexto') }}" style="width:70%" type="text"
                                id="dni_rezagado" name="dni_rezagado" onchange="submitData()" required>
                                <option value="">-- Recuperados y rezagados --</option>

                                @foreach ($rezagados as $id => $name)
                                    <option value="{{ $id }}">
                                        {{ __($name) }}</option>
                                @endforeach
                            </select>

                            <button class="icon-user-plus text-2xl text-sky-800 hover:underline"
                                type="submit"></button>
                        </form>
                    @endif
                </div>
                
            </div>
            <div class="p-1">
                @if (isset($lifeParticipants) && count($lifeParticipants) > 0)
                    <table id="tablaDatosConsolidados" class="W-96 space-x-2">
                        <thead class="rounded-t-lg">
                            <tr>
                                <th scope="col" colspan="3"
                                    class='border-b border-gray-200 px-1  text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightpink; color:black">
                                    @lang('VIERNES')</th>
                                <th scope="col" colspan="3"
                                    class='border-b border-gray-200 px-1  text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:#f9b941; color:black">
                                    @lang('SATURDAY')</th>
                                <th scope="col" colspan="3"
                                    class='border-b border-gray-200 px-1  text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightgreen; color:black">
                                    @lang('SUNDAY')</th>
                            </tr>
                            <tr>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightpink; color:black">
                                    A</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightpink; color:black">
                                    D</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightpink; color:black">
                                    NA</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:#f9b941; color:black">
                                    A</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:#f9b941; color:black">
                                    D</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:#f9b941; color:black">
                                    NA</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightgreen; color:black">
                                    A</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightgreen; color:black">
                                    D</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="background-color:lightgreen; color:black">
                                    NA</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            <tr class="border-b border-gray-200">
                                <td class="{{ Config::get('style.rowCenter') }}"
                                    style="background-color:lightpink; color:black">
                                    <span id="countAsistioFriday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countDesertoFriday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countNoAsistioFriday"></span>
                                </td>

                                <td class="{{ Config::get('style.rowCenter') }}"
                                    style="background-color:#f9b941; color:black">
                                    <span id="countAsistioSaturday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countDesertoSaturday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countNoAsistioSaturday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}"
                                    style="background-color:lightgreen; color:black">
                                    <span id="countAsistioSunday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countDesertoSunday"></span>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <span id="countNoAsistioSunday"></span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="p-1">
                @if (isset($follow) && count($follow) > 0)
                    <table id="tablaDatosConsolidados" class="W-96 space-x-2">
                        <thead class="bg-sky-800">
                            <tr>
                                @foreach ($follow as $thefollow)
                                    <th scope="col"
                                        class='px-1 py-0.5 text-xs font-bold text-center rtl:text-right text-white uppercase'>
                                        {{ $thefollow->confirm_assistance }}
                                    </th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            <tr class="border-b border-gray-200">
                                @foreach ($follow as $thefollow)
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thefollow->CANTIDAD }}
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="p-1">
                @if (isset($lifeParticipants))
                    <nav class="space-x-4 flex flex-row">
                        <input class="max-w-sm {{ Config::get('style.cajaTexto') }}" type="text" id="search"
                            placeholder="Buscar..." value="{{ isset($search) ? $search : '' }}"
                            onkeyup="submitData()" />

                    </nav>
                @endif
            </div>
        </div>

    </header>

    <div class="{{ Config::get('style.containerIndex') }}">

        {{-- @dump($lifeParticipants[0]->level) --}}
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                @if (isset($lifeParticipants) && count($lifeParticipants) > 0)
                    <input type="hidden" id="level" name="level"
                        value="{{ $lifeParticipants[0]->level }}" />
                @endif
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
                                            @lang('FDS')
                                        </th>
                                        @auth
                                            {{-- <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-30">
                                                @lang('Calls')
                                            </th> --}}
                                        @endauth
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Participant')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Friday')</br>@lang('Attended')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Saturday')</br>@lang('Attended')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Sunday')</br>@lang('Attended')
                                        </th>
                                        <th scope="col"
                                            class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                            @lang('Nickname')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Friday')</br>@lang('Statement')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Saturday')</br>@lang('Statement')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Sunday')</br>@lang('Statement')
                                        </th>

                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Role')
                                        </th>
                                        <th scope="col"
                                            class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                            @lang('Phone')
                                        </th>
                                        <th scope="col"
                                            class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                            @lang('Record')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($lifeParticipants as $theLifeParticipants)
                                        <tr class="border-b border-gray-200"
                                            @if ($theLifeParticipants->sunday_attended === 'ASISTIÓ') style="background-color:lightgreen" @endif
                                            @if ($theLifeParticipants->sunday_attended === 'NO ASISTIÓ') style="background-color:lightyellow" @endif
                                            @if ($theLifeParticipants->sunday_attended === 'DESERTÓ') style="background-color:lightpink" @endif>
                                            <td class="{{ Config::get('style.rowSequential') }}">
                                                {{ $theLifeParticipants->secuencial }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $theLifeParticipants->level }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}">
                                                {{ $theLifeParticipants->participant }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                <select
                                                    class="attendance-select-friday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                    data-participant-id="{{ $theLifeParticipants->id }}">
                                                    <option value="NO ASISTIÓ"
                                                        @if ($theLifeParticipants->friday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                            ASISTIÓ</b>
                                                    </option>
                                                    <option value="ASISTIÓ"
                                                        @if ($theLifeParticipants->friday_attended === 'ASISTIÓ') selected @endif>
                                                        <span style='color:red'>ASISTIÓ</span>
                                                    </option>
                                                    <option value="DESERTÓ"
                                                        @if ($theLifeParticipants->friday_attended === 'DESERTÓ') selected @endif>
                                                        DESERTÓ</option>
                                                </select>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                <select
                                                    class="attendance-select-saturday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                    data-participant-id="{{ $theLifeParticipants->id }}">
                                                    <option value="NO ASISTIÓ"
                                                        @if ($theLifeParticipants->saturday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                            ASISTIÓ</b>
                                                    </option>
                                                    <option value="ASISTIÓ"
                                                        @if ($theLifeParticipants->saturday_attended === 'ASISTIÓ') selected @endif>
                                                        <span style='color:red'>ASISTIÓ</span>
                                                    </option>
                                                    <option value="DESERTÓ"
                                                        @if ($theLifeParticipants->saturday_attended === 'DESERTÓ') selected @endif>
                                                        DESERTÓ</option>
                                                </select>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                <select
                                                    class="attendance-select-sunday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                    data-participant-id="{{ $theLifeParticipants->id }}">
                                                    <option value="NO ASISTIÓ"
                                                        @if ($theLifeParticipants->sunday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                            ASISTIÓ</b>
                                                    </option>
                                                    <option value="ASISTIÓ"
                                                        @if ($theLifeParticipants->sunday_attended === 'ASISTIÓ') selected @endif>
                                                        <span style='color:red'>ASISTIÓ</span>
                                                    </option>
                                                    <option value="DESERTÓ"
                                                        @if ($theLifeParticipants->sunday_attended === 'DESERTÓ') selected @endif>
                                                        DESERTÓ</option>
                                                </select>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->nickname }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    class="statement-change-friday {{ Config::get('style.cajaTexto') }} w-12 contenedor-change text-xs"
                                                    data-participant-id-change="{{ $theLifeParticipants->id }}"
                                                    value=" {{ old('friday_statement', property_exists($theLifeParticipants, 'friday_statement') ? $theLifeParticipants->friday_statement : '') }}" />
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    class="statement-change-saturday {{ Config::get('style.cajaTexto') }} w-12 contenedor-change text-xs"
                                                    data-participant-id-change="{{ $theLifeParticipants->id }}"
                                                    value=" {{ old('saturday_statement', property_exists($theLifeParticipants, 'saturday_statement') ? $theLifeParticipants->saturday_statement : '') }}" />
                                            </td>
                                            <td
                                                class="statement-change-sunday {{ Config::get('style.rowCenterXs') }}">
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    class="statement-change-sunday {{ Config::get('style.cajaTexto') }} w-12 contenedor-change text-xs"
                                                    data-participant-id-change="{{ $theLifeParticipants->id }}"
                                                    value=" {{ old('sunday_statement', property_exists($theLifeParticipants, 'sunday_statement') ? $theLifeParticipants->sunday_statement : '') }}" />
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theLifeParticipants->role }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                {{ $theLifeParticipants->phone }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} hidden sm:table-cell">
                                                <b>{{ $theLifeParticipants->record_mode }}</b>
                                                @if ($theLifeParticipants->number_focus)
                                                    <br>
                                                    {!! nl2br(e($theLifeParticipants->number_focus)) !!}
                                                @endif
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

    <script>
        const selectFocus = document.getElementById('training_id_next');

        selectFocus.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('focusNext').submit();
        });
        
        $(document).ready(function() {
            setInterval(reloadPageWithScrollPosition, 100000);
        });

        function reloadPageWithScrollPosition() {
            var scrollPosition = window.scrollY || window.pageYOffset;

            location.reload();

            window.scrollTo(0, scrollPosition);
        }
        function ver(valor)
        {
            var ele = document.getElementById(valor);
            if(ele.style.display == 'none' ) 
            {
                ele.style.display = 'block';
                //var currentPosition = window.scrollY;
                var currentPosition = document.documentElement.scrollTop || window.scrollY || document.body.scrollTop;
                console.log(currentPosition)
                window.scrollTo(0, currentPosition + 700);
            }
            else 
                ele.style.display = 'none';
        }
            
    </script>

    <script>
        
    
        $(document).ready(function() {
            $('#sinResultados').hide();
            contar();

            $('.attendance-select-friday').on('change', function() {
                var participantId = $(this).data('participant-id');
                var newStatus = $(this).val();
                var day = 'friday';

                // Realizar una solicitud AJAX para actualizar el estado
                $.ajax({
                    url: '/actualizar_estado_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        attendance_status: newStatus,
                        attendance_day: day
                    },
                    success: function(response) {
                        $('.attendance-select-saturday[data-participant-id="' + participantId +
                            '"]').val(newStatus);
                        $('.attendance-select-sunday[data-participant-id="' + participantId +
                            '"]').val(newStatus);
                        contar();
                    }
                });
            });

            $('.attendance-select-saturday').on('change', function() {
                var participantId = $(this).data('participant-id');
                var newStatus = $(this).val();
                var day = 'saturday';

                // Realizar una solicitud AJAX para actualizar el estado
                $.ajax({
                    url: '/actualizar_estado_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        attendance_status: newStatus,
                        attendance_day: day
                    },
                    success: function(response) {
                        $('.attendance-select-sunday[data-participant-id="' + participantId +
                            '"]').val(newStatus);
                        contar();
                    }
                });
            });

            $('.attendance-select-sunday').on('change', function() {
                var participantId = $(this).data('participant-id');
                var newStatus = $(this).val();
                var day = 'sunday';

                // Realizar una solicitud AJAX para actualizar el estado
                $.ajax({
                    url: '/actualizar_estado_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        attendance_status: newStatus,
                        attendance_day: day
                    },
                    success: function(response) {
                        contar();
                    }
                });
            });

            $('.statement-change-friday').on('change', function() {
                var participantId = $(this).data('participant-id-change');
                var newValue = $(this).val();
                var day = 'friday';

                $.ajax({
                    url: '/actualizar_declaracion_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        statement: newValue,
                        day: day
                    },
                    success: function(response) {

                    }
                });

                // Puedes realizar una solicitud AJAX aquí si es necesario.
            });


            $('.statement-change-saturday').on('change', function() {
                var participantId = $(this).data('participant-id-change');
                var newValue = $(this).val();
                var day = 'saturday';


                $.ajax({
                    url: '/actualizar_declaracion_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        statement: newValue,
                        day: day
                    },
                    success: function(response) {

                    }
                });

                // Puedes realizar una solicitud AJAX aquí si es necesario.
            });


            $('.statement-change-sunday').on('change', function() {
                var participantId = $(this).data('participant-id-change');
                var newValue = $(this).val();
                var day = 'sunday';

                $.ajax({
                    url: '/actualizar_declaracion_l/' + participantId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        statement: newValue,
                        day: day
                    },
                    success: function(response) {

                    }
                });

                // Puedes realizar una solicitud AJAX aquí si es necesario.
            });

        });

        function contar() {
            var countsFriday = {
                'NO ASISTIÓ': 0,
                'ASISTIÓ': 0,
                'DESERTÓ': 0
            };
            var countsSaturday = {
                'NO ASISTIÓ': 0,
                'ASISTIÓ': 0,
                'DESERTÓ': 0
            };
            var countsSunday = {
                'NO ASISTIÓ': 0,
                'ASISTIÓ': 0,
                'DESERTÓ': 0
            };

            $('#tablaDatos tbody tr').each(function() {
                var attendanceStatusFriday = $(this).find('.attendance-select-friday')
                    .val();
                countsFriday[attendanceStatusFriday]++;

                var attendanceStatusSaturday = $(this).find('.attendance-select-saturday')
                    .val();
                countsSaturday[attendanceStatusSaturday]++;

                var attendanceStatusSunday = $(this).find('.attendance-select-sunday')
                    .val();
                countsSunday[attendanceStatusSunday]++;
            });

            // Actualizar la vista con los conteos
            $('#countNoAsistioFriday').html(countsFriday['NO ASISTIÓ']);
            $('#countAsistioFriday').html(countsFriday['ASISTIÓ']);
            $('#countDesertoFriday').html(countsFriday['DESERTÓ']);


            $('#countNoAsistioSaturday').html(countsSaturday['NO ASISTIÓ']);
            $('#countAsistioSaturday').html(countsSaturday['ASISTIÓ']);
            $('#countDesertoSaturday').html(countsSaturday['DESERTÓ']);


            $('#countNoAsistioSunday').html(countsSunday['NO ASISTIÓ']);
            $('#countAsistioSunday').html(countsSunday['ASISTIÓ']);
            $('#countDesertoSunday').html(countsSunday['DESERTÓ']);

            $('#tablaDatos tbody tr').each(function() {
                var attendanceStatus = $(this).find('.attendance-select-sunday').val();
                if (attendanceStatus === 'ASISTIÓ') {
                    $(this).css('background-color', 'lightgreen');
                } else if (attendanceStatus === 'NO ASISTIÓ') {
                    $(this).css('background-color', 'lightyellow');
                } else if (attendanceStatus === 'DESERTÓ') {
                    $(this).css('background-color', 'lightpink');
                }
            });
        }




        function submitData() {
            var training_id = document.getElementById('training_id').value;
            var level = document.getElementById('level').value;
            var search = document.getElementById('search').value;
            var searchValue = $('#search').val();
            if (search === "") {
                searchValue = "%";
            }
            var training_idValue = $('#training_id').val();
            var levelValue = $('#level').val();

            $.ajax({
                url: "{{ route('LifeParticipants.index') }}",
                method: "GET",
                data: {
                    training_id: training_idValue,
                    level: levelValue,
                    search: searchValue,
                },
                success: function(response) {
                    var status = response.status;
                    if (status === undefined) {
                        $('#conResultados').hide()

                        $('#sinResultados').show()

                        $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue + '"')
                    }

                    if ($(response).find('#tablaDatos').length) {

                        $('#conResultados').show()
                        $('#sinResultados').hide()
                        var $training_id = $(response).find('#training_id');
                        var $level = $(response).find('#level');
                        var $search = $(response).find('#search');
                        var $tablaDatos = $(response).find('#tablaDatos');

                        if ($tablaDatos.find('tbody tr').length > 0) {

                            $('#tablaDatos').replaceWith($tablaDatos);

                            document.getElementById('search').focus();

                        } else {

                            $('#conResultados').hide()

                            $('#sinResultados').show()

                            $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue + '"')

                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Muestra el texto de la respuesta de error
                    console.log(status); // Muestra el estado de la solicitud (por ejemplo, "error")
                    console.log(error); // Muestra información de error adicional
                }
            });
        }
    </script>

</x-app-layout>
