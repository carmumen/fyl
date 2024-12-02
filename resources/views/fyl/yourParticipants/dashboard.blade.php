<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<x-app-layout title="Dashboard Your" meta-description="Dashboard Your">

    <x-slot name="title">
        @lang('Dashboard Your')
    </x-slot>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .table tr th {
            border: 0.5px solid white;
            padding:4px;
        }
        
        .table tr:hover td {
          background-color: #f2f2f2; /* Cambia este color al que desees */
        }

        .table tr td{
            border: 0.5px solid grey;
            padding:4px;
        }

        .table tr td{
            border: 0.5px solid grey;
            padding:4px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
        }

        .box {
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
        }
        
        .titulo{
            background-color: #085985;
            color: white;
        }
        
        .tituloPago{
            background-color: #10B981;
            color: white;
        }
        
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }

        @media (min-width: 764px) {
            .box1 {
                width: calc(33.33% - 5px);
                /* Un tercio del ancho menos el espacio entre las cajas */
            }
        }
        
        @keyframes parpadeo {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .parpadear {
            animation: parpadeo 1s infinite;
        }
Ï
    </style>

    <form id="your" method="GET" class="flex items-center space-x-2" action="{{ route('YourDashboard.index') }}">
        @csrf
        <select class="{{ Config::get('style.cajaTexto') }} contenedor-select" name="training_id" id="training_id"
            required>
            <option value="">--Seleccione--</option>
            @foreach ($training as $id => $name)
                <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                    {{ __($name) }}
                </option>
            @endforeach
        </select>
        
        @if(isset($payments) && count($payments) > 0 
        && isset($statement) && count($statement) > 0
        && isset($attendance) && count($attendance) > 0
        && isset($paseFocus) && count($paseFocus) > 0
        && isset($seguimiento) && count($seguimiento) > 0
        && isset($inicial) && count($inicial) > 0
        && isset($sabado) && count($sabado) > 0
        && isset($domingo) && count($domingo) > 0
        && isset($gestion) && count($gestion) > 0
        && isset($jornada) && count($jornada) > 0
        && isset($sabado) && count($sabado) > 0
        && isset($jornadaPagos) && count($jornadaPagos) > 0)
        
        <div class="p-1">
            <a class="{{ Config::get('style.btnSave') }}"
                href="{{ url('/exportar-tabla' . '/dashboard_your' . '/' . $trainingId . '/D|') }}">
                Exportar</a>
        </div>
        
        @endif
        
    </form>

    <div style="max-width:600px; margin: 0; padding: 0;">
        
            @if (isset($paseFocus) && count($paseFocus) > 0)
            <div class="mt-2 mx-2 bg-red-50 border border-red-400 rounded-lg">
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="2">RESUMEN FOCUS</th></tr>
                        <tr class="titulo">
                            <th style="width:40%; font-size:12px">COACH</th>
                            <th style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->coach }}
                            </th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX FINALIZAN FOCUS</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->finalizan }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PAGOS YOUR</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->Y }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PAGOS YOUR + LIFE</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->YL }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">TOTAL PAGOS</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->total }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">% PASE</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $paseFocus[0]->pase." %" }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (isset($seguimiento) && count($seguimiento) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="2">SEGUIMIENTO</th></tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:14px">PX</th>
                            <th class="titulo" style="font-size:14px">VALORES</th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX JORNADA</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $seguimiento[0]->J }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">% ASISTENCIA JORNADA</th>
                            <td style="text-align:center; font-size:14px">
                                @if($paseFocus[0]->total > 0)
                                {{ round($seguimiento[0]->J * 100 / $paseFocus[0]->total, 2) }} %
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX REZAGADOS</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $seguimiento[0]->Z }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX RECUPERADOS</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $seguimiento[0]->R }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX INICIALES</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $seguimiento[0]->inician }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            </div>
            @endif
            
            
            
            @if (isset($inicial) && count($inicial) > 0)
            <div class="mt-2 mx-2 bg-green-50 border border-green-400 rounded-lg">
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="2">DATOS INICIALES YOUR</th></tr>
                        <tr class="titulo">
                            <th style="width:40%; font-size:12px">COACH</th>
                            <th style="text-align:center; font-size:14px">
                                {{ $inicial[0]->coach }}
                            </th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX INICIALES</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $inicial[0]->iniciales }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PAGOS Y+L</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $inicial[0]->YL }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">% PASE INICIAL</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $inicial[0]->porcentaje." %" }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX POR MOVER</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $inicial[0]->porMover }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if (isset($jornadaPagos) && count($jornadaPagos) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="4">JORNADA YOUR</th></tr>
                        
                        <tr class="titulo">
                            <th></th>
                            <th>VIERNES</th>
                            <th>SÁBADO</th>
                            <th>DOMINGO</th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">PX INICIALES</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->iniciales }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->iniciales - $jornadaPagos[0]->deserto_viernes - $jornadaPagos[0]->deserto_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->iniciales - $jornadaPagos[0]->deserto_viernes - $jornadaPagos[0]->deserto_sabado - $jornadaPagos[0]->deserto_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">DESERCIÓN ACUMULADA</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_viernes. " + " . $jornadaPagos[0]->deserto_sabado." = ". $jornadaPagos[0]->deserto_viernes + $jornadaPagos[0]->deserto_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_viernes. " + " . $jornadaPagos[0]->deserto_sabado." + ".$jornadaPagos[0]->deserto_domingo." = ". $jornadaPagos[0]->deserto_viernes + $jornadaPagos[0]->deserto_sabado + $jornadaPagos[0]->deserto_domingo  }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">% DESERCIÓN</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_viernes_porcentual." %" }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_sabado_porcentual." %" }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->deserto_domingo_porcentual." %" }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">PX YOUR</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">PX Y+L</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_life_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_life_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_life_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px"><b>PX REAL</b></th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_viernes + $jornadaPagos[0]->your_life_viernes  }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_sabado + $jornadaPagos[0]->your_life_sabado - $jornadaPagos[0]->deserto_viernes - $jornadaPagos[0]->deserto_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->your_domingo + $jornadaPagos[0]->your_life_domingo - $jornadaPagos[0]->deserto_viernes - $jornadaPagos[0]->deserto_sabado - $jornadaPagos[0]->deserto_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">DECLARACIÓN</th>
                            <td style="text-align:center; font-size:14px; background-color: yellow">
                                {{ $jornadaPagos[0]->declaracion_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px; background-color: pink">
                                {{ $jornadaPagos[0]->declaracion_sabado }}
                            </td>
                            <td style="text-align:center; font-size:14px; background-color: #FF6FCC">
                                {{ $jornadaPagos[0]->declaracion_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">PAGO</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->pago_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px; background-color: yellow">
                                {{ $jornadaPagos[0]->pago_sabado }}
                            </td>
                            <td style="text-align:center; font-size:16px; background-color: pink;">
                                {{ $jornadaPagos[0]->pago_domingo }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">PAGO ACUMULADO</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->pago_viernes }}
                            </td>
                            <td style="text-align:center; font-size:14px; ">
                                @if($jornadaPagos[0]->pago_sabado > 0 )
                                    {{ $jornadaPagos[0]->pago_viernes + $jornadaPagos[0]->pago_sabado }}
                                @else
                                    {{ $jornadaPagos[0]->pago_sabado }}
                                @endif
                            </td>
                            <td style="text-align:center; font-size:16px; color: red;">
                                <b>
                                @if($jornadaPagos[0]->pago_domingo > 0 )
                                    {{ $jornadaPagos[0]->pago_viernes + $jornadaPagos[0]->pago_sabado + $jornadaPagos[0]->pago_domingo }}
                                @else
                                    {{ $jornadaPagos[0]->pago_domingo }}
                                @endif
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:20%; font-size:12px">%PASE</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->pase_viernes." %" }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->pase_sabado." %" }}
                            </td>
                            <td style="text-align:center; font-size:14px">
                                {{ $jornadaPagos[0]->pase_domingo." %" }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            
            @if (isset($gestion) && count($gestion) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="2">GESTIÓN ENTRENADOR</th></tr>
                        <tr class="titulo">
                            <th style="width:40%; font-size:12px">COACH</th>
                            <th style="text-align:center; font-size:14px">
                                {{ $gestion[0]->coach }}
                            </th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX POR MOVER</th>
                            <td style="text-align:center; font-size:14px">
                                @if (isset($inicial) && count($inicial) > 0)
                                    {{ $inicial[0]->porMover }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX DESERCIÓN POR MOVER</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $gestion[0]->desercion }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">PX PAGOS</th>
                            <td style="text-align:center; font-size:14px">
                                {{ $gestion[0]->pago }}
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">% EFECTIVIDAD MOVIDOS</th>
                            <td style="text-align:center; font-size:14px">
                                @if (isset($inicial) && count($inicial) > 0 && $inicial[0]->porMover > 0)
                                    {{ round($gestion[0]->pago * 100 / $inicial[0]->porMover,2)." %" }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:40%; font-size:12px">%DESERCION POR MOVER</th>
                            <td style="text-align:center; font-size:14px">
                                @if (isset($inicial) && count($inicial) > 0 && $inicial[0]->porMover > 0)
                                    {{ round($gestion[0]->desercion * 100 / $inicial[0]->porMover,2)." %" }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            </div>
            @endif
            
            
        </div>
    </div>
    
            
    
    <div style="max-width:600px; margin: 0; padding: 0; ">
        @if (isset($jornadaPagos) && count($jornadaPagos) > 0) 
        <div class="mt-2 mx-2 bg-yellow-50 border border-yellow-400 rounded-lg">  
        <div class="container">
            <div class="box border border-gray-400" >
                <div><b>Leyenda</b></div>
                <div class="flex flex-wrap text-xs">
                        <div style="width:25%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:20px"><b style="color:red; font-size:18px">+</b></div>
                                <div style="width:calc(100% - 20px)">Declaración</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:20px"><b style="color:red; font-size:18px">-</b></div>
                                <div style="width:calc(100% - 20px)">Deserción</div>
                            </div>
                        </div>
                        <div style="width:35%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:25px"><b style="color:red;">P A</b></div>
                                <div style="width:calc(100% - 25px)">Pago Anticipado</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:25px"><b style="color:red;">P V</b></div>
                                <div style="width:calc(100% - 25px)">Pago Viernes</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:25px"><b style="color:red;">P S</b></div>
                                <div style="width:calc(100% - 25px)">Pago Sábado</div>
                            </div>
                        </div>
                        <div style="width:40%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">P DM</b></div>
                                <div style="width:calc(100% - 30px)">Pago Domingo Mañana</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">P DT</b></div>
                                <div style="width:calc(100% - 30px)">Pago Domingo Tarde</div>
                            </div>
                        </div>
                        
                    
                    <table class="table" style="width:100%">
                        <tr><th colspan="12">DETALLE JORNADA</th></tr>
                        <tr class="titulo">
                            <th style="text-align:center; font-size:11px; width: 50px">STAFF</th>
                            <th style="text-align:center; font-size:11px; width: 50px">PX</th>
                            <th style="text-align:center; font-size:11px; ">O</th>
                            <th style="text-align:center; font-size:11px; ">- V</th>
                            <th style="text-align:center; font-size:11px; ">P A</th>
                            <th style="text-align:center; font-size:11px; ">P V</th>
                            <th style="text-align:center; font-size:11px; ">+ V</th>
                            <th style="text-align:center; font-size:11px; ">P S</th>
                            <th style="text-align:center; font-size:11px; ">- S</th>
                            <th style="text-align:center; font-size:11px; ">+ S</th>
                            <th style="text-align:center; font-size:11px; ">P DM</th>
                            <th style="text-align:center; font-size:11px; ">- D</th>
                            <th style="text-align:center; font-size:11px; ">+ D</th>
                            <th style="text-align:center; font-size:11px; ">P DT</th>
                        </tr>
                        @foreach($jornada as $theJornada)
                                <tr
                                     @if($theJornada->pago_viernes == 1 || $theJornada->pago_anticipado == 1 || $theJornada->PSP == 1)
                                        style="background-color: lightgreen;"
                                    @endif
                                >
                                    <td style="text-align:center; font-size:8px">
                                        {{ $theJornada->staff }}
                                    </td>
                                    <td style="text-align:center; font-size:8px">
                                        {{ $theJornada->participant }}
                                    </td>
                                    <td style="text-align:center; font-size:10px">
                                        <b>
                                        {{ $theJornada->record_mode }}
                                        </b>
                                    </td>
                                    
                                    @if($theJornada->deserto_viernes == 1)
                                    <td style="text-align:center; font-size:12px; background-color: red; color:white; font-weight:bold;"> 
                                        {{ "-".$theJornada->deserto_viernes }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->deserto_viernes }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->pago_anticipado == 1 || $theJornada->PSP == 1)
                                    <td style="text-align:center; font-size:12px; background-color: blue; color:white; font-weight:bold;"> 
                                        {{ $theJornada->pago_anticipado }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->pago_anticipado }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->pago_viernes == 1)
                                    <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                                        {{ "+".$theJornada->pago_viernes }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->pago_viernes }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->declaracion_viernes == 1)
                                    <td style="text-align:center; font-size:12px; background-color: yellow; font-weight:bold;"> 
                                        {{ $theJornada->declaracion_viernes }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->declaracion_viernes }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->pago_sabado == 1)
                                    <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                                        {{ "+".$theJornada->pago_sabado }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->pago_sabado }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->deserto_sabado == 1)
                                    <td title="Desercion Sabado" style="text-align:center; font-size:10px; background-color: red; color:white; font-weight:bold;"> 
                                        {{ "-".$theJornada->deserto_sabado }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->deserto_sabado }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->declaracion_sabado == 1)
                                    <td style="text-align:center; font-size:12px; background-color: pink; font-weight:bold;"> 
                                        {{ $theJornada->declaracion_sabado }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->declaracion_sabado }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->pago_domingoAM == 1)
                                    <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                                        {{ "+".$theJornada->pago_domingoAM }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->pago_domingoAM }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->deserto_domingo == 1)
                                    <td title="Desercion Sabado" style="text-align:center; font-size:10px; background-color: red; color:white; font-weight:bold;"> 
                                        {{ "-".$theJornada->deserto_domingo }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->deserto_domingo }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->declaracion_domingo == 1)
                                    <td style="text-align:center; font-size:12px; background-color: yellow; font-weight:bold;"> 
                                        {{ $theJornada->declaracion_domingo }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->declaracion_domingo }}
                                    </td>
                                    @endif
                                    
                                    @if($theJornada->pago_domingoPM == 1)
                                    <td style="text-align:center; font-size:12px; background-color: green; color:white; font-weight:bold;"> 
                                        {{ "+".$theJornada->pago_domingoPM }}
                                    </td>
                                    @else
                                    <td style="text-align:center; font-size:12px;">
                                        {{ $theJornada->pago_domingoPM }}
                                    </td>
                                    @endif
                                </tr>
                        @endforeach
                    </table>
                        
                   
                </div>
            </div>
        </div>
        </div>
        @endif    
    </div>   
    
    <div style="max-width:600px; margin: 0; padding: 0;">
            @if (isset($attendance) && count($attendance) > 0)
            <div class="mt-2 mx-2 bg-green-50 border border-green-400 rounded-lg">
                <div style="display: flex; justify-content: center;padding:10px"><b style="font-size:18px;">RESUMEN YOUR</b></div>
                <div class="container">
                    <div class="box border border-gray-400" >
                        <table class="w-full table">
                            <tr><th colspan="6">ASISTENCIA</th></tr>
                            <tr class="titulo">
                                <th style="width:20%; font-size:12px">CONFIRMARON</th>
                                <th style="width:20%; font-size:12px">NO ASISTIÓ</th>
                                <th style="width:20%; font-size:12px">LLEGARON</th>
                                <th style="width:20%; font-size:12px">DESERTÓ</th>
                                <th style="width:20%; font-size:12px">ASISTIÓ</th>
                            </tr>
                            @foreach($attendance as $theAttendance)
                            <tr>
                                <td style="text-align:center; font-size:14px">
                                    {{ $theAttendance->confirmaron }}
                                </td>
                                <td style="text-align:center; font-size:14px">
                                    {{ $theAttendance->no_asistio }}
                                </td>
                                <td style="text-align:center; font-size:14px">
                                    {{ $theAttendance->llegaron }}
                                </td>
                                <td style="text-align:center; font-size:14px">
                                    {{ $theAttendance->deserto }}
                                </td>
                                <td style="text-align:center; font-size:14px">
                                    <b style="color:red">{{ $theAttendance->asistio }}</b>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @if (isset($statement) && count($statement) > 0)
                <div class="container">
                    <div class="box border border-gray-400" >
                       
                        <div class="flex flex-wrap text-xs">
                        <table class="w-full table">
                            <tr><th colspan="9">DECLARACIÓN</th></tr>
                            <tr class="titulo">
                                <th style="width:10%; font-size:12px">SIN DECLARACIÓN</th>
                                <th style="width:10%; font-size:12px">VIERNES</th>
                                <th style="width:10%; font-size:12px">SÁBADO</th>
                                <th style="width:10%; font-size:12px">DOMINGO</th>
                                <th style="width:10%; font-size:12px">TOTAL</th>
                            </tr>
                            @foreach($statement as $theStatement)
                                    <tr>
                                        <td style="text-align:center; font-size:14px">
                                            {{ $theStatement->sd }}
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            {{ $theStatement->viernes }}
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            {{ $theStatement->sabado }}
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            {{ $theStatement->domingo }}
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            <b style="color:red">{{ $theStatement->viernes + $theStatement->sabado + $theStatement->domingo }}</b>
                                        </td>
                                    </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
                @endif
                @if (isset($payments) && count($payments) > 0)
                <div class="container">
                    <div class="box border border-gray-400" >
                        <table class="w-full table">
                            <tr><th colspan="6">PAGOS</th></tr>
                            <tr class="titulo">
                                <th style="width:16%; font-size:12px">SÁBADO</th>
                                <th style="width:16%; font-size:12px">DOMINGO</th>
                                <th style="width:17%; font-size:12px">POSTERIOR A YOUR</th>
                            </tr>
                            @foreach($payments as $thePayments)
                                    <tr>
                                        <td style="text-align:center; font-size:14px">
                                            <b style="color:red">{{ $thePayments->SABADO }}</b>
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            <b style="color:red">{{ $thePayments->DOMINGO }}</b>
                                        </td>
                                        <td style="text-align:center; font-size:14px">
                                            <b style="color:red">{{ $thePayments->DESPUES }}</b>
                                        </td>
                                    </tr>
                            @endforeach
                        </table>
                        @if (isset($confirm) && count($confirm) > 0)
                            <div><b>Compromisos</b></div>
                            @foreach($confirm as $theConfirm)
                                <div class="flex flex-wrap text-xs px-5">
                                    <div style="width:90px"><b style="color:red;">{{ $theConfirm->confirm }}</b></div>
                                    <div style="width:calc(100% - 90px)"><b>{{ $theConfirm->cantidad }}</b></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endif
            
        </div>
    </div>
    
    <div style="height:100px"></div>
    <script>
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('your').submit();
        });
        $(document).ready(function() {
            setInterval(reloadPageWithScrollPosition, 100000);
        });

        function reloadPageWithScrollPosition() {
            var scrollPosition = window.scrollY || window.pageYOffset;

            location.reload();

            window.scrollTo(0, scrollPosition);
        }
        function ver(valor)
        {
            var ele = document.getElementById(valor);
            if(ele.style.display == 'none' ) 
            {
                ele.style.display = 'block';
                //var currentPosition = window.scrollY;
                var currentPosition = document.documentElement.scrollTop || window.scrollY || document.body.scrollTop;
                console.log(currentPosition)
                window.scrollTo(0, currentPosition + 700);
            }
            else 
                ele.style.display = 'none';
        }
            
    </script>

</x-app-layout>
