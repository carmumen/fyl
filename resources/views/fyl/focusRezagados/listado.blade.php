<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="overflow-x: auto;">
    @if (isset($styleArray))
        <table id="tablaDatos" style="width:3000px">
            <thead class="top-0 bg-sky-800">
                <tr>
                    <th scope="col" style="text-align: center; font-weight: bold; width:200px">
                        Entrenamiento Inicial
                    </th>
                    <th scope="col" style="text-align: center; font-weight: bold; width:200px">
                        Entrenamiento Actualizado
                    </th>
                    <th scope="col" style="text-align: center; font-weight: bold; width:200px">
                        Último Intento
                    </th>
                    <th scope="col" style="text-align: center; font-weight: bold; width:300px">
                        Participante
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        Identidad
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:250px;' : '' }}">
                        email
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        Teléfono 1
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:120px;' : '' }}">
                        Teléfono 2
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Residencia
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:300px;' : '' }}">
                        Enrolador
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Email Enrolador
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Teléfono Enrolador
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Llamada
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Fecha llamada
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Confirmación llamada
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:500px;' : '' }}">
                        Resúmen llamada
                    </th>
                    <th scope="col"
                        style="{{ $styleArray ? 'text-align: center; font-weight: bold; width:200px;' : '' }}">
                        Operador
                    </th>
                    
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($rezagados as $therezagados)
                    <tr class="border-b border-gray-200">
                        <td style="vertical-align:middle; text-align: center; ">
                            {{ $therezagados->trainingOriginal }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->trainingActual) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->trainingFocus) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->surnames_names) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->DNI) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->email) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->phone) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->phone2) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->city_of_residenceT) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->enrolador) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->email_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->phone_enroller) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->type_call) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->date_call) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->confirm_assistance) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->summary_call) }}
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            {{ strip_tags($therezagados->name) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
