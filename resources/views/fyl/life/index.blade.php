<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    
        <div class="{{ Config::get('style.containerIndex') }}">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                    @if (isset($enrolados) && count($enrolados) > 0)
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="sticky top-0 bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        @lang('No.')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} ">
                                        @lang('Pago')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Nombre')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        <b>@lang('Identidad')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Phone')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                        <b>@lang('Training')</b>
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                        @lang('Asistencia')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($enrolados as $enrolado)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $enrolado->secuencial }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            @if($enrolado->boton == 'SI' && $enrolado->pasarela == 'SI')
                                                <img id="loading_{{ $enrolado->secuencial }}" src="{{ url('images/loading-gif-png-4.gif') }}" style="display: none; width:30px;" alt="Cargando...">
                                                <a style="margin:3px; width:30px; text-decoration:none" id="ver_{{ $enrolado->secuencial }}" onclick="enviarRegistro('{{ $enrolado->secuencial }},{{ $enrolado->hash }},{{ $enrolado->campus_id }}')" title="Obtener Link de Pago" href="#">
                                                    <span class="icon-paperplane btnPaperplane"></span>
                                                </a>
                                            @else
                                                {{ $enrolado->payment_status_focus }}
                                            @endif
                                        </td>
                                        <td class="{{ Config::get('style.rowLeftXs') }}">
                                            {{ $enrolado->surnames_names }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $enrolado->DNI }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $enrolado->phone }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ $enrolado->entrenamiento }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}" >
                                            {{ $enrolado->asisteFocus }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    </div>
                </main>
            </div>
        </div> 
</x-app-layout>
    
   
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    function prueba(){
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Enlace copiado al portapapeles",
          showConfirmButton: false,
        });
    }
        function procesarFilasTabla() {
                
            // Recorre todas las filas de la tabla
            $('tbody tr').each(function() {
                // Obtiene el valor del atributo data-id de la fila
                var idSecuencial = $(this).data('id-secuencial');
                
                enviarRegistro(idSecuencial);
                
                // Asigna un evento click al enlace de enviar
                $(this).find('.enviar-enlace').click(function() {
                    // Llama a la función enviarRegistro pasando el ID y el Secuencial
                    
                });
            });
        }
        
        function enviarRegistro(params) {
                if (typeof params === 'string' && params.includes(','))
                {
                    console.log(params);
                    var valores = params.split(',');
                
                    var secuencial = valores[0];
                    var id = valores[1];
                    var campus_id = valores[2];
                    
                    // Mostrar gif de carga
                    $('#loading_' + secuencial).show();
                    $('#ver_' + secuencial).hide();
                
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '/life-generate-link',
                        method: 'GET',
                        data: { secuencial: secuencial, 
                                id:id,
                                campus_id: campus_id
                        },
                        success: function(response) {
                            var url = response.data.url;
                            
                            copiaLink(url)
                            
                            // Ocultar gif de carga
                            $('#loading_' + secuencial).hide();
                            $('#ver_' + secuencial).show();
                        },
                        
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            var jsonResponse = xhr.responseText;

                            // Convertir el JSON en un objeto JavaScript
                            var responseObject = JSON.parse(jsonResponse);
                            
                            // Obtener el mensaje de error
                            var errorMessage = responseObject.error;
                            
                            // Mostrar el mensaje de error en la consola
                           
                            $('#loading_' + secuencial).hide();
                            $('#ver_' + secuencial).show();
                            
                            Swal.fire({
                              icon: "error",
                              title: "Oops...",
                              text: errorMessage,
                              footer: 'Focus Your Life'
                            });
                        }
                    });
                }
                    
            }            
    
        function copiaLink(link) {
            var textToCopy = link;
            var dummyInput = document.createElement("input");
            document.body.appendChild(dummyInput);
            dummyInput.setAttribute("value", textToCopy);
            dummyInput.select();
            document.execCommand("copy");
            setTimeout(function() {
                document.body.removeChild(dummyInput);
                Swal.fire("Enlace copiado al portapapeles");
                //alert('Enlace copiado al portapapeles');
            }, 100);
        }
    </script>
