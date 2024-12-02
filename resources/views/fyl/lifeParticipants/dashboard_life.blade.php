<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Life</title>

</head>
<body>

    <h1>Dashboard {{ $params['titulo'] }}</h1>
    
    @if (isset($params['dashboard']) && count($params['dashboard']) > 0 && isset($params['dashboard'][0]->name))
        <table>
            <tr>
                <td colspan="3" style="text-align:left; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][0]->name}}</td>
                <td colspan="4" style="text-align:center; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">FDS 1</td>
                <td colspan="3" style="text-align:rigth; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][0]->participant_count}}</td>
            </tr>
            <tr>
                @if (($params['pagos'][0]->ml_pagos + $params['pagos'][0]->p_pagos >= $params['pagos'][0]->ml_declara + $params['pagos'][0]->p_declara) && ($params['pagos'][0]->ml_pagos + $params['pagos'][0]->p_pagos) > 0)
                    <td colspan="3" style="width:150px; color:red">VICTORIA</td>
                @else
                    <td colspan="3" style="width:150px"></td>
                @endif
                <td colspan="4" style="text-align:center; font-size:16px;">{{$params['coach'][0]->COACH}}</td>
                @if (isset($params['pagos']) && count($params['pagos']) > 0 && $params['dashboard'][0]->p_sunday_attended > 0)
                    <td colspan="3" style="color:#840000">{{ number_format(($params['pagos'][0]->ml_pagos + $params['pagos'][0]->p_pagos) / ($params['dashboard'][0]->ml_sunday_attended + $params['dashboard'][0]->p_sunday_attended), 2) }}</td>
                @else
                    <td colspan="3"></td>
                @endif
            </tr>
            <tr>
                <th style="width:200px"></th>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 1</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 2</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 3</th>
            </tr>
            <tr>
                <th></th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Asistencia</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_friday_attended + $params['dashboard'][0]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_saturday_attended + $params['dashboard'][0]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_sunday_attended + $params['dashboard'][0]->p_sunday_attended}}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_friday_statement + $params['dashboard'][0]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_saturday_statement + $params['dashboard'][0]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->p_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][0]->ml_sunday_statement + $params['dashboard'][0]->p_sunday_statement}}</td>
            </tr>
        </table>
    @endif   
    
    @if (isset($params['pagos']) && count($params['pagos']) > 0)
        <table>
            <tr>
                <td></td>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"><b>PAGOS</b></th>
            </tr>
            <tr>
                <th></th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->ml_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->p_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->ml_declara + $params['pagos'][0]->p_declara }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->ml_fichas }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->P_ficha }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->ml_fichas + $params['pagos'][0]->P_ficha }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->ml_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][0]->p_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985; color:red"><b>{{ $params['pagos'][0]->ml_pagos + $params['pagos'][0]->p_pagos }}</b></td>
            </tr>
        </table>
    @endif
    
    @if (isset($params['pagosDetails']) && count($params['pagosDetails']) > 0)
        <table>
            <tr>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Role</th>
                <th colspan="3" style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Enrolador</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
            </tr>
            @foreach($params['pagosDetails'] as $thePagosDetails)
                @if($thePagosDetails->training_id == $params['pagos'][0]->training_id)
                    <tr style="
                        @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) 
                            background-color: lightgreen; 
                        @elseif ($thePagosDetails->PAGOS === "0") 
                            background-color: lightpink; 
                        @endif
                    ">
                        <th style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->role }}</th>
                        <td colspan="3" style="font-size:12px; text-align:left; border: 1px solid #085985">{{ $thePagosDetails->enrolador }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->statement }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->fichas }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->PAGOS }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif
    
    
    
    @if (isset($params['dashboard']) && count($params['dashboard']) > 0 && isset($params['dashboard'][1]->name))
        <table>
            <tr>
                <td colspan="3" style="text-align:left; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][1]->name}}</td>
                <td colspan="4" style="text-align:center; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">FDS 2</td>
                <td colspan="3" style="text-align:rigth; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][1]->participant_count}}</td>
            </tr>
            <tr>
                @if (($params['pagos'][1]->ml_pagos + $params['pagos'][1]->p_pagos >= $params['pagos'][1]->ml_declara + $params['pagos'][1]->p_declara) && ($params['pagos'][1]->ml_pagos + $params['pagos'][1]->p_pagos) > 0)
                    <td colspan="3" style="width:150px; color:red">VICTORIA</td>
                @else
                    <td colspan="3" style="width:150px"></td>
                @endif
                <td colspan="4" style="text-align:center; font-size:16px;">{{$params['coach'][1]->COACH}}</td>
                @if (isset($params['pagos']) && count($params['pagos']) > 0 && $params['dashboard'][1]->p_sunday_attended > 0)
                    <td colspan="3" style="color:#840000">{{ number_format(($params['pagos'][1]->ml_pagos + $params['pagos'][1]->p_pagos) / ($params['dashboard'][1]->ml_sunday_attended + $params['dashboard'][1]->p_sunday_attended), 2) }}</td>
                @else
                    <td colspan="3"></td>
                @endif
            </tr>
            <tr>
                <th style="width:200px"></th>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 1</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 2</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 3</th>
            </tr>
            <tr>
                <th></th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Asistencia</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_friday_attended + $params['dashboard'][1]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_saturday_attended + $params['dashboard'][1]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_sunday_attended + $params['dashboard'][1]->p_sunday_attended}}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_friday_statement + $params['dashboard'][1]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_saturday_statement + $params['dashboard'][1]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->p_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][1]->ml_sunday_statement + $params['dashboard'][1]->p_sunday_statement}}</td>
            </tr>
        </table>
    @endif   
    
    @if (isset($params['pagos']) && count($params['pagos']) > 0)
        <table>
            <tr>
                <td></td>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"><b>PAGOS</b></th>
            </tr>
            <tr>
                <th></th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->ml_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->p_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->ml_declara + $params['pagos'][1]->p_declara }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->ml_fichas }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->P_ficha }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->ml_fichas + $params['pagos'][1]->P_ficha }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->ml_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][1]->p_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985; color:red"><b>{{ $params['pagos'][1]->ml_pagos + $params['pagos'][1]->p_pagos }}</b></td>
            </tr>
        </table>
    @endif
    
    @if (isset($params['pagosDetails']) && count($params['pagosDetails']) > 0)
    <table>
        <tr>
            <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Role</th>
            <th colspan="3" style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Enrolador</th>
            <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
            <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
            <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
        </tr>
        @foreach($params['pagosDetails'] as $thePagosDetails)
            @if($thePagosDetails->training_id === $params['pagos'][1]->training_id)
                <tr style="
                        @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) 
                            background-color: lightgreen; 
                        @elseif ($thePagosDetails->PAGOS === "0") 
                            background-color: lightpink; 
                        @endif
                    ">
                    <th style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->role }}</th>
                    <td colspan="3" style="font-size:12px; text-align:left; border: 1px solid #085985">{{ $thePagosDetails->enrolador }}</td>
                    <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->statement }}</td>
                    <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->fichas }}</td>
                    <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->PAGOS }}</td>
                </tr>
            @endif
        @endforeach
    </table>
