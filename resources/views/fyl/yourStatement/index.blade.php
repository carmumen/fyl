<x-app-layout>
    @php
        if (session('entidad') == 'LifeParticipants') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'LifeParticipants']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }

        textarea {
            width: 100%;
            height: 40px;
            padding: 10px;
            box-sizing: border-box;
            margin: 10px 0;
            resize: vertical;
            /* Permitir redimensionar verticalmente */
        }

    .popover {
        display: none;
        position: absolute;
        background-color: #fff; /* Fondo blanco no transparente */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-top: 2px; /* Espaciado para evitar superposición con el texto */
        width:400px;
        z-index:1000px;

    }

    .popover-trigger:hover .popover {
        display: block;
    }

    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Life Participants')
        </h2>
    </x-slot>



    <header>
        <div class="flex flex-wrap justify-between">
            <div class=" p-1">
                @if (isset($training) && count($training) > 0)
                    <form id="life" method="GET" class="flex items-center space-x-2"
                        action="{{ route('YourStatement.index') }}">
                        @csrf
                        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="training_id"
                            id="training_id" required>
                            @foreach ($training as $id => $name)
                                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                        <button class="icon-upload text-2xl text-sky-800 hover:underline" type="submit" form="life"
                            title="cargar"></button>
                    </form>
                @endif
            </div>

            <div class=" p-1">
            </div>
        </div>
        <div class="flex flex-wrap justify-between">
            @if (isset($yourParticipants) && count($yourParticipants) > 0)
                <form id="focus2" method="GET" class="flex items-center space-x-2"
                    action="{{ route('YourStatement.index') }}">
                    @csrf
                    <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                    
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="staff_DNI"
                        id="staff_DNI" required>
                        <option value="%">--Staff--</option>
                        @foreach ($staff as $id => $name)
                            <option value="{{ $id }}" @if ($id == old('staff_DNI', $staffDNI)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <div class=" p-1">
                    @if (isset($yourParticipants) && count($yourParticipants) > 0)
                        
                    @endif
                </div>
                <div></div>
            @endif
        </div>
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">

        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div class="overflow-x-auto">
                    <div id="conResultados">
                        @if (isset($yourParticipants) && count($yourParticipants) > 0)
                            <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                                <thead class="sticky top-0 bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerSequential') }}">
                                            @lang('No.')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Staff')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Participant')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Gafete')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Phone')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Enroller')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Enroller Phone')
                                        </th>

                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Attended')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Statement')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                            @lang('Estado Pago LIFE')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-100">
                                    @foreach ($yourParticipants as $theYourParticipants)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowSequential') }}">
                                                {{ $theYourParticipants->secuencial }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }}">
                                                {{ $theYourParticipants->staff }}
                                            </td>
                                            <td class="{{ Config::get('style.rowLeftXs') }} relative">
                                                <span class="popover-trigger">
                                                    {{ $theYourParticipants->participant }}
                                                    <div class="popover" style="z-index:1000">
                                                        <p>{!! '<b>'.'Enrolador '. '</b><br><ul><li>' .$theYourParticipants->team_enroller . '</li><li>' .$theYourParticipants->enroller . '</li><li>' . $theYourParticipants->enroller_phone.'</ul>' !!}</p>
                                                    </div>
                                                </span>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theYourParticipants->nickname }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theYourParticipants->phone }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theYourParticipants->enroller }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theYourParticipants->enroller_phone }}
                                            </td>

                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                {{ $theYourParticipants->sunday_attended }}
                                            </td>
                                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                                @if ($theYourParticipants->pago_anticipado != 1)
                                                <select class="statement-select  {{ Config::get('style.cajaTexto') }} px-1 py-0 text-xxs"
                                                    data-participant-id="{{ $theYourParticipants->id }}">
                                                    <option value="S/D"><b>S/D</b></option>
                                                    <option value="VIERNES"
                                                        @if ($theYourParticipants->statement == 'VIERNES') selected @endif>
                                                        <b>VIERNES</b>
                                                    </option>
                                                    <option value="SÁBADO"
                                                        @if ($theYourParticipants->statement == 'SÁBADO') selected @endif>
                                                        <b>SÁBADO</b>
                                                    </option>
                                                    <option value="DOMINGO"
                                                        @if ($theYourParticipants->statement == 'DOMINGO') selected @endif>
                                                        <b>DOMINGO</b>
                                                    </option>
                                                </select>
                                                @endif
                                            </td>
                                            
                                            @if ($theYourParticipants->payment_status_life == 'PAGO TOTAL')
                                                @if ($theYourParticipants->pagos == 'JORNADA')
                                                    <td class="{{ Config::get('style.rowCenterXs') }} py-2 bg-green-800 text-white" style="width:200px">
                                                @elseif ($theYourParticipants->pagos == 'ANTICIPADO' || $theYourParticipants->pagos == 'S/P')
                                                    <td class="{{ Config::get('style.rowCenterXs') }} py-2 text-black" style="width:200px; background-color:orange">
                                                @else
                                                    <td class="{{ Config::get('style.rowCenterXs') }} py-2" style="width:200px;">
                                                @endif
                                                <span
                                                    class="px-2 py-2 text-xs ">
                                                    {{ $theYourParticipants->pagos }}
                                                </span>
                                                </td>
                                            @else
                                                <td class="{{ Config::get('style.rowCenterXs') }} py-2" style="width:200px;">
                                                    {{ $theYourParticipants->pago_anticipado }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                {{-- {{ $yourParticipants->links() }} --}}
                            </div>
                        @endif
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textareaInputs = document.querySelectorAll('.mensaje-input');

            textareaInputs.forEach(function(textarea) {
                textarea.addEventListener('change', function() {
                    const registroId = textarea.getAttribute('data-registro-id');
                    const mensaje = textarea.value;

                    // Realizar la solicitud AJAX al servidor para guardar el mensaje
                    guardarEnBaseDeDatos(registroId, mensaje);
                });
            });

            function guardarEnBaseDeDatos(registroId, mensaje) {
                $.ajax({
                    url: '/save-comment-y/' + registroId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment: mensaje
                    },
                    success: function(response) {
                        console.log(response);

                    }
                });
            }
        });
    </script>



   <script>
    $(document).ready(function() {
        // Captura el estado original de cada select
        $('.statement-select').each(function() {
            $(this).data('original-status', $(this).val());
        });

        $('.statement-select').on('change', function() {
            
            var participantId = $(this).data('participant-id');
            var newStatus = $(this).val();
            var originalStatus = $(this).data('original-status');
            

            var trainingId = document.getElementById('training_id');
            var staffDNISelect = document.getElementById('staff_DNI');
            
            console.log(participantId)
            console.log(newStatus)
            console.log(originalStatus)
            

            // Realiza la solicitud AJAX original
            $.ajax({
                url: '/actualizar_estado_dy/' + participantId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus,
                    staff_DNI: staffDNISelect.value,
                    training_id: trainingId.value,
                },
                success: function(response) {
                    console.log(response);
                    // Utiliza la respuesta del servidor para actualizar los colores
                    color();
                    contar();
                    $('#meta').html(response['meta']);
                    $('#porcentaje_meta').html(response['porcentaje_meta']);
                }
            });
        });

        $('.contenedor-selectXXX').on('change', function() {
                var staffDNISelect = document.getElementById('staff_DNI');

                if (this.id == 'legendary_DNI') {
                    staffDNISelect.selectedIndex = 0;
                }

                document.getElementById('focus2').submit();
            });

        // Inicializa los colores
        color();

        // Función para actualizar colores
        function color(status) {
            $('.statement-select').each(function() {
                var statement = status || $(this).val();
                var colors = {
                    'VIERNES': 'white',
                    'SÁBADO': 'white',
                    'DOMINGO': 'black',
                    'S/D': 'black'
                };
                var bgcolors = {
                    'VIERNES': 'green',
                    'SÁBADO': 'orange',
                    'DOMINGO': 'red',
                    'S/D': 'transparent'
                };

                // Remueve las clases antiguas y agrega las nuevas
                $(this).removeClass().addClass('statement-select contenedor-select text-xxs');
                //$(this).addClass(bgcolors[statement]);
                $(this).css('color', colors[statement]);
                $(this).css('background-color', bgcolors[statement]);
            });
        }

        function contar() {
            var countsStatus = {
                'posibilidad': 0,
                'acuerdo': 0
            };

            $('#tablaDatos tbody tr').each(function() {
                var status = $(this).find('.attendance-select').val();
                // Asegurarse de que status no sea undefined

                status = status || '';

                // Convertir el status a minúsculas para hacer la comparación insensible a mayúsculas y minúsculas
                status = status.toLowerCase();

                // Verificar si el status es 'posibilidad' o 'acuerdo'
                if (status === 'posibilidad' || status === 'acuerdo') {
                    countsStatus[status]++;
                }
            });

            // Actualizar la vista con los conteos
            $('#posibility').html(countsStatus['posibilidad']);
            $('#agreement').html(countsStatus['acuerdo']);
        }
    });
</script>

</x-app-layout>
