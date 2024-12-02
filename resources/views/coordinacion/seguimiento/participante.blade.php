<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Seguimiento Participante')
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
            border: 1px solid white; 
            font-size: 0.9rem; 
            padding: 5px 20px; 
            border-radius: 15px";
        }
    </style>

    <header>
        <div class="flex justify-between p-1" style="padding: 0px 20px"  >
            @if (isset($participante) && count($participante) > 0)
                @if (isset($actividades) && count($actividades) > 0)
                    <span style="padding:20px; color:#075985; font-weight:bold">{{ $actividades[0]->rol }}</span>
                @else
                    <span style="padding:20px; color:#075985; font-weight:bold"></span>
                @endif
                <span style="padding:20px; color:#075985; font-weight:bold">{{ $participante[0]->surnames_names }}</span>
                <form id="form_retorno" action="{{ route('Seguimiento.obtenerEntrenamiento') }}" method="POST">
                    @csrf
                    <input type="hidden" value ="{{ $campusId }}" name="campus_id" >
                    <input type="hidden" value ="{{ $trainingId }}" name="training_id" >
                </form>
                <div class="flex items-center justify-between m-4">
                    <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_retorno">@lang('To return')</button> 
                </div>
            @else
                <div class="flex justify-center p-1" style="padding: 0px 20px"  >
                    No se reconoce el participante.
                </div>
            @endif
        </div>
    </header>
    
    
    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div>
                    <form class="px-8 py-4" method="POST" action="{{ route('Seguimiento.store') }}">
                        @csrf
                    
                        <div class="flex items-center justify-between mt-2 mb-2">
                            <button class="{{ Config::get('style.btnSave') }}" type="submit">Registrar llamada</button>
                        </div>
                    
                        <textarea cols="5" rows="3" style="width: 100%;" name="resumen_llamada" placeholder="Escribe el resumen de la llamada..."></textarea>
                    
                        <input type="hidden" name="llamada_id">
                        <input type="hidden" value ="{{ $campusId }}" name="campus_id" >
                        <input type="hidden" value="{{ $trainingId }}" name="training_id">
                        <input type="hidden" value="{{ $participant_DNI }}" name="participant_DNI">
                    </form>

                </div>
                <div id="conResultados" style="overflow:auto">
                    
                    
                    
                    @if (isset($llamada_coordinacion) && count($llamada_coordinacion) > 0)
                        <table id="tablaDatos1" class="divide-y divide-gray-200" style="width:100%; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">FECHA</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">RESUMEN DE LLAMADA</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">COORDINADOR</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($llamada_coordinacion as $theLlamadaCoordinacion)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px; width:40px">
                                            {{ $theLlamadaCoordinacion->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px; width:100px">
                                            {{ $theLlamadaCoordinacion->fecha }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }}" style="padding: 5px; font-size: .8rem; text-align:justify">
                                            {{ $theLlamadaCoordinacion->resumen_llamada }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px; width:100px">
                                            {{ $theLlamadaCoordinacion->usuario }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    @endif
                    
                    
                    @if (isset($actividades) && count($actividades) > 0)
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:2500px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px"></th>
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
                                        <td class="text-center" style="width:170px">
                                            ACTIVIDADES
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->reunion_coordinacion === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->reunion_coordinacion === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->reunion_coordinacion }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->actividad_confianza === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->actividad_confianza === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->actividad_confianza }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->revision_promesas === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->revision_promesas === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->revision_promesas }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->toma_foto_inicial === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->toma_foto_inicial === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->toma_foto_inicial }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->linea_abrazos_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->linea_abrazos_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->linea_abrazos_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->marcha_legendarios_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->marcha_legendarios_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->marcha_legendarios_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->actividad_tanque === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->actividad_tanque === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->actividad_tanque }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->punto_magia === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->punto_magia === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->punto_magia }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->revision_promesas_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->revision_promesas_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->revision_promesas_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->vuelos_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->vuelos_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->vuelos_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->susurros === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->susurros === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->susurros }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->reto_dinero === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->reto_dinero === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->reto_dinero }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->seguimiento_promesas_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->seguimiento_promesas_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->seguimiento_promesas_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->linea_abrazos_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->linea_abrazos_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->linea_abrazos_2 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->paso_antorcha === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->paso_antorcha === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->paso_antorcha }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->marcha_legendarios_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->marcha_legendarios_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->marcha_legendarios_2 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->rompimiento_barreras === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->rompimiento_barreras === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->rompimiento_barreras }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->reto_tiempo === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->reto_tiempo === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->reto_tiempo }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->seguimiento_promesas_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->seguimiento_promesas_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->seguimiento_promesas_2 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->vuelos_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->vuelos_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->vuelos_2 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->mezcla_intimar_susurros === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->mezcla_intimar_susurros === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->mezcla_intimar_susurros }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theActividades->revision_promesas_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theActividades->revision_promesas_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theActividades->revision_promesas_2 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <br>
                <div id="conResultados" style="overflow:auto">
                    @if (isset($asignaciones) && count($asignaciones) > 0)
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:1200px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px"></th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Los 4 Acuerdos</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Kung Fu Panda</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Avatar</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">El Santo, El Surfista y EL Ejecutivo</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Sociedad de la Nieve</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">La Maestria del Amor</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">El Precio del Manana</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Elementos</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($asignaciones as $theAsignaciones)
                                    <tr class="border-b border-gray-200">
                                        <td class="text-center" style="width:170px">
                                            ASIGNACIONES
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->los_4_acuerdos === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->los_4_acuerdos === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->los_4_acuerdos }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->kung_fu_panda === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->kung_fu_panda === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->kung_fu_panda }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->avatar === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->avatar === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->avatar }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->santo_surfista_ejecutivo === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->santo_surfista_ejecutivo === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->santo_surfista_ejecutivo }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->sociedad_de_la_nieve === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->sociedad_de_la_nieve === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->sociedad_de_la_nieve }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->maestria_del_amor === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->maestria_del_amor === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->maestria_del_amor }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->el_precio_del_manana === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->el_precio_del_manana === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->el_precio_del_manana }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theAsignaciones->elementos === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theAsignaciones->elementos === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theAsignaciones->elementos }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <br>
                <div id="conResultados" style="overflow:auto">
                    @if (isset($llamadas) && count($llamadas) > 0)
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:1500px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px"></th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">1</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">3</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">4</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">5</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">6</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">7</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">8</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">9</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">10</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">11</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">12</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">13</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">14</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($llamadas as $theLlamadas)
                                    <tr class="border-b border-gray-200">
                                        <td class="text-center" style="width:170px">
                                            LLAMADAS
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_1 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_1 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_2 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_2 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_2 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_3 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_3 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_3 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_4 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_4 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_4 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_5 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_5 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_5 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_6 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_6 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_6 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_7 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_7 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_7 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_8 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_8 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_8 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_9 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_9 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_9 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_10 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_10 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_10 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_11 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_11 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_11 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_12 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_12 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_12 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_13 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_13 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_13 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="opciones" style="border-radius:15px;
                                                @if ($theLlamadas->llamada_14 === 'SI') border: 1px solid green; background-color:#e5f9e5; color:green; @endif
                                                @if ($theLlamadas->llamada_14 === 'NO') border: 1px solid red; background-color:#fce5d6; color:red; @endif"
                                            >
                                                {{ $theLlamadas->llamada_14 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <br>
                <div id="conResultados" style="overflow:auto;">
                    @if (isset($equipo) && count($equipo) > 0)
                        <table id="tablaDatos1" class="divide-y divide-gray-200" style="width:100%; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th colspan="2" style="padding:3px; color:black; font-size:.8rem; background-color:#FFABAB; border: 1px solid white;">ENROLAMIENTO</th>
                                    <th colspan="2" style="padding:3px; color:black; font-size:.8rem; background-color:#A3C1DA; border: 1px solid white;">EQUIPO</th>
                                    <th colspan="2" style="padding:3px; color:black; font-size:.8rem; background-color:#B9FBC0; border: 1px solid white;">COMUNIDAD</th>
                                </tr>
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">ENROLADOS</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">SENTADOS</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">FDS 2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">FDS 3</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">MINI LEGADO</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px; border: 1px solid white;">LEGADO</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                <tr class="border-b border-gray-200">
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $enrolados }}</span>
                                    </td>
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $sentados }}</span>
                                    </td>
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $equipo[0]->fds_2 }}</span>
                                    </td>
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $equipo[0]->fds_3 }}</span>
                                    </td>
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $comunidad[0]->mini_legado }}</span>
                                    </td>
                                    <td class="text-center" style="padding: 10px; border: 1px solid #075985;">
                                        <span>{{ $comunidad[0]->legado }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </main>
        </div>
    </div>
  
    
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
                url: '/actualizar_llamada/'+id+'/'+campo,
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
