@php
    $datos = $campusSeleccionado[0];
    list($campusId, $pais, $ciudad) = explode(",", $datos);
@endphp
<style>

    .table-wrapper {
        max-height: 200px; /* ajusta este valor según tu necesidad */
        overflow-y: auto;
        position: relative; /* Establece una posición relativa */
    }
    
    .table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* Fija el ancho de las columnas */
    }
    
    .table-wrapper th, .table-wrapper td {
        padding: 8px;
        text-align: left;
        white-space: nowrap; /* Evita el salto de línea en el contenido de las celdas */
        overflow: hidden; /* Oculta el contenido que desborda las celdas */
        text-overflow: ellipsis; /* Muestra puntos suspensivos (...) para el contenido que se desborda */
    }
    
    /* Fijar el encabezado y el pie de la tabla */
    .table-wrapper thead,
    .table-wrapper tfoot {
        position: sticky;
        z-index: 1; /* Asegura que estén por encima del cuerpo de la tabla */
    }
    
    .table-wrapper thead {
        top: 0; /* Fija el encabezado en la parte superior */
    }
    
    .table-wrapper tfoot {
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
            <th colspan="3" style="text-align:center">INGRESOS POR ENTRENAMIENTO</th>
        </tr>
    </table>
    
    <div class="card mb-3 mt-3">
        
        <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
            Consulta por Periodo
        </div>
        
        <div class="card-body p-3 ">
            <form class="col col-sm-6" id="form_estado" method="POST" action="{{ route('GastosIngresos.obtenerIngresos') }}" >
                @csrf
                <div class="row d-flex align-items-stretch">
                    <!-- Fila 1 -->
                    <div class="col-sm-3">
                        <!-- FECHA INICIO -->
                        <div class="form-group-sm">
                            <input type="hidden" id="campus_ingreso" name="campus_id" value="{{ $campusId }}"/>
                            <label for="fechaInicioIngreso" class="form-label">Desde:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaInicioIngreso" 
                                    name="fechaInicioIngreso" 
                                    value="{{ old('fechaInicioIngreso','') }}"  
                                    required />
                            @error('fechaInicioIngreso')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <!-- FECHA HASTA -->
                        <div class="form-group-sm">
                            <label for="fechaFinIngreso" class="form-label">Hasta:</label>
                            <input type="text" style="width: 100px"
                                    class="form-control form-control-sm datePickerClass" 
                                    id="fechaFinIngreso" 
                                    name="fechaFinIngreso" 
                                    value="{{ old('fechaFinIngreso','') }}"  
                                    required />
                            @error('fechaFinIngreso')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3 d-flex align-items-end">
                        <button type="button"
                            
                            class="btn text-white"  
                            style="background-color: #0284C7;"
                            onclick="obtenerIngresos()"
                            >Consultar</button>
                    </div>
                    
                    <div class="col-sm-3 d-flex align-items-end">
                        <a id="exportLinkIngresos" class="btn text-white" style="background-color: #0284C7; display:none" href="#">Exportar</a>
                    </div>
                </div>
                													
                
            </form>
            <div class=" mt-3">
                <h4>FOCUS</h4>
                <div class="table-wrapper">
                <table id="datosIngresosFocus" class="table table-sm" >
                    <thead class="table-primary table-sm" style="background-color:#8064a2; color:white; font-size: 0.8rem">
                        <tr style="border: 1px solid #8064a2;">
                            <td class="text-center">ENTRENAMIENTO</td>
                            <td class="text-center">RECIBO</td>
                            <td class="text-center">PARTICIPANTE</td>
                            <td class="text-center">FECHA DE INGRESO</td>
                            <td class="text-center">Tarjeta de Crédito</td>
                            <td class="text-center">Tarjeta de Débito</td>
                            <td class="text-center">Transferencia Austro</td>
                            <td class="text-center">Transferencia Pichincha</td>
                            <td class="text-center">Depósito</td>
                            <td class="text-center">Efectivo</td>
                            <td class="text-center">Apoyo Empresarial</td>
                            <td class="text-center">Gratis</td>
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
            <div class=" mt-3">
                <h4>YOUR</h4>
                <div class="table-wrapper">
                <table id="datosIngresosYour" class="table table-sm" >
                    <thead class="table-primary table-sm" style="background-color:#8064a2; color:white; font-size: 0.8rem">
                        <tr style="border: 1px solid #8064a2;">
                            <td class="text-center">ENTRENAMIENTO</td>
                            <td class="text-center">RECIBO</td>
                            <td class="text-center">PARTICIPANTE</td>
                            <td class="text-center">FECHA DE INGRESO</td>
                            <td class="text-center">Tarjeta de Crédito</td>
                            <td class="text-center">Tarjeta de Débito</td>
                            <td class="text-center">Transferencia Austro</td>
                            <td class="text-center">Transferencia Pichincha</td>
                            <td class="text-center">Depósito</td>
                            <td class="text-center">Efectivo</td>
                            <td class="text-center">Apoyo Empresarial</td>
                            <td class="text-center">Gratis</td>
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
            <div class=" mt-3">
                <h4>LIFE</h4>
                <div class="table-wrapper">
                <table id="datosIngresosLife" class="table table-sm" >
                    <thead class="table-primary table-sm" style="background-color:#8064a2; color:white; font-size: 0.8rem">
                        <tr style="border: 1px solid #8064a2;">
                            <td class="text-center">ENTRENAMIENTO</td>
                            <td class="text-center">RECIBO</td>
                            <td class="text-center">PARTICIPANTE</td>
                            <td class="text-center">FECHA DE INGRESO</td>
                            <td class="text-center">Tarjeta de Crédito</td>
                            <td class="text-center">Tarjeta de Débito</td>
                            <td class="text-center">Transferencia Austro</td>
                            <td class="text-center">Transferencia Pichincha</td>
                            <td class="text-center">Depósito</td>
                            <td class="text-center">Efectivo</td>
                            <td class="text-center">Apoyo Empresarial</td>
                            <td class="text-center">Gratis</td>
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
    function obtenerIngresos() {
    var url = '{{ route("GastosIngresos.obtenerIngresos") }}';
    var campus_id = $("#campus_ingreso").val();
    var fechaInicio = $("#fechaInicioIngreso").val();
    var fechaFin = $("#fechaFinIngreso").val();
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
            $('#datosIngresosFocus tbody').empty();
            $('#datosIngresosYour tbody').empty();
            $('#datosIngresosLife tbody').empty();
            
            var sumaTarjetaCreditoFocus = 0;
            var sumaTarjetaDebitoFocus = 0;
            var sumaTransferenciaAustroFocus = 0;
            var sumaTransferenciasPichinchaFocus = 0;
            var sumaDepositoFocus = 0;
            var sumaEfectivoFocus = 0;
            var sumaApoyoEmpresarialFocus = 0;
            var sumaGratisFocus = 0;
            var sumaAmountFocus = 0;
            
            var sumaTarjetaCreditoYour = 0;
            var sumaTarjetaDebitoYour = 0;
            var sumaTransferenciaAustroYour = 0;
            var sumaTransferenciasPichinchaYour = 0;
            var sumaDepositoYour = 0;
            var sumaEfectivoYour = 0;
            var sumaApoyoEmpresarialYour = 0;
            var sumaGratisYour = 0;
            var sumaAmountYour = 0;
            
            var sumaTarjetaCreditoLife = 0;
            var sumaTarjetaDebitoLife = 0;
            var sumaTransferenciaAustroLife = 0;
            var sumaTransferenciasPichinchaLife = 0;
            var sumaDepositoLife = 0;
            var sumaEfectivoLife = 0;
            var sumaApoyoEmpresarialLife = 0;
            var sumaGratisLife = 0;
            var sumaAmountLife = 0;
            
            response.forEach(function(registro) {
                var orden = registro.orden;
                if(orden == 1)
                {
                    var fila1 = '<tr class="border-b border-gray-200" style="font-size: 0.8rem">' +
                       '<td class="text-center">' + registro.training + '</td>' +
                       '<td class="text-center">' + registro.recibo + '</td>' +
                       '<td class="text-center">' + registro.participant + '</td>' +
                       '<td class="text-center">' + registro.payment_date + '</td>' +
                       '<td class="text-center">' + registro.tarjetaCredito + '</td>' +
                       '<td class="text-center">' + registro.tarjetaDebito + '</td>' +
                       '<td class="text-center">' + registro.transferenciaAustro + '</td>' +
                       '<td class="text-center">' + registro.transferenciasPichincha + '</td>' +
                       '<td class="text-center">' + registro.deposito + '</td>' +
                       '<td class="text-center">' + registro.efectivo + '</td>' +
                       '<td class="text-center">' + registro.apoyoEmpresarial + '</td>' +
                       '<td class="text-center">' + registro.gratis + '</td>' +
                       '<td class="text-center">' + registro.amount + '</td>' +
                       '</tr>';
                    $('#datosIngresosFocus tbody').append(fila1);
                    sumaTarjetaCreditoFocus += parseFloat(registro.tarjetaCredito);
                    sumaTarjetaDebitoFocus += parseFloat(registro.tarjetaDebito);
                    sumaTransferenciaAustroFocus += parseFloat(registro.transferenciaAustro);
                    sumaTransferenciasPichinchaFocus += parseFloat(registro.transferenciasPichincha);
                    sumaDepositoFocus += parseFloat(registro.deposito);
                    sumaEfectivoFocus += parseFloat(registro.efectivo);
                    sumaApoyoEmpresarialFocus += parseFloat(registro.apoyoEmpresarial);
                    sumaGratisFocus += parseFloat(registro.gratis);
                    sumaAmountFocus += parseFloat(registro.amount);
                    
                }
                if(orden == 2)
                {
                    var fila2 = '<tr class="border-b border-gray-200" style="font-size: 0.8rem">' +
                       '<td class="text-center">' + registro.training + '</td>' +
                       '<td class="text-center">' + registro.recibo + '</td>' +
                       '<td class="text-center">' + registro.participant + '</td>' +
                       '<td class="text-center">' + registro.payment_date + '</td>' +
                       '<td class="text-center">' + registro.tarjetaCredito + '</td>' +
                       '<td class="text-center">' + registro.tarjetaDebito + '</td>' +
                       '<td class="text-center">' + registro.transferenciaAustro + '</td>' +
                       '<td class="text-center">' + registro.transferenciasPichincha + '</td>' +
                       '<td class="text-center">' + registro.deposito + '</td>' +
                       '<td class="text-center">' + registro.efectivo + '</td>' +
                       '<td class="text-center">' + registro.apoyoEmpresarial + '</td>' +
                       '<td class="text-center">' + registro.gratis + '</td>' +
                       '<td class="text-center">' + registro.amount + '</td>' +
                       '</tr>';
                    $('#datosIngresosYour tbody').append(fila2);
                    sumaTarjetaCreditoYour += parseFloat(registro.tarjetaCredito);
                    sumaTarjetaDebitoYour += parseFloat(registro.tarjetaDebito);
                    sumaTransferenciaAustroYour += parseFloat(registro.transferenciaAustro);
                    sumaTransferenciasPichinchaYour += parseFloat(registro.transferenciasPichincha);
                    sumaDepositoYour += parseFloat(registro.deposito);
                    sumaEfectivoYour += parseFloat(registro.efectivo);
                    sumaApoyoEmpresarialYour += parseFloat(registro.apoyoEmpresarial);
                    sumaGratisYour += parseFloat(registro.gratis);
                    sumaAmountYour += parseFloat(registro.amount);
                }
                if(orden == 3)
                {
                    var fila3 = '<tr class="border-b border-gray-200" style="font-size: 0.8rem">' +
                       '<td class="text-center">' + registro.training + '</td>' +
                       '<td class="text-center">' + registro.recibo + '</td>' +
                       '<td class="text-center">' + registro.participant + '</td>' +
                       '<td class="text-center">' + registro.payment_date + '</td>' +
                       '<td class="text-center">' + registro.tarjetaCredito + '</td>' +
                       '<td class="text-center">' + registro.tarjetaDebito + '</td>' +
                       '<td class="text-center">' + registro.transferenciaAustro + '</td>' +
                       '<td class="text-center">' + registro.transferenciasPichincha + '</td>' +
                       '<td class="text-center">' + registro.deposito + '</td>' +
                       '<td class="text-center">' + registro.efectivo + '</td>' +
                       '<td class="text-center">' + registro.apoyoEmpresarial + '</td>' +
                       '<td class="text-center">' + registro.gratis + '</td>' +
                       '<td class="text-center">' + registro.amount + '</td>' +
                       '</tr>';
                    $('#datosIngresosLife tbody').append(fila3);
                    sumaTarjetaCreditoLife += parseFloat(registro.tarjetaCredito);
                    sumaTarjetaDebitoLife += parseFloat(registro.tarjetaDebito);
                    sumaTransferenciaAustroLife += parseFloat(registro.transferenciaAustro);
                    sumaTransferenciasPichinchaLife += parseFloat(registro.transferenciasPichincha);
                    sumaDepositoLife += parseFloat(registro.deposito);
                    sumaEfectivoLife += parseFloat(registro.efectivo);
                    sumaApoyoEmpresarialLife += parseFloat(registro.apoyoEmpresarial);
                    sumaGratisLife += parseFloat(registro.gratis);
                    sumaAmountLife += parseFloat(registro.amount);
                }
            });
            
            var footerFocus = '<tr>' +
                '<td class="text-center" colspan="4">Total FOCUS</td>' +
                '<td class="text-center">' + sumaTarjetaCreditoFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTarjetaDebitoFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciaAustroFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciasPichinchaFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaDepositoFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaEfectivoFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaApoyoEmpresarialFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaGratisFocus.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaAmountFocus.toFixed(2) + '</td>' +
                '</tr>';
            
            var footerYour = '<tr>' +
                '<td class="text-center" colspan="4">Total YOUR</td>' +
                '<td class="text-center">' + sumaTarjetaCreditoYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTarjetaDebitoYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciaAustroYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciasPichinchaYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaDepositoYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaEfectivoYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaApoyoEmpresarialYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaGratisYour.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaAmountYour.toFixed(2) + '</td>' +
                '</tr>';
            
            var footerLife = '<tr>' +
                '<td class="text-center" colspan="4">Total LIFE</td>' +
                '<td class="text-center">' + sumaTarjetaCreditoLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTarjetaDebitoLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciaAustroLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaTransferenciasPichinchaLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaDepositoLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaEfectivoLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaApoyoEmpresarialLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaGratisLife.toFixed(2) + '</td>' +
                '<td class="text-center">' + sumaAmountLife.toFixed(2) + '</td>' +
                '</tr>';
                        
            $('#datosIngresosFocus tfoot').html(footerFocus);
            $('#datosIngresosYour tfoot').html(footerYour);
            $('#datosIngresosLife tfoot').html(footerLife);
            
            
            urlExcel = '/exportar-tabla/reporte_ingresos/'+campus_id+'/'+fechaInicio+'|'+fechaFin;
            
            $('#exportLinkIngresos').attr('href', urlExcel);
            // Hacer visible el enlace
            
            if(sumaAmountFocus != 0 || sumaAmountYour != 0 || sumaAmountLife != 0)
                $('#exportLinkIngresos').show();
            else
                $('#exportLinkIngresos').hide();
            
        },
        error: function(xhr, status, error) {
            // Manejar errores
            console.error('Error al obtener el estado de cuenta:', error);
        }
    });
}

</script>

    