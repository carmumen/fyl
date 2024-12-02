<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<style>

    .table-wrapper-e {
        max-height: 40vh; /* ajusta este valor según tu necesidad */
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

<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" >
            <thead>
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold;">
                        @lang('No.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px; margin: 40px;' : '' }}">
                        @lang('Register Payments')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Team')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Enroller')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Registrado En')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Participant')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        ID @lang('Client')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Business Name')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:400px;' : '' }}">
                        @lang('Address')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:250px;' : '' }}">
                        @lang('Email')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Phone')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Program')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Date')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Price')
                    </th>
                    
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Amount')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('Método de Pago')
                    </th>
                    
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Card')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('Type Payment')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Bank')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Authorization')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Payment status')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Fecha Registro')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: left; font-weight: bold; width:400px;' : '' }}">
                        @lang('Comentarios')
                    </th>
                </tr>
            </thead>
            <tbody >
                @foreach ($payment_summary as $thepayment_summary)
                    <tr>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $thepayment_summary->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->registra) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->equipoEnrolador) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->enrolador) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->training_participant) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->surnames_names) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->CC_RUC) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->names_razon_social) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->address) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->email) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->program) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->payment_date) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->price) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->Monto) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->MetodoPago) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->Tarjeta) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->TipoPago) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->Banco) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->authorization_number) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->EstadoPago) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thepayment_summary->created_at) }}
                        </td>
                        <td style="vertical-align:middle; text-align: left; width:400px">
                            {{ strip_tags($thepayment_summary->comment ) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
    <div class="table-wrapper-e" style="overflow-x: auto;">
        <table id="tablaDatos" style="width:4000px" >
            <thead class="sticky top-0 bg-sky-800"  >
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                        @lang('No.')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="text-align:center; border:1px solid white; width:150px">
                        @lang('Register Payments')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="text-align:center; border:1px solid white; width:200px">
                        @lang('Team')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:300px">
                        @lang('Enroller')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:300px">
                        @lang('Registrado en')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:300px">
                        @lang('Participant')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Cliente')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:300px">
                        @lang('Business Name')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:400px">
                        @lang('Address')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:250px">
                        @lang('Email')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Phone')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Program')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:100px">
                        @lang('Fecha')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:100px">
                        @lang('Price')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:100px">
                        @lang('Amount')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:150px">
                        @lang('Método de Pago')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:100px">
                        @lang('Card')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:100px">
                        @lang('Type Payment')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:200px">
                        @lang('Bank')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Authorization')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Payment status')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}"  style="text-align:center; border:1px solid white; width:120px">
                        @lang('Fecha Registro')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }}" >
                        @lang('Comentarios')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($payment_summary as $thepayment_summary)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}  w-12" style="padding:4px">
                            {{ $thepayment_summary->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->registra) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->equipoEnrolador) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->enrolador) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->training_participant) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->surnames_names) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->CC_RUC) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->names_razon_social) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->address) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->email) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->phone) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->program) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->payment_date) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->price) }}
                        </td>
                        
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->Monto) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->MetodoPago) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->Tarjeta) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->TipoPago) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thepayment_summary->Banco) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->authorization_number) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->EstadoPago) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}"  style="text-align:center; ">
                            {{ strip_tags($thepayment_summary->created_at) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}" >
                            {{ strip_tags($thepayment_summary->comment ) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
