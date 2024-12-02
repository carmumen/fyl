<div class="px-1 py-3 md:px-8 ">
    <div id="mensaje" >
           <!-- <center>
                <b style="color:red; font-size:20px">El sistema se encuentra en proceso de inactivaci&oacute;n.</b> 
                
                <br>
                Estará disponible:
                <div id="temporizador" style="font-size: 2em; color:red">00:00</div>
               
            </center> -->
        </div>
    
    @php
        if (session('entidad') == $entidad) {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => $entidad]);
            session(['search' => '']);
        }
    @endphp

    @auth
        
        @if($entidad == 'Participants')
        
            <div class="flex  w-full" style="margin-top: -15px">
                <div class=" w-1/4"></div>
                <div class=" flex w-3/4 ">
                    
                    
                    <div style="width: 25%; padding-top:15px">
                     
                    
                    
                    
                        <label class="radio-label" style="width:80px">
                            <input type="radio" name="opcionB" value="P" title="Participante" onchange="submitData()" {{ (old('opcionB', session('parameter')) === 'P') ? 'checked' : '' }}>
                            P
                        </label>&nbsp;
                        <label class="radio-label">
                            <input type="radio" name="opcionB" value="E" title="Enrolador" onchange="submitData()" {{ (old('opcionB', session('parameter')) === 'E') ? 'checked' : '' }}>
                            E
                        </label>
                    </div>
                    <div style="width: 25%;">
                    </div>
                </div>
            </div>
        @endif
        
        <div class="flex  w-full">
            <div class=" w-1/4">
                 @if($entidad != 'Participants')
                <a class="{{ Config::get('style.btnCreate') }}" href="{{ route($entidad . '.create') }}">
                    <span class="icon-plus"></span>
                    <div class="hidden md:inline-block">&nbsp; @lang('New')</div>

                </a>
                @endif
            </div>
            <div class=" flex w-3/4 ">
                <div class="w-full md:w-4/5 md:inline-block">
                    <div class="flex flex-row  justify-between px-4">
                            
                        
                        <input class="w-full {{ Config::get('style.cajaBusqueda') }}" type="text" id="search"
                            placeholder="Buscar..." value="{{ isset($search) ? str_replace("%", " ", $search) : '' }}"
                            onkeyup="submitData('{{ $entidad }}')" />
                    </div>
                </div>
                <div class="hidden md:inline-block w-1/5 ">
                    <select class="{{ Config::get('style.cajaTexto') }} w-16 float-right" type="text" name="pag"
                        id="pag" onchange="submitData('{{ $entidad }}')" required />
                        @if($entidad != 'Users')
                            @if($entidad == 'Participants')
                            <option value="20">20</option>
                            @else
                            <option value="30">30</option>
                            @endif
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        @else
                            <option value="100">100</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>

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
    $(function() {
        $('#sinResultados').hide();
    });
    
    function submitData(entidad) {
        var searchValue = $('#search').val().replace(/ /g, '%') || "%";
        var pagValue = $('#pag').val();
        var tipoValue = $('input[name="opcionB"]:checked').val() || 'P';
    
        $.ajax({
            url: "{{ route($entidad . '.index') }}",
            method: "GET",
            data: {
                search: searchValue,
                pag: pagValue,
                tipo: tipoValue,
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
