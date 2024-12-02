<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Code')
        </h2>
    </x-slot>


    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A���ade 5px de espacio alrededor del contenido */
        }
    </style>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">

                <form id="formSeis" class="px-8 py-4 bg-white" method="POST"
                    action="{{ route('Enroller.generateCode') }}">
                    @csrf
                    <div class="flex flex-row flex-wrap  py-2 ">
                        @if ($campus->count() > 1)
                            <label class="flex flex-col p-2">
                                <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text"
                                    name="campus_id" value=" {{ old('campus_id') }}" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($campus->toArray() as $id => $name)
                                    <option value="{{ $id }}" {{ old('campus_id') == $id ? 'selected' : '' }}>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                                </select>
                            </label>
                        @else
                            <input type="hidden" name="campus_id" value="{{ $campus->keys()->first() }}" />
                        @endif


                        <label class="flex flex-col p-2">
                            <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
                            <input type="text" name="start_date"
                                class="{{ Config::get('style.cajaTexto') }} datePickerClass"
                                value="{{ old('start_date') }}" />
                            @error('start_date')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>

                        <label class="flex flex-col p-2">
                            <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
                            <input type="text" name="end_date"
                                class="{{ Config::get('style.cajaTexto') }} datePickerClass"
                                value="{{ old('end_date') }}" />
                            @error('end_date')
                                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
                            @enderror
                        </label>
                        <label class="flex flex-col p-2 mt-4">
                            <button class="{{ Config::get('style.btnSave') }}" type="submit"
                                form="formSeis">Generar</button>
                        </label>

                    </div>
                    @if ($errors->has('errors'))
                        <div class="text-red-500">
                            {{ $errors->first('errors') }}
                        </div>
                    @endif
                </form>

            </main>
        </div>
    </div>

    <div class="flex flex-col mt-6 mb-8">
        <main class="border border-gray-200 md:rounded-lg">
            <div id="conResultados">
                <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-sky-800">
                        <tr>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Training')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Team')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Start Date')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('End Date')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Link')
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100">
                        @foreach ($code as $codes)
                            <tr class="border-b border-gray-200">
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $codes->training }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $codes->training_id_enroller }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $codes->start_date }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $codes->end_date }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }} py-1">
                                    <button id="copyButton" class="{{ Config::get('style.btnSave') }}" onclick="copiaLink('{{ $codes->link }}');">
                                        @lang('Copiar link')
                                    </button>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pagina" class=" text-sky-800 bg-gray-50">
                    {{-- {{ $code->links() }} --}}
                </div>
            </div>
            <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50">
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {

            var currentDate = new Date();

            $(".datePickerClass").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                minDate: currentDate,
                firstDay: 1
            });

        });

        function copiaLink(value) {

            var textToCopy = value;
            var dummyInput = document.createElement("input");
            document.body.appendChild(dummyInput);
            dummyInput.setAttribute("value", textToCopy);
            dummyInput.select();
            document.execCommand("copy");
            setTimeout(function() {
                document.body.removeChild(dummyInput);
                alert('Enlace copiado al portapapeles');
            }, 100);
        }
    </script>
</x-app-layout>
