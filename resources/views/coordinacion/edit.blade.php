<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-200" style="color: #085986;">
            {{ __('Mis Promesas') }}
        </h2>
    </x-slot>
    
    <style>
        .custom-paragraph {
            max-width: 100%;
            text-align: justify;
            /* Otros estilos personalizados según sea necesario */
        }
    </style>
    
    <style>
    .scrollable-content {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .scrollable-content::-webkit-scrollbar {
        width: 9px; /* Ancho de la barra de desplazamiento */
        padding-left:10px;
    }
    
    .scrollable-content::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color de la pista */
    }
    
    .scrollable-content::-webkit-scrollbar-thumb {
        background: #085986; /* Color del pulgar */
        border-radius: 10px; /* Esquinas redondeadas */
    }
    
    .scrollable-content::-webkit-scrollbar-thumb:hover {
        background: #085986; /* Color del pulgar al pasar el mouse */
    }
    </style>
    
    <div class="flex items-center justify-center mb-3 mt-3">
        <span class="text-center" style="color:#085986; font-size: 1.5rem"><b>{{ $Participante }}</b></span>
    </div>
    <div class="flex items-start justify-between mt-4 mx-4">
        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_retorno">@lang('To return')</button> 
        <form id="form_retorno" action="{{ route('Promesa.index') }}" method="GET">
            @csrf
            <input type="hidden" value ="{{ $Promesa[0]->training_id }}" name="training_id" >
        </form>
    </div>
    
    <div class="flex">
        
    <!-- Columna izquierda (utiliza el resto del espacio) -->
    <div class="flex-1 bg-gray-200 p-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="bg-sky-800 py-2">
                <span class="{{ Config::get('style.headerCenter') }}">Revisión de Promesas</span>
            </div>
            
            <div class="p-6 text-gray-900 dark:text-gray-100 ">
                @if (!isset($Contrato[0]->id))
                    <div class="flex items-center justify-center mb-3 mt-3">
                        <span style="color:red">Solicitar al Participante que cargue la información de su contrato.</span>
                    </div>
                @endif
                <div class="py-5 scrollable-content px-3">    
                    @if (isset($Contrato[0]->id))
                        <div id="fila_{{ $Contrato[0]->id }}">  
                            
                            <div class="flex items-center justify-between mb-3" style="border-bottom: 1px solid #085986">
                                <span style="color:#085986; font-weight:bold; font-size:1.3rem">CONTRATO, VISIÓN Y PROPÓSITO</span>
                                <span class="@if ($Contrato[0]->estado == 'PENDIENTE APROBACIÓN') bg-orange-500 text-white @endif
                                            @if ($Contrato[0]->estado == 'OBSERVADO') bg-red-500 text-white @endif
                                            @if ($Contrato[0]->estado == 'APROBADO') bg-green-500 text-white @endif px-2">
                                    {{ $Contrato[0]->estado }}
                                </span>
                            </div>
                        
                            <br>
                        
                            <div class=" mb-3">
                                <div class="form-group row">
                                    <label for="promesa" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">CONTRATO:</label>
                                    <div class="col-sm-10">
                                        <p style="text-align:justify">
                                            {{ $Contrato[0]->contrato }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="vision" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">VISIÓN:</label>
                                    <div class="col-sm-10">
                                        <p style="max-width: 100%; text-align: justify;">
                                            {{ $Contrato[0]->vision }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="proposito" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">PROPÓSITO:</label>
                                    <div class="col-sm-10">
                                        <p style="text-align:justify">
                                            {{ $Contrato[0]->proposito }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                
                            </div>
                            <form id="form_contrato" action="{{ route('Promesa.updateContrato', $Contrato[0]->id ) }}" method="POST">
                                @csrf @method('POST')
                                
                                <input type="hidden" name="id" value="{{ $Contrato[0]->id }}" >
                                
                                <div class="flex flex-col space-y-4">
                                    <!-- Opción APROBAR -->
                                    <div class="flex items-center">
                                        <input type="radio" id="aprobar-contrato_{{ $Contrato[0]->id }}" name="estado" value="APROBADO" class="form-radio" onclick=contratoSeleccion(this.id)>
                                        <label for="aprobar-contrato_{{ $Contrato[0]->id }}" class="ml-2">APROBAR</label>
                                    </div>
                            
                                    <!-- Opción OBSERVAR -->
                                    <div class="flex items-center">
                                        <input type="radio" id="observar-contrato_{{ $Contrato[0]->id }}" name="estado" value="OBSERVADO" class="form-radio" onclick=contratoSeleccion(this.id)>
                                        <label for="observar-contrato_{{ $Contrato[0]->id }}" class="ml-2">OBSERVAR</label>
                                    </div>
                            
                                    <!-- Campo de texto para OBSERVAR, inicialmente oculto -->
                                    <div id="contrato-container_{{ $Contrato[0]->id }}" class="hidden">
                                        <label for="contrato_{{ $Contrato[0]->id }}" class="block">Escribe tu observación:</label>
                                        <textarea id="contrato_{{ $Contrato[0]->id }}" name="observacion" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                    </div>
                            
                                    <!-- Botón para enviar el formulario -->
                                    <button type="submit" class="bg-sky-700 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Enviar
                                    </button>
                                    <br>
                                </div>
                            </form>
                        </div>
                    @endif
        
                    @if (isset($Promesa))
                        @foreach ($Promesa as $thePromesa)
                            <div id="fila_{{ $thePromesa->secuencial }}" data-id-secuencial="{{ $thePromesa->id }},{{ $thePromesa->secuencial }}">
                                <div class="flex items-center justify-between mb-3" style="border-bottom: 1px solid #085986">
                                    <span style="color:#085986; font-weight:bold; font-size:1.3rem">PROMESA {{ $thePromesa->secuencial }}</span>
                                    <span class="@if ($thePromesa->estado == 'PENDIENTE APROBACIÓN') bg-orange-500 text-white @endif
                                                @if ($thePromesa->estado == 'OBSERVADO') bg-red-500 text-white @endif
                                                @if ($thePromesa->estado == 'APROBADO') bg-green-500 text-white @endif px-2">
                                        {{ $thePromesa->estado }}
                                    </span>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="promesa" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">Promesa:</label>
                                    <div class="col-sm-10">
                                        <p style="text-align:justify">
                                            {{ $thePromesa->promesa }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="vision" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">Formas de Ser:</label>
                                    <div class="col-sm-10">
                                        <p style="max-width: 100%; text-align: justify;">
                                            {{ $thePromesa->formas_de_ser }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="proposito" class="col-sm-2 col-form-label ps-5" style="color: #085986; font-weight: bold">Acciones:</label>
                                    <div class="col-sm-10">
                                        <p style="text-align:justify">
                                            {{ $thePromesa->acciones }}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                
                                <form id="form_promesa_{{ $thePromesa->id }}" action="{{ route('Promesa.update', $thePromesa->id ) }}" method="POST">
                                    @csrf @method('PATCH')
                                    
                                    <input type="hidden" name="id" value="{{ $thePromesa->id }}" >
                                    <input type="hidden" name="participant_DNI" value="{{ $thePromesa->participant_DNI }}" >
                                    <input type="hidden" name="training_id" value="{{ $thePromesa->training_id }}" >
                                    <input type="hidden" name="training_id" value="{{ $thePromesa->training_id }}" >
                                    <input type="hidden" name="promesa" value="{{ $thePromesa->secuencial }}" >
                                    
                                    <div class="flex flex-col space-y-4">
                                        <!-- Opción APROBAR -->
                                        <div class="flex items-center">
                                            <input type="radio" id="aprobar_{{ $thePromesa->id }}" name="estado" value="APROBADO" class="form-radio" onclick=seleccion(this.id)>
                                            <label for="aprobar_{{ $thePromesa->id }}" class="ml-2">APROBAR</label>
                                        </div>
                                
                                        <!-- Opción OBSERVAR -->
                                        <div class="flex items-center">
                                            <input type="radio" id="observar_{{ $thePromesa->id }}" name="estado" value="OBSERVADO" class="form-radio" onclick=seleccion(this.id)>
                                            <label for="observar_{{ $thePromesa->id }}" class="ml-2">OBSERVAR</label>
                                        </div>
                                
                                        <!-- Campo de texto para OBSERVAR, inicialmente oculto -->
                                        <div id="observacion-container_{{ $thePromesa->id }}" class="hidden">
                                            <label for="observacion_{{ $thePromesa->id }}" class="block">Escribe tu observación:</label>
                                            <textarea id="observacion_{{ $thePromesa->id }}" name="observacion" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                        </div>
                                
                                        <!-- Botón para enviar el formulario -->
                                        <button type="submit" class="bg-sky-700 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                            Enviar
                                        </button>
                                        <br>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                        </br>
                    @endif
                </div>
    
            </div>
        </div>
    </div>

    <!-- Columna derecha (ancho fijo de 300px) -->
    <div class="bg-gray-200 p-4" style="width:40%">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="bg-sky-800 py-2">
                <span class="{{ Config::get('style.headerCenter') }}">Observaciones realizadas</span>
            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100 ">
                <div class="py-5 scrollable-content px-3">
                    @if (isset($ObservacionContrato))
                    @foreach ($ObservacionContrato as $theObservacion)
                        @if($theObservacion->updated_at)
                        
                            <div class="flex items-center justify-between mb-3" style="border-bottom: 1px solid #085986">
                                <span style="color:#085986; font-weight:bold; font-size:0.8rem">CONTRATO</span>
                                <span style="color:#ff9000; font-weight:bold; font-size:0.8rem">{{ $theObservacion->updated_at }}</span>
                                <span class=" px-2" style="color: #085986">
                                    {{ $theObservacion->name }}
                                </span>
                            </div>
                            <div class="mb-3" style="text_align:justify">
                                <p class="formatted-text" style="text-align:justify">
                                    {{ $theObservacion->observacion }}
                                </p>
                            </div>
                            <br>
                        @endif
                    @endforeach
                    @endif
                    
                    @foreach ($Observacion as $theObservacion)
                        @if($theObservacion->updated_at)
                        
                            <div class="flex items-center justify-between mb-3" style="border-bottom: 1px solid #085986">
                                <span style="color:#085986; font-weight:bold; font-size:0.8rem">PROMESA</span>
                                <span style="color:#ff9000; font-weight:bold; font-size:0.8rem">{{ $theObservacion->updated_at }}</span>
                                <span class=" px-2" style="color: #085986">
                                    {{ $theObservacion->name }}
                                </span>
                            </div>
                            <div class="mb-3" style="text_align:justify">
                                <p class="formatted-text" style="text-align:justify">
                                    {{ $theObservacion->observacion }}
                                </p>
                            </div>
                            <br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        function contratoSeleccion(valor) {
            // Dividir el valor en partes
            const partes = valor.split('_');
            const estado = partes[0];
            const id = partes[1];
        
            // Mostrar el estado y el id en la consola
            console.log(estado);
            console.log(id);
        
            // Verificar si el estado es 'observar'
            if (estado === 'observar-contrato') {
                const caja = 'contrato-container_' + id;
                const observacionTexto = document.getElementById(caja);
        
                // Verificar si el elemento existe antes de manipularlo
                if (observacionTexto) {
                    observacionTexto.classList.remove('hidden');
                } else {
                    console.warn('Elemento con id ' + caja + ' no encontrado.');
                }
            }
        }
        
        function seleccion(valor) {
            // Dividir el valor en partes
            const partes = valor.split('_');
            const estado = partes[0];
            const id = partes[1];
        
            // Mostrar el estado y el id en la consola
            console.log(estado);
            console.log(id);
        
            // Verificar si el estado es 'observar'
            if (estado === 'observar') {
                const caja = 'observacion-container_' + id;
                const observacionTexto = document.getElementById(caja);
        
                // Verificar si el elemento existe antes de manipularlo
                if (observacionTexto) {
                    observacionTexto.classList.remove('hidden');
                } else {
                    console.warn('Elemento con id ' + caja + ' no encontrado.');
                }
            }
        }
        
    </script>
    
    <script>
        document.querySelectorAll('.formatted-text').forEach(paragraph => {
    let text = paragraph.innerHTML;
    text = text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
    text = text.replace(/\*(.*?)\*/g, '<b>$1</b>');
    paragraph.innerHTML = text;
});
    </script>
    
          

</x-app-layout>
