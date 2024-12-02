<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold;">
                        @lang('No.')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Ejecutivo')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Equipo Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:230px;' : '' }}">
                        @lang('Participante')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Phone')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:230px;' : '' }}">
                        @lang('Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:230px;' : '' }}">
                        @lang('Teléfono Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:230px;' : '' }}">
                        @lang('Ciudad')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Fecha de Llamada')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Tipo de Llamada')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:250px;' : '' }}">
                        @lang('Resultado de Llamada')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Resumen de Llamada')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Fecha de Registro')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Status')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Registrado en')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Asistencia')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($follow as $thefollow)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $thefollow->secuencial }}
                        </td>
                        <td style="vertical-align:middle">
                            {{ strip_tags($thefollow->oficinista) }}
                        </td>
                        <td style="vertical-align:middle">
                            {{ strip_tags($thefollow->team_name) }}
                        </td>
                        <td style="vertical-align:middle">
                            {{ strip_tags($thefollow->participante) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->phone) }}
                        </td>
                        <td style="vertical-align:middle">
                            {{ strip_tags($thefollow->enrolador) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->phone_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->city_of_residenceT) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->fecha_llamada) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->type_call) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->confirm_assistance) }}
                        </td>
                        <td style="word-wrap: break-word;">
                            {{ strip_tags($thefollow->summary_call) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->fecha_registro) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->record_mode) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->training_register) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($thefollow->sunday_attended) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200" style="width:1800px">
            <thead class="sticky top-0 bg-sky-800">
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerInt') }} " style="width:30px">
                        @lang('No.')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Ejecutivo')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Equipo Enrolador')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Participante')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Phone')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Enrolador')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Teléfono Enrolador')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Ciudad')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}" style="width:100px">
                        @lang('Fecha de Llamada')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Tipo de Llamada')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Resultado de Llamada')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Resumen de Llamada')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Fecha de Registro')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Status')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Registrado en')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Asistencia')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($follow as $thefollow)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }}">
                            {{ $thefollow->secuencial }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->oficinista) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->team_name) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->participante) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->phone) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->enrolador) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->phone_enroller) }}
                        </td>
                        <td class="{{ Config::get('style.rowLeftXs') }}">
                            {{ strip_tags($thefollow->city_of_residenceT) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->fecha_llamada) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->type_call) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->confirm_assistance) }}
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->summary_call) }}
                        </td>
                        <td class="w-24 {{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->fecha_registro) }}
                        </td>
                        <td class="w-24 {{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->record_mode) }}
                        </td>
                        <td class="w-24 {{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->training_register) }}
                        </td>
                        <td class="w-24 {{ Config::get('style.rowCenterXs') }}">
                            {{ strip_tags($thefollow->sunday_attended) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
