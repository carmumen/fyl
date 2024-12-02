<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Asignaciones')
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
                <span style="padding:20px; color:#075985; font-weight:bold">REGISTRO DE ASIGNACIONES</span>
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
    
    @if (isset($asignaciones) && count($asignaciones) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados" style="height:60vh; overflow:auto">
                        
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:1000px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }} element-seguimient" style="padding: 10px">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
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
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theAsignaciones->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }} element-seguimient">
                                            {{ $theAsignaciones->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theAsignaciones->rol }}">
                                            @php
                                                $words = explode(' ', $theAsignaciones->rol);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->los_4_acuerdos == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->los_4_acuerdos == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|l4a|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->los_4_acuerdos === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->los_4_acuerdos === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->kung_fu_panda == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->kung_fu_panda == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|kfp|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->kung_fu_panda === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->kung_fu_panda === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->avatar == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->avatar == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|a|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->avatar === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->avatar === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->santo_surfista_ejecutivo == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->santo_surfista_ejecutivo == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|sse|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->santo_surfista_ejecutivo === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->santo_surfista_ejecutivo === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->sociedad_de_la_nieve == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->sociedad_de_la_nieve == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|sdln|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->sociedad_de_la_nieve === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->sociedad_de_la_nieve === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->maestria_del_amor == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->maestria_del_amor == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|mda|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->maestria_del_amor === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->maestria_del_amor === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->el_precio_del_manana == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->el_precio_del_manana == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|epdm|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->el_precio_del_manana === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->el_precio_del_manana === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theAsignaciones->elementos == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theAsignaciones->elementos == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theAsignaciones->id }}|e|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theAsignaciones->elementos === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theAsignaciones->elementos === 'NO') selected @endif>
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
                url: '/actualizar_asignacion/'+id+'/'+campo,
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
