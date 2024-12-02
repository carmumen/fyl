<?php
header('Content-Type: text/html; charset=utf-8');
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Comunidad')
        </h2>
    </x-slot>
    <style>
        /* Contenedor de la tabla */
        .table-container {
            overflow-x: auto; /* Permite el desplazamiento horizontal */
            position: relative; /* Necesario para sticky */
            width: calc(100% - 20px); /* Ajusta el ancho total, dejando espacio para mè´°rgenes */
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
            z-index: 20; /* Asegura que estè´° por encima del contenido */
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
            left: 45px; /* Ajusta este valor segè´‚n el ancho de la primera columna */
            background-color: #075985; /* Fondo blanco para distinguir */
            color: white;
            z-index: 9; /* Asegura que se superponga a otras celdas */
        }
        #tablaDatos td:nth-child(2) {
            position: sticky;
            left: 45px; /* Ajusta este valor segè´‚n el ancho de la primera columna */
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
                <span style="padding:20px; color:#075985; font-weight:bold">REGISTRO DE LEGADO Y MINI LEGADO</span>
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
    
    @if (isset($comunidad) && count($comunidad) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados" style="height:60vh; overflow:auto">
                        
                        <table id="tablaDatos" class="divide-y divide-gray-200" style="max-width:600px; margin:0px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }} element-seguimient" style="padding: 10px;">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">MINI LEGADO</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">LEGADO</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($comunidad as $theComunidad)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theComunidad->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }} element-seguimient" >
                                            {{ $theComunidad->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theComunidad->rol }}">
                                            @php
                                                $words = explode(' ', $theComunidad->rol);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <input class="opciones"
                                                    type="number" value ="{{ $theComunidad->mini_legado }}" 
                                                    name="mini_legado"
                                                    maxlength="3"
                                                    min="1"
                                                    max="100"
                                                    data-participant-id="{{ $theComunidad->id }}|ml|{{ $trainingId }}"
                                                    onkeypress="return validarTecla(event, this, 'mini_legado')"
                                                    onchange="actualiza(this.getAttribute('data-participant-id'), this.value)">
                                        </td>
                                        <td class="text-center">
                                            <input class="opciones"
                                                    type="number" value ="{{ $theComunidad->legado }}" 
                                                    name="legado"
                                                    maxlength="3"
                                                    min="1"
                                                    max="100"
                                                    data-participant-id="{{ $theComunidad->id }}|l|{{ $trainingId }}"
                                                    onkeypress="return validarTecla(event, this, 'legado')"
                                                    onchange="actualiza(this.getAttribute('data-participant-id'), this.value)">
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
                url: '/actualizar_comunidad/'+id+'/'+campo,
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
        
        function validarTecla(event, input, name) {
            const value = input.value;
            const key = event.key;
        
            // Permitir teclas de control (Backspace, Delete, etc.)
            if (key === 'Backspace' || key === 'Delete' || key === 'ArrowLeft' || key === 'ArrowRight') {
                return true;
            }
        
            // Permitir solo nè´‚meros
            if (!/[0-9]/.test(key)) {
                event.preventDefault();
                return false;
            }
        
            // Comprobar longitud
            if (value.length >= 3) {
                event.preventDefault(); // Evitar que se escriban mè´°s de 3 dè´øgitos
                return false;
            }
        
            // Validar el rango en tiempo real
            const newValue = parseInt(value + key);
            if (newValue > 100) {
                event.preventDefault(); // Evitar que se exceda 200
                return false;
            }
        
            return true; // Permitir la entrada
        }
        
    </script>

</x-app-layout>