@endif

    
    @if (isset($params['dashboard']) && count($params['dashboard']) > 0 && isset($params['dashboard'][2]->name))
        <table>
            <tr>
                <td colspan="3" style="text-align:left; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][2]->name}}</td>
                <td colspan="4" style="text-align:center; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">FDS 3</td>
                <td colspan="3" style="text-align:rigth; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard'][2]->participant_count}}</td>
            </tr>
            <tr>
                @if (($params['pagos'][2]->ml_pagos + $params['pagos'][2]->p_pagos >= $params['pagos'][2]->ml_declara + $params['pagos'][2]->p_declara) && ($params['pagos'][2]->ml_pagos + $params['pagos'][2]->p_pagos) > 0)
                    <td colspan="3" style="width:150px; color:red">VICTORIA</td>
                @else
                    <td colspan="3" style="width:150px"></td>
                @endif
                <td colspan="4" style="text-align:center; font-size:16px;">{{$params['coach'][2]->COACH}}</td>
                @if (isset($params['pagos']) && count($params['pagos']) > 0 && $params['dashboard'][2]->p_sunday_attended > 0)
                    <td colspan="3" style="color:#840000">{{ number_format(($params['pagos'][2]->ml_pagos + $params['pagos'][2]->p_pagos) / ($params['dashboard'][2]->ml_sunday_attended + $params['dashboard'][2]->p_sunday_attended), 2) }}</td>
                @else
                    <td colspan="3"></td>
                @endif
            </tr>
            <tr>
                <th style="width:200px"></th>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 1</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 2</th>
                <th colspan="3" style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 3</th>
            </tr>
            <tr>
                <th></th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="width:100px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Asistencia</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_friday_attended + $params['dashboard'][2]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_saturday_attended + $params['dashboard'][2]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_sunday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_sunday_attended + $params['dashboard'][2]->p_sunday_attended}}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_friday_statement + $params['dashboard'][2]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_saturday_statement + $params['dashboard'][2]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->p_sunday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard'][2]->ml_sunday_statement + $params['dashboard'][2]->p_sunday_statement}}</td>
            </tr>
        </table>
    @endif   
    
    @if (isset($params['pagos']) && count($params['pagos']) > 0 )
        <table>
            <tr>
                <td></td>
                <th colspan="3" style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"><b>PAGOS</b></th>
            </tr>
            <tr>
                <th></th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Master Life</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Participante</th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->ml_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->p_declara }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->ml_declara + $params['pagos'][2]->p_declara }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->ml_fichas }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->P_ficha }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->ml_fichas + $params['pagos'][2]->P_ficha }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->ml_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos'][2]->p_pagos }}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985; color:red"><b>{{ $params['pagos'][2]->ml_pagos + $params['pagos'][2]->p_pagos }}</b></td>
            </tr>
        </table>
    @endif
    
    @if (isset($params['pagosDetails']) && count($params['pagosDetails']) > 0 && isset($params['pagos'][2]->training_id))
        <table>
            <tr>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Role</th>
                <th colspan="3" style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Enrolador</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
            </tr>
            @foreach($params['pagosDetails'] as $thePagosDetails)
                @if($thePagosDetails->training_id == $params['pagos'][2]->training_id)
                    <tr style="
                        @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) 
                            background-color: lightgreen; 
                        @elseif ($thePagosDetails->PAGOS === "0") 
                            background-color: lightpink; 
                        @endif
                    ">
                        <th style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->role }}</th>
                        <td colspan="3" style="font-size:12px; text-align:left; border: 1px solid #085985">{{ $thePagosDetails->enrolador }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->statement }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->fichas }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails->PAGOS }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif
    
    <!--
    @if (isset($params['dashboard_academy']) && count($params['dashboard_academy']) > 0)
        <table>
            <tr>
                <td colspan="2" style="text-align:left; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">Entrenadores en formación</td>
                <td colspan="3" style="text-align:center; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">Academia</td>
                <td colspan="2" style="text-align:rigth; font-size:16px; background-color: #085985; color: white; border: 0.5px solid white;">{{$params['dashboard_academy'][0]->participant_count}}</td>
            </tr>
            <tr>
                @if ($params['pagos_academy'][0]->p_pagos >= $params['pagos_academy'][0]->p_declara)
                    <td colspan="2" style="width:150px; color:red">VICTORIA</td>
                @else
                    <td colspan="2" style="width:150px"></td>
                @endif
                <td colspan="3" style="text-align:center; font-size:16px;">DIEGO CORONEL LÓPEZ</td>
                @if (isset($params['pagos_academy']) && count($params['pagos_academy']) > 0 && $params['dashboard_academy'][0]->p_sunday_attended > 0)
                    <td colspan="2" style="color:#840000">{{ number_format(($params['pagos_academy'][0]->p_pagos) / ($params['dashboard_academy'][0]->p_sunday_attended), 2) }}</td>
                @else
                    <td colspan="2"></td>
                @endif
            </tr>
            <tr>
                <th style="width:200px"></th>
                <th style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 1</th>
                <th style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 2</th>
                <th style="width:100px; text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Día 3</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Asistencia</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_friday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_saturday_attended}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_sunday_attended}}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_friday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_saturday_statement}}</td>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{$params['dashboard_academy'][0]->p_sunday_statement}}</td>
            </tr>
        </table>
    @endif   
    
    @if (isset($params['pagos_academy']) && count($params['pagos_academy']) > 0)
        <table>
            <tr>
                <td></td>
                <th style="text-align:center; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"><b>PAGOS</b></th>
            </tr>
            <tr>
                <th></th>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Total</th>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos_academy'][0]->p_declara }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Fichas</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $params['pagos_academy'][0]->P_ficha }}</td>
            </tr>
            <tr>
                <th style="background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
                <td style="font-size:12px; text-align:center; border: 1px solid #085985; color:red"><b>{{ $params['pagos_academy'][0]->p_pagos }}</b></td>
            </tr>
        </table>
    @endif
    
    @if (isset($params['pagosDetails_academy']) && count($params['pagosDetails_academy']) > 0)
        <table>
            <tr>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Role</th>
                <th colspan="3" style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Enrolador</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Declaración</th>
                <th style="padding:4px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">Pagos</th>
            </tr>
            @foreach($params['pagosDetails_academy'] as $thePagosDetails_academy)
                @if($thePagosDetails_academy->training_id == $params['pagosDetails_academy'][0]->training_id)
                    <tr
                        @if ($thePagosDetails_academy->PAGOS >= $thePagosDetails_academy->statement) style="background-color:lightgreen" @endif
                        @if ($thePagosDetails_academy->PAGOS === "0") style="background-color:lightpink" @endif
                    >
                        <th style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails_academy->role }}</th>
                        <td colspan="3" style="font-size:12px; text-align:left; border: 1px solid #085985">{{ $thePagosDetails_academy->enrolador }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails_academy->statement }}</td>
                        <td style="font-size:12px; text-align:center; border: 1px solid #085985">{{ $thePagosDetails_academy->PAGOS }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif
    -->
</body>
</html>
