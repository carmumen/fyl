<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Staff')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>
    <header>
                    
        <div class="flex flex-1 justify-center">
            <p style="color:red">Para cargar el listado de Staff haga click en la letra correspondiente al apellido o haga click sobre el signo + para registrar uno nuevo.</p>
        </div>
        <div class="flex flex-1 justify-center">
            <div class="letra-links text-right">
                <a class="px-1" href="#" data-letra="A">A</a>
                <a class="px-1" href="#" data-letra="B">B</a>
                <a class="px-1" href="#" data-letra="C">C</a>
                <a class="px-1" href="#" data-letra="D">D</a>
                <a class="px-1" href="#" data-letra="E">E</a>
                <a class="px-1" href="#" data-letra="F">F</a>
                <a class="px-1" href="#" data-letra="G">G</a>
                <a class="px-1" href="#" data-letra="H">H</a>
                <a class="px-1" href="#" data-letra="I">I</a>
                <a class="px-1" href="#" data-letra="J">J</a>
                <a class="px-1" href="#" data-letra="K">K</a>
                <a class="px-1" href="#" data-letra="L">L</a>
                <a class="px-1" href="#" data-letra="M">M</a>
                <a class="px-1" href="#" data-letra="N">N</a>
                <a class="px-1" href="#" data-letra="Ñ">Ñ</a>
                <a class="px-1" href="#" data-letra="O">O</a>
                <a class="px-1" href="#" data-letra="P">P</a>
                <a class="px-1" href="#" data-letra="Q">Q</a>
                <a class="px-1" href="#" data-letra="R">R</a>
                <a class="px-1" href="#" data-letra="S">S</a>
                <a class="px-1" href="#" data-letra="T">T</a>
                <a class="px-1" href="#" data-letra="U">U</a>
                <a class="px-1" href="#" data-letra="V">V</a>
                <a class="px-1" href="#" data-letra="W">W</a>
                <a class="px-1" href="#" data-letra="X">X</a>
                <a class="px-1" href="#" data-letra="Y">Y</a>
                <a class="px-1" href="#" data-letra="Z">Z</a>
                <a class="px-1" style="font-size:28px; color:navy; font-weight:bold" href="#" data-letra="+" title="NUEVO">+</a>
            </div>
        </div>

    </header>
    @php
        if (session('status')) {
            $staff = session('staff');
            $training = session('training');
        }
    @endphp

    <div class="{{ Config::get('style.containerIndex') }}">

        @if (session('status'))
            <div class="text-green-600 h-3 text-center">
                {{ __(session('status')) }}
                <br>
            </div>
        @endif
        
        <form id="life" method="GET" class="flex items-center space-x-2" action="{{ route('Staff.index') }}">
            @csrf
            <label class="flex flex-col mx-2 py-1">
                <span class="{{ Config::get('style.label') }}" >@lang('Training')</span>
                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="training_id" id="training_id"
                    required>
                    <option value="">--Seleccione--</option>
                    @foreach ($training as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                            {{ __($name) }}
                        </option>
                    @endforeach
                </select>
            </label>
        </form>

        <fieldset class=" border border-solid border-gray-300 py-2 rounded-md">
            <legend class="text-sm text-sky-900">@lang('Selección individual')</legend>

            <form id="form1" method="POST" action="{{ route('Staff.store') }}">
                @csrf
                <input type="hidden" name="type" value="normal" />
                <div class="flex flex-row flex-wrap mx-4">
                    <input type="hidden" id="training_id1" name="training_id" value="" />
                    
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}" >@lang('Role')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="role"
                            name="role" required>
                            <option value="">--Seleccione--</option>
                            <option value="CAPITAN" @if (old('role') == 'CAPITAN') selected @endif>CAPITAN</option>
                            <option value="STAFF" @if (old('role') == 'STAFF') selected @endif>STAFF</option>
                        </select>
                        @error('role')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Staff')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" id="participant_DNI"
                            name="participant_DNI" value="{{ old('participant_DNI') }}">
                        </select>
                        @error('participant_DNI')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" form="form1"
                            type="submit">Agregar</button>
                    </div>
                </div>
            </form>
        </fieldset>

        <fieldset id="newRegister" class=" border border-solid border-gray-300 py-2 rounded-md"
            style="display: none;">
            <legend class="text-sm text-sky-900">@lang('Registrar Staff')</legend>
            <form id="form2" method="POST" action="{{ route('Staff.store') }}">
                @csrf
                <input type="hidden" name="type" value="nuevo" />
                <input type="hidden" id="training_id2" name="training_id1" value="" />
                <div class="flex flex-row flex-wrap  py-2 mx-4">
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Role')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="role"
                            name="role" required>
                            <option value="">--Seleccione--</option>
                            <option value="CAPITAN" @if (old('role') == 'CAPITAN') selected @endif>CAPITAN</option>
                            <option value="STAFF" @if (old('role') == 'STAFF') selected @endif>STAFF</option>
                        </select>
                        @error('role')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="DNI"
                            value=" {{ old('DNI') }}" required />
                        @error('DNI')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names"
                            value=" {{ old('names') }}" required oninput="this.value = this.value.toUpperCase();" />
                        @error('names')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="surnames"
                            value=" {{ old('surnames') }}" required
                            oninput="this.value = this.value.toUpperCase();" />
                        @error('surnames')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Nickname')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="nickname"
                            value=" {{ old('nickname') }}" required
                            oninput="this.value = this.value.toUpperCase();" />
                        @error('nickname')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="email"
                            value=" {{ old('email') }}" required oninput="this.value = this.value.toLowerCase();" />
                        @error('email')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone"
                            value=" {{ old('phone') }}" required />
                        @error('phone')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" form="form2"
                            type="submit">Agregar</button>
                    </div>
            </form>
        </fieldset>

        @if (isset($staff) && count($staff) > 0)

            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col"
                                        class="{{ Config::get('style.headerSecuencial') }} text-white">
                                        @lang('No.')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Role')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Staff')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Email')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Phone')
                                    </th>
                                    @auth
                                        <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($staff as $thestaff)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowSequential') }}">
                                            {{ $thestaff->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $thestaff->role }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $thestaff->staff }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $thestaff->email }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $thestaff->phone }}

                                        </td>
                                        @auth
                                            <td class="w-24 inline-flex text-center py-1.5">
                                                <form action="{{ route('Staff.destroy', $thestaff->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                        onclick="return confirm('¿Seguro que deseas eliminar el Staff?')">
                                                        <span
                                                            class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                            {{-- {{ $staff->links() }} --}}
                        </div>
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                    </div>
                </main>
            </div>
        @endif
    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var trainingSelect = document.getElementById("training_id");

            trainingSelect.addEventListener('change', function() {
                // Accede al formulario y envíalo
                document.getElementById('training_id1').value = trainingSelect.value;
                document.getElementById('training_id2').value = trainingSelect.value;
                
                document.getElementById('life').submit();
            });
        });


        $(document).ready(function() {
            var trainingSelect = document.getElementById("training_id");
            document.getElementById('training_id1').value = trainingSelect.value;
            document.getElementById('training_id2').value = trainingSelect.value;
        });
        document.addEventListener("DOMContentLoaded", function() {
            const participant_DNI = document.getElementById("participant_DNI");
            const letraLinks = document.querySelectorAll('.letra-links a');

            letraLinks.forEach(letraLink => {
                letraLink.addEventListener("click", function(event) {
                    event.preventDefault();

                    const letraSeleccionada = this.getAttribute("data-letra");
                    console.log(letraSeleccionada);
                    if (letraSeleccionada == "+") {
                        toggleNewRegister();
                    } else {
                        fetch(`/obtener-participantes/${letraSeleccionada}`)
                            .then(response => response.json())
                            .then(data => {
                                participant_DNI.innerHTML = "";
                                data.participantes.forEach(participante => {
                                    const option = document.createElement("option");
                                    option.value = participante.DNI;
                                    option.textContent = participante.name;
                                    participant_DNI.appendChild(option);
                                });
                            })
                            .catch(error => console.error("Error:", error));
                    }
                });

            });
            var trainingSelect = document.getElementById("training_id");
            var programSelect = document.getElementById("program_id");

            trainingSelect.addEventListener("change", function() {
                redirectToController();
            });

            programSelect.addEventListener("change", function() {
                redirectToController();
            });

            function redirectToController() {
                var trainingId = trainingSelect.value;
                var programId = programSelect.value;

                if (trainingId && programId) {
                    var url = '/Staff?training_id=' + trainingId + '&program_id=' + programId;
                    window.location.href = url;
                }
            }

            // Restaurar valores seleccionados después de cargar la página
            var savedTrainingId = "{{ request('training_id') }}";
            var savedProgramId = "{{ request('program_id') }}";

            if (savedTrainingId) {
                trainingSelect.value = savedTrainingId;
            }

            if (savedProgramId) {
                programSelect.value = savedProgramId;
            }
        });


        function toggleNewRegister() {
            newRegister.style.display = 'block';
        }
    </script>

</x-app-layout>
