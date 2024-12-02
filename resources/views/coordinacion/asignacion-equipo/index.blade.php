<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Asignaciones Equipos')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
        }
    </style>

    <header style="margin:0px; padding:0px">
         <div class="flex flex-col w-full">
            <div class="flex space-x-1 bg-gray-200 rounded-t-lg p-0" style="cursor:pointer">
                <label class="tab-button w-full py-2 text-left text-white rounded-t-lg focus:outline-none"
                    style="font-weight:bold; color:#0284c7; background-color:#FFF; border:1px solid #0284c7; border-bottom:0px">
                    <center>Asignaciones Equipo</center>
                </label>
                <a class="tab-button w-full py-2 text-left text-gray-700 bg-gray-200 rounded-t-lg focus:outline-none" 
                    style="color:#0284c7; background-color:#FFF; border:1px solid #0284c7"
                    href="{{ route('Asignaciones.index') }}">
                    <center>Mantenimiento de asignaciones</center>
                </a>
            </div>
        </div>
    </header>
    
    <div class="{{ Config::get('style.containerIndex') }} py-4" style="border:1px solid #0284c7; border-top:0px;">
        <button id="openModalCreate" class="{{ Config::get('style.btnSave') }}">Nueva Asignación</button>
    
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 flex items-center justify-center z-50 hidden ">
            <div class="bg-white rounded shadow-lg p-8" 
                 style="margin:auto; background-color: #f2f9fc; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2), 0px 6px 6px rgba(0, 0, 0, 0.15);">
                <h2 id="titulo" class="text-xl font-semibold mb-4">Nueva Asignación</h2>
                <form id="formCrear">
                    @csrf
                    <input name="id" type="hidden" value="0" id="inputId">
                    @include('coordinacion/asignacion-equipo.form-fields')
                    <div class="flex items-center justify-between mt-4">
                        <button id="submitCreate" class="{{ Config::get('style.btnSave') }}" form="formCrear" type="submit">Crear</button>
                        <button type="button" id="closeModalCreate" class="mt-4 text-red-600">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="flex flex-col mt-6 mb-8">
            @if (isset($asignacionEquipo) && count($asignacionEquipo) > 0)
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                @auth
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:20px; background-color:orange">Editar</th>
                                @endauth
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Equipo')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Para')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Tipo Asignación')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Asignación')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Desde')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Hasta')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($asignacionEquipo as $theasignacion)
                                <tr class="border-b border-gray-200">
                                    @auth
                                        <td class="{{ Config::get('style.rowCenter') }} py-1 " style="width:20px">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                               onclick="editar(event, {{ $theasignacion->id }}, '{{ $theasignacion->training_id }}', '{{ $theasignacion->asignacion_id }}', '{{ $theasignacion->para }}', '{{ $theasignacion->desde }}', '{{ $theasignacion->hasta }}')" href="#">
                                                <span
                                                    class="icon-edit text-green-900 hover:bg-orange-500 hover:text-white font-mono text-xl"></span>
                                            </a>
                                        </td>
                                    @endauth
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theasignacion->equipo }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}"  style="width:50px">
                                        {{ $theasignacion->para }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="width:50px">
                                        {{ $theasignacion->tipo }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theasignacion->nombre }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}"  style="width:50px">
                                        {{ $theasignacion->desde }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}"  style="width:50px">
                                        {{ $theasignacion->hasta }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
            @endif
            <div id="loading" class="absolute flex items-center justify-center w-full h-full z-50 hidden" style="background: rgba(255, 255, 255, 0.8);">
                <div class="text-xl font-semibold text-gray-700">Cargando...</div>
            </div>
        </div>
        
    </div>
    
    <link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalCreateButton = document.getElementById('openModalCreate');
            const closeModalCreateButton = document.getElementById('closeModalCreate');
            const modalCreate = document.getElementById('modalCreate');
            const loadingIndicator = document.getElementById('loading');
            const inputId = document.getElementById('inputId');
            const titulo = document.getElementById('titulo');
            const submitButton = document.getElementById('submitCreate');
            
            openModalCreateButton.addEventListener('click', () => {
                modalCreate.classList.remove('hidden');
                inputId.value = 0;
                titulo.textContent = "Crear Asignación";
                submitButton.textContent = "Crear";
            });

            closeModalCreateButton.addEventListener('click', () => {
                closeModalCreate();
            });

            document.getElementById('formCrear').addEventListener('submit', async function(e) {
                e.preventDefault();
                showLoading();
                
                const formData = new FormData(this);
                try {
                    const response = await fetch("{{ route('AsignacionEquipo.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    console.log(1);
                    
                    if (response.ok) {
                        const data = await response.json();
                        alertify.success(data.message);
                        closeModalCreate();
                        recargarDatos();
                    } else {
                        const errorData = await response.json();
                        alertify.error(errorData.message);
                    }
                } catch (error) {
                    alertify.error('Error en la solicitud');
                } finally {
                    hideLoading();
                }
            });

            window.editar = function(event, id, training_id, asignacion_id, para, desde, hasta) {
                event.preventDefault();
                modalCreate.classList.remove('hidden');
                inputId.value = id;
                titulo.textContent = "Actualizar Asignación";
                submitButton.textContent = "Actualizar";
    
                document.getElementById('training_id').value = training_id;
                document.getElementById('asignacion_id').value = asignacion_id;
                document.getElementById('para').value = para;
                document.getElementById('desde').value = desde;
                document.getElementById('hasta').value = hasta;
            };
            
            async function recargarDatos() {
                try {
                    const response = await fetch("{{ route('Recarga.equipo') }}");
                    if (!response.ok) {
                        throw new Error('Error en la carga de datos');
                    }
                    const data = await response.json();
            
                    const tbody = document.querySelector('#tablaDatos tbody');
                    tbody.innerHTML = '';
            
                    data.forEach(asignacion => {
                        const row = `
                            <tr class="border-b border-gray-200">
                                @auth
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}} py-1 " style="width:20px">
                                    <a class="${{!! json_encode(Config::get('style.btnEdit')) !!}}"
                                       onclick="editar(event, ${asignacion.id}, '${asignacion.training_id}', '${asignacion.asignacion_id}', '${asignacion.para}', '${asignacion.desde}', '${asignacion.hasta}')" href="#">
                                        <span class="icon-edit text-green-900 hover:bg-orange-500 hover:text-white font-mono text-xl"></span>
                                    </a>
                                </td>
                                @endauth
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}">${asignacion.equipo}</td>
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}" style="width:50px">${asignacion.para}</td>
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}" style="width:50px">${asignacion.tipo}</td>
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}">${asignacion.nombre}</td>
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}" style="width:50px">${asignacion.desde}</td>
                                <td class="${{!! json_encode(Config::get('style.rowCenter')) !!}}" style="width:50px">${asignacion.hasta}</td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                } catch (error) {
                    alert('Error al cargar los datos, verifica la consola para más detalles.');
                }
            }

            function showLoading() {
                loadingIndicator.classList.remove('hidden');
            }

            function hideLoading() {
                loadingIndicator.classList.add('hidden');
            }

            function closeModalCreate() {
                modalCreate.classList.add('hidden');
                document.getElementById('formCrear').reset();
            }
        });
    </script>
</x-app-layout>
