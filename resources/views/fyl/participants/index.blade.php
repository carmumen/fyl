<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Participants')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A単ade 5px de espacio alrededor del contenido */
        }
    </style>
    <header>
       
        <div class="flex flex-wrap justify-between p-1"  >
            <div class="flex flex-wrap justify-start">
                <form id="campus_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Participants.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <input type="hidden" id="trainingId1" name="training_id" value="{{ $trainingId }}" />
                    <input type="hidden" id="parameter1" name="parameter" value="{{ $parameter }}" />
                    <input type="hidden" id="search1" name="search" value="{{ $search }}" />
                    <input type="hidden" id="pag1" name="pag" value="{{ $pag }}" />
                    
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
                        action="{{ route('Participants.obtenerEntrenamiento') }}">
                        @csrf
                        
                        <input type="hidden" id="campusId2" name="campus_id" value="{{ $campusId }}" />
                        <input type="hidden" id="parameter2" name="parameter" value="{{ $parameter }}" />
                        <input type="hidden" id="search2" name="search" value="{{ $search }}" />
                        <input type="hidden" id="pag2" name="pag" value="{{ $pag }}" />
                        
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
            
            <div class="flex flex-wrap justify-start">
                <form id="parameter_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Participants.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <input type="hidden" id="campusId3" name="campus_id" value="{{ $campusId }}" />
                    <input type="hidden" id="trainingId3" name="training_id" value="{{ $trainingId }}" />
                    <input type="hidden" id="search3" name="search" value="{{ $search }}" />
                    <input type="hidden" id="pag3" name="pag" value="{{ $pag }}" />
                    
                    <label class="radio-label" style="width:40px">
                        <input type="radio" name="parameter" value="P" title="Participante" {{ (old('parameter', $parameter === 'P')) ? 'checked' : '' }} onchange="buscaParametro('P')" >
                        P
                    </label>
                    <br>
                    <label class="radio-label">
                        <input type="radio" name="parameter" value="E" title="Enrolador" {{ (old('parameter', $parameter === 'E')) ? 'checked' : '' }} onchange="buscaParametro('E')" >
                        E
                    </label>
                </form>
                <form id="search_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Participants.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <input type="hidden" id="campusId4" name="campus_id" value="{{ $campusId }}" />
                    <input type="hidden" id="trainingId4" name="training_id" value="{{ $trainingId }}" />
                    <input type="hidden" id="parameter4" name="parameter" value="{{ $parameter }}" />
                    <input type="hidden" id="pag4" name="pag" value="{{ $pag }}" />
                    
                    <input class="{{ Config::get('style.cajaBusqueda') }}" type="text" id="search" name="search" style="width:400px"
                            placeholder="Buscar..." value="{{ isset($search) ? str_replace("%", " ", $search) : '' }}"
                            onkeyup="buscaCriterio()" />
                </form>
            </div>
            <div class="flex flex-wrap justify-end">
                <form id="pag_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Participants.obtenerEntrenamiento') }}">
                    @csrf
                    
                    <input type="hidden" id="campusId4" name="campus_id" value="{{ $campusId }}" />
                    <input type="hidden" id="trainingId4" name="training_id" value="{{ $trainingId }}" />
                    <input type="hidden" id="parameter4" name="parameter" value="{{ $parameter }}" />
                    <input type="hidden" id="pag4" name="pag" value="{{ $pag }}" />
                    
                    <select class="{{ Config::get('style.cajaTexto') }} w-16 float-right" type="text" name="pag"
                        id="pag"  required />
                        <option value="15" @if ($pag == 15) selected @endif>15</option>
                        <option value="30"  @if ($pag == 30) selected @endif>30</option>
                        <option value="50"  @if ($pag == 50) selected @endif>50</option>
                        <option value="100"  @if ($pag == 100) selected @endif>100</option>
                        <option value="200"  @if ($pag == 200) selected @endif>200</option>
                    </select>
                </form>
            </div>
        </div>
    </header>
    
    @if (!empty($participant))
    
        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        <table id="tablaDatos" class=" divide-y divide-gray-200" style="width:2400px">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:50px">
                                        @lang('No.')
                                    </th>
                                    @auth
                                        <th sscope="col" class="{{ Config::get('style.headerInt') }}" style="width:50px">Editar</th>
                                    @endauth
                                    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:100px">
                                        <b>@lang('APE')</b>
                                    </th>
    
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:80px">
                                        <b>@lang('Focus')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:80px">
                                        <b>@lang('Your')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:80px">
                                        <b>@lang('Life')</b>
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:150px">
                                        <b>@lang('Entrenamiento Original')</b>
                                    </th>
                                    
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:150px">
                                        <b>@lang('Entrenamiento Actualizado')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:150px">
                                        <b>@lang('Identidad')</b>
                                    </th>
                                    
                                    <th scope="col" colspan="2" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Nombre')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:200px">
                                        @lang('Badge')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:120px">
                                        @lang('Phone')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:200px">
                                        <b>@lang('Team')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:200px">
                                        @lang('Enroller')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:120px">
                                        @lang('Enroller Phone')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:200px">
                                        <b>@lang('F')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:200px">
                                        <b>@lang('Y')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:100px">
                                        @lang('Graduate')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                
                                    @foreach ($participant as $participants)
                                        <tr class="border-b border-gray-200">
                                            
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->secuencial }}
                                            </td>
                                            @auth
                                                <td class="{{ Config::get('style.rowCenter') }}" >
                                                    <a class="{{ Config::get('style.btnEdit') }} "
                                                        href="{{ route('Participants.editar', 
                                                                ['id' => $participants->id, 
                                                                 'campusId' => $campusId, 
                                                                 'trainingId' => $trainingId, 
                                                                 'parameter' => $parameter,
                                                                 'search' => $search,
                                                                 'pag' => $pag]) }}">
                                                        <span class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                                    </a>
                                                </td>
                                            @endauth
                                            
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                @if($participants->apoyo_f)
                                                    <b>F </b> {{ $participants->apoyo_f }}</span>
                                                @endif
                                                @if($participants->apoyo_fyl)
                                                    <br>
                                                    <b>FYL </b> {{ $participants->apoyo_fyl }}</span>
                                                @endif
                                                @if($participants->apoyo_y)
                                                    <br>
                                                    <b>Y </b> {{ $participants->apoyo_y }}</span>
                                                @endif
                                                @if($participants->apoyo_yl)
                                                    <br>
                                                    <b>YL </b> {{ $participants->apoyo_yl }}</span>
                                                @endif
                                                @if($participants->apoyo_l)
                                                    <br>
                                                    <b>L </b> {{ $participants->apoyo_l }}</span>
                                                @endif
                                            </td>
                                            
                                            <td class="{{ Config::get('style.rowCenterXs') }} ">
                                                @auth
                                                    @if (
                                                        $participants->payment_status_focus === '' ||
                                                            $participants->payment_status_your === '' ||
                                                            $participants->payment_status_your === 'ABONO' ||
                                                                $participants->usuario = 4)
                                                        @if (strlen($participants->DNI) > 0)
                                                            <a class="{{ config('style.btnPay') }}"
                                                                href="{{ route('Participants.payment', ['id' => $participants->id, 'campus_id' => $participants->campus_id, 'program' => 'FOCUS', 'training' => $participants->training_id, 'training_id_enroller' => $participants->training_id_enroller ?? '%', 'training_id' => $trainingId, 'parameter' => $parameter, 'search' => $search, 'pag' => $pag]) }}">
                                                                <span
                                                                    class="icon-credit-card text-green-900 text-sm hover:bg-green-500 hover:text-white"></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endauth
                                                @php
                                                    $words = explode(' ', $participants->payment_status_focus);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo $initials;
                                                @endphp
                                                
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} ">
                                                @auth
                                                    @if (
                                                        $participants->payment_status_focus === 'PAGO TOTAL' &&
                                                            ($participants->payment_status_life === '' || $participants->payment_status_life === 'ABONO' ||
                                                                $participants->usuario = 4))
                                                        @if (strlen($participants->DNI) > 0)
                                                            <a class="{{ config('style.btnPay') }}"
                                                                href="{{ route('Participants.payment', ['id' => $participants->id, 'campus_id' => $participants->campus_id, 'program' => 'YOUR', 'training' => $participants->training_id, 'training_id_enroller' => $participants->training_id_enroller ?? '%', 'training_id' => $trainingId, 'parameter' => $parameter, 'search' => $search, 'pag' => $pag]) }}">
                                                                <span
                                                                    class="icon-credit-card text-green-900 text-sm hover:bg-green-500 hover:text-white"></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endauth
                                                @php
                                                    $words = explode(' ', $participants->payment_status_your);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo $initials;
                                                @endphp
                                                
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }} ">
                                                @auth
                                                    @if (
                                                        $participants->payment_status_your === 'PAGO TOTAL' &&
                                                            ($participants->payment_status_life === '' ||
                                                                $participants->payment_status_life === 'ABONO' ||
                                                                $participants->usuario = 4) )
                                                        @if (strlen($participants->DNI) > 0)
                                                            <a class="{{ config('style.btnPay') }}"
                                                                href="{{ route('Participants.payment', ['id' => $participants->id, 'campus_id' => $participants->campus_id, 'program' => 'LIFE', 'training' => $participants->training_id, 'training_id_enroller' => $participants->training_id_enroller ?? '%', 'training_id' => $trainingId, 'parameter' => $parameter, 'search' => $search, 'pag' => $pag]) }}">
                                                                <span
                                                                    class="icon-credit-card text-green-900 text-sm hover:bg-green-500 hover:text-white"></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endauth
                                                @php
                                                    $words = explode(' ', $participants->payment_status_life);
                                                    $initials = '';
                                                    foreach ($words as $word) {
                                                        $initials .= strtoupper(substr($word, 0, 1));
                                                    }
                                                    echo $initials;
                                                @endphp
                                                
                                            </td>
        
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->training_original }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->training }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->DNI }}
                                            </td>
                                            <td style="width:8px">
                                                @if($participants->campus_id == 1 && $participants->valida == 0)
                                                    <span style="color:red" title="Verificar número de cédula">(!)</span>
                                                @endif
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}" style="width:200px">
                                                {{ $participants->surnames_names }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->nickname }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->phone }}
                                                 @if($participants->phone2)
                                                    <br>
                                                    {{ $participants->phone2 }}
                                                 @endif
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->team_name_training ? $participants->team_name_training : $participants->number_training }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}">
                                                {{ $participants->enrollerAN }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                {{ $participants->enroller_phone }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}" >
                                                <span style="color: @if($participants->status_focus == 'ASISTIÓ') green @else red @endif" >
                                                    {{ $participants->status_focus }}
                                                </span>
                                                <br>
                                                <b>{{ $participants->focus_attended }}</b>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                <span style="color: @if($participants->status_your == 'ASISTIÓ') green @else red @endif" >
                                                    {{ $participants->status_your }}
                                                </span>
                                                <br>
                                                <b>{{ $participants->your_attended }}</b>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                @if($participants->status_life == 'ASISTIÓ' && $participants->graduate == 'NO')
                                                    <form id="graduate_form" method="POST" 
                                                        action="{{ route('ParticipantsG.graduate',['id' => $participants->id]) }}">
                                                        @csrf
                                                        <input type="hidden" id="campusId5" name="campus_id" value="{{ $campusId }}" />
                                                        <input type="hidden" id="trainingId5" name="training_id" value="{{ $trainingId }}" />
                                                        <input type="hidden" id="parameter5" name="parameter" value="{{ $parameter }}" />
                                                        <input type="hidden" id="search5" name="search" value="{{ $search }}" />
                                                        <input type="hidden" id="pag5" name="pag" value="{{ $pag }}" />
                                                        
                                                        <button class="text-xl text-sky-800 hover:underline" type="button" title="GRADUAR" onclick="confirmGraduar('{{ $participants->id }}','{{ $participants->names_surnames }}','Participants')">NO</button>
                                                    </form>
                                                @elseif($participants->graduate == 'SI')
                                                    <span class="font-bold text-2xl" style="color:green">{{ $participants->graduate }}</span>
                                                @else
                                                    {{ $participants->graduate }}
                                                @endif
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
    
        $(function() {
            $('input').val(function(_, value) {
                return $.trim(value);
            });
            var searchInput = document.getElementById('search');
            var length = searchInput.value.length;
            
            if(length > 0)
            {
                searchInput.focus();
                searchInput.setSelectionRange(length, length);
            }
            
        });
            
        const selectCampus = document.getElementById('campus_id');
        const selectPag = document.getElementById('pag');
    
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
        
        selectPag.addEventListener('change', function() {
            document.getElementById('pag_form').submit();
        });
        
        function buscaParametro(parametro){
            document.getElementById('parameter_form').submit();
        }
        
        function buscaCriterio(){
            document.getElementById('search_form').submit();
        }
    
    
        function confirmGraduar(id,name,entidad) {
            if (confirm('¿Estás seguro de que quieres graduar a '+ name +'?')) {
                document.getElementById('graduate_form').submit();
                
            }
        }
        
        function graduarResult(id,entidad) {
            $.ajax({
                url: '/graduate/' + id,
                
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    submitData(entidad);
                    // Maneja la respuesta exitosa, si es necesario
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Maneja los errores, si es necesario
                    console.error(error);
                }
            });
        }
        </script>
        <!--
        <script>
            $(document).ready(function () {
                onSelectCampusChange();
                $('#campus_id').on('change', onSelectCampusChange);
                $('#training_id').on('change', onSelectChange);
            });
            
            
            function onSelectCampusChange() {
                var searchValue = $('#search_participant').val().replace(/ /g, '%') || "%";
                var pagValue = $('#pag').val();
                var tipoValue = $('input[name="opcionB"]:checked').val() || 'P';
                var campus = $('#campus_id').val();
                var training = $('#training_id').val();
                $.ajax({
                    url: "{{ route('Participants.index') }}",
                    method: "GET",
                    data: {
                        search: searchValue,
                        pag: pagValue,
                        tipo: tipoValue,
                        campus_id: campus,
                        trainingId: training,
                    },
                    success: function(response) {
                        
                        if ($(response).find('#tablaDatos').length) {
                            $('#conResultados').show();
                            $('#sinResultados').hide();
            
                            var $tablaDatos = $(response).find('#tablaDatos');
            
                            if ($tablaDatos.find('tbody tr').length > 0) {
                                var $pagina = $(response).find('#pagina');
                                var numRegistros = $tablaDatos.find('tbody tr').length;
            
                                $('#tablaDatos').replaceWith($tablaDatos);
                                $('#pagina').replaceWith($pagina);
                                $('#search').focus();
                            } else {
                                $('#conResultados').hide();
                                $('#sinResultados').show().html('No hay resultados para la búsqueda "' + searchValue + '"');
                            }
                        } 
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
                

            }
            
            function onSelectChange()
            {
                var searchValue = $('#search').val().replace(/ /g, '%') || "%";
                var pagValue = $('#pag').val();
                var tipoValue = $('input[name="opcionB"]:checked').val() || 'P';
                var campus = $('#campus_id').val();
                var training = $('#training_id').val();
                $.ajax({
                    url: "{{ route('Participants.index') }}",
                    method: "GET",
                    data: {
                        search: searchValue,
                        pag: pagValue,
                        tipo: tipoValue,
                        campus_id: campus,
                        training_id: training,
                    },
                    success: function(response) {
                        
                        if ($(response).find('#tablaDatos').length) {
                            $('#conResultados').show();
                            $('#sinResultados').hide();
            
                            var $tablaDatos = $(response).find('#tablaDatos');
            
                            if ($tablaDatos.find('tbody tr').length > 0) {
                                var $pagina = $(response).find('#pagina');
                                var numRegistros = $tablaDatos.find('tbody tr').length;
            
                                $('#tablaDatos').replaceWith($tablaDatos);
                                $('#pagina').replaceWith($pagina);
                                $('#search').focus();
                            } else {
                                $('#conResultados').hide();
                                $('#sinResultados').show().html('No hay resultados para la búsqueda "' + searchValue + '"');
                            }
                        } 
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
                
            }
            
        </script>
        -->
</x-app-layout>
