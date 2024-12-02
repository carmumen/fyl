<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Asignaciones')
        </h2>
    </x-slot>
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <header style="margin:0px; padding:0px">
         <div class="flex flex-col w-full">
            <div class="flex space-x-1 bg-gray-200 rounded-t-lg p-0" style="cursor:pointer">
                <a class="tab-button w-full py-2 text-left text-white rounded-t-lg focus:outline-none"
                    style="color:#0284c7; background-color:#FFF; border:1px solid #0284c7"
                    href="{{ route('AsignacionEquipo.index') }}">
                    <center>Asignaciones Equipo</center>
                </a>
                <label class="tab-button w-full py-2 text-left text-gray-700 bg-gray-200 rounded-t-lg focus:outline-none" 
                    style="font-weight:bold; color:#0284c7; background-color:#FFF; border:1px solid #0284c7; border-bottom:0px">
                    <center>Mantenimiento de asignaciones</center>
                </label>
            </div>
        </div>
    </header>
    
    <div class="{{ Config::get('style.containerIndex') }} py-4" style="border:1px solid #0284c7; border-top:0px;">
        <button id="openModalCreate" class="{{ Config::get('style.btnSave') }}">Crear Asignación</button>
    
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 flex items-center justify-center z-50 hidden ">
            <div class="bg-white rounded shadow-lg p-8" 
                 style="margin:auto; background-color: #f2f9fc; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2), 0px 6px 6px rgba(0, 0, 0, 0.15);">
                <h2 id="titulo" class="text-xl font-semibold mb-4">Crear Asignación</h2>
                <form id="formCrear" >
                    @csrf
                    <input name="id" type="hidden" value="0" id="inputId">
                    @include('coordinacion/asignaciones.form-fields')
                    <div class="flex items-center justify-between mt-4">
                        <button id="submitCreate" class="{{ Config::get('style.btnSave') }}" form="formCrear" type="submit">Crear</button>
                        <button id="closeModalCreate" class="mt-4 text-red-600">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="flex flex-col mt-6 mb-8">
            @if (isset($asignaciones) && count($asignaciones) > 0)
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                @auth
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}" style="width:20px; background-color:orange">Editar</th>
                                @endauth
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Tipo')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Nombre')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Link')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:50px">
                                    @lang('Estado')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($asignaciones as $theasignacion)
                                <tr class="border-b border-gray-200">
                                    @auth
                                        <td class="{{ Config::get('style.rowCenter') }} py-1 " style="width:20px">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                               onclick="editar(event, {{ $theasignacion->id }}, '{{ $theasignacion->tipo }}', '{{ $theasignacion->nombre }}', '{{ $theasignacion->link_formulario }}', '{{ $theasignacion->estado }}')" href="">
                                                <span
                                                    class="icon-edit text-green-900 hover:bg-orange-500 hover:text-white font-mono text-xl" ></span>
                                            </a>
                                        </td>
                                    @endauth
                                    <td class="{{ Config::get('style.rowCenter') }}" style="width:50px">
                                        {{ $theasignacion->tipo }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theasignacion->nombre }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theasignacion->link_formulario }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}"  style="width:50px">
                                        {{ $theasignacion->estado }}
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
            // Botones y elementos de los modales
            const openModalCreateButton = document.getElementById('openModalCreate');
            const closeModalCreateButton = document.getElementById('closeModalCreate');
            const modalCreate = document.getElementById('modalCreate');
            const loadingIndicator = document.getElementById('loading');
            const inputId = document.getElementById('inputId');
            const titulo = document.getElementById('titulo');
            const submitButton = document.getElementById('submitCreate');
            
            // Función para cargar datos y actualizar la tabla
            

            // Mostrar y Ocultar Modales
            openModalCreateButton.addEventListener('click', () => {
                modalCreate.classList.remove('hidden');
                inputId.value = 0;
                titulo.textContent = "Crear Asignación";
                submitButton.textContent = "Crear";
            });
            closeModalCreateButton.addEventListener('click', () => modalCreate.classList.add('hidden'));

            // Enviar datos de creación por AJAX
            document.getElementById('formCrear').addEventListener('submit', async function(e) {
                e.preventDefault(); // Evita el envío del formulario
                showLoading();
                
                const formData = new FormData(this);
                try {
                    const response = await fetch("{{ route('Asignaciones.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (response.ok) {
                        const data = await response.json(); // Convierte la respuesta a JSON
                        alertify.success(data.message); // Muestra el mensaje de éxito recibido
                        closeModalCreate(); // Cierra el modal al completar la solicitud
                        recargarDatos();
                    } else {
                        const errorData = await response.json(); // Obtiene los errores del servidor
                        alertify.error(errorData.message);
                    }
                } catch (error) {
                    alertify.error('Error en la solicitud'); // Error en caso de fallo de red o similar
                } finally {
                    hideLoading(); // Oculta el cargador sin importar el resultado
                }
            });

            // Función para abrir el modal de edición
            window.editar = function(event, id, tipo, nombre, linkFormulario, estado) {
                event.preventDefault();
                modalCreate.classList.remove('hidden');
                inputId.value = id; // Establece el valor de id al abrir el modal de edición
                titulo.textContent = "Actualizar Asignación";
                submitButton.textContent = "Actualizar";
    
                // otorga el valor de la fila a los campos
                document.getElementById('tipo').value = tipo;
                document.getElementById('nombre').value = nombre;
                document.getElementById('link_formulario').value = linkFormulario;
                document.getElementById('estado').value = estado;
            };
            
            async function recargarDatos() {
            try {
                const response = await fetch("{{ route('Asignaciones.recarga') }}");
                if (!response.ok) {
                    throw new Error('Error en la carga de datos');
                }
                const data = await response.json(); // Obtener los datos JSON

                // Actualiza la tabla aquí
                const tbody = document.querySelector('#tablaDatos tbody');
                tbody.innerHTML = ''; // Limpia la tabla

                data.forEach(asignacion => {
                    const row = document.createElement('tr');
                    row.className = 'border-b border-gray-200';
                    row.innerHTML = `
                        @auth
                        <td class="{{ Config::get('style.rowCenter') }} py-1 " style="width:20px">
                            <a class="{{ Config::get('style.btnEdit') }}"
                               onclick="editar(event, ${asignacion.id}, '${asignacion.tipo}', '${asignacion.nombre}', '${asignacion.link_formulario}', '${asignacion.estado}')" href="#">
                                <span class="icon-edit text-green-900 hover:bg-orange-500 hover:text-white font-mono text-xl"></span>
                            </a>
                        </td>
                        @endauth
                        <td class="{{ Config::get('style.rowCenter') }}" style="width:50px">${asignacion.tipo}</td>
                        <td class="{{ Config::get('style.rowCenter') }}">${asignacion.nombre}</td>
                        <td class="{{ Config::get('style.rowCenter') }}">${asignacion.link_formulario}</td>
                        <td class="{{ Config::get('style.rowCenter') }}" style="width:50px">${asignacion.estado}</td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (error) {
                console.error('Error al cargar los datos:', error);
                alert('Error al cargar los datos, verifica la consola para más detalles.');
            }
        }

            

            // Funciones para mostrar y ocultar la indicación de cargando
            function showLoading() {
                loadingIndicator.classList.remove('hidden');
            }

            function hideLoading() {
                loadingIndicator.classList.add('hidden');
            }

            // Funciones para cerrar modales
            function closeModalCreate() {
                modalCreate.classList.add('hidden');
                document.getElementById('formCrear').reset(); // Limpiar formulario
            }
        });
        
        
    </script>



</x-app-layout>
