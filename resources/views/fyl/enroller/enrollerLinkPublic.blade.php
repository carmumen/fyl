<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LACTsys') }}</title>
    <link rel="icon" href="{{ asset('imgages/tu_icono.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <style>
    </style>


</head>

<body class="font-sans antialiased body">

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg  mt-6 mb-8">

                <div class="space-y-4  mt-6 mb-8 px-8">
                    {{-- <label>{{ $users->names }}
                        <input type="text" value="{{ $fullUrl }}"
                    </label> --}}

                    {{-- @dump($training) --}}
                    <form method="POST" action="{{ route('filter-participants') }}">
                        @csrf

                        <select class="{{ Config::get('style.cajaTexto') }} w-48" type="text" name="training_id"
                            id="training_id" required />
                        @foreach ($training as $id => $name)
                            <option value="{{ $id }}" {{ old('training_id') == $id ? 'selected' : '' }}>
                                {{ __($name) }}</option>
                        @endforeach
                        </select>
                        @if (isset($participant) && count($participant) > 0)
                        <select name="participant_DNI" id="participant_DNI">
                            <option value="">Selecciona tu nombre</option>
                            @foreach ($participant as $theparticipant)
                                <option value="{{ $theparticipant->id }}"
                                    {{ old('theparticipant') == $theparticipant->id ? 'selected' : '' }}>
                                    {{ $theparticipant->name }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <button type="submit">Filtrar</button>
                    </form>

                    <div class="flex-1 md:w-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Team')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id"
                                id="training_id" value=" {{ old('training_id') }}" required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                            @error('training_id')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror

                        </label>
                    </div>

                    <div class="flex-1 md:w-1/4 px-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Team')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id"
                                id="training_id" value=" {{ old('training_id') }}" required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                            @error('training_id')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror

                        </label>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // training();
            $('#training_id').on('change', function() {
                var trainingId = $(this).val();
                if (trainingId) {
                    // Realiza una solicitud AJAX para cargar las provincias basadas en el país seleccionado
                    $.ajax({
                        url: '/listas/lifeEnroller/' + trainingId,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#staff_DNI').html(data);
                        }
                    });
                } else {
                    console.log('la falla');
                    // Limpia el selector de provincias si no se seleccionó un país
                    $('#staff_DNI').html('<option value="">--Seleccione--</option>');
                }
            });
        });

        // function copiaLink() {

        //     var textToCopy =
        //     var dummyInput = document.createElement("input");
        //     document.body.appendChild(dummyInput);
        //     dummyInput.setAttribute("value", textToCopy);
        //     dummyInput.select();
        //     document.execCommand("copy");
        //     setTimeout(function() {
        //         document.body.removeChild(dummyInput);
        //         alert('Enlace copiado al portapapeles');
        //     }, 100);
        // }
    </script>
</body>

</html>
