<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold;">
                        @lang('ENTRENAMIENTO.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px; margin: 40px;' : '' }}">
                        @lang('RECIBO')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('PARTICIPANTE')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('FECHA DE INGRESO')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Tarjeta de Crédito')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Tarjeta de Débito')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Transferencia Austro')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Transferencia Pichincha')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Depósito')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Efectivo')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Apoyo Empresarial')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Gratis')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('TOTAL')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($ingresos as $ingreso)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $ingreso->training }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->recibo) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->participant) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->payment_date) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->tarjetaCredito) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->tarjetaDebito) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->transferenciaAustro) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->transferenciasPichincha) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->deposito) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->efectivo) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->apoyoEmpresarial) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->gratis) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($ingreso->amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
