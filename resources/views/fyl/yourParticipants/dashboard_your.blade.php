<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Focus</title>

</head>
<body>

    <h1>Dashboard {{ $params['titulo'] }}</h1>
        
    @if (isset($params['paseFocus']) && count($params['paseFocus']) > 0)
    <table>
        <tr><th colspan="2" style="text-align:center; font-size:16px; border: 1px solid #085985">RESUMEN FOCUS</th></tr>
        <tr>
            <th style="width:200px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">COACH</th>
            <th style="width:200px; font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">
                {{ $params['paseFocus'][0]->coach }}
            </th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX FINALIZAN FOCUS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['paseFocus'][0]->finalizan }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PAGOS YOUR</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['paseFocus'][0]->Y }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PAGOS YOUR + LIFE</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['paseFocus'][0]->YL }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">TOTAL PAGOS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['paseFocus'][0]->total }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">% PASE</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['paseFocus'][0]->pase." %" }}
            </td>
        </tr>
    </table>
    @endif
            
    @if (isset($params['seguimiento']) && count($params['seguimiento']) > 0)
    <table>
        <tr><th colspan="2" style="text-align:center; font-size:16px; border: 1px solid #085985">SEGUIMIENTO</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">VALORES</th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX JORNADA</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['seguimiento'][0]->J }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">% ASISTENCIA JORNADA</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                @if($params['paseFocus'][0]->total > 0)
                {{ round($params['seguimiento'][0]->J * 100 / $params['paseFocus'][0]->total, 2) }} %
                @endif
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX REZAGADOS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['seguimiento'][0]->Z }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX RECUPERADOS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['seguimiento'][0]->R }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX INICIALES</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['seguimiento'][0]->inician }}
            </td>
        </tr>
    </table>
    @endif
            
    @if (isset($params['inicial']) && count($params['inicial']) > 0)
    <table>
        <tr><th colspan="2" style="text-align:center; font-size:16px; border: 1px solid #085985">DATOS INICIALES YOUR</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">COACH</th>
            <th style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['inicial'][0]->coach }}
            </th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX INICIALES</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['inicial'][0]->iniciales }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PAGOS Y+L</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['inicial'][0]->YL }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">% PASE INICIAL</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['inicial'][0]->porcentaje." %" }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX POR MOVER</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['inicial'][0]->porMover }}
            </td>
        </tr>
    </table>
    @endif
            
    @if (isset($params['jornadaPagos']) && count($params['jornadaPagos']) > 0)
    <table>
        <tr><th colspan="4" style="text-align:center; font-size:16px; border: 1px solid #085985">JORNADA YOUR</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"></th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">VIERNES</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:200px">SÁBADO</th>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:200px">DOMINGO</th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX INICIALES</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->iniciales }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->iniciales - $params['jornadaPagos'][0]->deserto_viernes - $params['jornadaPagos'][0]->deserto_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->iniciales - $params['jornadaPagos'][0]->deserto_viernes - $params['jornadaPagos'][0]->deserto_sabado - $params['jornadaPagos'][0]->deserto_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">DESERCIÓN ACUMULADA</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_viernes. " + " . $params['jornadaPagos'][0]->deserto_sabado." = ". $params['jornadaPagos'][0]->deserto_viernes + $params['jornadaPagos'][0]->deserto_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_viernes. " + " . $params['jornadaPagos'][0]->deserto_sabado." + ".$params['jornadaPagos'][0]->deserto_domingo." = ". $params['jornadaPagos'][0]->deserto_viernes + $params['jornadaPagos'][0]->deserto_sabado + $params['jornadaPagos'][0]->deserto_domingo  }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">% DESERCIÓN</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_viernes_porcentual." %" }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_sabado_porcentual." %" }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->deserto_domingo_porcentual." %" }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX YOUR</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX Y+L</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_life_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_life_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_life_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;"><b>PX REAL</b></th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_viernes + $params['jornadaPagos'][0]->your_life_viernes  }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_sabado + $params['jornadaPagos'][0]->your_life_sabado - $params['jornadaPagos'][0]->deserto_viernes - $params['jornadaPagos'][0]->deserto_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->your_domingo + $params['jornadaPagos'][0]->your_life_domingo - $params['jornadaPagos'][0]->deserto_viernes - $params['jornadaPagos'][0]->deserto_sabado - $params['jornadaPagos'][0]->deserto_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">DECLARACIÓN</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; background-color: yellow">
                {{ $params['jornadaPagos'][0]->declaracion_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; background-color: pink">
                {{ $params['jornadaPagos'][0]->declaracion_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; background-color: #FF6FCC">
                {{ $params['jornadaPagos'][0]->declaracion_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PAGO</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->pago_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; background-color: yellow">
                {{ $params['jornadaPagos'][0]->pago_sabado }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; background-color: pink;">
                {{ $params['jornadaPagos'][0]->pago_domingo }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PAGO ACUMULADO</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->pago_viernes }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; ">
                @if($params['jornadaPagos'][0]->pago_sabado > 0 )
                    {{ $params['jornadaPagos'][0]->pago_viernes + $params['jornadaPagos'][0]->pago_sabado }}
                @else
                    {{ $params['jornadaPagos'][0]->pago_sabado }}
                @endif
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985; color: red;">
                <b>
                @if($params['jornadaPagos'][0]->pago_domingo > 0 )
                    {{ $params['jornadaPagos'][0]->pago_viernes + $params['jornadaPagos'][0]->pago_sabado + $params['jornadaPagos'][0]->pago_domingo }}
                @else
                    {{ $params['jornadaPagos'][0]->pago_domingo }}
                @endif
                </b>
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">%PASE</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->pase_viernes." %" }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->pase_sabado." %" }}
            </td>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['jornadaPagos'][0]->pase_domingo." %" }}
            </td>
        </tr>
    </table>
    @endif
            
    @if (isset($params['gestion']) && count($params['gestion']) > 0)
    <table>
        <tr><th colspan="2" style="text-align:center; font-size:16px; border: 1px solid #085985">GESTIÓN ENTRENADOR</th></tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">COACH</th>
            <th style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['gestion'][0]->coach }}
            </th>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX POR MOVER</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                @if (isset($params['inicial']) && count($params['inicial']) > 0)
                    {{ $params['inicial'][0]->porMover }}
                @endif
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX DESERCIÓN POR MOVER</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['gestion'][0]->desercion }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PX PAGOS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                {{ $params['gestion'][0]->pago }}
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">% EFECTIVIDAD MOVIDOS</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                @if (isset($params['inicial']) && count($params['inicial']) > 0 && $params['inicial'][0]->porMover > 0)
                    {{ round($params['gestion'][0]->pago * 100 / $params['inicial'][0]->porMover,2)." %" }}
                @endif
            </td>
        </tr>
        <tr>
            <th style="font-size:12px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">%DESERCION POR MOVER</th>
            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                @if (isset($params['inicial']) && count($params['inicial']) > 0 && $params['inicial'][0]->porMover > 0)
                    {{ round($params['gestion'][0]->desercion * 100 / $params['inicial'][0]->porMover,2)." %" }}
                @endif
            </td>
        </tr>
    </table>
    @endif 
    
    @if (isset($params['jornadaPagos']) && count($params['jornadaPagos']) > 0) 
    <table>
        <tr><th colspan="14" style="text-align:center; font-size:16px; border: 1px solid #085985">DETALLE JORNADA</th></tr>
        <tr>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">STAFF</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center;">PARTICIPANTE</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; ">Origen</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; ">Deserción<br>Viernes</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Pago<br>Anticipado</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Pago<br>Viernes</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Declaración<br>Viernes</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Pago<br>Sábado</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Deserción<br>Sábado</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Declaración<br>Sábado</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Pago<br>Domingo Mañana</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Deserción<br>Domingo</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Declaración<br>Domingo</th>
            <th style="text-align:center; font-size:11px; background-color: #085985; color: white; border: 0.5px solid white; text-align:center; width:130px">Pago<br>Domingo Tarde</th>
        </tr>
        @foreach($params['jornada'] as $theJornada)
        <tr
             @if($theJornada->pago_viernes == 1 || $theJornada->pago_anticipado == 1 || $theJornada->PSP == 1)
                style="background-color: lightgreen;"
            @endif
        >
            <td style="text-align:center; font-size:8px; border: 1px solid #085985">
                {{ $theJornada->staff }}
            </td>
            <td style="text-align:center; font-size:8px; border: 1px solid #085985">
                {{ $theJornada->participant }}
            </td>
            <td style="text-align:center; font-size:10px; border: 1px solid #085985">
                <b>
                {{ $theJornada->record_mode }}
                </b>
            </td>
            
            @if($theJornada->deserto_viernes == 1)
            <td style="text-align:center; font-size:12px; background-color: red; color:white; font-weight:bold;"> 
                {{ "-".$theJornada->deserto_viernes }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->deserto_viernes }}
            </td>
            @endif
            
            @if($theJornada->pago_anticipado == 1 || $theJornada->PSP == 1)
            <td style="text-align:center; font-size:12px; background-color: blue; color:white; font-weight:bold;"> 
                {{ $theJornada->pago_anticipado }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->pago_anticipado }}
            </td>
            @endif
            
            @if($theJornada->pago_viernes == 1)
            <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                {{ "+".$theJornada->pago_viernes }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->pago_viernes }}
            </td>
            @endif
            
            @if($theJornada->declaracion_viernes == 1)
            <td style="text-align:center; font-size:12px; border: 1px solid #085985 background-color: yellow; font-weight:bold;"> 
                {{ $theJornada->declaracion_viernes }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->declaracion_viernes }}
            </td>
            @endif
            
            @if($theJornada->pago_sabado == 1)
            <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                {{ "+".$theJornada->pago_sabado }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->pago_sabado }}
            </td>
            @endif
            
            @if($theJornada->deserto_sabado == 1)
            <td title="Desercion Sabado" style="text-align:center; font-size:10px; background-color: red; color:white; font-weight:bold;"> 
                {{ "-".$theJornada->deserto_sabado }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->deserto_sabado }}
            </td>
            @endif
            
            @if($theJornada->declaracion_sabado == 1)
            <td style="text-align:center; font-size:12px; background-color: pink; font-weight:bold;"> 
                {{ $theJornada->declaracion_sabado }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->declaracion_sabado }}
            </td>
            @endif
            
            @if($theJornada->pago_domingoAM == 1)
            <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                {{ "+".$theJornada->pago_domingoAM }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->pago_domingoAM }}
            </td>
            @endif
            
            @if($theJornada->deserto_domingo == 1)
            <td title="Desercion Sabado" style="text-align:center; font-size:10px; background-color: red; color:white; font-weight:bold;"> 
                {{ "-".$theJornada->deserto_domingo }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->deserto_domingo }}
            </td>
            @endif
            
            @if($theJornada->declaracion_domingo == 1)
            <td style="text-align:center; font-size:12px; background-color: yellow; font-weight:bold;"> 
                {{ $theJornada->declaracion_domingo }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->declaracion_domingo }}
            </td>
            @endif
            
            @if($theJornada->pago_domingoPM == 1)
            <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                {{ "+".$theJornada->pago_domingoPM }}
            </td>
            @else
            <td style="text-align:center; font-size:12px; border: 1px solid #085985">
                {{ $theJornada->pago_domingoPM }}
            </td>
            @endif
        </tr>
        @endforeach
    </table>
    @endif 
        
        @if (isset($params['attendance']) && count($params['attendance']) > 0)
                    <table>
                        <tr><th colspan="5" style="text-align:center; font-size:16px; border: 1px solid #085985">ASISTENCIA</th></tr>
                        <tr>
                            <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">CONFIRMARON</th>
                            <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">NO ASISTIÓ</th>
                            <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">LLEGARON</th>
                            <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">DESERTÓ</th>
                            <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">ASISTIÓ</th>
                        </tr>
                        @foreach($params['attendance'] as $theAttendance)
                        <tr>
                            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                {{ $theAttendance->confirmaron }}
                            </td>
                            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                {{ $theAttendance->no_asistio }}
                            </td>
                            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                {{ $theAttendance->llegaron }}
                            </td>
                            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                {{ $theAttendance->deserto }}
                            </td>
                            <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                <b style="color:red">{{ $theAttendance->asistio }}</b>
                            </td>
                        </tr>
                        @endforeach
                    </table>
        @endif
        
        @if (isset($params['statement']) && count($params['statement']) > 0)
                <table>
                    <tr><th colspan="5" style="text-align:center; font-size:16px; border: 1px solid #085985">DECLARACIÓN</th></tr>
                    <tr>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">SIN DECLARACIÓN</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">VIERNES</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">SÁBADO</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">DOMINGO</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">TOTAL</th>
                    </tr>
                    @foreach($params['statement'] as $theStatement)
                            <tr>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    {{ $theStatement->sd }}
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    {{ $theStatement->viernes }}
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    {{ $theStatement->sabado }}
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    {{ $theStatement->domingo }}
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    <b style="color:red">{{ $theStatement->viernes + $theStatement->sabado + $theStatement->domingo }}</b>
                                </td>
                            </tr>
                    @endforeach
                </table>
        @endif
        
        @if (isset($params['payments']) && count($params['payments']) > 0)
                <table>
                    <tr><th colspan="3" style="text-align:center; font-size:16px; border: 1px solid #085985">PAGOS</th></tr>
                    <tr>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">SÁBADO</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">DOMINGO</th>
                        <th style="text-align:center; font-size:12px; background-color: #085985; color:white; font-weight:bold;">POSTERIOR A YOUR</th>
                    </tr>
                    @foreach($params['payments'] as $thePayments)
                            <tr>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    <b style="color:red">{{ $thePayments->SABADO }}</b>
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    <b style="color:red">{{ $thePayments->DOMINGO }}</b>
                                </td>
                                <td style="text-align:center; font-size:14px; border: 1px solid #085985">
                                    <b style="color:red">{{ $thePayments->DESPUES }}</b>
                                </td>
                            </tr>
                    @endforeach
                </table>
        @endif
    
</body>
</html>
