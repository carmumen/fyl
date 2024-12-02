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
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px; margin: 40px;' : '' }}">
                        @lang('EQUIPO EN JUEGO')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        @lang('EQUIPO ENROLADOR')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('PARTICIPANTE')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('IDENTIDAD')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        ID @lang('EMAIL')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        ID @lang('TELÉFONO')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($equipo as $equipos)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center;">
                            {{ $equipos->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->EQUIPO_EN_JUEGO) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->EQUIPO_ENROLADOR) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->PARTICIPANTE) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->IDENTIDAD) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->EMAIL) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($equipos->phone) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
