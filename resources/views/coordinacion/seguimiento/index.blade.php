<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Seguimiento')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
        }
        
        .andy {
            font-size:.8rem;
            padding: 7px; 
            margin:5px;
            background-color: #06699b; /*#075985; #62BC0F;*/
            color: #e8e8e8;
            display: table;
            border-radius: 5px;
            line-height: 1rem;
            cursor: pointer;
            box-shadow: inset 0 10px 15px rgba(255,255,255,.35), inset 0 -10px 15px rgba(0,0,0,.05), inset 10px 0 15px rgba(0,0,0,.05), inset -10px 0 15px rgba(0,0,0,.05), 0 5px 20px rgba(0,0,0,.05);
        }
            
        .andy:hover {
            box-shadow: inset 0 5px 30px rgba(0,0,0,.2);
            background-size: 5.9em;
            color: #f7a96a;
             box-shadow: inset 0 5px 5px rgba(255,255,255,1), inset 0 -10px 15px rgba(0,0,0,.05), inset 10px 0 15px rgba(0,0,0,.05), inset -10px 0 15px rgba(0,0,0,.05), 0 5px 20px rgba(0,0,0,.05);
        }
            
        .andy:active {
            box-shadow: inset 0 5px 30px rgba(0,0,0,.5);
            background-size: 5.9em;
            color: #FB923C;
        }
        
        .inactivo{
            font-size:.8rem;
            padding: 10px; 
            display: block;
            border-radius: 5px;
            line-height: 1rem;
        }
        
        
        .persona {
            font-size:.8rem;
            padding: 10px; 
            display: block;
            border-radius: 5px;
            line-height: 1rem;
            cursor: pointer;
        }
            
        .persona:hover {
            padding-left: 10px; 
            box-shadow: inset 0 5px 30px rgba(0,0,0,.2);
            background-size: 5.9em;
            color: #075985;
             box-shadow: inset 0 5px 5px rgba(255,255,255,1), inset 0 -10px 5px rgba(0,0,0,.05), inset 10px 0 15px rgba(0,0,0,.05), inset -10px 0 15px rgba(0,0,0,.05), 0 5px 20px rgba(0,0,0,.05);
        }
            
        .persona:active {
            box-shadow: inset 0 5px 5px rgba(0,0,0,.5);
            background-size: 5.9em;
            color: #FB923C;
        }
        
        
    </style>

    <header>
        <div class="flex flex-wrap justify-between p-1"  >
            <div class="flex flex-wrap justify-start">
                <form id="campus_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Seguimiento.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" 
                        onchange="submitData('{{ 'Participants' }}')"
                        name="campus_id"
                        id="campus_id" required>
                        <option value="0">--Seleccione la Sede--</option>
                        @foreach ($campus as $id => $name)
                            <option value="{{ $id }}"
                                @if ($id == old('campus_id', $campusId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
               
                <form id="training_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Seguimiento.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <input type="hidden" id="campusId2" name="campus_id" value="{{ $campusId }}" />
                    
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                        id="training_id" >
                        <option value="0">--Equipo Enrolador--</option>
                        @foreach ($training as $id => $name)
                            <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </header>
    
    @if (isset($seguimiento) && count($seguimiento) > 0)

        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">No.</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Participante</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Rol</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Activo</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Total Enrolamiento</th>
                                    <th>
                                        <form id="form_1" action="{{ route('Seguimiento.promesas') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Promesas">Total Promesas</button>
                                        </form>
                                    </th>
                                    <th>
                                        <form id="form_2" action="{{ route('Seguimiento.actividades') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Actividades">Total Actividades</button>
                                        </form>
                                    </th>
                                    <th>
                                        <form id="form_3" action="{{ route('Seguimiento.asignaciones') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Asignaciones">Total Asignaciones</button>
                                        </form>
                                    </th>
                                    <th>
                                        <form id="form_4" action="{{ route('Seguimiento.llamadas') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Llamadas">Total Llamadas</button>
                                        </form>
                                    </th>
                                    <th>
                                        <form id="form_5" action="{{ route('Seguimiento.equipo') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Equipo">Total Equipo</button>
                                        </form>
                                    </th>
                                    <th>
                                        <form id="form_6" action="{{ route('Seguimiento.comunidad') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="campus_id" value="{{ $campusId }}" />
                                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                            <button type="submit" class="andy" title="Total Comunidad">Total Comunidad</button>
                                        </form>
                                    </th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Resultado Final</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Enrolados</th>
                                    <th class="{{ Config::get('style.headerCenter') }}" style="padding: 10px">Sentados</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($seguimiento as $theSeguimiento)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}" style="padding: 5px">
                                            {{ $theSeguimiento->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeft') }}">
                                            @if($theSeguimiento->activo === 'SI')
                                            <a class="persona"
                                                href="{{ route('Seguimiento.show', $theSeguimiento->participant_DNI.'|'.$trainingId.'|'.$campusId) }}">
                                                {{ $theSeguimiento->surnames_names }}
                                            </a>
                                            @else
                                            <span class="inactivo">
                                                {{ $theSeguimiento->surnames_names }}
                                            </span>
                                            @endif
                                            
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" title="{{ $theSeguimiento->role }}">
                                            @php
                                                $words = explode(' ', $theSeguimiento->role);
                                                $initials = '';
                                                foreach ($words as $word) {
                                                    $initials .= strtoupper(substr($word, 0, 1));
                                                }
                                                echo $initials;
                                            @endphp
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }} font-bold "
                                            @if ($theSeguimiento->activo === 'SI') style="font-size: 1rem; color:green" @endif 
                                            @if ($theSeguimiento->activo === 'NO') style="font-size: 1rem; color:red" @endif
                                        >
                                            {{ $theSeguimiento->activo }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter')}} font-bold " 
                                            @if ($theSeguimiento->enrolamiento === '100') style="font-size: 1rem; color:green" @endif 
                                            @if ($theSeguimiento->enrolamiento === '80') style="font-size: 1rem; color:green" @endif
                                            @if ($theSeguimiento->enrolamiento === '40') style="font-size: 1rem; color:orange" @endif
                                            @if ($theSeguimiento->enrolamiento === '0') style="font-size: 1rem; color:red" @endif
                                        >
                                            {{ $theSeguimiento->enrolamiento }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_promesa }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_actividad }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_asignacion }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_llamada }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_equipo }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->t_comunidad }}%
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }} font-bold " 
                                            @php
                                                $valor = number_format(($theSeguimiento->enrolamiento + $theSeguimiento->t_promesa + $theSeguimiento->t_actividad + $theSeguimiento->t_asignacion + $theSeguimiento->t_llamada + $theSeguimiento->t_equipo + $theSeguimiento->t_comunidad) / 7, 2);
                                            @endphp
                                            @if ( $valor >= 80 ) style="font-size: 1rem; background-color: green; color:#FFF" @endif
                                            @if ( $valor >= 40 && $valor < 80 ) style="font-size: 1rem; background-color: orange; color:#FFF" @endif
                                            @if ( $valor < 40 ) style="font-size: 1rem; background-color: red; color:#FFF" @endif
                                        >
                                            {{ $valor }}

                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->enrolados }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $theSeguimiento->sentados }}
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
        const selectCampus = document.getElementById('campus_id');
    
        selectCampus.addEventListener('change', function() {
            document.getElementById('campus_form').submit();
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const selectTraining = document.getElementById('training_id');
        
            if (selectTraining) {
                selectTraining.addEventListener('change', function() {
                    document.getElementById('training_form').submit();
                });
            }
        });
    </script>

</x-app-layout>
