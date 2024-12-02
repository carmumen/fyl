<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('LISTADO') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap justify-start">
        @if (isset($campus) && count($campus) > 0)
            <div class=" p-1">
                <form id="campus_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Listado.equiposEnJuego') }}">
                    @csrf
                    <input type="hidden" id="training" name="training_id" value="0" />
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="campus_id"
                        id="campus_id" required>
                        <option value="">--Seleccione la Sede--</option>
                        @foreach ($campus as $id => $name)
                            <option value="{{ $id }}"
                                @if ($id == old('campus_id', $campusId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif
            
        @if (isset($training) && count($training) > 0)
            <div class="p-1">
                <form id="training_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Listado.equiposEnJuego') }}">
                    @csrf
                    <input type="hidden" id="campus" name="campus_id" />
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                        id="training_id" >
                        <option value="">--Seleccione el Entrenamiento--</option>
                        @foreach ($training as $theTraining)
                            <option value="{{ $theTraining->id }}" @if ($theTraining->id == old('training_id', $trainingId)) selected @endif>
                                {{ __($theTraining->name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif
        
        @if (isset($trainingInGame) && count($trainingInGame) > 0)
            <div class="p-1 mx-5 flex items-center space-x-2">
                <a class="{{ Config::get('style.btnSave') }}"
                    href="{{ url('/exportar-tabla' . '/equipos_en_juego' . '/' . $trainingId . '/' . $campusId) }}">
                    Exportar</a> 

            </div>
        @endif
            
    </div>
        
        
    @if (isset($trainingInGame) && count($trainingInGame) > 0)
        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12 py-3">
                                        @lang('No.')
                                    </th>
    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        <b>@lang('EQUIPO EN JUEGO')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        <b>@lang('EQUIPO ENROLADOR')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        <b>@lang('PARTICIPANTE')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} ">
                                        <b>@lang('IDENTIDAD')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} ">
                                        <b>@lang('EMAIL')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} ">
                                        <b>@lang('TELÉFONO')</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                
                                    @foreach ($trainingInGame as $trainingInGames)
                                        <tr class="border-b border-gray-200">
                                            
                                            <td class="{{ Config::get('style.rowCenter') }} py-2" >
                                                {{ $trainingInGames->secuencial }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->EQUIPO_EN_JUEGO }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->EQUIPO_ENROLADOR }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->PARTICIPANTE }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->IDENTIDAD }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->EMAIL }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $trainingInGames->phone }}
                                            </td>
                                             
                                        </tr>
                                    @endforeach
                                
                            </tbody>
                        </table>
                        
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                    </div>
                </main>
            </div>
        </div>  
    @endif
    
    <script>
    
        const selectCampus = document.getElementById('campus_id');
        const selectTraining = document.getElementById('training_id');

        selectCampus.addEventListener('change', function() {
            
           
                document.getElementById('campus_form').submit();
        });
        
        selectTraining.addEventListener('change', function() {
            $('#campus').val(selectCampus.value);
            console.log('sdfsdfsd')
            document.getElementById('training_form').submit();
        });
        
        
        
    </script>

</x-app-layout>