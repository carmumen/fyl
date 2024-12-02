<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Focus</title>

</head>
<body>

    <h1>Dashboard {{ $params['titulo'] }}</h1>
   
    @if (isset($params['gender']) && count($params['gender']) > 0)
    <table >
        <tr><th colspan="4" style="text-align:center; font-size:16px; border: 1px solid #085985">Participantes por Género</th></tr>
        <tr >
            <th style="width:100px; padding:4px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">DÍA</th>
            <th style="width:100px; padding:4px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">FEMENINO</th>
            <th style="width:100px; padding:4px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">MASCULINO</th>
            <th style="width:100px; padding:4px; font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid white; text-align:center;">OTRO</th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['gender'][0]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][0]->femenino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][0]->masculino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][0]->otro }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['gender'][1]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][1]->femenino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][1]->masculino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][1]->otro }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['gender'][2]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][2]->femenino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][2]->masculino }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['gender'][2]->otro }}</td>
        </tr>
    </table>
    @endif
    
    @if (isset($params['city']) && count($params['city']) > 0)
    <table>
        <tr><th colspan="3" style="text-align:center; font-size:16px; border: 1px solid #085985">Participantes por Ciudad</th></tr>
        <tr class="titulo">
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;" title="Pago">DÍA</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['city'][0]->campus }}</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid white; text-align:center;">OTRAS</th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['city'][0]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][0]->ciudad }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][0]->otra }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['city'][1]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][1]->ciudad }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][1]->otra }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['city'][2]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][2]->ciudad }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['city'][2]->otra }}</td>
        </tr>
    </table>
    @endif
    
    
    @if (isset($params['age_range']) && count($params['age_range']) > 0)
    <table>
        <tr><th colspan="6" style="text-align:center; font-size:16px; border: 1px solid #085985">Participantes por Edad</th></tr>
        <tr class="titulo">
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;" title="Pago">DÍA</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Menor a 18</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">18 a 27</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">28 a 40</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">41 a 65</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid white; text-align:center;">Mayor a 66</th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['age_range'][0]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][0]->menor18 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][0]->e18a27 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][0]->e28a40 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][0]->e41a65 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][0]->mayor66 }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['age_range'][1]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->menor18 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->e18a27 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->e28a40 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->e41a65 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->mayor66 }}</td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $params['age_range'][2]->dia }}</th>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][2]->menor18 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][2]->e18a27 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][2]->e28a40 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->e41a65 }}</td>
            <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['age_range'][1]->mayor66 }}</td>
        </tr>
    </table>
    @endif
                    
    @if (isset($params['payments']) && count($params['payments']) > 0)
    <table>
        <tr><th colspan="6" style="text-align:center; font-size:16px; border: 1px solid #085985">Resúmen de Pagos</th></tr>
        <tr>
            <th style="font-size:10px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"></th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;" title="Pago">Pago<br>Anticipado</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pago<br>en Jornada</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Your</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Your + Life</th>
            <th style="width:100px; font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid #085985; text-align:center;">Total.</th>
        </tr>
        @foreach($params['payments'] as $thePaymentsDetails)
        <tr>
            <th style="font-size:10px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $thePaymentsDetails->status }}</th>
            <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                @if($thePaymentsDetails->status == "TOTAL PAGOS")
                    <b>{{ $thePaymentsDetails->pago_anticipado }}</b>
                @else
                    {{ $thePaymentsDetails->pago_anticipado }}
                @endif
            </td>
            <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                @if($thePaymentsDetails->status == "TOTAL PAGOS")
                    <b>{{ $thePaymentsDetails->pago }}</b>
                @else
                    {{ $thePaymentsDetails->pago }}
                @endif
            </td>
            <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                @if($thePaymentsDetails->status == "TOTAL PAGOS")
                    <b>{{ $thePaymentsDetails->Y }}</b>
                @else
                    {{ $thePaymentsDetails->Y }}
                @endif
            </td>
            <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                @if($thePaymentsDetails->status == "TOTAL PAGOS")
                    <b>{{ $thePaymentsDetails->YL }}</b>
                @else
                    {{ $thePaymentsDetails->YL }}
                @endif
            </td>
            @if($thePaymentsDetails->status == "TOTAL PAGOS")
                <td style="text-align:center; border: 1px solid #085985 font-size:14px; color:red;">
                        <b style="color:red; font-size:16px">{{ $thePaymentsDetails->TOTAL }}</b>
                </td>
                @else
                <td style="text-align:center; font-size:14px; border: 1px solid #085985 font-size:14px;">
                        <b>{{ $thePaymentsDetails->TOTAL }}</b>
                </td>
            @endif
        </tr>
        @endforeach
    </table>
    @endif
            
    @if (isset($params['payments_staff']) && count($params['payments_staff']) > 0)
    <table class="w-full table">
    <tr><th colspan="9" style="text-align:center; font-size:16px; border: 1px solid #085985">Resúmen de Pagos por Staff</th></tr>
    <tr>
        <th style="width:250px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">STAFF</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Acuerdo</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Posibilidad</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Abono<br>Your</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Abono<br>Your + Life</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pago Total<br>Your</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pago Total<br>Your<br>Abono Life</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pago Total<br>Your + Life</th>
        <th style="width:100px; font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid white; text-align:center;">Pagos</th>
    </tr>
    @foreach($params['payments_staff'] as $thePayments_staff)
    <tr>
        <th class="titulo" style="font-size:10px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $thePayments_staff->staff }}</th>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->ACUERDO }}</b>
            @else
                {{ $thePayments_staff->ACUERDO }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->POSIBILIDAD }}</b>
            @else
                {{ $thePayments_staff->POSIBILIDAD }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->A_Y }}</b>
            @else
                {{ $thePayments_staff->A_Y }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->A_YL }}</b>
            @else
                {{ $thePayments_staff->A_YL }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->PT_Y }}</b>
            @else
                {{ $thePayments_staff->PT_Y }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->PTY_AL }}</b>
            @else
                {{ $thePayments_staff->PTY_AL }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b>{{ $thePayments_staff->PT_YL }}</b>
            @else
                {{ $thePayments_staff->PT_YL }}
            @endif
        </td>
        <td style="text-align:center; border: 1px solid #085985 font-size:14px">
            @if($thePayments_staff->staff == "TOTAL")
                <b style="color:red; font-size:16px">{{ $thePayments_staff->Pagos }}</b>
            @else
                <b>{{ $thePayments_staff->Pagos }}</b>
            @endif
        </td>
    </tr>
    @endforeach
    </table>
    @endif                
       
    @if (isset($params['attendance']) && count($params['attendance']) > 0)
    <table class="w-full table">
        <tr><th colspan="4" style="text-align:center; font-size:16px; border: 1px solid #085985">Asistencia General</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"></th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">NO ASISTIÓ</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">DESERTÓ</th>
            <th style="font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid white; text-align:center;">ASISTIÓ</th>
        </tr>
        @foreach($params['attendance'] as $theAttendance)
                <tr>
                    <th style="font-size:10px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $theAttendance->status }}</th>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance->status == "FOCUS")
                            <b>{{ $theAttendance->NO_ASISTIÓ }}</b>
                        @else
                            {{ $theAttendance->NO_ASISTIÓ }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance->status == "FOCUS")
                            <b>{{ $theAttendance->DESERTÓ }}</b>
                        @else
                            {{ $theAttendance->DESERTÓ }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance->status == "FOCUS")
                            <b style="color:red; font-size:16px">{{ $theAttendance->ASISTIÓ }}</b>
                        @else
                            <b>{{ $theAttendance->ASISTIÓ }}</b>
                        @endif
                    </td>
                </tr>
        @endforeach
    </table>
    @endif
            
    @if (isset($params['attendance_teams']) && count($params['attendance_teams']) > 0)
    <table class="w-full table">
        <tr><th colspan="9" style="text-align:center; font-size:16px; border: 1px solid #085985">Asistencia Por Equipos</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">EQUIPO</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Confirmaron</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">LLegaron</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Recuperados</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Rezagados</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Jornada</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">No asistió</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Desertó</th>
            <th style="font-size:12px; background-color: #085985; color: white; border-rigth: 0.5px solid #085985; text-align:center;">Asistió</th>
        </tr>
        @foreach($params['attendance_teams'] as $theAttendance_teams)
                <tr>
                    <th style="font-size:10px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">{{ $theAttendance_teams->team_name }}</th>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px" title="CONFIRMARON">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->CONFIRMARON }}</b>
                        @else
                            {{ $theAttendance_teams->CONFIRMARON }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->LLEGARON }}</b>
                        @else
                            {{ $theAttendance_teams->LLEGARON }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->RECUPERADO }}</b>
                        @else
                            {{ $theAttendance_teams->RECUPERADO }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->REZAGADO }}</b>
                        @else
                            {{ $theAttendance_teams->REZAGADO }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->JORNADA }}</b>
                        @else
                            {{ $theAttendance_teams->JORNADA }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->NO_ASISTIÓ }}</b>
                        @else
                            {{ $theAttendance_teams->NO_ASISTIÓ }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b>{{ $theAttendance_teams->DESERTÓ }}</b>
                        @else
                            {{ $theAttendance_teams->DESERTÓ }}
                        @endif
                    </td>
                    <td style="text-align:center; border: 1px solid #085985 font-size:14px">
                        @if($theAttendance_teams->team_name == "TOTAL")
                            <b style="color:red; font-size:12px">{{ $theAttendance_teams->ASISTIÓ }}</b>
                        @else
                            <b>{{ $theAttendance_teams->ASISTIÓ }}</b>
                        @endif
                    </td>
                </tr>
        @endforeach
    </table>
    @endif
    
</body>
</html>
