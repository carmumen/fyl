<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold;">
                        @lang('Fecha.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px; margin: 40px;' : '' }}">
                        @lang('Tipo de Gasto')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Categoria')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Proveeedor')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Descripcion')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        ID @lang('Total')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($gastos as $gasto)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $gasto->fecha }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($gasto->tipoGasto) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($gasto->categoria) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($gasto->proveedor) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($gasto->descripcion) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($gasto->total) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                        @lang('No.')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Register Payments')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Team')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Enroller')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Participant')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        ID @lang('Client')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Business Name')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Address')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Email')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Phone')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Program')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Date')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Price')
                    </th>
                    @if ($payment_summary[0]->parameter == 'C')
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Credit card')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Debit card')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Transfer') Austro
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Transfer') Pichincha
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Deposit')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Cash')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Apoyo Empresarial')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Free')
                        </th>
                    @else
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Amount')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                            @lang('Método de Pago')
                        </th>
                    @endif
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Card')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Type Payment')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Bank')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Authorization')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Payment status')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($payment_summary as $thepayment_summary)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            {{ $thepayment_summary->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thepayment_summary->RegistraPago) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thepayment_summary->Equipo) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Enrolador) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Participante) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Cliente) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->RazonSocial) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Direccion) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Email) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Telefono) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->program) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->fecha) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->price) }}
                        </td>
                        @if ($thepayment_summary->parameter == 'C')
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->TarjetaCredito > 0)
                                    <b>{{ strip_tags($thepayment_summary->TarjetaCredito) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->TarjetaCredito) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->TarjetaDebito > 0)
                                    <b>{{ strip_tags($thepayment_summary->TarjetaDebito) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->TarjetaDebito) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Transferencia_Austro > 0)
                                    <b>{{ strip_tags($thepayment_summary->Transferencia_Austro) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Transferencia_Austro) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Transferencia_Pichincha > 0)
                                    <b>{{ strip_tags($thepayment_summary->Transferencia_Pichincha) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Transferencia_Pichincha) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Deposito > 0)
                                    <b>{{ strip_tags($thepayment_summary->Deposito) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Deposito) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Efectivo > 0)
                                    <b>{{ strip_tags($thepayment_summary->Efectivo) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Efectivo) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Apoyo_Empresarial > 0)
                                    <b>{{ strip_tags($thepayment_summary->Apoyo_Empresarial) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Apoyo_Empresarial) }}
                                @endif
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                @if ($thepayment_summary->Gratis > 0)
                                    <b>{{ strip_tags($thepayment_summary->Gratis) }}</b>
                                @else
                                    {{ strip_tags($thepayment_summary->Gratis) }}
                                @endif
                            </td>
                        @else
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                {{ strip_tags($thepayment_summary->Monto) }}
                            </td>
                            <td class="{{ Config::get('style.rowCenterXs') }}">
                                {{ strip_tags($thepayment_summary->MetodoPago) }}
                            </td>
                        @endif
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Tarjeta) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->TipoPago) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Banco) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->authorization_number) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->EstadoPago) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
