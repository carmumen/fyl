@php
    $datos = $campusSeleccionado[0];
    list($campusId, $pais, $ciudad) = explode(",", $datos);
@endphp
<div class="col col-lg-6 col-md-9 col-sm-12 p-3">

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
            <th colspan="3" style="text-align:center">ESTADO DE CUENTA</th>
        </tr>
    </table>
    
    <div class="card mb-3 mt-3">
        
        <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
            Consulta por Periodo
        </div>
        
        <div class="card-body p-3">
            <form id="form_estado" method="POST" action="{{ route('GastosEstadoCuenta.obtenerEstadoCuenta') }}" >
                @csrf
                <div class="row d-flex align-items-stretch">
                    <!-- Fila 1 -->
                    <div class="col-sm-4">
                        <!-- FECHA INICIO -->
                        <div class="form-group-sm">
                            <input type="hidden" id="campus_id" name="campus_id" value="{{ $campusId }}"/>
                            <label for="fechaInicio" class="form-label">Desde:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaInicio" 
                                    name="fechaInicio" 
                                    value="{{ old('fechaInicio','') }}"  
                                    required />
                            @error('fechaInicio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <!-- FECHA HASTA -->
                        <div class="form-group-sm">
                            <label for="fechaFin" class="form-label">Hasta:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaFin" 
                                    name="fechaFin" 
                                    value="{{ old('fechaFin','') }}"  
                                    required />
                            @error('fechaFin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-4 d-flex align-items-end">
                        <button type="button"
                            
                            class="btn text-white"  
                            style="background-color: #0284C7;"
                            onclick="obtenerEstadoCuenta()"
                            >Consultar</button>
                    </div>
                </div>
                <div class=" mt-3">
                    <table id="datos" class="table table-sm" >
                        <thead class="table-primary table-sm" style="background-color:#8064a2; color:white">
                            <tr style="border: 1px solid #8064a2;">
                                <td class="text-center">Concepto</td>
                                <td class="text-center">Monto</td>
                            </tr>   
                        </thead>
                        <tbody class="table-info table-sm" style="background-color:#edfcff">
                            
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        
    </div>
</div>

<script>
    function obtenerEstadoCuenta() {
    var url = '{{ route("GastosEstadoCuenta.obtenerEstadoCuenta") }}';
    var campus_id = $("#campus_id").val();
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
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
            $('#datos tbody').empty();
            
            // Iterar sobre los datos recibidos y agregar filas a la tabla
            Object.keys(response).forEach(function(key) {
                var fila = '<tr class="border-b border-gray-200">' +
                           '<th class="text-center">Saldo inicial</th>' +
                           '<td class="text-center">' + response[0].saldoInicial + '</td>' +
                           '</tr>' +
                           '<tr class="border-b border-gray-200">' +
                           '<th class="text-center">Ingresos</th>' +
                           '<td class="text-center">' + response[0].ingresos + '</td>' +
                           '</tr>' +
                           '<tr class="border-b border-gray-200">' +
                           '<th class="text-center">Devoluciones</th>' +
                           '<td class="text-center">' + response[0].devoluciones + '</td>' +
                           '</tr>' +
                           '<tr class="border-b border-gray-200">' +
                           '<th class="text-center">Ctas. por cobrar</th>' +
                           '<td class="text-center">' + response[0].cuentasPorCobrar + '</td>' +
                           '</tr>' +
                           '<tr class="border-b border-gray-200">' +
                           '<th class="text-center">Egresos</th>' +
                           '<td class="text-center">' + response[0].egresos + '</td>' +
                           '</tr>' +
                           '<tr style="border: 1px solid #8064a2; background-color:#8064a2; color:white">' +
                           '<th class="text-center">Saldo sede</th>' +
                           '<td class="text-center">' + response[0].saldo_sede + '</td>' +
                           '</tr>';
                $('#datos tbody').append(fila);
            });
            
            
        },
        error: function(xhr, status, error) {
            // Manejar errores
            console.error('Error al obtener el estado de cuenta:', error);
        }
    });
}

</script>

    