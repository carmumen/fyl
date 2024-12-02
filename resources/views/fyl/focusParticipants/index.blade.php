<x-app-layout>
    @php
        if (session('entidad') == 'FocusParticipants') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'FocusParticipants']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Fondo oscuro semi-transparente */
        }

        /* Estilos para la ventana emergente */
        .popup {
            display: none;
            position: fixed;
            background: white;
            border: 1px solid #ccc;
            padding: 20px;
            width: 90%;
            max-width: 500px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0px 0px 10px #000;
        }

        .popupContainer {
            height: 400px;
            overflow: auto;
        }


        .radio-label {
            font-size: 12px;
            /* Cambia el tamaño de letra a 12px o al valor que desees */
            line-height: 1.4;
            /* Cambia el valor de interlineado a 1.2 o al que prefieras */
        }

        .custom-radio-label {
            /* position: relative; */
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 12px;
            display: inline
        }

        .custom-radio-label input[type="radio"] {
            display: none;
            /* Oculta el botón de radio nativo */
        }

        .custom-radio-label span {
            margin-left: 8px;
            /* Espacio entre el botón de radio personalizado y el texto */
        }

        .custom-radio-label input[type="radio"]:checked+span,
        .custom-radio-label span.estilo-check  {
            font-weight: bold;
            color: red;
            font-size: 15px;
        }
        
        .overlay-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Fondo semi-transparente */
            display: flex;
            align-items: center;
            justify-content: center;

            background-color: transparent;
        }

        .overlay-spinner img {

            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Focus Participants')
        </h2>
    </x-slot>

    <header>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-sky-700">
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Participante Jornada</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Asistió</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">Desertó</th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">No asistió</th>
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
                            <form id="focus" method="POST" action="{{ route('FocusParticipants.store') }}">
                                @csrf
                                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                                    name="training_id" id="training_id" required>
                                    @foreach ($training as $id => $name)
                                        <option value="{{ $id }}"
                                            @if ($id == old('training_id', $trainingId)) selected @endif>
                                            {{ __($name) }}</option>
                                    @endforeach
                                </select>

                                <button class="icon-upload text-2xl text-sky-800 hover:underline" onclick="submitData()"></button>
                            </form>
                        @endif
                    </td>
                    <td class="text-center"><span id="countAsistioSunday"></span></td>
                    <td class="text-center"><span id="countDesertoSunday"></span></td>
                    <td class="text-center"><span id="countNoAsistioSunday"></span></td>
                    <td class="text-center">
                        @if (isset($follow) && count($follow) > 0)
                            <button id="showPopup" class="text-xl text-sky-800 hover:underline"
                                onclick="mostrarPopup('popup')">
                                <span class="icon-image "></span> B
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (isset($follow) && count($follow) > 0)
                            <button id="showPopup1" class="text-xl text-sky-800 hover:underline"
                                onclick="mostrarPopup('popup1')">
                                <span class="icon-image"></span> L
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                            id="confirm_assistance_B" name="confirm_assistance_B" onchange="submitData()" required />
                        <option value="%">-- Bienvenida --</option>
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            @foreach ($call_B->toArray() as $acronym => $name)
                                <option value="{{ $acronym }}" @if ($acronym == old('confirm_assistance_B', $call_id_B)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        @endif
                        </select>
                    </td>
                    <td class="text-center">
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                            id="confirm_assistance_L" name="confirm_assistance_L" onchange="submitData()" required />
                        <option value="%">-- Logistica --</option>
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            @foreach ($call_L->toArray() as $acronym => $name)
                                <option value="{{ $acronym }}" @if ($acronym == old('confirm_assistance_L', $call_id_L)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                        @endif
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table class="min-w-full divide-y divide-gray-200 px-4 mt-2">
            <tr>
                <td class="px-4" style="width: 20%">
                    @if (isset($focusParticipants) && count($focusParticipants) > 0)
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select mx-4" type="text"
                            id="training_id_enroller" name="training_id_enroller" onchange="submitData()" required />
                        <option value="0">-- Equipos --</option>
                        @if (isset($distinctTrainings) && count($distinctTrainings) > 0)
                            @foreach ($distinctTrainings as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('training_id_enroller', $trainingIdEnroller)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                        @endif
                    </select>
                     @endif
                </td>
                <td class="px-4" style="width: 30%; ">
                    <input list="participants" name="q" id="otrasede" placeholder="Buscar participante otra sede..." autocomplete="off" style="width:calc(100% - 50px); padding:3px; font-size:12px; border-radius:5px; border:1px solid #ccc">
                        <input type="hidden" id="selectedDNI">
                        <datalist id="participants"></datalist>
                        <button type="submit" style="width:30px;color:#0569A1" onclick="agregaOtraSede()"><span class="icon-plus" title="Agregar"></span></button>
                </td>

                <td class="px-4 flex flex-row">
                    <div class="flex flex-col ">
                        <div class="flex flex-row  justify-between px-4" style="width:200px">
                            <label class="radio-label">
                                <input type="radio" name="opcionB" value="P" onchange="submitData()" checked>
                                Participante
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="opcionB" value="E" onchange="submitData()"> Enrolador
                            </label>
                        </div>
                        <div class="flex flex-row justify-between px-4 mx-2">

                            <div>
                                <button class="px-0" onclick="deseleccionarOpciones()"><span
                                        class="icon-loop2 text-xs"></span></button>
                            </div>
                            <div id="grupoOpciones">
                                <label class="custom-radio-label px-1" title="NORMAL">
                                    <input type="radio" name="opcionC" value="NORMAL" onchange="submitData()" @if($mode == "NORMAL") checked @endif>
                                    <span>N</span>
                                </label>
                                <label class="custom-radio-label px-1" title="RECUPERADO">
                                    <input type="radio" name="opcionC" value="RECUPERADO" onchange="submitData()" @if($mode == "RECUPERADO") checked @endif>
                                    <span>R</span>
                                </label>
                                <label class="custom-radio-label px-1" title="REZAGADO">
                                    <input type="radio" name="opcionC" value="REZAGADO" onchange="submitData()" @if($mode == "REZAGADO") checked @endif>
                                    <span>Z</span>
                                </label>
                            </div>
                        </div>
                    </div>



                    <div class="relative w-full">
                        <input class="w-full {{ Config::get('style.cajaTexto') }}" type="text" id="search" name="search"
                            placeholder="Buscar... Ingrese mínimo 5 caracteres. Primer apellido ó primer nombre" 
                            value="{{ isset($search) ? $search : '' }}" onkeyup="buscar()" />
                    
                        
                            <button type="button" class="absolute inset-y-0 right-0 px-2 py-1"
                                onclick="limpiarBusqueda()">
                                <!-- Agrega el icono "X" o cualquier otro icono de tu elección -->
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                      
                    </div>
                </td>
            </tr>
        </table>
    </header>

    <div class="overlay-spinner">
        <img src="{{ url('images/loading-gif-png-4.gif') }}" alt="Cargando...">
    </div>
        
    <div class="overlay" id="overlay"></div>
    
    <div class="popup" id="popup">
        <div class="flex justify-between" style="background-color:white">
            <button id="copiaBienvenida"><span class="icon-download" style="color:navy"></span></button>
            <span style="color:navy; font-weigth:bold">BIENVENIDA</span>
            <button class="closePopup" onclick="cerrarPopup('popup')" title="CERRAR"><span class="icon-cross"
                    style="color:red"></span></button>
        </div>
        <div class="w-full popupContainer">
            <div id="bienvenida" class="p-4 text-center">
                @if (isset($follow) && count($follow) > 0)
                
                    <h1 class="py-2">BIENVENIDA JORNADA</h1>
                    <h2 class="py-2" style="color:navy">Resumen de llamadas</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $resumen_welcome,
                        'title' => 'Resumen',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Ejecutivo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $ejecutivo_welcome,
                        'title' => 'Ejecutivo',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Equipo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $equipo_welcome,
                        'title' => 'Equipo',
                    ])
                    
                    
                    <h1 class=" mt-4">BIENVENIDA REZAGADOS Y RECUPERADOS</h1>
                    
                    <h2 class="py-2" style="color:navy">Resumen de llamadas</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $resumen_welcomeR,
                        'title' => 'Resumen',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Ejecutivo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $ejecutivo_welcomeR,
                        'title' => 'Ejecutivo',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Equipo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $equipo_welcomeR,
                        'title' => 'Equipo',
                    ])
                @endif
                <br>
                <br>
            </div>
        </div>
    </div>

    <div class="popup" id="popup1">
        <div class="flex justify-between" style="background-color:white">
            <button id="copiaLogistica"><span class="icon-download" style="color:navy"></span></button>
            <span style="color:navy; font-weigth:bold">LOGÍSTICA</span>
            <button class="closePopup" onclick="cerrarPopup('popup1')" title="CERRAR"><span class="icon-cross"
                    style="color:red"></span></button>
        </div>
        
        <div class="w-full popupContainer">
            <div id="logistica" class="p-4 text-center">
                @if (isset($follow) && count($follow) > 0)
                    <h1 class="py-2">LOGÍSTICA JORNADA</h1>
                    <h2 class="py-2" style="color:navy">Resumen de llamadas</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $resumen_logistics,
                        'title' => 'Resumen',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Ejecutivo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $ejecutivo_logistics,
                        'title' => 'Ejecutivo',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Equipo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $equipo_logistics,
                        'title' => 'Equipo',
                    ])
                    
                    
                    <h1 class=" mt-4">LOGÍSTICA REZAGADOS Y RECUPERADOS</h1>
                    
                    <h2 class="py-2" style="color:navy">Resumen de llamadas</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $resumen_logisticsR,
                        'title' => 'Resumen',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Ejecutivo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $ejecutivo_logisticsR,
                        'title' => 'Ejecutivo',
                    ])

                    <h2 class="py-2" style="color:navy">Llamadas por Equipo</h2>
                    @include('fyl/focusParticipants/tabla', [
                        'data' => $equipo_logisticsR,
                        'title' => 'Equipo',
                    ])
                @endif
                <br>
                <br>
            </div>
        </div>
    </div>
    <?php
    // Recupera la posición almacenada en la cookie si existe
        $posicionScroll = isset($_COOKIE['posicionScroll']) ? $_COOKIE['posicionScroll'] : 0;
    ?>

    <div id="principal" class="{{ Config::get('style.containerIndex') }} " style="height: calc(100vh - 15rem);"
        onscroll="guardarPosicionScroll()">
        <div class="flex flex-col mt-6 mb-8">

            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    @if (isset($focusParticipants) && count($focusParticipants) > 0)
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerSequential') }}">
                                        @lang('No.')
                                    </th>
                                    @auth
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            Bienvenida
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            Logistica
                                        </th>
                                    @endauth
                                    <th></th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        @lang('Friday')</br>@lang('Attended')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        @lang('Saturday')</br>@lang('Attended')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        @lang('Sunday')</br>@lang('Attended')
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        <button class="sort-button" data-sort="surnames">@lang('PARTICIPANTE')</button>
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        <button class="sort-button" data-sort="nickname">@lang('NICKNAME')</button>
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        @lang('PHONE')
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        <button class="sort-button" data-sort="record">@lang('RECORD')</button>
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        <button class="sort-button"
                                            data-sort="team_enroller">@lang('Team Enroller')</button>
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        <button class="sort-button"
                                            data-sort="team_enroller">@lang('Enroller')</button>
                                    </th>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerCenterXs') }} hidden sm:table-cell">
                                        <button class="sort-button"
                                            data-sort="team_enroller">@lang('Enroller Phone')</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($focusParticipants as $theFocusParticipants)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowSequential') }}">
                                            {{ $theFocusParticipants->secuencial }}
                                        </td>
                                        @auth
                                            <td class="w-32 text-center py-1">
                                                <div
                                                    class="text-xs w-32 ml-1
                                                    @if ($theFocusParticipants->welcome_count == 0) rounded-md bg-red-500 py-2
                                                    @else
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'SI') rounded-md bg-green-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'NC') rounded-md bg-blue-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'PF') rounded-md bg-orange-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'PC') rounded-md bg-yellow-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'NI') rounded-md bg-gray-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'SLL') rounded-md bg-red-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_welcome == 'OS') rounded-md bg-blue-200 @endif
                                                    @endif">
                                                    <div>
                                                        <span>{{ $theFocusParticipants->welcome_count }}</span>

                                                        <form method="POST" class="{{ Config::get('style.btnCall') }}"
                                                            action="{{ route('FocusCall.call') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $theFocusParticipants->id }}" />
                                                            <input type="hidden" name="type_call" value="Bienvenida" />

                                                            <button
                                                                class="icon-phone-hang-up text-green-900 hover:bg-green-500 hover:text-white"></button>
                                                        </form>
                                                        <span>{{ $theFocusParticipants->confirm_assistance_welcome }}</span>
                                                    </div>
                                                    @php
                                                        $words = explode(' ', $theFocusParticipants->userWelcome);
                                                        $initials = '';
                                                        foreach ($words as $word) {
                                                            $initials .= strtoupper(substr($word, 0, 1));
                                                        }
                                                        echo $initials;
                                                    @endphp
                                                </div>

                                            </td>

                                            <td class="w-32 text-center py-1">
                                                <div
                                                    class="text-xs w-32 ml-1
                                                    @if ($theFocusParticipants->logistics_count == 0) rounded-md bg-red-500 py-2
                                                    @else
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'SI') rounded-md bg-green-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'NC') rounded-md bg-blue-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'PF') rounded-md bg-orange-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'PC') rounded-md bg-yellow-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'NI') rounded-md bg-gray-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'SLL') rounded-md bg-red-500 @endif
                                                        @if ($theFocusParticipants->confirm_assistance_logistics == 'OS') rounded-md bg-blue-200 @endif
                                                    @endif">
                                                    <div>
                                                        <span>{{ $theFocusParticipants->logistics_count }}</span>

                                                        <form method="POST" class="{{ Config::get('style.btnCall') }}"
                                                            action="{{ route('FocusCall.call') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $theFocusParticipants->id }}" />
                                                            <input type="hidden" name="type_call" value="Logistica" />

                                                            <button
                                                                class="icon-phone-hang-up text-green-900 hover:bg-green-500 hover:text-white"></button>
                                                        </form>
                                                        <span>{{ $theFocusParticipants->confirm_assistance_logistics }}</span>
                                                    </div>
                                                    @php
                                                        $words = explode(' ', $theFocusParticipants->userLogistics);
                                                        $initials = '';
                                                        foreach ($words as $word) {
                                                            $initials .= strtoupper(substr($word, 0, 1));
                                                        }
                                                        echo $initials;
                                                    @endphp
                                                </div>

                                            </td>
                                        @endauth
                                        <td class="{{ Config::get('style.rowCenterXs') }}" title="ÚLTIMO SEGUIMIENTO">
                                            {{ $theFocusParticipants->confirm_assistance_up }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            <select
                                                class="attendance-select-friday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                data-participant-id="{{ $theFocusParticipants->id }}">
                                                <option value="NO ASISTIÓ"
                                                    @if ($theFocusParticipants->friday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                        ASISTIÓ</b>
                                                </option>
                                                <option value="ASISTIÓ"
                                                    @if ($theFocusParticipants->friday_attended === 'ASISTIÓ') selected @endif>
                                                    <span style='color:red'>ASISTIÓ</span>
                                                </option>
                                                <option value="DESERTÓ"
                                                    @if ($theFocusParticipants->friday_attended === 'DESERTÓ') selected @endif>
                                                    DESERTÓ</option>
                                            </select>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            <select
                                                class="attendance-select-saturday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                data-participant-id="{{ $theFocusParticipants->id }}">
                                                <option value="NO ASISTIÓ"
                                                    @if ($theFocusParticipants->saturday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                        ASISTIÓ</b>
                                                </option>
                                                <option value="ASISTIÓ"
                                                    @if ($theFocusParticipants->saturday_attended === 'ASISTIÓ') selected @endif>
                                                    <span style='color:red'>ASISTIÓ</span>
                                                </option>
                                                <option value="DESERTÓ"
                                                    @if ($theFocusParticipants->saturday_attended === 'DESERTÓ') selected @endif>
                                                    DESERTÓ</option>
                                            </select>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            <select
                                                class="attendance-select-sunday  {{ Config::get('style.cajaTexto') }} contenedor-select text-xxs"
                                                data-participant-id="{{ $theFocusParticipants->id }}">
                                                <option value="NO ASISTIÓ"
                                                    @if ($theFocusParticipants->sunday_attended === 'NO ASISTIÓ') selected @endif><b>NO
                                                        ASISTIÓ</b>
                                                </option>
                                                <option value="ASISTIÓ"
                                                    @if ($theFocusParticipants->sunday_attended === 'ASISTIÓ') selected @endif>
                                                    <span style='color:red'>ASISTIÓ</span>
                                                </option>
                                                <option value="DESERTÓ"
                                                    @if ($theFocusParticipants->sunday_attended === 'DESERTÓ') selected @endif>
                                                    DESERTÓ</option>
                                            </select>
                                        </td>
                                   
                                        <td class="{{ Config::get('style.rowLeftXs') }} text-xxs ">
                                            {{ $theFocusParticipants->participant }}
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->nickname }}
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->phone }}
                                            @if($theFocusParticipants->phone2)
                                                <br>
                                                {{ $theFocusParticipants->phone2 }}
                                            @endif
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            <b>{{ $theFocusParticipants->record_mode }}</b>
                                            @if ($theFocusParticipants->number_focus)
                                                <br>
                                                {!! nl2br(e($theFocusParticipants->number_focus)) !!}
                                            @endif
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->team_enroller }}
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->enroller }}
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->enroller_phone }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                            {{-- {{ $focusParticipants->links() }} --}}
                        </div>
                    @endif
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>


    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        // Esta función se llama cada vez que el usuario realiza un desplazamiento en el div
        function guardarPosicionScroll() {
            var divConScroll = document.getElementById('principal');
            var posicionVertical = divConScroll.scrollTop;
            document.cookie = "posicionScroll=" + posicionVertical;
        }

        // Agrega un listener al evento de desplazamiento del div
        document.getElementById('principal').addEventListener('scroll', guardarPosicionScroll);

        // Esta función se llama al cargar la página para establecer la posición inicial del div
        document.addEventListener('DOMContentLoaded', function() {
            var divConScroll = document.getElementById('principal');
            // Recupera la posición almacenada en la cookie si existe
            var posicionScroll = parseInt(getCookie("posicionScroll")) || 0;
            divConScroll.scrollTop = posicionScroll;
        });

        // Función auxiliar para obtener el valor de una cookie por nombre
        function getCookie(nombre) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + nombre + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }
        
        $(document).ready(function() {
            contar();
            activarEstados();
    
            setupCopyButton('copiaLogistica', 'logistica');
            setupCopyButton('copiaBienvenida', 'bienvenida');
            $('#sinResultados').hide();
            contar();

        });
        
        function activarEstados()
        {
            $('.attendance-select-friday').on('change', function() {
                var participantId = $(this).data('participant-id');
                var newStatus = $(this).val();
                var day = 'friday';

                // Realizar una solicitud AJAX para actualizar el estado
                $.ajax({
                    url: '/actualizar_estado_f/' + participantId,
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
                    url: '/actualizar_estado_f/' + participantId,
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
                    url: '/actualizar_estado_f/' + participantId,
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
        
        }

        function setupCopyButton(buttonId, targetId) {
            document.getElementById(buttonId).addEventListener('click', function() {
                var divToCopy = document.getElementById(targetId);
                copyAndDownloadImage(divToCopy);
            });
        }

        function copyAndDownloadImage(divToCopy) {
            html2canvas(divToCopy).then(function(canvas) {
                
                var imgData = canvas.toDataURL('image/png');
                var a = document.createElement('a');
                a.href = imgData;
                a.download = 'imagen.png';
                a.click();
            });
        }

        function mostrarPopup(id) {
            var overlay = document.getElementById('overlay');
            var popup = document.getElementById(id);
            overlay.style.display = 'block';
            popup.style.display = 'block';
        }

        function cerrarPopup(id) {
            var overlay = document.getElementById('overlay');
            var popup = document.getElementById(id);
            overlay.style.display = 'none';
            popup.style.display = 'none';
        }
        
        

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
        
        function buscar()
        {
            var search = document.getElementById('search').value;
            
            if(search.length === 0 || search.length > 4 )
               submitData(); 
        }

        function submitData1() {

            var training_id = document.getElementById('training_id').value;
            var training_id_enroller = document.getElementById('training_id_enroller').value;
            var search = document.getElementById('search').value;
            var confirm_assistance_B = document.getElementById('confirm_assistance_B').value;
            var confirm_assistance_L = document.getElementById('confirm_assistance_L').value;

            var elementosDeRadio = document.getElementsByName("opcionB");
            var elementosDeRadioC = document.getElementsByName("opcionC");

            var opcionSeleccionada;
            for (var i = 0; i < elementosDeRadio.length; i++) {
                if (elementosDeRadio[i].checked) {
                    opcionSeleccionada = elementosDeRadio[i].value;
                    break;
                }
            }
            var opcionSeleccionadaC;
            for (var i = 0; i < elementosDeRadioC.length; i++) {
                if (elementosDeRadioC[i].checked) {
                    opcionSeleccionadaC = elementosDeRadioC[i].value;
                    break;
                }
            }

            var searchValue = $('#search').val();
            if (search === "") {
                searchValue = "%";
            }
            var training_idValue = $('#training_id').val();
            var training_id_enrollerValue = $('#training_id_enroller').val();

            $.ajax({
                url: "{{ route('FocusParticipants.index') }}",
                method: "GET",
                data: {
                    training_id: training_idValue,
                    training_id_enroller: training_id_enrollerValue,
                    search: searchValue,
                    call_B: confirm_assistance_B,
                    call_L: confirm_assistance_L,
                    perfil: opcionSeleccionada,
                    mode: opcionSeleccionadaC,
                },
                success: function(response) {
                    var status = response.status;
                    if (status === undefined) {
                        $('#conResultados').hide();
                        $('#sinResultados').show();
                        $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue + '"');
                    }

                    if ($(response).find('#tablaDatos').length) {
                        $('#conResultados').show();
                        $('#sinResultados').hide();
                        var $training_id = $(response).find('#training_id');
                        var training_id_enroller = $(response).find('#training_id_enroller');
                        var $search = $(response).find('#search');
                        var $tablaDatos = $(response).find('#tablaDatos');

                        if ($tablaDatos.find('tbody tr').length > 0) {
                            $('#tablaDatos').replaceWith($tablaDatos);
                            document.getElementById('search').focus();
                        } else {
                            $('#conResultados').hide();
                            $('#sinResultados').show();
                            $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue +
                                '"');
                        }
                    }
                   
                    activarEstados();
                    contar();
                },
                error: function(xhr, status, error) {
                    
                }

            });
        }
        
        function showLoadingSpinner() {
            document.querySelector('.overlay-spinner').style.display = 'block';
        }
        
        function hideLoadingSpinner() {
            document.querySelector('.overlay-spinner').style.display = 'none';
        }
        
        function submitData() {
            var training_idValue = $('#training_id').val() || "%";
            var training_id_enrollerValue = $('#training_id_enroller').val() || "%";
            var searchValue = $('#search').val() || "%";
            var confirm_assistance_B = $('#confirm_assistance_B').val();
            var confirm_assistance_L = $('#confirm_assistance_L').val();
        
            var opcionSeleccionada = obtenerValorRadio("opcionB");
            var opcionSeleccionadaC = obtenerValorRadio("opcionC");
            
            ///showLoadingSpinner();
        
            $.ajax({
                url: "{{ route('FocusParticipants.index') }}",
                method: "GET",
                data: {
                    training_id: training_idValue,
                    training_id_enroller: training_id_enrollerValue,
                    search: searchValue,
                    call_B: confirm_assistance_B,
                    call_L: confirm_assistance_L,
                    perfil: opcionSeleccionada,
                    mode: opcionSeleccionadaC,
                },
                success: function(response) {
                    var status = response.status;
        
                    if (status === undefined) {
                        $('#conResultados').hide();
                        $('#sinResultados').show();
                        $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue + '"');
                    }
        
                    if ($(response).find('#tablaDatos').length) {
                        $('#conResultados').show();
                        $('#sinResultados').hide();
                        var $tablaDatos = $(response).find('#tablaDatos');
        
                        if ($tablaDatos.find('tbody tr').length > 0) {
                            $('#tablaDatos').replaceWith($tablaDatos);
                            document.getElementById('search').focus();
                        } else {
                            $('#conResultados').hide();
                            $('#sinResultados').show();
                            $('#sinResultados').html('No hay resultados para la búsqueda "' + searchValue + '"');
                        }
                    }
        
                    activarEstados();
                    contar();
                    hideLoadingSpinner();
                },
                error: function(xhr, status, error) {
                    hideLoadingSpinner();
                }
            
            });
        }
        
        function obtenerValorRadio(nombre) {
            var elementosDeRadio = document.getElementsByName(nombre);
            for (var i = 0; i < elementosDeRadio.length; i++) {
                if (elementosDeRadio[i].checked) {
                    return elementosDeRadio[i].value;
                }
            }
            return null;
        }



        function deseleccionarOpciones() {
            var grupoOpciones = document.getElementById("grupoOpciones");
            var radios = grupoOpciones.querySelectorAll('input[type="radio"]');

            radios.forEach(function(radio) {
                radio.checked = false;
            });
            submitData();
        }
        // Resto de tu código...
    </script>
    <script>
    $(document).ready(function() {
        $("#otrasede").on('input', function() {
            var search = $(this).val();
            var training_id = document.getElementById('training_id').value;
            $.ajax({
                url: "{{ route('ParticipantsOtraSede.searchOtraSede') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    search: search,
                    trainingId: training_id // Ajusta según sea necesario
                },
                success: function(data) {
                    var datalist = $("#participants");
                    datalist.empty();

                    data.forEach(function(participant) {
                        var option = $("<option>").attr("value", participant.DNI).text(participant.name);
                        datalist.append(option);
                    });
                }
            });
        });
        
        $("#otrasede").on('change', function() {
            var selectedValue = $(this).val();
            var selectedText = $("#participants option[value='" + selectedValue + "']").text();
        
            // Establece el valor y el texto del campo oculto
            $("#selectedDNI").val(selectedValue);
            $("#otrasede").val(selectedText);
        });
        hideLoadingSpinner();
    });
    
    function agregaOtraSede()
    {
        var participant_DNI = document.getElementById('selectedDNI').value;
        var training_id = document.getElementById('training_id').value;
        
        if(participant_DNI == "")
        {
            alert("Seleccione al participante.");
            return;
        }
        
        
        $.ajax({
            url: '/agregarFocusOtraSede',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                DNI: participant_DNI,
                trainingId: training_id,
            },
            success: function(response) {
                console.log(response);
                submitData();
            }
        });
        
    }
    
    function limpiarBusqueda() {
        var busqueda = document.getElementById('search').value;
        console.log(busqueda);

        if (busqueda !== "") {
            document.getElementById('search').value = '';
            submitData();
        }
    }
    
   
</script>

    
    
</x-app-layout>
