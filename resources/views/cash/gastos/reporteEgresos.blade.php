@php
    $datos = $campusSeleccionado[0];
    list($campusId, $pais, $ciudad) = explode(",", $datos);
@endphp
<style>

    .table-wrapper-e {
        max-height: 600px; /* ajusta este valor según tu necesidad */
        overflow-y: auto;
        position: relative; /* Establece una posición relativa */
    }
    
    .table-wrapper-e table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* Fija el ancho de las columnas */
    }
    
    .table-wrapper-e th, .table-wrapper td {
        padding: 8px;
        text-align: left;
        white-space: nowrap; /* Evita el salto de línea en el contenido de las celdas */
        overflow: hidden; /* Oculta el contenido que desborda las celdas */
        text-overflow: ellipsis; /* Muestra puntos suspensivos (...) para el contenido que se desborda */
    }
    
    /* Fijar el encabezado y el pie de la tabla */
    .table-wrapper-e thead,
    .table-wrapper-e tfoot {
        position: sticky;
        z-index: 1; /* Asegura que estén por encima del cuerpo de la tabla */
    }
    
    .table-wrapper-e thead {
        top: 0; /* Fija el encabezado en la parte superior */
    }
    
    .table-wrapper-e tfoot {
        bottom: 0; /* Fija el pie en la parte inferior */
    }


</style>
<div class="col col-md-12 p-3">

    <table style="width:100%">
        <tr>
            <td rowspan="4" style="width:140px; text-align:center">
                <img src="{{ asset('images/focus5.png') }}" width="60%" alt="Focus Your Life">
            </td>
            <th style="width:50px">País:</td>
            <td>{{ $pais }}</td>
        </tr>
        <tr>
            <th>Sede:</th>
            <td>{{ $ciudad }}</td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <th colspan="3" style="text-align:center">EGRESOS</th>
        </tr>
    </table>
    
    <div class="card mb-3 mt-3">
        
        <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
            Consulta por Periodo
        </div>
        
        <div class="card-body p-3 ">
            <form class="col col-sm-8" id="form_estado" method="GET" action="{{ route('GastosEgresos.obtenerEgresos') }}" >
                @csrf
                <div class="row d-flex align-items-stretch">
                    <!-- Fila 1 -->
                    <div class="col-sm-3">
                        <!-- FECHA INICIO -->
                        <div class="form-group-sm">
                            <input type="hidden" id="campus_egresos" name="campus_id" value="{{ $campusId }}"/>
                            <label for="fechaInicioEgresos" class="form-label">Desde:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaInicioEgresos" 
                                    name="fechaInicioEgresos" 
                                    value="{{ old('fechaInicioEgresos','') }}"  
                                    required />
                            @error('fechaInicioIngreso')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <!-- FECHA HASTA -->
                        <div class="form-group-sm">
                            <label for="fechaFinEgresos" class="form-label">Hasta:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaFinEgresos" 
                                    name="fechaFinEgresos" 
                                    value="{{ old('fechaFinEgresos','') }}"  
                                    required />
                            @error('fechaFinEgresos')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3 d-flex align-items-end">
                        <button type="button"
                            class="btn text-white"  
                            style="background-color: #0284C7;"
                            onclick="obtenerEgresos()"
                            >Consultar</button>
                    </div>
                    <div class="col-sm-3 d-flex align-items-end">
                        <a id="exportLink" class="btn text-white" style="background-color: #0284C7; display:none" href="#">Exportar</a>
                    </div>
                </div>
            </form>
            
            <div class="card mb-3 mt-3">
            
                <div class="table-wrapper-e">
                <table id="datosEgresos" class="table table-sm" >
                    <thead class="table-primary table-sm" style="background-color:#8064a2; color:white; font-size: 0.8rem">
                        <tr style="border: 1px solid #8064a2;">
                            <td class="text-center">FECHA</td>
                            <td class="text-center">TIPO GASTO</td>
                            <td class="text-center">CATEGORÍA</td>
                            <td class="text-center">PROVEEDOR</td>
                            <td class="text-center">DESCRIPCIÓN</td>
                            <td class="text-center">TOTAL</td>
                        </tr>   
                    </thead>
                    <tbody class="table-info table-sm" style="background-color:#edfcff; max-height: 200px; overflow-y: auto;">
                        
                    </tbody>
                    <tfoot class="table-primary table-sm" style="background-color:#8064a2; color:white; font-size: 0.8rem">
                        <!-- Pie de la tabla -->
                    </tfoot>
                </table>
                </div>
            </div>
            
        </div>
        
    </div>
    </div>

<script>

   

    function obtenerEgresos() {
    var url = '{{ route("GastosEgresos.obtenerEgresos") }}';
    var campus_id = $("#campus_egresos").val();
    var fechaInicio = $("#fechaInicioEgresos").val();
    var fechaFin = $("#fechaFinEgresos").val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: url,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            campus_id: campus_id,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin
        },
        success: function(response) {
            // Limpiar el cuerpo de la tabla
            $('#datosEgresos tbody').empty();
            
            var sumaTotal = 0;
            
            response.forEach(function(registro) {
                var fila = '<tr class="border-b border-gray-200" style="font-size: 0.8rem">' +
                   '<td class="text-center">' + registro.fecha + '</td>' +
                   '<td class="text-center">' + registro.tipoGasto + '</td>' +
                   '<td class="text-center">' + registro.categoria + '</td>' +
                   '<td class="text-center">' + registro.proveedor + '</td>' +
                   '<td class="text-center">' + registro.descripcion + '</td>' +
                   '<td class="text-center">' + registro.total + '</td>' +
                   '</tr>';
                $('#datosEgresos tbody').append(fila);

                sumaTotal += parseFloat(registro.total);
            });
            
            var footer = '<tr>' +
                '<td class="text-center" colspan="5">Total EGRESOS</td>' +
                '<td class="text-center">' + sumaTotal.toFixed(2) + '</td>' +
                '</tr>';
                        
            $('#datosEgresos tfoot').html(footer);
            
            urlExcel = '/exportar-tabla/reporte_gastos/'+campus_id+'/'+fechaInicio+'|'+fechaFin;
            
            $('#exportLink').attr('href', urlExcel);
            // Hacer visible el enlace
            
            if(sumaTotal != 0)
                $('#exportLink').show();
            else
                $('#exportLink').hide();
        },
        error: function(xhr, status, error) {
            // Manejar errores
            console.error('Error al obtener los egresos:', error);
        }
    });
}

</script>

    