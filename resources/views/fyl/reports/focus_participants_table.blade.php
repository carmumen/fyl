<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold;">
                        @lang('No.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px; margin: 40px;' : '' }}">
                        @lang('Bienvenida')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Logistica')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Attendance Status')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Participant')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        ID @lang('Nickname')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Phone')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Record')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('Team Enroller')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Enroller')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($focusParticipants as $theFocusParticipants)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $theFocusParticipants->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->confirm_assistance_welcome) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->confirm_assistance_logistics) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->sunday_attended) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->participant) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->nickname) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->record_mode) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->team_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($theFocusParticipants->enroller) }}
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
                        @lang('Bienvenida')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Logistica')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Attendance Status')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Participant')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        ID @lang('Nickname')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Phone')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Record')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Team Enroller')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Enroller')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($focusParticipants as $theFocusParticipants)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            {{ $theFocusParticipants->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($theFocusParticipants->confirm_assistance_welcome) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($theFocusParticipants->confirm_assistance_logistics) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->sunday_attended) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->participant) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->nickname) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->phone) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->record_mode) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->team_enroller) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($theFocusParticipants->enroller) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
