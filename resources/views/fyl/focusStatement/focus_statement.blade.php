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
                        @lang('Staff')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Participante')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Teléfono')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Equipo Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        @lang('Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:150px;' : '' }}">
                        @lang('Teléfono Enrolador')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Gafete')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('Asistencia')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('YOUR')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:100px;' : '' }}">
                        @lang('LIFE')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        @lang('Declaración')
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:800px;' : '' }}">
                        @lang('Comentario')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($declaracion as $the_declaracion)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center; height:50px;">
                            {{ $the_declaracion->secuencial }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->staff) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->participant) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->team_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->enroller_phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->nickname) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->sunday_attended) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->payment_status_your) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->payment_status_life) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($the_declaracion->confirm_assistance_next) }}
                        </td>
                        <td style="vertical-align:middle; text-align: left;">
                            @foreach ($the_declaracion->comments  as $comment) 
                                ({{ $comment->name }}&nbsp;&nbsp;{{ $comment->created_at }})&nbsp;&nbsp;
                                {{ $comment->status }}&nbsp;&nbsp;{{ $comment->comment }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

