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
        <div class="flex flex-wrap justify-between px-4">
            <div class="px-1">
                
                @if (isset($campus) && count($campus) > 0)
                    <form id="campus_form" method="POST" action="{{ route('FocusRezagados.store') }}">
                        @csrf
                        <span class="{{ Config::get('style.label') }}">Sede: </span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-2" type="text"
                            name="campus_id" id="campus_id" required>
                            <option value="">--Seleccione--</option>
                            @foreach ($campus as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('campus_id', $campusId)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            
            @if (isset($participants_rezagados) && count($participants_rezagados) > 0)
                <div class="p-1">
                    <a class="{{ Config::get('style.btnSave') }}"
                        href="{{ url('/exportar-tabla' . '/focus_rezagados' . '/' . $campusId . '/F') }}">
                        Exportar</a>
                </div>
            @endif
        </div>
        
    
    </header>

    <div class="overlay-spinner">
        <img src="{{ url('images/loading-gif-png-4.gif') }}" alt="Cargando...">
    </div>
        
    <div class="overlay" id="overlay"></div>
    

    <?php
    // Recupera la posición almacenada en la cookie si existe
        $posicionScroll = isset($_COOKIE['posicionScroll']) ? $_COOKIE['posicionScroll'] : 0;
    ?>

    <div id="principal" class="{{ Config::get('style.containerIndex') }} " style="height: calc(100vh - 15rem);"
        onscroll="guardarPosicionScroll()">
        <div class="flex flex-col mt-6 mb-8">

            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    @if (isset($participants_rezagados) && count($participants_rezagados) > 0)
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerSequential') }}">
                                        @lang('No.')
                                    </th>
                                    @auth
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            Seguimiento
                                        </th>
                                    @endauth
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:300px">
                                        Participante
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:300px">
                                        Enrolador
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:200px">
                                        Entrenamiento
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:120px">
                                        Llamada
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        Resúmen Llamada
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        Operador
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($participants_rezagados as $theFocusParticipants)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowSequential') }}">
                                            {{ $theFocusParticipants->secuencial }}
                                        </td>
                                        @auth
                                            <td class="w-32 text-center py-1">
                                                <div
                                                    class="text-xs w-32 ml-1">
                                                    <div>
                                                        <span>{{ $theFocusParticipants->cant }}</span>

                                                        <form method="POST" class="{{ Config::get('style.btnCall') }}"
                                                            action="{{ route('FocusRezagadosCall.call') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $theFocusParticipants->id }}" />
                                                                
                                                            <input type="hidden" name="type_call" value="Bienvenida" />
                                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                                            <input type="hidden" name="training_id" value="{{ $theFocusParticipants->training_id_focus }}" />
                                                            <input type="hidden" name="participant_DNI" value="{{ $theFocusParticipants->DNI }}" />

                                                            <button
                                                                class="icon-phone-hang-up text-green-900 hover:bg-green-500 hover:text-white"></button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </td>
                                        @endauth
                                        <td class="{{ Config::get('style.rowCenterXs') }} text-xxs ">
                                            <b>{{ $theFocusParticipants->surnames_names }}</b>
                                            <br>
                                            {{ $theFocusParticipants->email }}
                                            <br>
                                            {{ $theFocusParticipants->phone }}
                                            @if($theFocusParticipants->phone2)
                                                &nbsp;-&nbsp;
                                                {{ $theFocusParticipants->phone2 }}
                                            @endif
                                            <br>
                                            {{ $theFocusParticipants->city_of_residenceT }}
                                        </td>
                                   
                                        <td class="{{ Config::get('style.rowCenterXs') }} text-xxs ">
                                            <b>{{ $theFocusParticipants->enrolador }}</b><br>
                                            {{ $theFocusParticipants->email_enroller }}<br>
                                            {{ $theFocusParticipants->phone_enroller }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            <b>Inicial:</b>&nbsp;{{ $theFocusParticipants->trainingOriginal }}<br>
                                            <b>Actual:</b>&nbsp;{{ $theFocusParticipants->trainingActual }}<br>
                                            <span style="color:red"><b>Focus:</b>&nbsp;{{ $theFocusParticipants->trainingFocus }}</span>
                                        </td>
                                        
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            <b style="font-size:0.9rem">{{ $theFocusParticipants->type_call }}</b><br>
                                            {{ $theFocusParticipants->date_call }}<br>
                                            <span style="font-size:1rem">{{ $theFocusParticipants->confirm_assistance }}</span>
                                        </td>
                                        
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->summary_call }}
                                        </td>
                                        <td
                                            class="{{ Config::get('style.rowCenterXs') }} text-xxs hidden sm:table-cell">
                                            {{ $theFocusParticipants->name }}
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
        const selectCampus = document.getElementById('campus_id');
    
        selectCampus.addEventListener('change', function() {
            document.getElementById('campus_form').submit();
        });
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
        
        
        function buscar()
        {
            var search = document.getElementById('search').value;
            
            if(search.length === 0 || search.length > 4 )
               submitData(); 
        }

        /*
        function showLoadingSpinner() {
            document.querySelector('.overlay-spinner').style.display = 'block';
        }
        */
        hideLoadingSpinner()
        function hideLoadingSpinner() {
            document.querySelector('.overlay-spinner').style.display = 'none';
        }
        
        /*
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
                url: "{{ route('FocusRezagados.index') }}",
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
        */
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
