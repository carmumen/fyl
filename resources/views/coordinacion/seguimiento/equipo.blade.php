<?php
header('Content-Type: text/html; charset=utf-8');
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Equipo')
        </h2>
    </x-slot>
    <style>
        /* Contenedor de la tabla */
        .table-container {
            overflow-x: auto; /* Permite el desplazamiento horizontal */
            position: relative; /* Necesario para sticky */
            width: calc(100% - 20px); /* Ajusta el ancho total, dejando espacio para márgenes */
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
            z-index: 20; /* Asegura que está por encima del contenido */
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
            left: 45px; /* Ajusta este valor según el ancho de la primera columna */
            background-color: #075985; /* Fondo blanco para distinguir */
            color: white;
            z-index: 9; /* Asegura que se superponga a otras celdas */
        }
        #tablaDatos td:nth-child(2) {
            position: sticky;
            left: 45px; /* Ajusta este valor según el ancho de la primera columna */
            background-color: white; /* Fondo blanco para distinguir */
            
            z-index: 9; /* Asegura que se superponga a otras celdas */
        }
        
        .opciones {
            border: 0px solid white; 
            font-size: 0.9rem; 
            padding: 5px 0px 5px 10px; 
            border-radius: 15px";
            width: 3rem;
        }
    </style>

    <header>
        <div class="flex justify-between p-1" style="padding: 0px 20px"  >
                <span style="padding:20px; color:#075985; font-weight:bold">REGISTRO DE LÍNEA DE PARTICIPACIÓN</span>
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
    
    @if (isset($equipo) && count($equipo) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados" style="height:60vh; overflow:auto">
                        
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="max-width:600px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }} element-seguimient" style="padding: 10px">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">FDS 2</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">FDS 3</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($equipo as $theEquipo)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theEquipo->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }}  element-seguimient">
                                            {{ $theEquipo->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theEquipo->rol }}">
                                            @php
                                                $words = explode(' ', $theEquipo->rol);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <input class="opciones"
                                                    type="number" value ="{{ $theEquipo->fds_2 }}" 
                                                    name="fds_2"
                                                    maxlength="3"
                                                    min="1"
                                                    max="200"
                                                    data-participant-id="{{ $theEquipo->id }}|2|{{ $trainingId }}"
                                                    onkeypress="return validarTecla(event, this, 'fds_2')"
                                                    onchange="validarUnicidad(this, 'fds_2')">
                                        </td>
                                        <td class="text-center">
                                            <input class="opciones"
                                                    type="number" value ="{{ $theEquipo->fds_3 }}" 
                                                    name="fds_3"
                                                    maxlength="3"
                                                    min="1"
                                                    max="200"
                                                    data-participant-id="{{ $theEquipo->id }}|3|{{ $trainingId }}"
                                                    onkeypress="return validarTecla(event, this, 'fds_3')"
                                                    onchange="validarUnicidad(this, 'fds_3')">
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
           
        });
        
        function actualiza(participantId,selectedValue) {
            var partes = participantId.split('|');
            var id = partes[0]; 
            var campo = partes[1]; 
            var training = partes[2]; 
            
            var respuesta = selectedValue;

            $.ajax({
                url: '/actualizar_equipo/'+id+'/'+campo,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    campo: campo,
                    respuesta: respuesta,
                },
                success: function(response) {
                    //color();
                    console.log(response);
                }
            });
        }
        
        function validarUnicidad(input, name) {
            const value = input.value;
            const inputs = document.querySelectorAll(`input[name='${name}']`);
            let count = 0;
        
            inputs.forEach((item) => {
                if (item.value === value) {
                    count++;
                }
            });
        
            if (count > 1) {
                alert('El número ingresado ya existe. Por favor, ingresa un número único.');
                input.value = ''; // Limpiar el campo si hay un duplicado
            } else {
                actualiza(input.getAttribute('data-participant-id'), value);
            }
        }
        
        function validarTecla(event, input, name) {
            const value = input.value;
            const key = event.key;
        
            // Permitir teclas de control (Backspace, Delete, etc.)
            if (key === 'Backspace' || key === 'Delete' || key === 'ArrowLeft' || key === 'ArrowRight') {
                return true;
            }
        
            // Permitir solo números
            if (!/[0-9]/.test(key)) {
                event.preventDefault();
                return false;
            }
        
            // Comprobar longitud
            if (value.length >= 3) {
                event.preventDefault(); // Evitar que se escriban más de 3 dígitos
                return false;
            }
        
            // Validar el rango en tiempo real
            const newValue = parseInt(value + key);
            if (newValue > 200) {
                event.preventDefault(); // Evitar que se exceda 200
                return false;
            }
        
            return true; // Permitir la entrada
        }
        
    </script>

</x-app-layout>
