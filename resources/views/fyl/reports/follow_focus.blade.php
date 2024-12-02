<x-app-layout>
    @php
        if (session('entidad') == 'FollowFocus') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'FollowFocus']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Follow Focus')
        </h2>
    </x-slot>

    <header>
        <div class="flex flex-wrap justify-between mx-8">
            <div class="p-1">
                {{-- @dump($trainingId) --}}
                <nav class="space-x-4">
                    <span class="">
                        @if (isset($training) && count($training) > 0)
                            <form id="life" method="GET" class="flex items-center space-x-2"
                                action="{{ route('ReportsFocusCalls.calls') }}">
                                @csrf
                                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                    name="training_id" id="training_id" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach ($training as $id => $name)
                                        <option value="{{ $id }}"
                                            @if ($id == old('training_id', $trainingId)) selected @endif>
                                            {{ __($name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="filter" id="filter" value="1" />
                            </form>
                        @endif
                    </span>
                </nav>
            </div>

            @if (isset($follow))
                <div class="p-1 flex items-center">

                    <input type="radio" id="ultima" name="filter" value="1"
                        {{ old('filter', $filter) == 1 ? 'checked' : '' }}
                        class="form-radio h-5 w-5 text-sky-800 border-sky-600 focus:ring-sky-200 ">
                    <label for="ultima" class="m-2 text-sky-800 cursor-pointer">Última</label>

                    <input type="radio" id="todo" name="filter" value="0"
                        {{ old('filter', $filter) == 0 ? 'checked' : '' }}
                        class="form-radio h-5 w-5 text-sky-800 border-sky-600 focus:ring-sky-200 ">
                    <label for="todo" class="m-2 text-sky-800 cursor-pointer">Todas</label>
                </div>

                <div class="p-1">
                    <a class="inline-flex items-center px-1 py-1 text-xs font-semibold tracking-widest
                    text-center text-white uppercase transition duration-150 ease-in-out
                    border border-2 border-transparent rounded-md
                     bg-green-800 hover:bg-green-700 active:bg-green-700
                    focus:outline-none focus:border-green-500"
                        href="{{ url('/exportar-tabla' . '/seguimiento_focus' . '/' . $trainingId . '/' . $filter) }}">
                        <i class="icon-file-excel text-xl"></i>&nbsp; EXPORTAR
                    </a>
                </div>
            @endif

        </div>


    </header>

    @if (isset($follow))
        <div class="px-1 py-1 mb-8 md:px-8 md:py-2 bg-white w-full overflow-auto">

            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">

                    <div class="overflow-x-auto">
                        <div id="conResultados">


                            @include('fyl/reports.follow_focus_table', $follow)


                            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                {{-- {{ $payment_summary->links() }} --}}
                            </div>
                        </div>
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                    </div>
                </main>
            </div>
        </div>
    @endif

    <script>
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('life').submit();
        });

        document.addEventListener("DOMContentLoaded", function() {
            const opciones = document.getElementsByName("filter");

            // Agregar un evento change a cada botón de opción
            opciones.forEach(opcion => {
                opcion.addEventListener("change", function() {
                    if (this.checked) {
                        // Obtener el valor de la opción seleccionada
                        const valorSeleccionado = this.value;
                        document.getElementById('filter').value = valorSeleccionado;
                        document.getElementById('life').submit();
                    }
                });
            });
        });
    </script>

</x-app-layout>
