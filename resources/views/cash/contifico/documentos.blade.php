<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Documentos')
        </h2>
    </x-slot>
    <style>
        .form-label {
            margin-bottom: 1px;
            /* Ajusta el espacio vertical aquí */
            margin-top: 4px;
            font-size: 0.8rem;
        }
        .bg-app{
            background-color: #085985;
        }
        .btnEditar,
        .btnEditar:hover,
        .btnEditar:focus {
            color:#085985;
            background-color: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            transition: transform 0.2s;
        }
        
        .btnEditar:hover {
          transform: scale(1.1); /* Cambia el tamaño del botón al 110% en el hover */
        }
        
        .btnPaperplane {
            font-size: 1rem;
            text-decoration:none;
            margin: 2px;
            color: #1D4ED8;
        }
        
        .btnPaperplane:hover {
            font-size: 1.3rem;
        }
      
    
    </style>

    <div class="{{ Config::get('style.containerIndex') }}" style="height: 88vh">
        <div class="container-fluid">
            @if (Session::has('success'))
                <div id="successAlert" class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            
            @if (Session::has('error'))
                <div id="errorAlert" class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            
            <script>
                // Función para ocultar automáticamente el mensaje después de 5 segundos
                setTimeout(function() {
                    $('#successAlert').fadeOut('slow');
                    $('#errorAlert').fadeOut('slow');
                }, 5000); // 5000 milisegundos = 5 segundos
            </script>
           
            <div class="d-flex justify-content-between p-3">
                <label class="form-label" style="font-size:15px; color:#085985 ">FACTURACIÓN CONTÍFICO</label>
                <input type="text" name="buscar" id = "buscar" class="{{ Config::get('style.cajaBusqueda') }}"
                        style="width:30%"
                        placeholder="Busca cliente..." 
                        value=" {{ old('buscar', $buscar) }}"
                        onkeyup="submitData()" />
                <span>
                    <input type="checkbox" id="errores" name="errores" @if($errores == 'SI') checked @endif />
                    <label for="checkbox" style="color:red">Errores</label>
                </span>
                    
                <button class="btn text-white" onclick="procesarFilasTabla()"
                        style="background-color: #0284C7; font-family:arial">
                    <i class="icon-paperplane"></i> Enviar todos los documentos a Contifico 
                </button>
            </div>
            
            
            <div id="conResultados">
                <table id="tablaDatos" class="table table-sm ">
                    <thead class="table-primary table-sm" style="background-color:#085985; color:white; font-size: 0.7rem">
                        <tr style="border: 1px solid #085985;">
                            <td class="text-center align-middle">No.</td>
                            <td class="text-center align-middle">Acción</td>
                            <td class="text-center align-middle">Doc. Id</td>
                            <td class="text-center align-middle">Fecha de Emisión</td>
                            <td class="text-center align-middle">Documento</td>
                            <td class="text-center align-middle">Cédula RUC</td>
                            <td class="text-center align-middle">Razón Social</td>
                            <td class="text-center align-middle">Dirección</td>
                            <td class="text-center align-middle">Correo</td>
                            <td class="text-center align-middle">Descripción</td>
                            <td class="text-center align-middle">Sub Total</td>
                            <td class="text-center align-middle">IVA</td>
                            <td class="text-center align-middle">Total</td>
                            <td class="text-center align-middle">Participante</td>
                            <td class="text-center align-middle">Estado</td>
                            <td class="text-center align-middle">Comentario</td>
                        </tr>   
                    </thead>
                    <tbody class="table-info table-sm" >
                        @foreach ($documentos as $the_documento)
                        <tr style="font-size: 0.6rem" id="fila_{{ $the_documento->secuencial }}" data-id-secuencial="{{ $the_documento->id }},{{ $the_documento->secuencial }}" class="border-b border-gray-100" style="height:40px">
                            <td class="text-center">
                                {{ $the_documento->secuencial }}
                            </td>
                            <td class="text-center align-middle ">
                                <div class="d-flex" style="width:100px">
                                    <a style="margin:3px; width:30px; text-decoration:none" title="Ver pagos" href="#" onclick="toggleDetalle('{{ $the_documento->secuencial }}')">
                                        <span class="icon-coin-dollar btnPaperplane"></span>
                                    </a>
                                    <img id="loading_{{ $the_documento->secuencial }}" src="{{ url('images/loading-gif-png-4.gif') }}" style="display: none; width:30px" alt="Cargando...">
                                    @if($the_documento->estado_json == 'CON ERROR')
                                    <!--
                                        <a style="margin:3px; width:30px; text-decoration:none" onclick="regenerarRegistro('{{ $the_documento->id }}')" title="Regenerar Documento" href="">
                                            <span class="icon-refresh btnPaperplane" style="color:green"></span>
                                        </a>
                                    -->
                                        <button type="button"  
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" 
                                                data-bs-whatever="{{ $the_documento->names_razon_social }}"
                                                data-bs-param1="{{ $the_documento->id }}"
                                                data-bs-param2="{{ $the_documento->secuencial }}"
                                                data-bs-param3="{{ $the_documento->comentario }}"
                                                class="{{ Config::get('style.btnEdit') }} " 
                                                id="edit_comment_button"
                                                title="Registro Manual">
                                                <i class="icon-pencil"></i>
                                        </button>
                                    @else
                                        <a style="margin:3px; width:30px; text-decoration:none" id="ver_{{ $the_documento->secuencial }}" onclick="enviarRegistro('{{ $the_documento->id }},{{ $the_documento->secuencial }}')" title="Enviar a Contifico" href="#">
                                            <span class="icon-paperplane btnPaperplane"></span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $the_documento->id }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->fecha_emision }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->documento }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->cliente_id }}
                            </td>
                            <td class="text-center" style="font-size:0.6rem">
                                {{ $the_documento->names_razon_social }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->address }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->email }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->descripcion }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->subtotal_iva }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->iva }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->total }}
                            </td>
                            <td class="text-center">
                                {{ $the_documento->names_surnames }}
                            </td>
                            <td class="text-center estado-column">
                                {{ $the_documento->estado_json }}
                            </td>
                            <td class="text-center comentario-column">
                                @php
                                    $estados = explode('|', $the_documento->comentario);
                                @endphp
                                
                                @foreach ($estados as $estado)
                                    {{ $estado }}<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr id="detalle_{{ $the_documento->secuencial }}" class="detalle" style="background-color:#f7f7f7; display: none;">
                            <td colspan="16">
                                <table  class="min-w-full divide-y divide-gray-200">
    
                                    <thead class="bg-sky-800">
                                        <tr>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Payment Date')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Program')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Payment Record')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Payment Method')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Authorization number')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Card')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Plazos')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Amount')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Factura')
                                            </th>
                                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                                @lang('Comment')
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-gray-100">
                                        @foreach ($the_documento->pagos  as $payments)
                                            <tr class="border-b border-yellow-200">
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->payment_date }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->program }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->payment_record }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->payment_method }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->authorization_number }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->card }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->tipo_pago }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->amount }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->names_razon_social }}
                                                </td>
                                                <td class="{{ Config::get('style.rowInt') }}">
                                                    {{ $payments->comment }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                    {{ $documentos->links() }}
                </div>
            </div>
            
            <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
            </div>
            
            
    
            <!-- Enlace al archivo JavaScript de Bootstrap solo para el modal -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titulo">Nuevo mensaje</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="registro" method="GET"
                                  action="#">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="documento_id" name="documento_id" >
                                    <input type="hidden" class="form-control" id="documento_secuencial" name="documento_secuencial" >
                                </div>
                                <table>
                                    <tr>
                                        <th rowspan="2" style="color: red; padding-right: 5px; vertical-align:top">Nota:</th>
                                        <td>
                                            Ingresa el Número de documento <b style="color: red;">SIN ERRORES</b>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Una vez hecho el registro, éste no podrá ser modificado.
                                        </td>
                                    </tr>
                                </table>
                                <div class="mb-3">
                                    <label for="comment" class="col-form-label"><b>Número de documento:</b></label>
                                    <input type="text" class="form-control form-control" id="comment" name="comment"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer flex justify-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: .8rem">Cerrar</button>
                            <button type="button" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Script de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            var jq3_6 = jQuery.noConflict(true);
        </script>
        
        <script>
            window.onload = function() {
                ocultarFilas();
            };
            
            // Supongamos que tienes un campo de texto con id "miInput"
            let input = document.getElementById('buscar');
            
            // Obtienes el valor actual del campo
            let valor = input.value;
            
            // Aplicas trim() para eliminar espacios al inicio y al final
            let valorSinEspacios = valor.trim();
            
            // Asignas el valor limpio de vuelta al campo de texto
            input.value = valorSinEspacios;
            
            function ocultarFilas(){
                var detalles = document.querySelectorAll('.detalle');
                detalles.forEach(function(detalle) {
                    detalle.style.display = 'none';
                });
            }
        
            function toggleDetalle(secuencial) {
                var detalle = document.getElementById('detalle_' + secuencial);
                if (detalle) {
                    var display = detalle.style.display;
                    ocultarFilas();
                    if (display === 'none' || display === '') {
                        detalle.style.display = 'table-row';
                    } else {
                        detalle.style.display = 'none';
                    }
                } else {
                    console.error('El elemento con el ID detalle_' + secuencial + ' no se encontró en el DOM.');
                }
            }
            
            var checkbox = document.getElementById('errores');

            // Agregar un event listener para el evento change
            checkbox.addEventListener('change', function() {
                submitData();
            });
            
            function submitData() {
                var buscar = $('#buscar').val();//.replace(/ /g, '%') || "%";
                var checkbox = document.getElementById('errores');
                var errores = 'NO';

                // Verificar si está marcado
                if (checkbox.checked) {
                    errores = 'SI';
                } 
                
                $.ajax({
                    url: "{{ route('ContificoD.Documentos') }}",
                    method: "GET",
                    data: {
                        buscar: buscar,
                        errores: errores,
                    },
                    success: function(response) {
                        console.log(response)
                        var $response = $(response);
                        var $tablaDatos = $response.find('#tablaDatos');
                        var $pagina = $response.find('#pagina');
            
                        if ($tablaDatos.length > 0) {
                            $('#conResultados').show();
                            $('#sinResultados').hide();
            
                            if ($tablaDatos.find('tbody tr').length > 0) {
                                $('#tablaDatos').replaceWith($tablaDatos);
                                $('#pagina').replaceWith($pagina);
                                $('#search_participant').focus();
                            } else {
                                $('#conResultados').hide();
                                $('#sinResultados').show().html('No hay resultados para "' + buscar + '"');
                            }
                        } else {
                            $('#conResultados').hide();
                            $('#sinResultados').show().html('No se encuentra la tabla de datos en la respuesta.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

        </script>

        
    <script>
        $(document).ready(function() {
            var exampleModal = document.getElementById('exampleModal');
            var titulo = document.getElementById('titulo');
            var documento_id = document.getElementById('documento_id');
            var document_secuencial = document.getElementById('document_secuencial');
            var document_comment = document.getElementById('comment');
            
            
    
            exampleModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                var cliente = button.getAttribute('data-bs-whatever');
                var documentId = button.getAttribute('data-bs-param1');
                var secuencial = button.getAttribute('data-bs-param2');
                var comment = button.getAttribute('data-bs-param3');
                
                var commentario = '';
            
                if (comment.includes('|')) {
                    var partes = comment.split('|'); // Separar el texto en un array usando '|'
                    commentario = partes[0]; // Tomar la primera posición del array
                } 
                
                var modalTitle = exampleModal.querySelector('.modal-title');
    
                modalTitle.innerHTML = '';
    
                // Creamos el texto con el salto de línea usando insertAdjacentHTML
                modalTitle.insertAdjacentHTML('beforeend', 'Cliente:<br><b>' + cliente + '</b>');
    
                // Update modal inputs with extracted values
                titulo.value = cliente;
                documento_id.value = documentId;
                documento_secuencial.value = secuencial;
                document_comment.value = commentario;
            });
    
            exampleModal.querySelector('.btn-primary').addEventListener('click', function () {
                registroManual();
                location.reload();
            });
        });
        
        function regenerarRegistro(id)
        {
            actualizar(id);
            location.reload();
        }
        
        function actualizar(id)
        {
             $.ajax({
                url: '/regenera_documento',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    documento_id: id,
                },
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                    console.error('Error en la solicitud AJAX:', error);
                    alert('Hubo un problema al actualizar el documento. Por favor, intenta de nuevo.');
                }
            });
        }
        
        function registroManual() {
            var documento_id = document.getElementById('documento_id').value;
            var documento_secuencial = document.getElementById('documento_secuencial').value;
            var document_comment = document.getElementById('comment').value;
            
            if (document_comment.trim() === "") {
                alert("Ingresa No. Factura.");
                return;
            }
            
            $('#loading_' + documento_secuencial).show();
            $('#ver_' + documento_secuencial).hide();
            
            $.ajax({
                url: '/actualiza_documento',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    documento_secuencial: documento_secuencial,
                    documento_id: documento_id,
                    comment: document_comment,
                },
                success: function(response) {
                    document.getElementById('comment').value = ''; 
                    $('#exampleModal').modal('hide');  // Cerrar el modal después de guardar exitosamente
                    
                    // Recargar la página después de guardar los datos
                    
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                    console.error('Error en la solicitud AJAX:', error);
                    alert('Hubo un problema al actualizar el documento. Por favor, intenta de nuevo.');
                }
            });
        }

        
        
    </script>


        <script>
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
                    var valores = params.split(',');
                
                    var id = valores[0];
                    var secuencial = valores[1];
                    // Mostrar gif de carga
                    $('#loading_' + secuencial).show();
                    $('#ver_' + secuencial).hide();
                
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '/envia_documento',
                        method: 'GET',
                        data: { id: id, secuencial:secuencial },
                        success: function(response) {
                            
                            $('#fila_' + secuencial + ' .estado-column').text(response.estado);
    
                            // Actualizar el comentario en la fila
                            $('#fila_' + secuencial + ' .comentario-column').text(response.comentario);
                        
                            // Ocultar gif de carga
                            $('#loading_' + secuencial).hide();
                            $('#ver_' + secuencial).show();
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Manejar errores si es necesario
                        }
                    });
                }
                    
            }            
            
            
        </script>
</x-app-layout>