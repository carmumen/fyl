<div class="px-1 py-3 md:px-8 ">
    <div id="mensaje" >
             <!-- <center>
                <b style="color:red; font-size:20px">El sistema se encuentra en proceso de inactivaci&oacute;n.</b> 
              
                <br>
                Estar®¢ disponible:
                <div id="temporizador" style="font-size: 2em; color:red">00:00</div>
               
            </center> -->
        </div>
    @php
        if (session('entidad') == $entidad) {
            $search_participant = session('search_participant');
            
            $pag = session('pag_participant');
            
            if ($search_participant === null) {
                $search_participant = '';
            } else {
                if (Str::length($search_participant) == 1) {
                    $search_participant = '';
                }
            }
        } else {
            session(['entidad' => $entidad]);
            session(['search_participant' => '']);
        }
    @endphp

    @auth
    
    <table style="width:100%">
        <tr>
            <td style="width:20%">
                @if (isset($campus) && count($campus) > 0)
                    <form id="campus_form" method="POST" class="flex items-center space-x-2"
                        action="{{ route('Participants.obtenerEntrenamiento') }}">
                        @csrf
                        <input type="hidden" id="opcionB_campus" name="opcionB" />
                        <input type="hidden" id="pag_campus" name="pag" />
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" 
                            onchange="submitData('{{ $entidad }}')"
                            name="campus_id"
                            id="campus_id" required>
                            <option value="%">--Seleccione la Sede--</option>
                            @foreach ($campus as $id => $name)
                                <option value="{{ $id }}"
                                    @if ($id == old('campus_id', $campusId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </td>
            <td style="width:20%">
                @if (isset($training) && count($training) > 0)
                    <form id="training_form" method="POST" class="flex items-center space-x-2"
                        action="{{ route('Participants.recarga') }}">
                        @csrf
                        <input type="hidden" id="campus" name="campus_id" />
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                            id="training_id" >
                            <option value="%">--Equipo Enrolador--</option>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </td>
            <td style="width:5%">
                <label class="radio-label" style="width:80px">
                    <input type="radio" name="opcionB" value="P" title="Participante" onchange="submitData('{{ $entidad }}')" {{ (old('opcionB', session('parameter')) === 'P') ? 'checked' : '' }}>
                    P
                </label>
                <label class="radio-label">
                    <input type="radio" name="opcionB" value="E" title="Enrolador" onchange="submitData('{{ $entidad }}')" {{ (old('opcionB', session('parameter')) === 'E') ? 'checked' : '' }}>
                    E
                </label>
            </td>
            <td >
                <input class="w-full {{ Config::get('style.cajaBusqueda') }}" type="text" id="search_participant"
                            placeholder="Buscar..." value="{{ isset($search_participant) ? str_replace("%", " ", $search_participant) : '' }}"
                            onkeyup="submitData('{{ $entidad }}')" />
            </td>
            <td style="width:10%; text-align:rigth">
                <select class="{{ Config::get('style.cajaTexto') }} w-16 float-right" type="text" name="pag"
                    id="pag" onchange="submitData('{{ $entidad }}')" required />
                    <option value="20" @if ($pag == 20) selected @endif>20</option>
                    <option value="30"  @if ($pag == 30) selected @endif>30</option>
                    <option value="50"  @if ($pag == 50) selected @endif>50</option>
                    <option value="100"  @if ($pag == 100) selected @endif>100</option>
                    <option value="200"  @if ($pag == 200) selected @endif>200</option>
                </select>
            </td>
        </tr>
    </table>

        @if (session('status'))
            <div class="text-green-600 h-3">
                {{ __(session('status')) }}
            </div>
        @endif
        @if (session('errors'))
            <div class="font-bold text-red-500 h-3">
                {{ __(session('errors')) }}
            </div>
        @endif

    @endauth
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    const selectCampus = document.getElementById('campus_id');
    const selectTraining = document.getElementById('training_id');
    const selectPag = document.getElementById('pag');
    const selectParameter = document.getElementById('pag');

    selectCampus.addEventListener('change', function() {
        console.log(selectPag.value);
        console.log(selectParameter.value);
        $('#opcionB_campus').val(selectParameter.value);
        $('#pag_campus').val(selectPag.value);
        document.getElementById('campus_form').submit();
    });
    
    if(selectTraining)
    {
        selectTraining.addEventListener('change', function() {
            $('#campus').val(selectCampus.value);
            document.getElementById('training_form').submit();
        });
    }



    $(function() {
        $('#sinResultados').hide();
        submitData('Participants');
    });
    
    function submitData(entidad) {
        var campus = document.getElementById('campus_id');
        var training = document.getElementById('training_id');
        var trainingValue = (training !== null) ? training.value : '%';
        var searchParticipantValue = $('#search_participant').val().replace(/ /g, '%') || "%";
        var pagValue = $('#pag').val();
        var tipoValue = $('input[name="opcionB"]:checked').val() || 'P';
        
        console.log(tipoValue) 
    
        $.ajax({
            url: "{{ route('Participants.index') }}",
            method: "GET",
            data: {
                campus_id: campus.value,
                training_id: trainingValue,
                search_participant: searchParticipantValue,
                pag: pagValue,
                tipo: tipoValue,
            },
            success: function(response) {
                var $response = $(response);
                var $tablaDatos = $response.find('#tablaDatos');
                var $pagina = $response.find('#pagina');
    
                if ($tablaDatos.length > 0) {
                    $('#conResultados').show();
                    $('#sinResultados').hide();
    
                    if ($tablaDatos.find('tbody tr').length > 0) {
                        $('#tablaDatos').replaceWith($tablaDatos);
                        $('#pagina').replaceWith($pagina);
                        $('#search_participant').focus();
                    } else {
                        $('#conResultados').hide();
                        $('#sinResultados').show().html('No hay resultados para la b√∫squeda "' + searchParticipantValue + '"');
                    }
                } else {
                    $('#conResultados').hide();
                    $('#sinResultados').show().html('No se encontr√≥ la tabla de datos en la respuesta.');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }



</script>
