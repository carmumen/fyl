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
                        @lang('Team')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Role')
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
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('FIRMA')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($lista_life as $thelista_life)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center; height:50px;">
                            {{ $thelista_life->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->training) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->role) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->participant_list) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->nickname) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thelista_life->phone_enroller) }}
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
                        @lang('Team')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Role')
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
                        @lang('Firma')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($lista_life as $thelista_life)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            {{ $thelista_life->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_life->training) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_life->role) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_life->participant_list) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thelista_life->nickname) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_life->phone) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_life->enroller) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thelista_life->phone_enroller) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
