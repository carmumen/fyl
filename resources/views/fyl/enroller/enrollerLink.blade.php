<x-app-layout>
   
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Participants')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <header>
        {{-- @include('partials/header', ['entidad' => 'Participants']) --}}
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <form id="form"  class="flex items-center space-x-2"
                method="GET"
                action="{{ route('Enroller.index') }}">
            @csrf
            <label class="flex flex-col w-64">
                <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="campus_id" name="campus_id" required >
                    <option value="">-- Seleccione --</option>
                    @foreach ($campus as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('campus_id', $campusId)) selected @endif>
                        {{ __($name) }}
                    </option>
                    @endforeach
                </select>
            </label>
        </form>
        @if (isset($participant) && count($participant) > 0)
        <fieldset id="newRegister" class=" border border-solid border-gray-300 py-2 rounded-md m-2"
        {{-- style="display: none;" --}}
            >
            <legend class="text-sm text-sky-900">@lang('Registrar Recuperado o Rezagado')</legend>
            <form id="form2" method="POST" action="{{ route('EnrollerNR.newRegister') }}">
                @csrf
                <input type="hidden" name="campusId" value="{{ $campusId }}" />
                <div class="flex flex-row flex-wrap  py-2 mx-4">
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Training Enroller')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="training_id_enroller" name="training_id_enroller" required >
                            <option value="">-- Seleccione --</option>
                            @foreach ($training as $id => $team_name)
                            <option value="{{ $id }}"
                                @if($id == old('training_id_enroller')) selected @endif>
                                {{ __($team_name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('training_id_enroller')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Enroller')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="DNI_enroller" name="DNI_enroller"
                                value=" {{ old('DNI_enroller') }}" >
                        </select>
                        @error('DNI_enroller')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                        <input type="text" class="{{ Config::get('style.cajaTexto') }} mr-4" id="names" name="names"
                                value=" {{ old('names') }}" />
                        @error('names')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Training Invited')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="training_id" name="training_id" required >
                            <option value="">-- Seleccione --</option>
                            @foreach ($trainingInvited as $id => $name)
                            <option value="{{ $id }}"
                                @if($id == old('training_id')) selected @endif>
                                {{ __($name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('training_id')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" form="form2"
                            type="submit">Agregar</button>
                    </div>
            </form>
        </fieldset>
        @endif
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    @if (isset($participant) && count($participant) > 0)
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        @lang('No.')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Training')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-24">
                                        <b>@lang('DNI')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-24">
                                        <b>@lang('Surnames')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-24">
                                        <b>@lang('Names')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        <b>@lang('Nickname')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        <b>@lang('Phone')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Training Enroller')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Enroller')
                                    </th>
                                    @auth
                                        <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($participant as $participants)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->training }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->DNI }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeftXs') }}">
                                            {{ $participants->surnames }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeftXs') }}">
                                            {{ $participants->names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->nickname }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->phone }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->training_enroller}}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->enroller}}
                                        </td>
                                        @auth
                                            <td class="w-24 inline-flex text-center py-1.5">
                                                <a class="{{ Config::get('style.btnEdit') }}"
                                                    href="{{ route('Enroller.edit', $participants->id) }}">
                                                    <span
                                                        class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                                </a>
                                                @if($participants->training_enroller && $participants->enroller)
                                                <button id="copyButton" class="{{ Config::get('style.btnSave') }} rounded-full" onclick="copiaLink('{{ $participants->url }}');">
                                                    <span class="icon-code"></span>
                                                </button>
                                                @endif
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagina" class=" text-sky-800 bg-gray-50">
                            {{-- {{ $participants->links() }} --}}
                        </div>
                    @endif
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50">
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
         $('#training_id_enroller').on('change', onSelectTrainingChange);
        })

        function onSelectTrainingChange() {
            var training_id_enroller = $('#training_id_enroller').val();
            if (training_id_enroller == "") return;
            var url = '/dni_training/' + training_id_enroller;
            var html_select = '<option value="">-- Seleccione --</option>';
            //var selectedPrice = @php echo json_encode(session('price', false)); @endphp;

            $.get(url, function(data) {
                for (var i = 0; i < data.length; ++i) {
                    html_select += '<option value="' + data[i].DNI + '"';
                    // if (selectedOptionValue !== null && data[i].DNI == selectedOptionValue) {
                    //     html_select += ' selected';
                    // }
                    html_select += '>' + data[i].name + '</option>';
                }
                $('#DNI_enroller').html(html_select);
            });

        }

        const selectElement = document.getElementById('campus_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('form').submit();
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
