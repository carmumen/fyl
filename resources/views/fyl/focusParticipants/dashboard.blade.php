<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<x-app-layout title="Dashboard Focus" meta-description="Dashboard Focus">

    <x-slot name="title">
        @lang('Dashboard Focus')
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


    <form id="life" method="GET" class="flex items-center space-x-2" action="{{ route('FocusDashboard.index') }}">
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
        
        @if(isset($gender) && count($gender) > 0 
        && isset($city) && count($city) > 0
        && isset($age_range) && count($age_range) > 0
        && isset($payments) && count($payments) > 0
        && isset($payments_staff) && count($payments_staff) > 0
        && isset($attendance) && count($attendance) > 0
        && isset($attendance_teams) && count($attendance_teams) > 0)
        
        <div class="p-1">
            <a class="{{ Config::get('style.btnSave') }}"
                href="{{ url('/exportar-tabla' . '/dashboard_focus' . '/' . $trainingId . '/D|') }}">
                Exportar</a>
        </div>
        
        @endif
        
    </form>

    <div style="max-width:600px; margin: 0; padding: 0;">
        @if (isset($gender) && count($gender) > 0)
        <div class="mt-2 mx-2 bg-red-50 border border-red-400 rounded-lg">
            <div class="container">
                <div class="box border border-gray-400" >
                    <table  class="w-full table">
                        <tr><th colspan="4">Datos Generales</th></tr>
                        <tr><th colspan="4">Participantes por Género</th></tr>
                        <tr class="titulo">
                            <th style="width:14%; font-size:12px" title="Pago">DÍA</th>
                            <th style="width:14%; font-size:12px">FEMENINO</th>
                            <th style="width:14%; font-size:12px">MASCULINO</th>
                            <th style="width:14%; font-size:12px">OTRO</th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $gender[0]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[0]->femenino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[0]->masculino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[0]->otro }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $gender[1]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[1]->femenino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[1]->masculino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[1]->otro }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $gender[2]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[2]->femenino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[2]->masculino }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $gender[2]->otro }}</td>
                        </tr>
                    </table>
                    
                    @if (isset($city) && count($city) > 0)
                    <table class="w-full table">
                        <tr><th colspan="3">Participantes por Ciudad</th></tr>
                        <tr class="titulo">
                            <th style="width:14%; font-size:12px" title="Pago">DÍA</th>
                            <th style="width:14%; font-size:12px">{{ $city[0]->campus }}</th>
                            <th style="width:14%; font-size:12px">OTRAS</th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $city[0]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[0]->ciudad }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[0]->otra }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $city[1]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[1]->ciudad }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[1]->otra }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $city[2]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[2]->ciudad }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $city[2]->otra }}</td>
                        </tr>
                    </table>
                    @endif
                    
                    @if (isset($age_range) && count($age_range) > 0)
                    <table class="w-full table">
                        <tr><th colspan="6">Participantes por Edad</th></tr>
                        <tr class="titulo">
                            <th style="width:14%; font-size:12px" title="Pago">DÍA</th>
                            <th style="width:14%; font-size:12px">Menor a 18</th>
                            <th style="width:14%; font-size:12px">18 a 27</th>
                            <th style="width:14%; font-size:12px">28 a 40</th>
                            <th style="width:14%; font-size:12px">41 a 65</th>
                            <th style="width:14%; font-size:12px">Mayor a 66</th>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $age_range[0]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[0]->menor18 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[0]->e18a27 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[0]->e28a40 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[0]->e41a65 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[0]->mayor66 }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $age_range[1]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->menor18 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->e18a27 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->e28a40 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->e41a65 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->mayor66 }}</td>
                        </tr>
                        <tr>
                            <th class="titulo" style="width:14%; font-size:12px">{{ $age_range[2]->dia }}</th>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[2]->menor18 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[2]->e18a27 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[2]->e28a40 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->e41a65 }}</td>
                            <td style="width:14%; text-align:center; font-size:12px">{{ $age_range[1]->mayor66 }}</td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        @endif
    
        <div class="mt-2 mx-2 bg-green-50 border border-green-400 rounded-lg">
            @if (isset($payments) && count($payments) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <div><b>Leyenda</b></div>
                    <div class="flex flex-wrap text-xs">
                        <div style="width:30px"><b style="color:red;">PA</b></div>
                        <div style="width:calc(100% - 30px)">Pago Anticipado</div>
                    </div>
                    <div class="flex flex-wrap text-xs">
                        <div style="width:30px"><b style="color:red;">PJ</b></div>
                        <div style="width:calc(100% - 30px)">Pago en Jornada</div>
                    </div>
                    <table class="w-full table">
                        <tr><th colspan="6">Resúmen de Pagos</th></tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:14%; font-size:12px" title="Pago">PA</th>
                            <th style="width:14%; font-size:12px">PJ</th>
                            <th style="width:14%; font-size:12px">Y</th>
                            <th style="width:14%; font-size:12px">YL</th>
                            <th style="width:14%; font-size:12px">Tot.</th>
                        </tr>
                        @foreach($payments as $thePaymentsDetails)
                                <tr>
                                    <th class="titulo" style="font-size:10px">{{ $thePaymentsDetails->status }}</th>
                                    <td style="text-align:center; font-size:14px">
                                        @if($thePaymentsDetails->status == "TOTAL PAGOS")
                                            <b>{{ $thePaymentsDetails->pago_anticipado }}</b>
                                        @else
                                            {{ $thePaymentsDetails->pago_anticipado }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($thePaymentsDetails->status == "TOTAL PAGOS")
                                            <b>{{ $thePaymentsDetails->pago }}</b>
                                        @else
                                            {{ $thePaymentsDetails->pago }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($thePaymentsDetails->status == "TOTAL PAGOS")
                                            <b>{{ $thePaymentsDetails->Y }}</b>
                                        @else
                                            {{ $thePaymentsDetails->Y }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($thePaymentsDetails->status == "TOTAL PAGOS")
                                            <b>{{ $thePaymentsDetails->YL }}</b>
                                        @else
                                            {{ $thePaymentsDetails->YL }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($thePaymentsDetails->status == "TOTAL PAGOS")
                                            <b style="color:red; font-size:16px">{{ $thePaymentsDetails->TOTAL }}</b>
                                        @else
                                            <b>{{ $thePaymentsDetails->TOTAL }}</b>
                                        @endif
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
            @if (isset($payments_staff) && count($payments_staff) > 0)
                
                    <div class="container">
                        <div class="box border border-gray-400" >
                            <div><b>Leyenda</b></div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:40%">
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:30px"><b style="color:red;">A</b></div>
                                        <div style="width:calc(100% - 30px)">Acuerdo</div>
                                    </div>
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:30px"><b style="color:red;">P</b></div>
                                        <div style="width:calc(100% - 30px)">Posibilidad</div>
                                    </div>
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:30px"><b style="color:red;">AY</b></div>
                                        <div style="width:calc(100% - 30px)">Abono YOUR</div>
                                    </div>
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:30px"><b style="color:red;">AYL</b></div>
                                        <div style="width:calc(100% - 30px)">Abono YOUR + LIFE</div>
                                    </div>
                                </div>
                                <div style="width:60%">
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:50px"><b style="color:red;">PTY</b></div>
                                        <div style="width:calc(100% - 50px)">Pago Total YOUR</div>
                                    </div>
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:50px"><b style="color:red;">PTYAL</b></div>
                                        <div style="width:calc(100% - 50px)">Pago Total YOUR + Abono LIFE</div>
                                    </div>
                                    <div class="flex flex-wrap text-xs">
                                        <div style="width:50px"><b style="color:red;">PTYL</b></div>
                                        <div style="width:calc(100% - 50px)">Pago Total YOUR + LIFE</div>
                                    </div>
                                </div>
                                    
                                    
                            <table class="w-full table">
                                <tr><th colspan="9">Resúmen de Pagos por Staff</th></tr>
                                <tr class="titulo">
                                    <th>STAFF</th>
                                    <th style="width:10%; font-size:12px">A</th>
                                    <th style="width:10%; font-size:12px">P</th>
                                    <th style="width:10%; font-size:12px">AY</th>
                                    <th style="width:10%; font-size:12px">AYL</th>
                                    <th style="width:10%; font-size:12px">PTY</th>
                                    <th style="width:10%; font-size:12px">PTYAL</th>
                                    <th style="width:10%; font-size:12px">PTYL</th>
                                    <th style="width:10%; font-size:12px">Pagos</th>
                                </tr>
                                @foreach($payments_staff as $thePayments_staff)
                                        <tr>
                                            <th class="titulo" style="font-size:10px">{{ $thePayments_staff->staff }}</th>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->ACUERDO }}</b>
                                                @else
                                                    {{ $thePayments_staff->ACUERDO }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->POSIBILIDAD }}</b>
                                                @else
                                                    {{ $thePayments_staff->POSIBILIDAD }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->A_Y }}</b>
                                                @else
                                                    {{ $thePayments_staff->A_Y }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->A_YL }}</b>
                                                @else
                                                    {{ $thePayments_staff->A_YL }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->PT_Y }}</b>
                                                @else
                                                    {{ $thePayments_staff->PT_Y }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->PTY_AL }}</b>
                                                @else
                                                    {{ $thePayments_staff->PTY_AL }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b>{{ $thePayments_staff->PT_YL }}</b>
                                                @else
                                                    {{ $thePayments_staff->PT_YL }}
                                                @endif
                                            </td>
                                            <td style="text-align:center; font-size:14px">
                                                @if($thePayments_staff->staff == "TOTAL")
                                                    <b style="color:red; font-size:16px">{{ $thePayments_staff->Pagos }}</b>
                                                @else
                                                    <b>{{ $thePayments_staff->Pagos }}</b>
                                                @endif
                                            </td>
                                        </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
            
    
    <div style="max-width:600px; margin: 0; padding: 0;">
        <div class="mt-2 mx-2 bg-yellow-50 border border-yellow-400 rounded-lg">
            @if (isset($attendance) && count($attendance) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr><th colspan="6">Asistencia General</th></tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%; font-size:12px">NO ASISTIÓ</th>
                            <th style="width:20%; font-size:12px">DESERTÓ</th>
                            <th style="width:20%; font-size:12px">ASISTIÓ</th>
                        </tr>
                        @foreach($attendance as $theAttendance)
                                <tr>
                                    <th class="titulo" style="font-size:10px">{{ $theAttendance->status }}</th>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance->status == "FOCUS")
                                            <b>{{ $theAttendance->NO_ASISTIÓ }}</b>
                                        @else
                                            {{ $theAttendance->NO_ASISTIÓ }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance->status == "FOCUS")
                                            <b>{{ $theAttendance->DESERTÓ }}</b>
                                        @else
                                            {{ $theAttendance->DESERTÓ }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance->status == "FOCUS")
                                            <b style="color:red; font-size:16px">{{ $theAttendance->ASISTIÓ }}</b>
                                        @else
                                            <b>{{ $theAttendance->ASISTIÓ }}</b>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
            @if (isset($attendance_teams) && count($attendance_teams) > 0)
            <div class="container">
                <div class="box border border-gray-400" >
                    <div><b>Leyenda</b></div>
                    <div class="flex flex-wrap text-xs">
                        <div style="width:30%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">C</b></div>
                                <div style="width:calc(100% - 30px)">Confirmaron</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">LL</b></div>
                                <div style="width:calc(100% - 30px)">LLegaron</div>
                            </div>
                        </div>
                        <div style="width:40%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">REC</b></div>
                                <div style="width:calc(100% - 30px)">Recuperados</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">REZ</b></div>
                                <div style="width:calc(100% - 30px)">Rezagados</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">JOR</b></div>
                                <div style="width:calc(100% - 30px)">De Jornada</div>
                            </div>
                        </div>
                        <div style="width:30%">
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">NA</b></div>
                                <div style="width:calc(100% - 30px)">No Asistió</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">D</b></div>
                                <div style="width:calc(100% - 30px)">Desertó</div>
                            </div>
                            <div class="flex flex-wrap text-xs">
                                <div style="width:30px"><b style="color:red;">A</b></div>
                                <div style="width:calc(100% - 30px)">Asistió</div>
                            </div>
                        </div>
                    </div>
                    
                    <table class="w-full table">
                        <tr><th colspan="9">Asistencia Por Equipos</th></tr>
                        <tr class="titulo">
                            <th>EQUIPO</th>
                            <th style="width:10%; font-size:12px">C</th>
                            <th style="width:10%; font-size:12px">LL</th>
                            <th style="width:10%; font-size:12px">REC</th>
                            <th style="width:10%; font-size:12px">REZ</th>
                            <th style="width:10%; font-size:12px">JOR</th>
                            <th style="width:10%; font-size:12px">NA</th>
                            <th style="width:10%; font-size:12px">D</th>
                            <th style="width:10%; font-size:12px">A</th>
                        </tr>
                        @foreach($attendance_teams as $theAttendance_teams)
                                <tr>
                                    <th class="titulo" style="font-size:10px">{{ $theAttendance_teams->team_name }}</th>
                                    <td style="text-align:center; font-size:14px" title="CONFIRMARON">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->CONFIRMARON }}</b>
                                        @else
                                            {{ $theAttendance_teams->CONFIRMARON }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->LLEGARON }}</b>
                                        @else
                                            {{ $theAttendance_teams->LLEGARON }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->RECUPERADO }}</b>
                                        @else
                                            {{ $theAttendance_teams->RECUPERADO }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->REZAGADO }}</b>
                                        @else
                                            {{ $theAttendance_teams->REZAGADO }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->JORNADA }}</b>
                                        @else
                                            {{ $theAttendance_teams->JORNADA }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->NO_ASISTIÓ }}</b>
                                        @else
                                            {{ $theAttendance_teams->NO_ASISTIÓ }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b>{{ $theAttendance_teams->DESERTÓ }}</b>
                                        @else
                                            {{ $theAttendance_teams->DESERTÓ }}
                                        @endif
                                    </td>
                                    <td style="text-align:center; font-size:14px">
                                        @if($theAttendance_teams->team_name == "TOTAL")
                                            <b style="color:red; font-size:12px">{{ $theAttendance_teams->ASISTIÓ }}</b>
                                        @else
                                            <b>{{ $theAttendance_teams->ASISTIÓ }}</b>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>   
    
    
    <script>
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('life').submit();
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
