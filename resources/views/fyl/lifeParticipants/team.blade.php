<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Staff')
        </h2>
    </x-slot>
    <header>

    </header>

    <div class="{{ Config::get('style.containerIndex') }}">

        @if (session('status'))
            <div class="text-green-600 h-3 text-center">
                {{ __(session('status')) }}
                <br>
            </div>
        @endif
        <fieldset class=" border border-solid border-gray-300 py-2 rounded-md">
            <legend class="text-sm text-sky-900">@lang('Legendario Staff')</legend>
            <div class="flex flex-row flex-wrap mx-4">
                <select class="{{ Config::get('style.cajaTexto') }} w-48" type="text" name="training_id"
                    id="training_id" required />
                </select>
                <select class="{{ Config::get('style.cajaTexto') }} w-48" type="text" name="staff_DNI" id="staff_DNI"
                    required />
                </select>
            </div>
            <form id="form1" method="POST" action="{{ route('Staff.store') }}">
                @csrf

                <input type="hidden" name="type" value="normal" />
                <div class="flex flex-row flex-wrap mx-4">
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
                        <nav class="space-x-4">
                            <span class="">
                                <form method="POST" class="flex items-center space-x-2"
                                    action="{{ route('FocusParticipants.store') }}">
                                    @csrf
                                    {{-- <span class="{{ Config::get('style.label') }}">@lang('Training')</span> --}}

                                    <button class="icon-upload text-2xl text-sky-800 hover:underline"
                                        type="submit"></button>
                                </form>
                            </span>
                        </nav>
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Program')</span>
                        <select class="{{ Config::get('style.cajaTexto') }}" id="program_id" name="program_id" required>
                            <option value="">-- Seleccione --</option>
                            {{-- @foreach ($program as $id => $name)
                                <option value="{{ $id }}" @if ($staff->isNotEmpty() && $id == old('program_id', $staff[0]->program_id)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach --}}
                        </select>
                        @error('program_id')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Role')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="role" required />
                        <option value="">--Seleccione--</option>
                        <option value="CAPITAN">CAPITAN</option>
                        <option value="STAFF">STAFF</option>
                        </select>
                        @error('role')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Staff')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} " id="participant_DNI"
                            name="participant_DNI">
                        </select>
                        @error('role')
                            <br>
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" form="form1"
                            type="submit">Agregar</button>
                    </div>
                </div>
            </form>
        </fieldset>

        <fieldset id="newRegister" class=" border border-solid border-gray-300 py-2 rounded-md" style="display: none;">
            <legend class="text-sm text-sky-900">@lang('Registrar Staff')</legend>
            <form id="form2" method="POST" action="{{ route('Staff.store') }}">
                @csrf
                <input type="hidden" name="type" value="nuevo" />
                <div class="flex flex-row flex-wrap  py-2 mx-4">
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="DNI"
                            value=" {{ old('DNI') }}" required />
                        @error('DNI')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names"
                            value=" {{ old('names') }}" required oninput="this.value = this.value.toUpperCase();" />
                        @error('names')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="surnames"
                            value=" {{ old('surnames') }}" required oninput="this.value = this.value.toUpperCase();" />
                        @error('surnames')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Nickname')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="nickname"
                            value=" {{ old('nickname') }}" required oninput="this.value = this.value.toUpperCase();" />
                        @error('nickname')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="email"
                            value=" {{ old('email') }}" required oninput="this.value = this.value.toLowerCase();" />
                        @error('email')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <label class="flex flex-col mx-2 py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone"
                            value=" {{ old('phone') }}" required />
                        @error('phone')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                    <div class="flex items-center justify-between mt-4 px-4">
                        <button class="{{ Config::get('style.btnSave') }}" form="form2"
                            type="submit">Agregar</button>
                    </div>
            </form>
        </fieldset>
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {
        training();
        $('#training_id').on('change', function() {
            var trainingId = $(this).val();
            if (trainingId) {
                // Realiza una solicitud AJAX para cargar las provincias basadas en el país seleccionado
                $.ajax({
                    url: '/listas/staffFocus/' + trainingId,
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

    function training() {
        var html = '<option value="">-- Seleccione --</option>';
        $.ajax({
            url: '/listas/training',
            type: 'GET',
            success: function(data) {
                console.log(data);
                var selectElement = $('#training_id');

                // Limpia el contenido actual del select
                selectElement.empty();

                // Agrega la opción por defecto
                selectElement.append('<option value="">-- Seleccione --</option>');

                // Recorre los datos y agrega las opciones al select
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        selectElement.append('<option value="' + key + '">' + data[key] + '</option>');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);

                // Puedes imprimir el objeto jqXHR completo para obtener más detalles del error
                console.log(jqXHR);

                // También puedes mostrar un mensaje de error más específico en función del error
                if (jqXHR.status === 500) {
                    alert("Error interno del servidor. Por favor, inténtalo de nuevo más tarde.");
                } else {
                    alert("Se produjo un error al cargar los datos.");
                }
            }
        });
    }
</script>
