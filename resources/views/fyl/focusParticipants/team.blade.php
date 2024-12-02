<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Staff')
        </h2>
    </x-slot>
    <header>
        <label class="flex flex-col">
            <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
            <select class="{{ Config::get('style.cajaTexto') }} w-64" type="text" id="training_id" name="training_id"
                required />
            <option value="">-- Seleccione --</option>
            @foreach ($training->toArray() as $id => $name)
                <option value="{{ $id }}">
                    {{ __($name) }}</option>
            @endforeach
            </select>
        </label>
    </header>
    <div class="flex flex-row">
        @if (isset($legendary) && count($legendary) > 0)
            <div class="{{ Config::get('style.containerIndex') }} ">
                <form method="POST" action="{{ route('TeamStaffLegendary.storeTS') }}">
                    @csrf

                    <input type="hidden" name="trainning_id" value="{{ $trainingId }}" />

                    <div class="flex flex-col md:flex-row py-1">
                        <label class="flex flex-col mr-4">
                            <span class="{{ Config::get('style.label') }}">@lang('Legendary')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="legendary_DNI"
                                required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($legendary as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('legendary_DNI', $legendaryDNI)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>

                        @if (isset($staff_legendary) && count($staff_legendary) > 0)
                            <label class="flex flex-col mr-4">
                                <span class="{{ Config::get('style.label') }}">@lang('Staff')</span>
                                <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                    name="staff_legendary_DNI" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($staff_legendary as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('staff_legendary_DNI')) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                            </label>
                            <label class="flex flex-col mt-4">
                                <button class="{{ Config::get('style.btnSave') }}" type="submit">Relacionar</button>
                            </label>
                        @endif
                    </div>

                </form>
                <span class="text-red-500">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </span>
                <div class="flex-1 flex-col ">
                    <label class="flex flex-col">
                        @if (isset($team_staff_legendary) && count($team_staff_legendary) > 0)
                            <main class="mt-4 border border-gray-200 md:rounded-lg mb-10">
                                <div id="conResultados">
                                    {{-- @dump($team_staff_legendary) --}}
                                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-sky-800">
                                            <tr>
                                                <th scope="col"
                                                    class="{{ Config::get('style.headerLeftXs') }} py-2">
                                                    @lang('No.')
                                                </th>
                                                <th scope="col"
                                                    class="{{ Config::get('style.headerLeftXs') }} py-2">
                                                    @lang('Legendary')
                                                </th>
                                                <th scope="col" class="{{ Config::get('style.headerLeftXs') }}">
                                                    @lang('Staff')
                                                </th>
                                                @auth
                                                    <th scope="col" class="w-16 relative py-1.5 px-4"></th>
                                                @endauth
                                            </tr>
                                        </thead>
                                        <tbody class="bg-gray-100">
                                            @foreach ($team_staff_legendary as $theteam_staff_legendary)
                                                <tr class="border-b border-gray-200">
                                                    <td class="{{ Config::get('style.rowSequential') }} w-12 ">
                                                        {{ $theteam_staff_legendary->secuencial }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                                        {{ $theteam_staff_legendary->legendary }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                                        {{ $theteam_staff_legendary->staff }}
                                                    </td>
                                                    @auth
                                                        <td class="w-16 inline-flex text-center py-1">
                                                            @if ($theteam_staff_legendary->staff)
                                                                <form
                                                                    action="{{ route('TeamStaffD.destroySL', $theteam_staff_legendary->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button class="{{ Config::get('style.btnDelete') }}"
                                                                        type="submit"
                                                                        onclick="return confirm('¿Seguro que deseas eliminar la relación?')">
                                                                        <span
                                                                            class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endauth
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                        {{-- {{ $team_staff_legendary->links() }} --}}
                                    </div>
                                </div>
                            </main>
                        @endif
                    </label>
                </div>
            </div>
        @endif
        @if (isset($staff) && count($staff) > 0)
            <div class="{{ Config::get('style.containerIndex') }} ">
                <form method="POST" action="{{ route('TeamStaff.store') }}">
                    @csrf
                    <div class="flex flex-col md:flex-row py-1">

                        <label class="flex flex-col mr-4">
                            <span class="{{ Config::get('style.label') }}">@lang('Staff')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="staff_DNI"
                                required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($staff as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('staff_DNI', $staffDNI)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>
                        </label>

                        @if (isset($participants) && count($participants) > 0)
                            <label class="flex flex-col mr-4">
                                <span class="{{ Config::get('style.label') }}">@lang('Participants')</span>
                                <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                    name="participants_DNI" required />
                                <option value="">-- Seleccione --</option>
                                @foreach ($participants as $id => $name)
                                    <option value="{{ $id }}"
                                        @if ($id == old('participants_DNI')) selected @endif>
                                        {{ __($name) }}</option>
                                @endforeach
                                </select>
                            </label>
                            <label class="flex flex-col mt-4">
                                <button class="{{ Config::get('style.btnSave') }}" type="submit">Relacionar</button>
                            </label>
                        @endif
                    </div>

                </form>
                <span class="text-red-500">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </span>
                <div class="flex-1 flex-col">
                    <label class="flex flex-col">
                        @if (isset($focusParticipants) && count($focusParticipants) > 0)
                            <main class="mt-4 border border-gray-200 md:rounded-lg mb-10">
                                <div id="conResultados">
                                    {{-- @dump($focusParticipants) --}}
                                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-sky-800">
                                            <tr>
                                                <th scope="col"
                                                    class="{{ Config::get('style.headerLeftXs') }} py-2">
                                                    @lang('No.')
                                                </th>
                                                <th scope="col" class="{{ Config::get('style.headerLeftXs') }}">
                                                    @lang('Staff')
                                                </th>
                                                <th scope="col"
                                                    class="{{ Config::get('style.headerLeftXs') }} py-2">
                                                    @lang('Participant')
                                                </th>
                                                <th scope="col" class="{{ Config::get('style.headerLeftXs') }}">
                                                    @lang('Nickname')
                                                </th>
                                                @auth
                                                    <th scope="col" class="w-16 relative py-1.5 px-4"></th>
                                                @endauth
                                            </tr>
                                        </thead>
                                        <tbody class="bg-gray-100">
                                            @foreach ($focusParticipants as $theFocusParticipants)
                                                <tr class="border-b border-gray-200">
                                                    <td class="{{ Config::get('style.rowSequential') }} w-12 ">
                                                        {{ $theFocusParticipants->secuencial }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                                        {{ $theFocusParticipants->staff }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                                        {{ $theFocusParticipants->participant }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                                        {{ $theFocusParticipants->nickname }}
                                                    </td>
                                                    @auth
                                                        <td class="w-16 inline-flex text-center py-1">
                                                            @if ($theFocusParticipants->staff)
                                                                <form
                                                                    action="{{ route('TeamStaff.destroy', $theFocusParticipants->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button class="{{ Config::get('style.btnDelete') }}"
                                                                        type="submit"
                                                                        onclick="return confirm('¿Seguro que deseas eliminar la relación?')">
                                                                        <span
                                                                            class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endauth
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                        {{-- {{ $focusParticipants->links() }} --}}
                                    </div>
                                </div>
                            </main>
                        @endif
                    </label>
                </div>
            </div>
        @endif

    </div>



</x-app-layout>


<script>
    $(document).ready(function() {


        $('.legendary-select').on('change', function() {
            var member_DNI = $(this).val();
            var newStatus = $(this).prop('checked');
            var selectedTrainingId = $("#training_id").val();

            var updateUrl = "{{ route('TeamStaff.store') }}";
            // Realizar una solicitud AJAX para actualizar el estado
            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    member_DNI: member_DNI,
                    newStatus: newStatus,
                    trainingId: selectedTrainingId,
                    programId: 2,
                    team: 'legendary'
                },
                success: function(response) {
                    //console.log(response)
                    var url = '/TeamStaff?training_id=' + response;
                    window.location.href = url;
                    // Puedes agregar aquí algún mensaje de éxito si lo deseas
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error:', textStatus);
                    console.log('Error detail:', errorThrown);
                }
            });
        });

        $('.participante-select').on('change', function() {
            var scrollPosition = $(window).scrollTop();
            var member_DNI = $(this).val();
            var newStatus = $(this).prop('checked');
            var selectedTrainingId = $("#training_id").val();


            var updateUrl = "{{ route('TeamStaff.store') }}";
            // Realizar una solicitud AJAX para actualizar el estado
            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    member_DNI: member_DNI,
                    newStatus: newStatus,
                    trainingId: selectedTrainingId,
                    programId: 2,
                    team: 'participant'
                },
                success: function(response) {
                    console.log(response)
                    $(window).scrollTop(scrollPosition);
                    var url = '/TeamStaff?training_id=' + response;
                    window.location.href = url;
                    // Puedes agregar aquí algún mensaje de éxito si lo deseas
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error:', textStatus);
                    console.log('Error detail:', errorThrown);
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function() {

        var trainingSelect = document.getElementById("training_id");

        trainingSelect.addEventListener("change", function() {
            redirectToController();
        });

        function redirectToController() {
            var trainingId = trainingSelect.value;

            if (trainingId) {
                var url = '/TeamStaff?training_id=' + trainingId;
                window.location.href = url;
            }
        }

        // Restaurar valores seleccionados después de cargar la página
        var savedTrainingId = "{{ request('training_id') }}";

        if (savedTrainingId) {
            trainingSelect.value = savedTrainingId;
        }
    });


    // Agregar un evento 'scroll' al objeto window
    window.addEventListener('scroll', function() {
        // Almacenar la posición actual en el almacenamiento local
        localStorage.setItem('scrollPosition', window.scrollY.toString());
    });

    // Verificar si hay una posición almacenada en el almacenamiento local
    var scrollPosition = localStorage.getItem('scrollPosition');

    if (scrollPosition) {
        // Si hay una posición almacenada, desplázate a esa posición al cargar la página
        window.scrollTo(0, parseInt(scrollPosition));
    }
</script>
