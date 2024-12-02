<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Llamadas')
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
                <span style="padding:20px; color:#075985; font-weight:bold">REGISTRO DE LLAMADAS</span>
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
    
    @if (isset($llamadas) && count($llamadas) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados" style="height:60vh; overflow:auto">
                        
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="width:1500px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }} element-seguimient" style="padding: 10px">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
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
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theLlamadas->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }} element-seguimient" >
                                            {{ $theLlamadas->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theLlamadas->rol }}">
                                            @php
                                                $words = explode(' ', $theLlamadas->rol);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_1 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_1 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|1|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_1 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_1 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_2 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_2 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|2|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_2 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_2 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_3 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_3 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|3|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_3 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_3 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_4 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_4 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|4|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_4 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_4 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_5 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_5 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|5|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_5 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_5 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_6 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_6 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|6|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_6 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_6 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_7 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_7 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|7|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_7 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_7 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_8 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_8 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|8|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_8 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_8 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_9 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_9 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|9|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_9 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_9 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_10 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_10 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|10|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_10 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_10 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_11 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_11 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|11|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_11 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_11 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_12 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_12 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|12|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_12 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_12 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_13 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_13 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|13|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_13 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_13 === 'NO') selected @endif>
                                                    NO
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="opciones asiste-select" style="border-radius:15px" onchange="actualiza(this.getAttribute('data-participant-id'), this.value)"
                                                @if ($theLlamadas->llamada_14 == 'SI') style="background-color:green; color:white;" @endif
                                                @if ($theLlamadas->llamada_14 == 'NO') style="background-color:orange; color:white;" @endif
                                                data-participant-id="{{ $theLlamadas->id }}|14|{{ $trainingId }}">
                                                <option value=""></option>
                                                <option value="SI"
                                                    @if ($theLlamadas->llamada_14 === 'SI') selected @endif>
                                                    SI
                                                </option>
                                                <option value="NO"
                                                    @if ($theLlamadas->llamada_14 === 'NO') selected @endif>
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
