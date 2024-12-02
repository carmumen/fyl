<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800" style="background-color: yellow">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold; height:30px">
                        @lang('No.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('NOMBRE')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('SEUDÓNIMO')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('TELÉFONO')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('ENROLADOR')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('TELÉFONO ENROLADOR')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('LIFE')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('FIRMA')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($lista_your as $thelista_your)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center; height:50px;">
                            {{ $thelista_your->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->participant_list) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->nickname) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->phone_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_your->payment_status_life) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">

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
                        @lang('Participants')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Nickname')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Phone')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Enroller')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Phone Enroller')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('LIFE')
                    </th>
                   
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($lista_your as $thelista_your)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            {{ $thelista_your->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_your->participant_list) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_your->nickname) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_your->phone) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_your->enroller) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_your->team_name_e) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_your->payment_status_life) }}
                        </td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
