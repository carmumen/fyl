<x-app-layout>
    @php
        if (session('entidad') == 'FocusStatement') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'FocusStatement']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
        
        .form-control-autoresize {
            resize: vertical; /* Permite que el textarea se redimensione verticalmente */
            height: 180px; /* Altura máxima */
        }
        
       
        
        /* Estilos para el modal de Bootstrap */

        .modal12 {
            display: none;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal {
            position: fixed;
            top: 40%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1050;
            display: none;
            width: 100%; 
            overflow-x: hidden;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.5); 
            outline: 0;
            padding: 30%; 
            border-radius: 10px; 
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.5); 
        }
        
        .form-control {
          display: block;
          width: 100%;
          padding: $input-padding-y $input-padding-x;
          font-family: $input-font-family;
          font-weight: $input-font-weight;
          line-height: $input-line-height;
          color: $input-color;
          background-color: $input-bg;
          background-clip: padding-box;
          border: $input-border-width solid $input-border-color;
          appearance: none; 
        }
        
        .col-form-label {
          padding-top: add($input-padding-y, $input-border-width);
          padding-bottom: add($input-padding-y, $input-border-width);
          margin-bottom: 0; // Override the `<legend>` default
          font-style: $form-label-font-style;
          font-weight: $form-label-font-weight;
          line-height: $input-line-height;
          color: $form-label-color;
        }
        
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 10px;
        }
        
        .modal-content {
            position: relative;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.5);
        }
        
        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        
        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }
        
        .btn-close {
            color: #000;
            float: right;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
        }
        
        .btn-close:hover {
            color: #000;
            text-decoration: none;
            opacity: .75;
        }
        
        .modal-body {
            position: relative;
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
            justify-content: flex-end;
        }
        .modal-footerqeqe {
          display: flex;
          flex-wrap: wrap;
          flex-shrink: 0;
          align-items: center; // vertically center
          justify-content: flex-end; // Right align buttons with flex property because text-align doesn't work on flex items
          padding: $modal-inner-padding - $modal-footer-margin-between * .5;
          border-top: $modal-footer-border-width solid $modal-footer-border-color;
        }
        
        
        .btn {
          display: inline-block;
          font-family: $btn-font-family;
          font-weight: $btn-font-weight;
          line-height: $btn-line-height;
          color: $body-color;
          text-align: center;
          text-decoration: if($link-decoration == none, null, none);
          white-space: $btn-white-space;
          vertical-align: middle;
          cursor: if($enable-button-pointers, pointer, null);
          user-select: none;
          background-color: transparent;
          border: $btn-border-width solid transparent;
        
            padding: 10px;
            border-radius: 5px;
            font-size:1rem;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-secondary:hover {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .attendance-select{
            width:100px;
            margin:1px;
            -webkit-appearance: none; /* Oculta la flecha en Webkit (Chrome, Safari) */
            -moz-appearance: none; /* Oculta la flecha en Firefox */
            appearance: none; /* Oculta la flecha en otros navegadores */
            background: transparent; 
        }
        

    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Life Participants')
        </h2>
    </x-slot>

    <header>
        <div class="flex flex-wrap justify-between"  >
            <div class=" p-1">
                @if (isset($training) && count($training) > 0)
                    <form id="focus1" method="GET" class="flex items-center space-x-2"
                        action="{{ route('FocusStatement.index') }}">
                        @csrf
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="training_id"
                            id="training_id" required>
                            <option value="%">--Seleccione--</option>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                        <!--
                        <button class="icon-upload text-2xl text-sky-800 hover:underline" type="submit" form="life"
                            title="cargar"></button>
                        -->
                    </form>
                @endif
            </div>
            <div class=" p-1">
                @if (isset($focusParticipants) && count($focusParticipants) > 0)
                    <table id="tablaDatosConsolidados" class="W-96 space-x-2">
                        <thead class="rounded-t-lg">
                            <tr>
                                <th scope="col" colspan="4"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightgreen; color:black">
                                    PAGO TOTAL</th>
                                <th scope="col" colspan="3"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightpink; color:black">
                                    ABONO</th>
                                <th colspan="2"></th>
                                <th scope="col" colspan="2"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:green; color:white">
                                    META</th>
                            </tr>
                            <tr>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightgreen; color:black">
                                    Y</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightgreen; color:black">
                                    Y + L</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightgreen; color:black">
                                    Tot.</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightgreen; color:black">
                                    %</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightpink; color:black">
                                    Y</th>
                                
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightpink; color:black">
                                    Tot. A.</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:lightpink; color:black">
                                    % PT + A</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:orange; color:white">
                                    Posibilidad</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:blue; color:white">
                                    Acuerdo</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:green; color:white">
                                    Tot.</th>
                                <th scope="col"
                                    class='border border-gray-200 text-xxs font-bold text-center rtl:text-right uppercase'
                                    style="padding-left: 2px; padding-right: 2px; background-color:green; color:white">
                                    %</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            <tr class="border-b border-gray-200">
                                <td id="your_pt" class="{{ Config::get('style.rowCenter') }}">
                                    {{ $focusParticipants[0]->your_pt }}
                                </td>
                                <td id="life_pt" class="{{ Config::get('style.rowCenter') }}">
                                    {{ $focusParticipants[0]->life_pt }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="your_life_pt">{{ $focusParticipants[0]->your_pt + $focusParticipants[0]->life_pt }}</b>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="total_your_life_pt"
                                        style="font-size: 16px">{{ round((($focusParticipants[0]->your_pt + $focusParticipants[0]->life_pt) * 100) / count($focusParticipants), 2) }}</b>
                                </td>
                                <td id="your_a" class="{{ Config::get('style.rowCenter') }}">
                                    {{ $focusParticipants[0]->your_a }}
                                </td>
                                
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="your_life_a">{{ $focusParticipants[0]->your_a + $focusParticipants[0]->life_a }}</b>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="total_pt_a"
                                        style="font-size: 16px">{{ round((($focusParticipants[0]->your_pt + $focusParticipants[0]->life_pt + $focusParticipants[0]->your_a + $focusParticipants[0]->life_a) * 100) / count($focusParticipants), 2) }}</b>
                                </td>
                                <td id="posibility" class="{{ Config::get('style.rowCenter') }}">
                                    {{ $focusParticipants[0]->posibility }}
                                </td>
                                <td id="agreement" class="{{ Config::get('style.rowCenter') }}">
                                    {{ $focusParticipants[0]->agreement }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="meta">{{ $focusParticipants[0]->your_pt + $focusParticipants[0]->life_pt + $focusParticipants[0]->your_a + $focusParticipants[0]->life_a + $focusParticipants[0]->posibility }}</b>
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    <b id="porcentaje_meta"
                                        style="font-size: 16px">{{ round((($focusParticipants[0]->your_pt + $focusParticipants[0]->life_pt + $focusParticipants[0]->your_a + $focusParticipants[0]->life_a + $focusParticipants[0]->posibility) * 100) / count($focusParticipants), 2) }}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            <div></div>
        </div>
        <div class="flex flex-wrap justify-start">
            <div class=" p-1">
                
            </div>
            @if (isset($training) && count($training) > 0)
                <form id="focus2" method="GET" class="flex items-center space-x-2"
                    action="{{ route('FocusStatement.index') }}">
                    @csrf
                    <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                    
                    <select id="confirm_assistance_next" name="confirm_assistance_next" 
                        @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'ACUERDO') style="background-color:blue; color:white; padding-right: 30px;" @endif
                        @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'NO INTERESA') style="background-color:red; color:white; padding-right: 30px;" @endif
                        @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'POSIBILIDAD') style="background-color:orange; color:black; padding-right: 30px;" @endif
                        @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'CONFIRMADO') style="background-color:green; color:white; padding-right: 30px;" @endif
                        class="{{ Config::get('style.cajaTexto') }} contenedor-select1  py-2 text-xxs" style="padding-right: 30px;">
                        <option value="%" style="background-color:white; color:black"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == '%') selected @endif>
                            <b>--TODOS--</b>
                        </option>
                        <option value="SD" style="background-color:white; color:black"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'SD') selected @endif>
                            <b>S/D</b>
                        </option>
                        <option value="POSIBILIDAD" style="background-color:orange; color:black;"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'POSIBILIDAD') selected @endif>
                            <b>POSIBILIDAD</b>
                        </option>
                        <option value="ACUERDO" style="background-color:blue; color:white"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'ACUERDO') selected @endif>
                            <b>ACUERDO</b>
                        </option>
                        <option value="NO INTERESA" style="background-color:red; color:white"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'NO INTERESA') selected @endif>
                            <b>NO INTERESA</b>
                        </option>
                        <option value="CONFIRMADO" style="background-color:green; color:white"
                            @if (isset($confirmAssistanceNext) && $confirmAssistanceNext == 'CONFIRMADO') selected @endif>
                            <b>CONFIRMADO</b>
                        </option>
                    </select>
                    
                    <select class=" {{ Config::get('style.cajaTexto') }} contenedor-select1" style="padding-right: 30px; display:none" name="legendary_DNI"
                        id="legendary_DNI" required>
                        <option value="%">--Legendarios--</option>
                        @if (isset($legendary) && count($legendary) > 0)
                            @foreach ($legendary as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('legendary_DNI', $legendaryDNI)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select1" style="padding-right: 30px;" name="staff_DNI"
                        id="staff_DNI" required>
                        <option value="%">--Staff--</option>
                        @if (isset($staff) && count($staff) > 0)
                            @foreach ($staff as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('staff_DNI', $staffDNI)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    @if(isset($statementStaff))
                        <span> Declaración en sala: </span>
                        <br>
                        <input class="{{ config('style.cajaTexto') }} statementStaff"  type="text" id="statementStaff" name="statementStaff"
                               maxlength="2" onkeypress="return valideKey(event);" style="width:40px"
                               value="{{ $statementStaff }}" 
                               @if($staffDNI =="%") disabled @endif/>
                    @endif
                    
                    <div class="p-1">
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            <a class="{{ Config::get('style.btnSave') }}"
                                href="{{ url('/exportar-tabla' . '/focus_declaracion' . '/' . $trainingId . '/F') }}">
                                Exportar</a> 
                        @endif
                    </div>
                    
                </form>
            @endif
        </div>
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">

        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div class="overflow-x-auto">
                    <div id="conResultados">
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="sticky top-0 bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerSequential') }}">
                                            @lang('No.')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Staff')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Participant')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Team Enroller')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Gafete')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Enrolador')
                                        </th>
                                        
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Attended')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Your')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Life')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:120px">
                                            @lang('Statement')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:120px">
                                            @lang('Comentario')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($focusParticipants as $theFocusParticipants)
                                        <tr class="border-b border-gray-200">
                                            <td @if(count($theFocusParticipants->comments) > 0) rowspan=2 style="border-bottom: 1px solid white;" @endif class="{{ Config::get('style.rowSequential') }} ">
                                                {{ $theFocusParticipants->secuencial }}
                                            </td>
                                            <td @if(count($theFocusParticipants->comments) > 0) rowspan=2 @endif class="{{ Config::get('style.rowLeftXs') }} border-b border-gray-200">
                                                {{ $theFocusParticipants->staff }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }} relative">
                                                {{ $theFocusParticipants->participant }} <br>
                                                {{ $theFocusParticipants->phone }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}">
                                                {{ $theFocusParticipants->team_enroller }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theFocusParticipants->nickname }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theFocusParticipants->enroller }} <br>
                                                {{ $theFocusParticipants->enroller_phone }}
                                            </td>
                                            
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theFocusParticipants->sunday_attended }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                @php
                                                    $words = explode(' ', $theFocusParticipants->payment_status_your);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo $initials;
                                                @endphp
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                @php
                                                    $words = explode(' ', $theFocusParticipants->payment_status_life);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo $initials;
                                                @endphp
                                            </td>
                                            
                                            <td class="{{ Config::get('style.rowCenterXs') }} my-2">
                                                @if ($theFocusParticipants->payment_status_your == 'PAGO TOTAL')
                                                    <span
                                                        class="px-3 py-2 bg-green-800 text-white text-xs" style="border-radius: 0.3rem;">CONFIRMADO</span>
                                                @else
                                                    <select 
                                                        class="attendance-select form-select rounded  px-1 py-0 text-xxs"
                                                        @if ($theFocusParticipants->confirm_assistance_next == 'ACUERDO') style="background-color:blue; color:white; font-size:0.8rem; padding:4px;" @endif
                                                        @if ($theFocusParticipants->confirm_assistance_next == 'NO INTERESA') style="background-color:red; color:white; font-size:0.8rem; padding:4px;" @endif
                                                        @if ($theFocusParticipants->confirm_assistance_next == 'POSIBILIDAD') style="background-color:orange; color:black; font-size:0.8rem; padding:4px;" @endif
                                                        @if ($theFocusParticipants->confirm_assistance_next == 'CONFIRMADO') style="background-color:green; color:white; font-size:0.8rem; padding:4px;" @endif
                                                        @if ($theFocusParticipants->confirm_assistance_next == '') class="" style="background-color:white; color:black; font-size:0.8rem; padding:4px;" @endif
                                                        
                                                        data-participant-id="{{ $theFocusParticipants->id }}">
                                                        <option value="0"><b>S/D</b></option>
                                                        <option value="POSIBILIDAD"
                                                            @if ($theFocusParticipants->confirm_assistance_next == 'POSIBILIDAD') selected @endif>
                                                            <b>POSIBILIDAD</b>
                                                        </option>
                                                        <option value="ACUERDO"
                                                            @if ($theFocusParticipants->confirm_assistance_next == 'ACUERDO') selected @endif>
                                                            <b>ACUERDO</b>
                                                        </option>
                                                        <option value="NO INTERESA"
                                                            @if ($theFocusParticipants->confirm_assistance_next == 'NO INTERESA') selected @endif>
                                                            <b>NO INTERESA</b>
                                                        </option>
                                                    </select>
                                                @endif
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} my-2">
                                                <!-- Botón para abrir el modal -->
                                                <button type="button" 
                                                        class="btn btn-primary" 
                                                        style="font-size:0.9rem; padding:5px; border:1px solid white"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#exampleModal"
                                                        data-bs-whatever="{{ $theFocusParticipants->participant }}"
                                                        data-bs-param1="{{ $theFocusParticipants->id }}"
                                                        data-bs-param2="{{ $theFocusParticipants->secuencial }}"
                                                        data-bs-param3"0"
                                                        data-bs-param4="">
                                                    Agregar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="detalle_{{ $theFocusParticipants->secuencial }}" class="detalle" style="background-color:#f7f7f7; @if(count($theFocusParticipants->comments) == 0) display:none @endif">
                                            
                                            <td colspan="9" style="padding:0px">
                                                <table  class="min-w-full divide-y divide-gray-200">
                                                    <tbody class="bg-gray-100">
                                                        @foreach ($theFocusParticipants->comments  as $comment) 
                                                            <tr class="border-b border-yellow-200">
                                                                <td class="{{ Config::get('style.rowLeftXs') }}" style="text-align:left; background-color:#f9f9c5">
                                                                   <b>{{ $comment->created_at }} {{ $comment->status }}</b> {{ $comment->comment }}
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    <button type="button"  style="display:none"
                                                                        class="{{ Config::get('style.btnDelete') }}"
                                                                        onclick="return confirm('多Seguro que deseas eliminar el departamento?')">
                                                                        <span
                                                                            class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                                    </button>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    <button type="button" data-bs-toggle="modal" style="display:none" 
                                                                        data-bs-target="#exampleModal" 
                                                                        data-bs-whatever="{{ $theFocusParticipants->participant }}"
                                                                        data-bs-param1="{{ $theFocusParticipants->id }}"
                                                                        data-bs-param2="{{ $theFocusParticipants->secuencial }}"
                                                                        data-bs-param3="{{ $comment->id }}"
                                                                        data-bs-param4="{{ $comment->comment }}" 
                                                                        class="{{ Config::get('style.btnEdit') }} " id="edit_comment_button">
                                                                        <i class="icon-pencil"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="{{ Config::get('style.rowInt') }}" style="width: 160px;">
                                                                   {{ $comment->name }}
                                                                </td>
                                                            </tr>
                                                         @endforeach
                                                    </tbody>
                                                </table>
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
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="focus_comments" method="POST"
                          action="{{ route('FocusStatementC.insertComment') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="focus_participant_id" name="focus_participant_id" >
                            <input type="hidden" class="form-control" id="focus_secuencial" name="focus_secuencial" >
                            <input type="hidden" class="form-control" id="comment_id" name="comment_id" >
                            <select class="{{ Config::get('style.cajaTexto') }}"  
                                style="padding-right: 30px;"
                                name="status"
                                id="status" required>
                                <option value="S/D">--Seleccione--</option>
                                <option value="POSIBILIDAD">POSIBILIDAD</option>
                                <option value="PRÓXIMA FECHA">PRÓXIMA FECHA</option>
                                <option value="POR CONFIRMAR">POR CONFIRMAR</option>
                                <option value="NO CONTESTA">NO CONTESTA</option>
                                <option value="NO LE INTERESA">NO LE INTERESA</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="col-form-label">Comentario:</label>
                            <textarea class="form-control form-control-autoresize" id="comment" name="comment"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer flex justify-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: .8rem">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Comentario</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var exampleModal = document.getElementById('exampleModal');
            var exampleModalLabel = document.getElementById('exampleModalLabel');
            var focusParticipantIdInput = document.getElementById('focus_participant_id');
            var focus_secuencial = document.getElementById('focus_secuencial');
            var comment_id = document.getElementById('comment_id');
            var focus_comment = document.getElementById('comment');
    
            exampleModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                var participant = button.getAttribute('data-bs-whatever');
                var focusId = button.getAttribute('data-bs-param1');
                var secuencial = button.getAttribute('data-bs-param2');
                var commentId = button.getAttribute('data-bs-param3');
                var comment = button.getAttribute('data-bs-param4');
                
                var modalTitle = exampleModal.querySelector('.modal-title');
    
                modalTitle.innerHTML = '';
    
                // Creamos el texto con el salto de línea usando insertAdjacentHTML
                modalTitle.insertAdjacentHTML('beforeend', 'Participante:<br><b>' + participant + '</b>');
    
                // Update modal inputs with extracted values
                exampleModalLabel.value = participant;
                focusParticipantIdInput.value = focusId;
                focus_secuencial.value = secuencial;
                comment_id.value = commentId;
                focus_comment.value = comment;
            });
    
            exampleModal.querySelector('.btn-primary').addEventListener('click', function () {
                sendComment();
                $('#exampleModal').modal('hide');
            });
            
            
            $('#attendance-select-filter').change(function() {
                var selectedColor = $(this).find('option:selected').css('background-color');
                var selectedTextColor = $(this).find('option:selected').css('color');
                $(this).css('background-color', selectedColor);
                $(this).css('color', selectedTextColor);
            });
            
        });
        
        function sendComment()
        {
            var focusParticipantIdInput = document.getElementById('focus_participant_id').value;
            var commentId = document.getElementById('comment_id').value;
            var comment = document.getElementById('comment').value;
            var comment_status = document.getElementById('status').value;
            var focus_secuencial = document.getElementById('focus_secuencial').value;
            
            if(focusParticipantIdInput == "")
            {
                alert("Selecciona el registro");
                return;
            }
                
            if(comment == "")
            {
                alert("Ingresa el comentario.");
                return;
            }
            
            $.ajax({
                    url: '/save-comment',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        focus_secuencial: focus_secuencial,
                        focus_participant_id: focusParticipantIdInput,
                        comment_id: commentId,
                        comment: comment,
                        status: comment_status,
                    },
                    success: function(response) {
                        $('#exampleModal').modal('hide');  // Close the modal after successful save
                        document.getElementById('comment').value = ''; 
                        
                        var secuencial = response.focus_secuencial;
                        var comments = response.comments;
                        
                        console.log(comments)
                    
                        // Construir el HTML de la tabla interna
                        var tableHtml = '';
                        comments.forEach(function(comment) {
                            tableHtml += '<tr class="border-b border-yellow-200">';
                            tableHtml += '<td class="{{ Config::get('style.rowLeftXs') }}" style="text-align:left; background-color:#f9f9c5"><b>' + comment.created_at + " " + comment.status + '</b> ' + comment.comment + '</td>';
                            tableHtml += '<td class="{{ Config::get('style.rowInt') }}" style="width: 240px;">' + comment.name + '</td>';
                            tableHtml += '</tr>';
                        });
                    
                        // Actualizar el contenido de la tabla interna
                        $('#detalle_' + secuencial + ' tbody').html(tableHtml);
                    
                        // Mostrar la fila si hay comentarios
                        if (comments.length > 0) {
                            $('#detalle_' + secuencial).show();
                        } else {
                            $('#detalle_' + secuencial).hide();
                        }
                    }
                });
        }
        
    </script>




   <script>
    $(document).ready(function() {
        // Captura el estado original de cada select
        $('.attendance-select').each(function() {
            $(this).data('original-status', $(this).val());
        });

        $('.attendance-select').on('change', function() {
            var participantId = $(this).data('participant-id');
            var newStatus = $(this).val();
            var originalStatus = $(this).data('original-status');
            var day = 'friday';
            
            var trainingId = document.getElementById('training_id');
            var staffDNISelect = document.getElementById('staff_DNI');
            var legendaryDNISelect = document.getElementById('legendary_DNI');
            
        

            // Realiza la solicitud AJAX original
            $.ajax({
                url: '/actualizar_estado_d/' + participantId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus,
                    staff_DNI: staffDNISelect.value,
                    legendary_DNI: legendaryDNISelect.value,
                    training_id: trainingId.value,
                },
                success: function(response) {
                    console.log(response);
                    // Utiliza la respuesta del servidor para actualizar los colores
                    color();
                    contar();
                    $('#meta').html(response['meta']);
                    $('#porcentaje_meta').html(response['porcentaje_meta']);
                }
            });
        });
        
        $('#statementStaff').on('change', function() {
            var trainingId = document.getElementById('training_id');
            var staffDNISelect = document.getElementById('staff_DNI');
            var statement = document.getElementById('statementStaff');
            // Realiza la solicitud AJAX original
            $.ajax({
                url: '/actualizar_statement_f/',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    training_id: trainingId.value,
                    staff_DNI: staffDNISelect.value,
                    statement: statement.value,
                },
                success: function(response) {
                }
            });
        });
        
        $('.contenedor-select').on('change', function() {
            var staffDNISelect = document.getElementById('staff_DNI');

            if (this.id == 'legendary_DNI') {
                staffDNISelect.selectedIndex = 0;
            }

            document.getElementById('focus1').submit();
        });
            
        $('.contenedor-select1').on('change', function() {
            var staffDNISelect = document.getElementById('staff_DNI');

            if (this.id == 'legendary_DNI') {
                staffDNISelect.selectedIndex = 0;
            }

            document.getElementById('focus2').submit();
        });
        
        // Inicializa los colores
        color();
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
    
    function color(status) {
    $('.attendance-select').each(function() {
        // Obtiene el valor del select o usa el estado pasado como parámetro
        var statement = status || $(this).val();

        // Define los colores y colores de fondo
        var colors = {
            'ACUERDO': 'white',
            'NO INTERESA': 'white',
            'POSIBILIDAD': 'black',
            '0': 'black'
        };
        var bgcolors = {
            'ACUERDO': 'blue',
            'NO INTERESA': 'red',
            'POSIBILIDAD': 'orange',
            '0': 'transparent'
        };

        // Establece el color y el color de fondo
        $(this).css({
            'color': colors[statement] || 'black',
            'background-color': bgcolors[statement] || 'transparent'
        });
    });
}
$(document).on('change', '.attendance-select', function() {
    color();
});
    
    function contar() {
        var countsStatus = {
            'posibilidad': 0,
            'acuerdo': 0
        };

        $('#tablaDatos tbody tr').each(function() {
            var status = $(this).find('.attendance-select').val();
            // Asegurarse de que status no sea undefined
            
            status = status || '';
    
            // Convertir el status a minúsculas para hacer la comparación insensible a mayúsculas y minúsculas
            status = status.toLowerCase();
    
            // Verificar si el status es 'posibilidad' o 'acuerdo'
            if (status === 'posibilidad' || status === 'acuerdo') {
                countsStatus[status]++;
            }
        });
    
        // Actualizar la vista con los conteos
        $('#posibility').html(countsStatus['posibilidad']);
        $('#agreement').html(countsStatus['acuerdo']);
    }
    
</script>

</x-app-layout>
