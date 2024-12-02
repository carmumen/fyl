<x-app-layout title="Participants" meta-description="Participants">
    <x-slot name="title">
        @lang('Participants')
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A単ade 5px de espacio alrededor del contenido */
        }
    </style>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Generate Link')</h1>



    <div class="flex flex-1 px-8 py-4 bg-white">
        @if (isset($training) && count($training) > 0)
                <div class="flex flex-1 flex-col">
                    <form id="form" method="POST" action="{{ route('Life.generateCodeEnroller') }}">
                        @csrf
                        <input type="hidden" name="training_id_enroller" value="{{ $training[0]->training_id_enroller }}" />
                        <input type="hidden" name="DNI_enroller" value="{{ $training[0]->DNI_enroller }}" />
                        <input type="hidden" name="campus_id" value="{{ $training[0]->campus_id }}" />
                        <input type="hidden" name="training_id" value="{{ $training[0]->training_in_game }}" />
                        <span class="text-red-900"><b>Nota: </b></span>
                        
                        <span><b>En enlace generado tendr&aacute; una duraci&oacute;n de 2 horas</b></span>
                        <br><br>
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Mi Equipo')</span>
                            <span style="padding-left:20px">{{ $training[0]->team_name }}</span>
                        </label>
                        
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Entrenamiento en juego')</span>
                            <span style="padding-left:20px">{{ $training[0]->game }}</span>
                        </label>
                        <div class="py-2 w-full">

                            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Generar Enlace')</button>
                            
                            @if (isset($link))
                            <label class="flex flex-col">
                                <br>
                                @if (isset($error))
                                    <span class="font-bold text-red-500/80">{{ $error }}</span>
                                @else
                                    <span class="font-bold text-blue-500/80">Este enlace generado tendr&aacute; una duraci&oacute;n de 2 horas y es reutilizable</span>
                                @endif
                            </label>
                            <button id="copyButton" class="{{ Config::get('style.btnSave') }}" onclick="copiaLink('{{ $link }}')">Copiar Enlace</button>
                            @endif
                        </div>
                    </form>
                    
                </div>
        @endif
    </div>

    <script>
        function copiaLink(link) {
            var textToCopy = link;
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
