<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Mis Calendarios') }}
        </h2>
    </x-slot>
    
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
        .focus-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
        .scroll-container{
            height: 70vh;
            overflow-y: auto;
        }
    </style>
    
    <div class="flex flex-wrap justify-between">
        <div class=" p-1">
            @if (isset($campus) && count($campus) > 0)
                <form id="campus_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Calendar.obtenerEntrenamiento') }}">
                    @csrf
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="campus_id"
                        id="campus_id" required>
                        <option value="">--Seleccione la Sede--</option>
                        @foreach ($campus as $id => $name)
                            <option value="{{ $id }}"
                                @if ($id == old('campus_id', $campusId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
            </div>
            <div class="p-1">
        @if (isset($training) && count($training) > 0)
                <form id="training_form" method="POST" class="flex items-center space-x-2"
                    action="{{ route('Calendar.getCalendar') }}">
                    @csrf
                    <input type="hidden" id="campus" name="campus_id" />
                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select m-4" name="training_id"
                        id="training_id" >
                        <option value="">--Seleccione el Entrenamiento--</option>
                        @foreach ($training as $id => $name)
                            <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="p-1">
                <button type="button" 
                        onclick="guardarActividades()"  
                        class="{{ Config::get('style.btnSave') }} m-4">
                    Registrar
                </button>
            </div>
        @endif
            
    </div>
    
    @if (isset($training) && count($training) > 0)
        
        <div class="py-2">
            <div class="max-w-8xl mx-auto px-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900 dark:text-gray-100  scroll-container">
                		<table id="tablaActividades" class="min-w-full divide-y divide-gray-200">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }} py-2">ACTIVIDAD</th>
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }} py-2">FECHA INICIO</th>
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }} py-2">DÍAS</th>
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }} py-2">DESDE</th>
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }} py-2">HORAS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100" style="font-size:1rem">
                                <tr class="border-b border-gray-200">
                                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }} bg-sky-800 actividad">* 1FDS (se requiere de todo el fin de semana para el entrenamiento)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio text-white bg-sky-800" value="{{ isset($actividades[0]->start_date) ? $actividades[0]->start_date : '' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias text-white bg-sky-800" value="{{ isset($actividades[0]->days) ? $actividades[0]->days : '3' }}" style="width: 4rem" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio text-white bg-sky-800" value="{{ isset($actividades[0]->start_hour) ? $actividades[0]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas text-white bg-sky-800" value="{{ isset($actividades[0]->hours) ? $actividades[0]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                
                                <tr class="border-b border-gray-200">
                                    @if (isset($campusId))
                                   
                                        @if($campusId == "3")
                                            <th class="{{ Config::get('style.rowLeft') }} actividad ">Entrega de promesas formal al correo: fylcoordinacioncue@gmail.com</th>
                                        @else
                                            <th class="{{ Config::get('style.rowLeft') }} actividad ">Entrega de promesas formal al correo: fylcoordinacionuio@gmail.com</th>
                                        @endif
                                    @endif
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[1]->start_date) ? $actividades[1]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[1]->days) ? $actividades[1]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[1]->start_hour) ? $actividades[1]->start_hour : '23:59' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[1]->hours) ? $actividades[1]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad ">Reunión con coordinación de Life (vía zoom)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[2]->start_date) ? $actividades[2]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[2]->days) ? $actividades[2]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[2]->start_hour) ? $actividades[2]->start_hour : '19:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[2]->hours) ? $actividades[2]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad ">Entrega de Directorio. En formato digital y formato físico</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[3]->start_date) ? $actividades[3]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[3]->days) ? $actividades[3]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[3]->start_hour) ? $actividades[3]->start_hour : '15:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[3]->hours) ? $actividades[3]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Actividad CONFIANZA, Revisión de Promesas, Toma de foto inicial y Línea de abrazos</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[4]->start_date) ? $actividades[4]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[4]->days) ? $actividades[4]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[4]->start_hour) ? $actividades[4]->start_hour : '15:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[4]->hours) ? $actividades[4]->hours : '6' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Paso de antorcha y Marcha de legendarios</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[5]->start_date) ? $actividades[5]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[5]->days) ? $actividades[5]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[5]->start_hour) ? $actividades[5]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[5]->hours) ? $actividades[5]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Actividad TANQUE, Revisión de promesas, Vuelos</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[6]->start_date) ? $actividades[6]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[6]->days) ? $actividades[6]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[6]->start_hour) ? $actividades[6]->start_hour : '15:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[6]->hours) ? $actividades[6]->hours : '6' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }} actividad bg-sky-800">* 2FDS (se requiere de todo el fin de semana para el entrenamiento)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio text-white bg-sky-800" value="{{ isset($actividades[7]->start_date) ? $actividades[7]->start_date : '' }}"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias text-white bg-sky-800" value="{{ isset($actividades[7]->days) ? $actividades[7]->days : '3' }}" style="width: 4rem" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio text-white bg-sky-800" value="{{ isset($actividades[7]->start_hour) ? $actividades[7]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas text-white bg-sky-800" value="{{ isset($actividades[7]->hours) ? $actividades[7]->hours : '0' }}" style="width: 4rem" ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Susurros</td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[8]->start_date) ? $actividades[8]->start_date : '' }}"></th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[8]->days) ? $actividades[8]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[8]->start_hour) ? $actividades[8]->start_hour : '20:30' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[8]->hours) ? $actividades[8]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Seguimiento de promesas y Línea de abrazos</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[9]->start_date) ? $actividades[9]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[9]->days) ? $actividades[9]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[9]->start_hour) ? $actividades[9]->start_hour : '17:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[9]->hours) ? $actividades[9]->hours : '5' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Marcha de legendarios</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[10]->start_date) ? $actividades[10]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[10]->days) ? $actividades[10]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[10]->start_hour) ? $actividades[10]->start_hour : '19:15' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[10]->hours) ? $actividades[10]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Actividad ROMPIMIENTO DE BARRERAS, Seguimiento de Promesas, Vuelos</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[11]->start_date) ? $actividades[11]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[11]->days) ? $actividades[11]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[11]->start_hour) ? $actividades[11]->start_hour : '15:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[11]->hours) ? $actividades[11]->hours : '8' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }} actividad bg-sky-800">* 3FDS (se requiere de todo el fin de semana para el entrenamiento)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio text-white bg-sky-800" value="{{ isset($actividades[12]->start_date) ? $actividades[12]->start_date : '' }}"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias text-white bg-sky-800" value="{{ isset($actividades[12]->days) ? $actividades[12]->days : '3' }}" style="width: 4rem" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio text-white bg-sky-800" value="{{ isset($actividades[12]->start_hour) ? $actividades[12]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas text-white bg-sky-800" value="{{ isset($actividades[12]->hours) ? $actividades[12]->hours : '0' }}" style="width: 4rem" ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Mezcla Intimar y Susurros</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[13]->start_date) ? $actividades[13]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[13]->days) ? $actividades[13]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[13]->start_hour) ? $actividades[13]->start_hour : '20:30' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[13]->hours) ? $actividades[13]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Revisión de promesas final, indicaciones para 4 FDS (vía zoom)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[14]->start_date) ? $actividades[14]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[14]->days) ? $actividades[14]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[14]->start_hour) ? $actividades[14]->start_hour : '19:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[14]->hours) ? $actividades[14]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }} actividad bg-sky-800">* 4FDS (Bajo invitación, se requiere de todo el fin de semana para el entrenamiento)</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio text-white bg-sky-800" value="{{ isset($actividades[15]->start_date) ? $actividades[15]->start_date : '' }}"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias text-white bg-sky-800" value="{{ isset($actividades[15]->days) ? $actividades[15]->days : '1' }}" style="width: 4rem" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio text-white bg-sky-800" value="{{ isset($actividades[15]->start_hour) ? $actividades[15]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas text-white bg-sky-800" value="{{ isset($actividades[15]->hours) ? $actividades[15]->hours : '0' }}" style="width: 4rem" ></td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <th class="{{ Config::get('style.rowLeft') }} actividad">Entrega de la foto oficial con los integrantes graduados</th>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="date" class="fechaInicio" value="{{ isset($actividades[16]->start_date) ? $actividades[16]->start_date : '' }}"></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="dias" value="{{ isset($actividades[16]->days) ? $actividades[16]->days : '1' }}" style="width: 4rem"  ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="time" class="horaInicio" value="{{ isset($actividades[16]->start_hour) ? $actividades[16]->start_hour : '18:00' }}" ></td>
                                    <td class="{{ Config::get('style.rowCenter') }}"><input type="number" class="horas" value="{{ isset($actividades[16]->hours) ? $actividades[16]->hours : '0' }}" style="width: 4rem"  ></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    
    function guardarActividades() {
        var datosActividades = [];
        var camposValidos = true;
        var trainingId = document.getElementById('training_id').value;
    
        $('#tablaActividades tbody tr').each(function(index) {
            var actividad = $(this).find('.actividad').text().trim();
            var fechaInicio = $(this).find('.fechaInicio').val();
            var dias = $(this).find('.dias').val();
            var horaInicio = $(this).find('.horaInicio').val();
            var duracion = $(this).find('.horas').val();
    
            if (trainingId === '' || actividad === '' || fechaInicio === '' || dias === '' || horaInicio === '' || duracion === '') {
                camposValidos = false;
                alert('Por favor, complete todos los campos antes de guardar.');
                return false;
            }
    
            var actividadData = {
                orden: index + 1, // Añadir un índice secuencial (empezando en 1)
                training_id: trainingId,
                actividad: actividad,
                fecha_inicio: fechaInicio,
                dias: dias,
                hora_inicio: horaInicio,
                duracion: duracion
            };
    
            datosActividades.push(actividadData);
        });
    
        if (!camposValidos) {
            return;
        }
    
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        $.ajax({
            url: '{{ route("Calendar.save") }}', // Usamos la ruta nombrada en Blade
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                actividades: JSON.stringify(datosActividades)
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                alert('Actividades guardadas exitosamente.');
                // Aquí puedes manejar la respuesta del servidor si es necesario
            },
            error: function(xhr, status, error) {
                console.error('Error al guardar actividades:', error);
                alert('Hubo un error al intentar guardar las actividades.');
                // Aquí puedes manejar errores en la petición AJAX
            }
        });
    }



    </script>
    
   
    <script>
    
        const selectCampus = document.getElementById('campus_id');
        const selectTraining = document.getElementById('training_id');

        selectCampus.addEventListener('change', function() {
            document.getElementById('campus_form').submit();
        });
        
        selectTraining.addEventListener('change', function() {
            $('#campus').val(selectCampus.value);
            document.getElementById('training_form').submit();
        });
        
        
        
    </script>

</x-app-layout>
