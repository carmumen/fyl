<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Actividades')
        </h2>
    </x-slot>
    <style>
        /* Contenedor de la tabla */
        .table-container {
            overflow-x: auto; /* Permite el desplazamiento horizontal */
            position: relative; /* Necesario para sticky */
            width: calc(100% - 20px); /* Ajusta el ancho total, dejando espacio para m���rgenes */
            margin: 10px; /* Espaciado alrededor del contenedor */
        }
        
        /* Estilos para la tabla */
        #tablaDatos {
            border-collapse: collapse;
            width: 100%; /* Asegura que la tabla use el ancho completo */
        }
        #tablaDatos thead {
            position: sticky;
            top: 0; /* Fija la fila en la parte superior */
            background-color: #075985; /* Fondo de la fila */
            color: white; /* Color del texto */
            z-index: 20; /* Asegura que est��� por encima del contenido */
        }
        
        /* Estilo para las celdas de la tabla */
        #tablaDatos th, #tablaDatos td {
            padding: 10px;
            border: 1px solid #ccc; /* Opcional, puedes ajustarlo */
        }
        
        /* Fijar la primera columna */
        #tablaDatos th:first-child,
        #tablaDatos td:first-child {
            position: sticky;
            left: 0;
            background-color: #075985; /* Fondo blanco para distinguir */
            color: white;
            z-index: 10; /* Asegura que se superponga a otras celdas */
        }
        
        /* Fijar la segunda columna */
        #tablaDatos th:nth-child(2){
            position: sticky;
            left: 45px; /* Ajusta este valor seg���n el ancho de la primera columna */
            background-color: #075985; /* Fondo blanco para distinguir */
            color: white;
            z-index: 9; /* Asegura que se superponga a otras celdas */
        }
        #tablaDatos td:nth-child(2) {
            position: sticky;
            left: 45px; /* Ajusta este valor seg���n el ancho de la primera columna */
            background-color: white; /* Fondo blanco para distinguir */
            
            z-index: 9; /* Asegura que se superponga a otras celdas */
        }
        
        .opciones {
            border: 0px solid white; 
            font-size: 0.9rem; 
            padding: 5px 30px 5px 10px; 
            border-radius: 15px";
        }
    </style>

    <header>
        <div class="flex justify-between p-1" style="padding: 0px 20px"  >
                <span style="padding:20px; color:#075985; font-weight:bold">REGISTRO DE ACTIVIDADES</span>
                <form id="form_retorno" action="{{ route('Seguimiento.obtenerEntrenamiento') }}" method="POST">
                    @csrf
                    <input type="hidden" value ="{{ $campusId }}" name="campus_id" >
                    <input type="hidden" value ="{{ $trainingId }}" name="training_id" >
                </form>
                <div class="flex items-center justify-between m-4">
                    <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_retorno">@lang('To return')</button> 
                </div>
                
        </div>
    </header>
    
    @if (isset($actividades) && count($actividades) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados" style="height:60vh; overflow:auto">
                        
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:2500px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }} element-seguimient" style="padding: 10px;">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Reuni&oacute;n<br>Coordinaci&oacute;n</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Actividad<br>Confianza</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Revisi&oacute;n<br>Promesas</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Toma<br>Foto Inicial</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">L&iacute;nea<br>Abrazos 1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Marcha<br>Legendarios 1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Actividad<br>Tanque</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Punto<br>Magia</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Revisi&oacute;n<br>Promesas 1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Vuelos<br>1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Susurros</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Reto<br>Dinero</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Seguimiento<br>Promesas 1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">L&iacute;nea<br>Abrazos 2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Paso<br>Antorcha</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Marcha<br>Legendarios 2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rompimiento<br>Barreras</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Reto<br>Tiempo</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Seguimiento<br>Promesas 2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Vuelos<br>2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Mezcla<br>Intimar Susurros</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Revisi&oacute;n<br>Promesas 2</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($actividades as $theActividades)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theActividades->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }} element-seguimient">
                                            {{ $theActividades->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theActividades->rol }}">
                                            @php
                                                $words = explode(' ', $theActividades->rol);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->reunion_coordinacion == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->reunion_coordinacion == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rc|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->reunion_coordinacion === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->reunion_coordinacion === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->actividad_confianza == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->actividad_confianza == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|ac|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->actividad_confianza === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->actividad_confianza === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->revision_promesas == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->revision_promesas == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rp|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->revision_promesas === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->revision_promesas === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->toma_foto_inicial == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->toma_foto_inicial == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|tf|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->toma_foto_inicial === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->toma_foto_inicial === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->linea_abrazos_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->linea_abrazos_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|la1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->linea_abrazos_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->linea_abrazos_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->marcha_legendarios_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->marcha_legendarios_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|ml1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->marcha_legendarios_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->marcha_legendarios_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->actividad_tanque == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->actividad_tanque == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|at|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->actividad_tanque === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->actividad_tanque === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->punto_magia == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->punto_magia == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|pm|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->punto_magia === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->punto_magia === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->revision_promesas_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->revision_promesas_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rp1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->revision_promesas_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->revision_promesas_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->vuelos_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->vuelos_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|v1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->vuelos_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->vuelos_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->susurros == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->susurros == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|s|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->susurros === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->susurros === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->reto_dinero == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->reto_dinero == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rd|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->reto_dinero === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->reto_dinero === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->seguimiento_promesas_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->seguimiento_promesas_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|sp1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->seguimiento_promesas_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->seguimiento_promesas_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->linea_abrazos_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->linea_abrazos_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|la2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->linea_abrazos_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->linea_abrazos_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->paso_antorcha == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->paso_antorcha == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|pa|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->paso_antorcha === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->paso_antorcha === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->marcha_legendarios_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->marcha_legendarios_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|ml2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->marcha_legendarios_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->marcha_legendarios_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->rompimiento_barreras == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->rompimiento_barreras == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rb|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->rompimiento_barreras === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->rompimiento_barreras === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->reto_tiempo == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->reto_tiempo == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rt|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->reto_tiempo === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->reto_tiempo === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->seguimiento_promesas_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->seguimiento_promesas_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|sp2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->seguimiento_promesas_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->seguimiento_promesas_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->vuelos_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->vuelos_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|v2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->vuelos_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->vuelos_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->mezcla_intimar_susurros == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->mezcla_intimar_susurros == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|mis|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->mezcla_intimar_susurros === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->mezcla_intimar_susurros === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theActividades->revision_promesas_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theActividades->revision_promesas_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theActividades->id }}|rp2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theActividades->revision_promesas_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theActividades->revision_promesas_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </main>
            </div>
        </div>
    
    @endif
    
    <script>
        $(document).ready(function () {
            color();
        });
        
        function actualiza(participantId,selectedValue) {
            var partes = participantId.split('|');
            var id = partes[0]; 
            var campo = partes[1]; 
            var training = partes[2]; 
            
            var respuesta = selectedValue;

            $.ajax({
                url: '/actualizar_actividad/'+id+'/'+campo,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    campo: campo,
                    respuesta: respuesta,
                },
                success: function(response) {
                    color();
                    console.log(response);
                }
            });
        }
        
        function color(){
            $('.asiste-select').each(function() {
                // Obtiene el valor del select o usa el estado pasado como parámetro
                var statement = status || $(this).val();
        
                // Define los colores y colores de fondo
                var colors = {
                    'SI': 'green',
                    'NO': 'red',
                    '': 'black'
                };
                var bgcolors = {
                    'SI': '#e5f9e5',
                    'NO': '#fce5d6',
                    '': 'white'
                };
                var border = {
                    'SI': '1px solid green',
                    'NO': '1px solid red',
                    '': '1px solid white'
                };
        
                // Establece el color y el color de fondo
                $(this).css({
                    'font-weight': 'bold',
                    'color': colors[statement] || 'black',
                    'background-color': bgcolors[statement] || 'transparent',
                    'border': border[statement] || 'transparent',
                });
            });
        }
    </script>

</x-app-layout>
