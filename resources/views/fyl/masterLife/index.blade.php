<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Staff')
        </h2>
    </x-slot>
    @php
        if (session('status')) {
            $masterLife = session('masterLife');
            $training = session('training_ml');
            $trainingId = session('trainingId_ml');
            $exists = session('exist_ml');
        }
    @endphp

    <header>
        @if ($trainingId != 0)
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
                    <a class="px-1 text-xl" href="#" data-letra="+">+</a>
                </div>
            </div>
        @endif
    </header>
    <div class="{{ Config::get('style.containerIndex') }}">

        @if (session('status'))
            <div class="text-green-600 h-3 text-center">
                {{ __(session('status')) }}
                <br>
            </div>
        @endif

        <fieldset class=" border border-solid border-gray-300 py-2 rounded-md">
            <legend class="text-sm text-sky-900">@lang('Carga masiva')</legend>
            <div class="flex flex-row flex-wrap mx-4">
                <label class="flex flex-col py-1">
                    <form id="life" method="GET" action="{{ route('MasterLife.index') }}">
                        @csrf
                        <label class="flex flex-col mx-2 py-1">
                            <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} w-64" type="text" id="training_id"
                                name="training_id" required>
                                <option value="0">--Seleccione--</option>
                                @if($training)
                                @foreach ($training as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('training_id', $trainingId)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                                @endif
                            </select>
                        </label>
                    </form>
                </label>
                <label class="flex flex-col mx-2 mt-4 py-1">
                    @if (isset($exists) && $exists == 'NO')
                        <form id="form1" method="POST" action="{{ route('master-life.storeMassive') }}">
                            @csrf
                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                            <button class="{{ Config::get('style.btnSave') }}" form="form1" type="submit">Cargar
                                Staff de Your</button>
                        </form>
                    @endif
                </label>
            </div>
            @if ($trainingId != 0)
                <form id="form1" method="POST" action="{{ route('MasterLife.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="normal" />
                    <div class="flex flex-row flex-wrap mx-4">
                        <input type="hidden" name="training_id" value="{{ $trainingId }}" />

                        <label class="flex flex-col mx-2 py-1">
                            <span class="{{ Config::get('style.label') }}">@lang('Staff')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " style="width:300px"
                                id="participant_DNI" name="participant_DNI" value="{{ old('participant_DNI') }}">
                            </select>
                            @error('participant_DNI')
                                <br>
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                        <div class="flex items-center justify-between mt-4 px-4">
                            <button id="btAgregar" class="{{ Config::get('style.btnSave') }}" form="form1"
                                style="display: none" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
            @endif
        </fieldset>

        <fieldset id="newRegister" class=" border border-solid border-gray-300 py-2 rounded-md"
            style="display: none;">
            <legend class="text-sm text-sky-900">@lang('Registrar Staff')</legend>
            <form id="form2" method="POST" action="{{ route('MasterLife.store') }}">
                @csrf
                <input type="hidden" name="type" value="nuevo" />
                <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                <div class="flex flex-row flex-wrap  py-2 mx-4">
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="participant_DNI"
                            value=" {{ old('participant_DNI') }}" required />
                        @error('participant_DNI')
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

        @if (isset($masterLife) && count($masterLife) > 0)

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
                                @foreach ($masterLife as $themasterLife)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowSequential') }}">
                                            {{ $themasterLife->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $themasterLife->role }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $themasterLife->masterLife }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $themasterLife->email }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenterXs') }}">
                                            {{ $themasterLife->phone }}

                                        </td>
                                        @auth
                                            <td class="w-24 inline-flex text-center py-1.5">
                                                <form action="{{ route('MasterLife.destroy', $themasterLife->id) }}"
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
                            {{-- {{ $masterLife->links() }} --}}
                        </div>
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                    </div>
                </main>
            </div>

        @endif
    </div>


    <script>
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            document.getElementById('life').submit();
        });
        $(document).ready(function() {});
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
                                if (data.participantes.length > 0) {
                                    $('#btAgregar').show();
                                } else {
                                    $('#btAgregar').hide();
                                }
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
