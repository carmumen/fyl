<x-app-layout title="Participants" meta-description="Participants">
    <x-slot name="title">
        @lang('Participants')
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Generate Link')</h1>



    <div class="flex px-8 py-4 bg-white">
        @if (isset($trainingEnroller) && count($trainingEnroller) > 0)
            @foreach ($trainingEnroller as $thetrainingEnroller)
                <div class="flex flex-1 flex-col">
                    <form id="{{ $thetrainingEnroller->training_id_enroller }}" method="POST" action="{{ route('EnrollerG.generateInternalCode') }}">
                        @csrf
                        <input type="hidden" name="training_id_enroller" value="{{ $thetrainingEnroller->training_id_enroller }}" />
                        <input type="hidden" name="DNI_enroller" value="{{ $thetrainingEnroller->DNI_enroller }}" />
                        <span class="text-red-900"><b>Nota: </b></span>
                        <span><b>En enlace generado tendr&aacute; una duraci&oacute;n de 2 horas</b></span>
                        <br><br>
                        <span>Generar enlace como {{ $thetrainingEnroller->team_name }}</span>
                        <div class="py-2 mx-8 w-full">

                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                                id="training_id" required>
                                @foreach ($training_id as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('training_id', $trainingId)) selected @endif>
                                        {{ __($name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="{{ Config::get('style.btnSave') }} mx-4" form="{{ $thetrainingEnroller->training_id_enroller }}" type="submit">@lang('Generar Enlace')</button>

                            @if (isset($link))
                                <button id="copyButton" style="cursor: pointer;" class="{{ Config::get('style.btnSave') }} m-4" style="margin-top: 2px" onclick="copiaLink('{{ $link }}')">Copiar Enlace</button>
                            @endif
                        </div>
                    </form>
                    @if (isset($error))
                        <span class="font-bold text-red-500/80">{{ $error }}</span>
                    @endif
                </div>
            @endforeach
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
