<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Campus')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <header>
        <div class="flex flex-wrap justify-start">
            <div class="p-1">
                @if (isset($training) && count($training) > 0)
                    <form id="training_form" method="GET" class="flex items-center space-x-2"
                        action="{{ route('Promesa.index') }}">
                        @csrf
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                            id="training_id" >
                            <option value="">--Seleccione el Entrenamiento--</option>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
        </div>
    </header>
    
    @if (isset($Promesa) && count($Promesa) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        
                        
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    @auth
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">REVISI脫N</th>
                                    @endauth
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Equipo')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('DNI')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Participante')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Pendiente de aprobaci贸n')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Observadas')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Aprobadas')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($Promesa as $thePromesa)
                                    <tr class="border-b border-gray-200">
                                        @auth
                                            <td class="{{ Config::get('style.rowCenter') }} py-1">
                                                <a class="{{ Config::get('style.btnEdit') }}"
                                                    href="{{ route('Promesa.edit', $thePromesa->DNI.'|'.$thePromesa->training_id) }}">
                                                    <span
                                                        class="icon-eye text-green-900 hover:bg-orange-500 hover:text-white font-mono text-xl" ></span>
                                                </a>
                                            </td>
                                        @endauth
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $thePromesa->training_name }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $thePromesa->DNI }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $thePromesa->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" style="font-weight:bold; font-size:1.2rem">
                                            {{ $thePromesa->pendiente }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" style="font-weight:bold; font-size:1.2rem">
                                            {{ $thePromesa->observado }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}
                                            @if ($thePromesa->aprobado == 0) bg-red-500 text-white @endif
                                            @if ($thePromesa->pendiente > 0 && $thePromesa->aprobado > 0 ) bg-orange-500 text-white @endif
                                            @if ($thePromesa->pendiente == 0 && $thePromesa->aprobado < 5 ) bg-orange-500 text-white @endif
                                            @if ($thePromesa->pendiente == 0 && $thePromesa->aprobado > 4) bg-green-500 text-white @endif" style="font-weight:bold; font-size:1.2rem">
                                            {{ $thePromesa->aprobado }}
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
            //onSelectCampusChange();
            //$('#campus_id').on('change', onSelectCampusChange);
            $('#training_id').on('change', onSelectChange);
        });
        
        function onSelectCampusChange() {
            document.getElementById('campus_form').submit();
        };
        
        function onSelectChange() {
            console.log
            var campusId = $('#campus_id').val();
            $('#campus').val(campusId);  // Actualizar el campus_id
            document.getElementById('training_form').submit();
        };
    </script>

</x-app-layout>
