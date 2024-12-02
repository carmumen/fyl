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
           
            <div class="d-flex justify-content-between p-3">
                <label class="form-label" style="font-size:15px; color:#085985 ">PRODUCTOS REGISTRADOS EN CONTÍFICO</label>
                <form id="form_producto" method="GET" action="{{ route('Actualiza.Productos') }}">
                    @csrf
                    <button type="submit"
                        form="form_producto"
                        class="btn text-white"  
                        style="background-color: #0284C7;">Actualizar Listado</button>
                </form>
                <form id="form_prices" method="GET" action="{{ route('Actualiza.Precios') }}">
                    @csrf
                    <button type="submit"
                        form="form_prices"
                        class="btn text-white"  
                        style="background-color: #0284C7;">Actualizar Precios</button>
                </form>
            </div>
            
            <table class="table table-sm ">
                <thead class="table-primary table-sm" style="background-color:#085985; color:white; font-size:0.8rem">
                    <tr style="border: 1px solid #085985;">
                        <td class="text-center">Código</td>
                        <td class="text-center">Nombre</td>
                        <td class="text-center">Tipo</td>
                        <td class="text-center">PVP Manual</td>
                        <td class="text-center">PVP 1</td>
                        <td class="text-center">PVP 2</td>
                        <td class="text-center">PVP 3</td>
                        <td class="text-center">PVP 4</td>
                        <td class="text-center">% IVA</td>
                        <td class="text-center">PVP1+IVA</td>
                        <td class="text-center">PVP2+IVA</td>
                        <td class="text-center">PVP3+IVA</td>
                        <td class="text-center">PVP4+IVA</td>
                        <td class="text-center" style="display:none"></td>
                    </tr>   
                </thead>
                <tbody class="table-info table-sm">
                    @foreach ($productos as $the_producto)
                    <tr class="border-b border-gray-100" style="font-size:0.8rem">
                        
                        <td class="text-center">
                            {{ $the_producto->codigo }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->nombre }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->tipo }}
                        </td>
                        <td class="text-center">
                            {{ $the_producto->pvp_manual }}
                        </td>
                        <td class="text-center" style="background-color:#FDD317">
                            {{ $the_producto->pvp1 }}
                        </td>
                        <td class="text-center" style="background-color:#FFE900">
                            {{ $the_producto->pvp2 }}
                        </td>
                        <td class="text-center" style="background-color:#FFF433">
                            {{ $the_producto->pvp3 }}
                        </td>
                        <td class="text-center" style="background-color:#FFFF66">
                            {{ $the_producto->pvp4 }}
                        </td>
                        <td class="text-center"  style="background-color:#89dfed">
                            {{ $the_producto->porcentaje_iva }}
                        </td>
                        <td class="text-center" style="background-color:#FDD317">
                            {{ number_format($the_producto->pvp1 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center" style="background-color:#FFE900">
                            {{ number_format($the_producto->pvp2 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center" style="background-color:#FFF433">
                            {{ number_format($the_producto->pvp3 * (1 + $the_producto->porcentaje_iva/100),2) }}
                        </td>
                        <td class="text-center" style="background-color:#FFFF66">
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