<x-app-layout>
    @php
        if (session('entidad') == 'ParticipantsNameChange') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'ParticipantsNameChange']);
            session(['search' => '']);
        }

        if (session('status')) {
            $campusId = session('campusE');
        }

    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Name Change')
        </h2>
    </x-slot>

    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Aè´–ade 5px de espacio alrededor del contenido */
        }
    </style>

    <header>
        {{-- @include('partials/header', ['entidad' => 'ParticipantsNameChange']) --}}
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <form id="form"  class="flex items-center space-x-2"
                method="GET"
                action="{{ route('ParticipantsNameChange.index') }}">
            @csrf
            <label class="flex flex-col w-64">
                <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" type="text" id="training_id" name="training_id" required >
                    <option value="">-- Seleccione --</option>
                    @foreach ($training as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('training_id', $trainingId)) selected @endif>
                        {{ __($name) }}
                    </option>
                    @endforeach
                </select>
            </label>
            
                
         
        </form>
        
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
                                        @lang('Team Enroller')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        <b>@lang('Enroller')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-24">
                                        <b>@lang('Phone Enroller')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        <b>@lang('Participants')</b>
                                    </th>
                                    @auth
                                        <th scope="col" class="w-24 {{ Config::get('style.headerCenterXs') }} ">
                                            <b>@lang('Link')</b>
                                        </th>
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
                                            {{ $participants->team_enroller }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $participants->enroller }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeftXs') }}">
                                            {{ $participants->phone_enroller }}
                                        </td>
                                        <td class="{{ Config::get('style.rowLeftXs') }}">
                                            {{ $participants->participant }}
                                        </td>
                                        @auth
                                            <td class="w-24 py-1 {{  Config::get('style.rowCenter') }}">
                                                @if($participants->url)
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
        const selectElement = document.getElementById('training_id');

selectElement.addEventListener('change', function() {
    // Accede al formulario y envè´øalo
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
