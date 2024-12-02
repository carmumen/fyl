<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Producto')
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
            
            <div class="card mb-3">
                <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #085985;">
                    Mantenimiento de Productos
                </div>
                <div class="card-body p-4">
                    <form id="form_producto" method="POST" action="{{ route('Producto.store') }}">
                        @csrf
                        <div class="row d-flex align-items-stretch">
                            <!-- Fila 1 -->
                            <div class="col-md-2">
                                <!-- CODIGO -->
                                <div class="form-group-sm">
                                    <input type="hidden" 
                                            id="categoria_id" 
                                            name="categoria_id" 
                                            value="1"
                                            /> 
                                            
                                    <input type="hidden" 
                                            id="pos" 
                                            name="pos" 
                                            value="{{ old('pos', $producto ? $producto->pos : '') }}"
                                            /> 
                                            
                                    <label for="codigo" class="form-label">CÓDIGO:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="codigo" 
                                            name="codigo" 
                                            value="{{ old('codigo', $producto ? $producto->codigo : '') }}" 
                                             />
                                    @error('codigo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Nombre del Producto -->
                                <div class="form-group-sm">
                                    <label for="nombre_producto" class="form-label">Nombre:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="nombre_producto"
                                            name="nombre_producto" 
                                            value="{{ old('nombre_producto', $producto ? $producto->nombre_producto : '') }}" 
                                            required />
                                    @error('nombre_producto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Tipo -->
                                <div class="form-group-sm">
                                    <label for="tipo" class="form-label">Tipo:</label>
                                    <select class="form-control form-control-sm" 
                                            id="tipo"
                                            name="tipo"
                                            value="{{ old('tipo', $producto ? $producto->tipo : '') }}" >
                                        <option value="SERVICIO">SERVICIO</option>
                                        <option value="PRODUCTO">PRODUCTO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- PVP Manual -->
                                <div class="form-group-sm">
                                    <label for="tipo" class="form-label">PVP Manual:</label>
                                    <select class="form-control form-control-sm" 
                                            id="pvp_manual"
                                            name="pvp_manual"
                                            value="{{ old('pvp_manual', $producto ? $producto->pvp_manual : '') }}" >
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Paga Impuesto -->
                                <div class="form-group-sm">
                                    <label for="tipo" class="form-label">Paga Imp.:</label>
                                    <select class="form-control form-control-sm" 
                                            id="paga_impuesto"
                                            name="paga_impuesto"
                                            value="{{ old('paga_impuesto', $producto ? $producto->paga_impuesto : '') }}"  >
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- PVP 1 -->
                                <div class="form-group-sm">
                                    <label for="pvp1" class="form-label">PVP 1:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm inputDecimal" 
                                            id="pvp1" 
                                            name="pvp1" 
                                            value="{{ old('pvp1', $producto ? $producto->pvp1 : '') }}"  
                                            required />
                                    @error('pvp1')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- PVP 2 -->
                                <div class="form-group-sm">
                                    <label for="pvp2" class="form-label">PVP 2:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm inputDecimal" 
                                            id="pvp2" 
                                            name="pvp2" 
                                            value="{{ old('pvp2', $producto ? $producto->pvp2 : '') }}"  
                                            required />
                                    @error('pvp2')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- PVP 3 -->
                                <div class="form-group-sm">
                                    <label for="pvp3" class="form-label">PVP 3:</label>
                                    <input type="te3t" 
                                            class="form-control form-control-sm inputDecimal" 
                                            id="pvp3" 
                                            name="pvp3" 
                                            value="{{ old('pvp3', $producto ? $producto->pvp3 : '') }}"  
                                            required />
                                    @error('pvp3')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- PVP 4 -->
                                <div class="form-group-sm">
                                    <label for="pvp4" class="form-label">PVP 4:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm inputDecimal" 
                                            id="pvp4" 
                                            name="pvp4" 
                                            value="{{ old('pvp4', $producto ? $producto->pvp4 : '') }}"  
                                            required />
                                    @error('pvp4')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Porcentaje IVA -->
                                <div class="form-group-sm">
                                    <label for="porcentaje_iva" class="form-label">% IVA:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="porcentaje_iva" 
                                            name="porcentaje_iva"
                                            value="{{ old('porcentaje_iva', $producto ? $producto->porcentaje_iva : '') }}"  
                                            required />
                                    @error('porcentaje_iva')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Botón de Enviar -->
                        
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit"
                                    form="form_producto"
                                    class="btn text-white"  
                                    style="background-color: #0284C7;">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <label class="form-label text-secundary">LISTA DE PRODUCTOS</label>
            <table class="table table-sm ">
                <thead class="table-primary table-sm" style="background-color:#085985; color:white">
                    <tr style="border: 1px solid #085985;">
                        
                        <td class="text-center">Editar</td>
                        <td class="text-center">Código</td>
                        <td class="text-center">Nombre</td>
                        <td class="text-center">Tipo</td>
                        <td class="text-center">PVP Manual</td>
                        <td class="text-center">Paga Impuesto</td>
                        <td class="text-center">PVP 1</td>
                        <td class="text-center">PVP 2</td>
                        <td class="text-center">PVP 3</td>
                        <td class="text-center">PVP 4</td>
                        <td class="text-center">% IVA</td>
                        <td class="text-center">PU 1</td>
                        <td class="text-center">PU 2</td>
                        <td class="text-center">PU 3</td>
                        <td class="text-center">PU 4</td>
                        <td class="text-center" style="display:none"></td>
                    </tr>   
                </thead>
                <tbody class="table-info table-sm">
                    @foreach ($productos as $the_producto)
                    <tr class="border-b border-gray-200">
                        @auth
                            <td class="text-center">
                                <button class="btnEditar"><i class="fa-solid fa-pen-to-square" ></i></button>
                            </td>
                        @endauth
                        <td class="text-center">
                            {{ $the_producto->codigo }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->nombre_producto }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->tipo }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp_manual }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->paga_impuesto }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp1 }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp2 }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp3 }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp4 }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->porcentaje_iva }}
                        </td>
                        <td class="text-center">
                            {{ number_format($the_producto->pvp1 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center">
                            {{ number_format($the_producto->pvp2 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center">
                            {{ number_format($the_producto->pvp3 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center">
                            {{ number_format($the_producto->pvp4 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center" style="display:none">
                            {{ $the_producto->pos }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{ $productos->links() }}
                    </div>
            
        </div>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Script de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


        <script>
        
                        
            $(document).ready(function() {
                $('#codigo').prop('readonly', false);
              // Evento para capturar el clic en el botón "Editar"
                $('.btnEditar').click(function() {
                // Obtener los datos de la fila correspondiente
                var fila = $(this).closest('tr');
                var codigo = fila.find('td:eq(1)').text();
                var nombre_producto = fila.find('td:eq(2)').text();
                var tipo = fila.find('td:eq(3)').text();
                var pvp_manual = fila.find('td:eq(4)').text();
                var paga_impuesto = fila.find('td:eq(5)').text();
                var pvp1 = fila.find('td:eq(6)').text();
                var pvp2 = fila.find('td:eq(7)').text();
                var pvp3 = fila.find('td:eq(8)').text();
                var pvp4 = fila.find('td:eq(9)').text();
                var porcentaje_iva = fila.find('td:eq(10)').text();
                var pos = fila.find('td:eq(15)').text();
                
                // Mostrar los datos en el formulario
                $('#codigo').val(codigo.trim());
                $('#codigo').prop('readonly', true);
                
                $('#nombre_producto').val(nombre_producto.trim());
                //$('#tipo').val(tipo);
                //$('#pvp_manual').val(pvp_manual);
                
                $('#tipo option').filter(function() {
                    return $(this).text().trim() === tipo.trim();
                }).prop('selected', true);
                
                $('#pvp_manual option').filter(function() {
                    return $(this).text().trim() === pvp_manual.trim();
                }).prop('selected', true);
                
                $('#paga_impuesto option').filter(function() {
                    return $(this).text().trim() === paga_impuesto.trim();
                }).prop('selected', true);
                
                $('#pvp1').val(pvp1.trim());
                $('#pvp2').val(pvp2.trim());
                $('#pvp3').val(pvp3.trim());
                $('#pvp4').val(pvp4.trim());
                $('#porcentaje_iva').val(porcentaje_iva.trim());
                $('#pos').val(pos.trim());
              });
            });
            
            document.addEventListener('DOMContentLoaded', function () {
                
                $('.inputDecimal').on('input', function() {
                    // Reemplazar cualquier carácter que no sea número o punto con una cadena vacía
                    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
                    
                    // Limitar la longitud total a 10 caracteres
                    if ($(this).val().length > 10) {
                        $(this).val($(this).val().slice(0, 10));
                    }
            
                    // Si hay más de un punto decimal, eliminar los caracteres adicionales
                    if ($(this).val().split('.').length > 2) {
                        var partes = $(this).val().split('.');
                        $(this).val(partes[0] + '.' + partes.slice(1).join(''));
                    }
                });
                
                document.getElementById('codigo').addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Limitar el valor a 3 dígitos
                    if (this.value.length > 3) {
                        this.value = this.value.slice(0, 3);
                    }
                });
                
                
                document.getElementById('porcentaje_iva').addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Limitar el valor a 2 dígitos
                    if (this.value.length > 2) {
                        this.value = this.value.slice(0, 2);
                    }
                });
               
            });
            
            
            
            
            
        </script>
</x-app-layout>