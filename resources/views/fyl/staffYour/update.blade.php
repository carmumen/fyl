<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Staff')
        </h2>
    </x-slot>
    <header>
        <form method="POST" action="{{ route('Staff.store') }}">
            @csrf
            <div class="flex flex-row flex-wrap  py-2 mx-8">
                <label class="flex flex-col ">
                    <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
                    <select class="{{ Config::get('style.cajaTexto') }} w-64" type="text" id="training_id"
                        name="training_id" required />
                    <option value="">-- Seleccione --</option>

                    @foreach ($training->toArray() as $id => $name)
                        <option value="{{ $id }}" @if ($staff->isNotEmpty() && $id == old('training_id', $staff[0]->training_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>
                <div class="flex items-center justify-between mt-4 px-4">
                    <button class="{{ Config::get('style.btnSave') }}" type="submit">Agregar</button>
                </div>
            </div>
        </form>
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerSecuencial') }} text-white">
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
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thestaff->role }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thestaff->staff }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thestaff->email }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thestaff->phone }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <form action="{{ route('Staff.destroy', $thestaff) }}" method="POST">
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
    </div>


    <script>
        $(document).ready(function() {});
        document.addEventListener("DOMContentLoaded", function() {
            const participant_DNI = document.getElementById("participant_DNI");
            const letraLinks = document.querySelectorAll('.letra-links a');

            letraLinks.forEach(letraLink => {
                letraLink.addEventListener("click", function(event) {
                    event.preventDefault();

                    const letraSeleccionada = this.getAttribute("data-letra");
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
    </script>

</x-app-layout>
