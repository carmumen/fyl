<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Transferencias')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A単ade 5px de espacio alrededor del contenido */
        }
        
        /* Contenedor principal */
        .flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 16px; /* Espaciado alrededor */
        }

        /* Estilo del formulario */
        form {
            background-color: #f9f9f9; /* Fondo claro */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            padding: 20px; /* Espaciado interno */
            width: 100%; /* Ancho completo */
            max-width: 600px; /* Ancho máximo */
        }

        /* Estilo de etiquetas y textos */
        span {
            font-size: 1rem; /* Tamaño de fuente */
            font-weight: bold; /* Negrita */
            margin-bottom: 8px; /* Espacio debajo */
            display: block; /* Asegura que se comporten como bloques */
        }

        /* Estilo de los inputs */
        input[type="text"] {
            width: calc(100% - 24px); /* Ancho completo menos padding */
            padding: 10px; /* Espaciado interno */
            border: 1px solid #ccc; /* Borde gris */
            border-radius: 4px; /* Bordes redondeados */
            margin-bottom: 16px; /* Espacio inferior */
            transition: border-color 0.3s; /* Transición suave en el borde */
        }

        input[type="text"]:focus {
            border-color: #007BFF; /* Borde azul en foco */
            outline: none; /* Sin borde de enfoque */
        }

        /* Estilo de los botones */
        .button {
            background-color: #007BFF; /* Color de fondo azul */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            border-radius: 4px; /* Bordes redondeados */
            padding: 10px 15px; /* Espaciado interno */
            cursor: pointer; /* Cambia el cursor al pasar el mouse */
            transition: background-color 0.3s; /* Transición suave en el fondo */
        }

        .button:hover {
            background-color: #0056b3; /* Color de fondo más oscuro al pasar el mouse */
        }

        /* Estilo para los radiobuttons y etiquetas */
        input[type="radio"] {
            margin-right: 8px; /* Espacio a la derecha */
        }

        label {
            margin-right: 20px; /* Espacio a la derecha entre etiquetas */
            cursor: pointer; /* Cambia el cursor al pasar el mouse */
        }

        /* Espaciado para cada grupo de elementos */
        .m-4 {
            margin: 16px 0; /* Espaciado arriba y abajo */
        }

        /* Icono de búsqueda */
        .icon-search {
            font-size: 1.5rem; /* Tamaño del icono */
            color: #007BFF; /* Color del icono */
            transition: color 0.3s; /* Transición suave en el color */
        }

        .icon-search:hover {
            color: #0056b3; /* Color del icono al pasar el mouse */
        }
    </style>
    <header>
       
        <div class="flex flex-wrap justify-between p-1">
            <div>
                <form id="entrenamiento_form" method="GET" action="{{ route('PaymentB.busca') }}">
                    @csrf
                    
                    
                    <div class="m-2">
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <span>Entrenamiento:  </span>
                            @foreach ($pagos as $thepagos)
                                <div>
                                    <input type="radio" 
                                           id="entrenamiento{{ $loop->index }}" 
                                           name="entrenamiento" 
                                           value="{{ $thepagos->entrenamiento }}"
                                           @if ($thepagos->entrenamiento == old('entrenamiento',$entrenamiento)) checked @endif
                                           onchange="submitData('{{ $thepagos->entrenamiento }}')">
                                    <label for="entrenamiento{{ $loop->index }}">
                                        {{ $thepagos->entrenamiento }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </header>
    
    <div class="{{ Config::get('style.containerIndex') }} px-2">
        <div style="height: 30px">
            @if (Session::has('success'))
                <div id="successAlert" style="background-color: #93d693; color: #008000; padding:1px 8px; border-radius:5px">
                    {{ Session::get('success') }}
                </div>
            @endif
            
            @if (Session::has('error'))
                <div id="errorAlert" style="background-color: #f9b8d3; color: red; padding:1px 8px; border-radius:5px">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
        <div class="flex flex-col mb-8">
            <main>
                <form id="save_form" method="POST" action="{{ route('PaymentTr.transferir') }}">
                    @csrf
                    @if (!empty($origen))
                    <span>Participante Origen:</span>
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select ms-4 me-4 mb-4" 
                        style="width:500px"
                        name="DNI_origen"
                        id="DNI_origen" 
                        onchange="valida()"
                        required>
                        <option value="0">-- Seleccione el participante que registró el pago --</option>
                        @foreach ($origen as $theorigen)
                            <option value="{{ $theorigen->DNI }}"
                                @if ($theorigen->DNI == old('DNI_origen')) selected @endif>
                                {{ $theorigen->surnames_names. ' - ' .$theorigen->training. ' - ' .$theorigen->campus }}
                            </option>
                        @endforeach
                    </select>
                    @error('DNI_origen')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                    @endif
                    
                    @if (!empty($origen))
                    <input type="hidden" id="entrenamiento1" name="entrenamiento" value="{{ $entrenamiento }}" />
                    <span>Participante Destino:</span>
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select ms-4 me-4"
                        style="width:500px"
                        name="DNI_destino"
                        id="DNI_destino"  
                        onchange="valida()"
                        required>
                        <option value="0">-- Seleccione el participante que recibe la transferencia --</option>
                        @foreach ($destino as $thedestino)
                            <option value="{{ $thedestino->DNI }}"
                                @if ($thedestino->DNI == old('DNI_destino')) selected @endif>
                                {{ $thedestino->surnames_names. ' - ' .$thedestino->training. ' - ' .$thedestino->campus }}
                            </option>
                        @endforeach
                    </select>
                    @error('DNI_destino')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                    
                    <div class="m-4">
                        <span>Observaciones:</span>
                        <textarea type="text" id="observacion" name="observacion" onchange="valida()" style="width:500px; " ></textarea>
                    </div>
                    @error('observacion')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                    
                    <div class="m-4">
                        <button id="btGuardar" class="button" type="submit" title="TRANSFERIR" style="display:none" form="save_form" >Transferir</button>
                    </div>
                    @endif
                </form>
            </main>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function submitData(entrenamiento) {
            document.getElementById('entrenamiento_form').submit();
        }
        function valida(){
            const DNI_origen = document.getElementById('DNI_origen');
            const DNI_destino = document.getElementById('DNI_destino');
            const observacion = document.getElementById('observacion');
            const btGuardar = document.getElementById('btGuardar');
            
            if(DNI_origen.value > 0 && DNI_destino.value > 0 && observacion.value != ""){
                btGuardar.style.display = "block";
            }
            
        }
    </script>
    
</x-app-layout>
