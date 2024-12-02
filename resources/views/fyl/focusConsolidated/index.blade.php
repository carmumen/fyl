<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Focus Consolidated')
        </h2>
    </x-slot>

    <header>
        {{-- <form method="POST" action="{{ route('FocusConsolidated.index') }}">
            @csrf --}}
        <div class="flex flex-row flex-wrap  py-2 mx-8">
            <label class="flex flex-col ">
                <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
                <select class="{{ Config::get('style.cajaTexto') }} w-64" type="text" id="training_id" name="training_id"
                    required />
                <option value="">-- Seleccione --</option>
                @foreach ($training->toArray() as $id => $name)
                    <option value="{{ $id }}">{{ __($name) }}</option>
                @endforeach
                </select>
            </label>
        </div>
        {{-- </form> --}}
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="container mx-auto mt-8 p-4">
            <h1 class="text-2xl font-semibold mb-4">Registro de Pagos y Asistencia</h1>
            <form class="bg-white shadow-md rounded px-8 py-6" method="POST"
                action="{{ route('FocusConsolidated.store') }}">
                @csrf
                <table>
                    <tr>
                        <th scope="col"
                            class="{{ Config::get('style.headerLeft') }} border-2 border-slate-300 bg-sky-800">
                            ASISTENCIA:</th>
                        <td class="{{ Config::get('style.rowRight') }} border-2 border-slate-300 text-2xl w-32">
                            <input name="training_id_consolidated" type="hidden" value="{{ $trainingId }}" />
                            <input name="program_id" type="hidden" value="2" />
                            <input name="total_focus" type="hidden" value="{{ $a }}" />
                            <input name="focus" type="hidden" value="{{ $f }}" />
                            <input name="focus_your" type="hidden" value="{{ $fy }}" />
                            <input name="focus_your_life" type="hidden" value="{{ $fyl }}" />
                            {{ $a }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"
                            class="{{ Config::get('style.headerLeft') }} border-2 border-slate-300 bg-sky-800">
                            PAGO FOCUS:</th>
                        <td class="{{ Config::get('style.rowRight') }} border-2 border-slate-300 text-2xl w-32">
                            {{ $f }}</td>
                    </tr>
                    <tr>
                        <th scope="col"
                            class="{{ Config::get('style.headerLeft') }} border-2 border-slate-300 bg-sky-800">
                            PAGO FOCUS+YOUR:</th>
                        <td class="{{ Config::get('style.rowRight') }} border-2 border-slate-300 text-2xl">
                            {{ $fy }}</td>
                    </tr>
                    <tr>
                        <th scope="col"
                            class="{{ Config::get('style.headerLeft') }} border-2 border-slate-300 bg-sky-800">
                            PAGO FOCUS+YOUR+LIFE:</th>
                        <td class="{{ Config::get('style.rowRight') }} border-2 border-slate-300 text-2xl">
                            {{ $fyl }}</td>
                    </tr>
                </table>

                <div class="m-4">
                    <button class="{{ Config::get('style.btnSave') }}" type="submit">Consolidar Día</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var trainingSelect = document.getElementById("training_id");

            trainingSelect.addEventListener("change", function() {
                redirectToController();
            });

            function redirectToController() {
                var trainingId = trainingSelect.value;

                if (trainingId) {
                    var url = '/FocusConsolidated?training_id=' + trainingId;
                    window.location.href = url;
                }
            }

            // Restaurar valores seleccionados después de cargar la página
            var savedTrainingId = "{{ request('training_id') }}";

            if (savedTrainingId) {
                trainingSelect.value = savedTrainingId;
            }
        });
    </script>

</x-app-layout>
