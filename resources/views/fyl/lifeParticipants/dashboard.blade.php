<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<x-app-layout title="Dashboard Life" meta-description="Dashboard Life">

    <x-slot name="title">
        @lang('Dashboard Life')
    </x-slot>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .table tr th td{
            border: 0.5px solid grey;
            padding:4px;
        }

        .table tr td{
            border: 0.5px solid grey;
            padding:4px;
        }
        
        .table tr:hover td {
          background-color: #f2f2f2; /* Cambia este color al que desees */
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
            .box {
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
    <div class="flex justify-start">
        <form id="life" method="GET" class="flex items-center space-x-2" action="{{ route('LifeDashboard.index') }}">
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
        </form>
        
        @php
            $hasDashboard = isset($dashboard) && count($dashboard) > 0;
            $hasPagos = isset($pagos) && count($pagos) > 0;
            $hasPagosDetails = isset($pagosDetails) && count($pagosDetails) > 0;
            $hasCoach = isset($coach) && count($coach) > 0;
        @endphp
                    
        @if ($hasDashboard && $hasPagos && $hasPagosDetails && $hasCoach)
        
        <div class="p-1">
            <a class="{{ Config::get('style.btnSave') }}"
                href="{{ url('/exportar-tabla' . '/dashboard_life' . '/' . $trainingId . '/D|') }}">
                Exportar</a>
        </div>
        
        @endif            
       
        
        @if(isset($pagoMedios) && $pagoMedios !== 0)
            <div style="margin-left: 5rem">
                <span style="color: #FF7560">Pagos realizados mediante <b>Pago Medios {{ $pagoMedios }}</b></span>
            </div>
        @endif
    
    </div>
    
    


    @if (isset($dashboard) && count($dashboard) > 0)
        @php
            $primero = count($dashboard) - count($dashboard) + 1
        @endphp
        <div class="mt-2 mx-2 bg-yellow-50 border border-yellow-400 rounded-lg">
            <div class="container">
                <span class="w-1/3">{{$dashboard[0]->name}}
                    @if (isset($pagos) && count($pagos) > 0)
                        @if (($pagos[0]->ml_pagos + $pagos[0]->p_pagos >= $pagos[0]->ml_declara + $pagos[0]->p_declara) && ($pagos[0]->ml_pagos + $pagos[0]->p_pagos) > 0)
                            <br>
                            <span class="parpadear text-red-800">
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                    VICTORIA
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                            </span>
                        @endif
                    @endif
                </span>
                <span class="w-1/3" style="text-align:center">FDS 1<br>{{$coach[0]->COACH}}</span>
                <span class="w-1/3 text-right">{{$dashboard[0]->participant_count}}
                    @if (isset($pagos) && count($pagos) > 0 && $dashboard[0]->p_sunday_attended > 0)
                        <br>
                        <span class="text-red-800">{{ number_format(($pagos[0]->ml_pagos + $pagos[0]->p_pagos) / ($dashboard[0]->ml_sunday_attended + $dashboard[0]->p_sunday_attended), 2) }}</span>
                    @endif
                </span>
            </div>
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 1</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_friday_attended + $dashboard[0]->p_friday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_friday_statement + $dashboard[0]->p_friday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 2</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_saturday_attended + $dashboard[0]->p_saturday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_saturday_statement + $dashboard[0]->p_saturday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 3</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_sunday_attended + $dashboard[0]->p_sunday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[0]->ml_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->p_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[0]->ml_sunday_statement + $dashboard[0]->p_sunday_statement}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (isset($pagos) && count($pagos) > 0)
            <div class="container">
                <table class="w-full table">
                    <tr>
                        <th colspan="4"><b>PAGOS</b></th>
                    </tr>
                    <tr class="tituloPago">
                        <th></th>
                        <th style="width:20%">ML</th>
                        <th style="width:20%">Px</th>
                        <th style="width:20%">Tot.</th>
                    </tr>
                    <tr>
                        <th class="tituloPago">Declaración</th>
                        <td style="text-align:center">{{ $pagos[0]->ml_declara }}</td>
                        <td style="text-align:center">{{ $pagos[0]->p_declara }}</td>
                        <td style="text-align:center">{{ $pagos[0]->ml_declara + $pagos[0]->p_declara }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Fichas</th>
                        <td style="text-align:center">{{ $pagos[0]->ml_fichas }}</td>
                        <td style="text-align:center">{{ $pagos[0]->P_ficha }}</td>
                        <td style="text-align:center">{{ $pagos[0]->ml_fichas + $pagos[0]->P_ficha }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Pagos</th>
                        <td style="text-align:center">{{ $pagos[0]->ml_pagos }}</td>
                        <td style="text-align:center">{{ $pagos[0]->p_pagos }}</td>
                        <td style="text-align:center; font-size:22px; color:red"><b>{{ $pagos[0]->ml_pagos + $pagos[0]->p_pagos }}</b></td>
                    </tr>
                </table>
            </div>
            @endif
            
            @if (isset($pagosDetails) && count($pagosDetails) > 0)
            
            <button class="{{ Config::get('style.btnEdit') }} mb-4" onclick="ver(0)">
                <span class="icon-eye">Ver detalle</span>
            </button>
            
            <div class="container" id="0" style="display:none">
                <table class="w-full table">
                    <tr class="titulo">
                        <th style="padding:4px">Role</th>
                        <th style="padding:4px">Enrolador</th>
                        <th style="padding:4px">Declaración</th>
                        <th style="padding:4px">Fichas</th>
                        <th style="padding:4px">Pagos</th>
                    </tr>
                    @foreach($pagosDetails as $thePagosDetails)
                        @if($thePagosDetails->training_id == $pagos[0]->training_id)
                            <tr
                                @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) style="background-color:lightgreen" @endif
                                @if ($thePagosDetails->PAGOS === "0") style="background-color:lightpink" @endif
                            >
                                <th class="titulo" style="font-size:10px">{{ $thePagosDetails->role }}</th>
                                <td style="text-align:center; font-size:10px">{{ $thePagosDetails->enrolador }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->statement }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->fichas }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->PAGOS }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
            @endif
            
        </div>
        
    @if(isset($dashboard[1]->name))

        <div class="mt-2 mx-2 bg-blue-50 border border-blue-400 rounded-lg">
            <div class="container">
                <span class="w-1/3">{{$dashboard[1]->name}}
                    @if (isset($pagos) && count($pagos) > 1)
                        @if (($pagos[1]->ml_pagos + $pagos[1]->p_pagos >= $pagos[1]->ml_declara + $pagos[1]->p_declara) && ($pagos[1]->ml_pagos + $pagos[1]->p_pagos) > 0)
                            <br>
                            <span class="parpadear text-red-800">
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                    VICTORIA
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                            </span>
                        @endif
                    @endif
                </span>
                <span class="w-1/3" style="text-align:center">FDS 2<br>{{$coach[1]->COACH}}</span>
                <span class="w-1/3 text-right">{{$dashboard[1]->participant_count}}
                    @if (isset($pagos) && count($pagos) > 0 && $dashboard[1]->p_sunday_attended > 0)
                        <br>
                        <span class="text-red-800">{{ number_format(($pagos[1]->ml_pagos + $pagos[1]->p_pagos) / ($dashboard[1]->ml_sunday_attended + $dashboard[1]->p_sunday_attended), 2) }}</span>
                    @endif
                </span>
            </div>
            <div class="container">
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 1</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_friday_attended + $dashboard[1]->p_friday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_friday_statement + $dashboard[1]->p_friday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 2</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_saturday_attended + $dashboard[1]->p_saturday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_saturday_statement + $dashboard[1]->p_saturday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 3</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_sunday_attended + $dashboard[1]->p_sunday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[1]->ml_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->p_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[1]->ml_sunday_statement + $dashboard[1]->p_sunday_statement}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (isset($pagos) && count($pagos) > 1)
            <div class="container">
                <table class="w-full table">
                    <tr>
                        <th colspan="4"><b>PAGOS</b></th>
                    </tr>
                    <tr class="tituloPago">
                        <th ></th>
                        <th style="width:20%">ML</th>
                        <th style="width:20%">Px</th>
                        <th style="width:20%">Tot.</th>
                    </tr>
                    <tr>
                        <th class="tituloPago">Declaración</th>
                        <td style="text-align:center">{{ $pagos[1]->ml_declara }}</td>
                        <td style="text-align:center">{{ $pagos[1]->p_declara }}</td>
                        <td style="text-align:center">{{ $pagos[1]->ml_declara + $pagos[1]->p_declara }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Fichas</th>
                        <td style="text-align:center">{{ $pagos[1]->ml_fichas }}</td>
                        <td style="text-align:center">{{ $pagos[1]->P_ficha }}</td>
                        <td style="text-align:center">{{ $pagos[1]->ml_fichas + $pagos[1]->P_ficha }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Pagos</th>
                        <td style="text-align:center">{{ $pagos[1]->ml_pagos }}</td>
                        <td style="text-align:center">{{ $pagos[1]->p_pagos }}</td>
                        <td style="text-align:center; font-size:22px; color:red"><b>{{ $pagos[1]->ml_pagos + $pagos[1]->p_pagos }}</b></td>
                    </tr>
                </table>
            </div>
            @endif
            
            @if (isset($pagosDetails) && count($pagosDetails) > 1)
            
            <button class="{{ Config::get('style.btnEdit') }} mb-4" onclick="ver(1)">
                <span class="icon-eye">Ver detalle</span>
            </button>
            
            <div class="container" id="1" style="display:none">
                <table class="w-full table">
                    <tr class="titulo">
                        <th>Role</th>
                        <th>Enrolador</th>
                        <th>Declaración</th>
                        <th>Fichas</th>
                        <th>Pagos</th>
                    </tr>
                    @foreach($pagosDetails as $thePagosDetails)
                        @if($thePagosDetails->training_id == $pagos[1]->training_id)
                            <tr
                                @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) style="background-color:lightgreen" @endif
                                @if ($thePagosDetails->PAGOS === "0") style="background-color:lightpink" @endif
                            >
                                <th class="titulo" style="font-size:10px">{{ $thePagosDetails->role }}</th>
                                <td style="text-align:center; font-size:10px">{{ $thePagosDetails->enrolador }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->statement }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->fichas }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->PAGOS }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
            @endif
        </div>
        
    @endif

    @if(isset($dashboard[2]->name))
        <div class="mt-2 mx-2 bg-pink-50 border border-pink-400 rounded-lg">
            <div class="container">
                <span class="w-1/3">{{$dashboard[2]->name}}
                    @if (isset($pagos) && count($pagos) > 2)
                        @if ($pagos[2]->ml_pagos + $pagos[2]->p_pagos >= $pagos[2]->ml_declara + $pagos[2]->p_declara && ($pagos[2]->ml_pagos + $pagos[2]->p_pagos) > 0)
                            <br>
                            <span class="parpadear text-red-800">
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                    VICTORIA
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                            </span>
                        @endif
                    @endif
                </span>
                <span class="w-1/3" style="text-align:center">FDS 3<br>{{$coach[2]->COACH}}</span>
                <span class="w-1/3 text-right">{{$dashboard[2]->participant_count}}
                    @if (isset($pagos) && count($pagos) > 0 && $dashboard[2]->p_sunday_attended > 0)
                        <br>
                        <span class="text-red-800">{{ number_format(($pagos[2]->ml_pagos + $pagos[2]->p_pagos) / ($dashboard[2]->ml_sunday_attended + $dashboard[2]->p_sunday_attended), 2) }}</span>
                    @endif
                </span>
            </div>
            <div class="container">

                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 1</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_friday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_friday_attended + $dashboard[2]->p_friday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_friday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_friday_statement + $dashboard[2]->p_friday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 2</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_saturday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_saturday_attended + $dashboard[2]->p_saturday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_saturday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_saturday_statement + $dashboard[2]->p_saturday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 3</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">ML</th>
                            <th style="width:20%">Px</th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_sunday_attended}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_sunday_attended + $dashboard[2]->p_sunday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard[2]->ml_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->p_sunday_statement}}</td>
                            <td style="text-align:center">{{$dashboard[2]->ml_sunday_statement + $dashboard[2]->p_sunday_statement}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (isset($pagos) && count($pagos) > 2)
            <div class="container">
                <table class="w-full table">
                    <tr>
                        <th colspan="4"><b>PAGOS</b></th>
                    </tr>
                    <tr class="tituloPago">
                        <th></th>
                        <th style="width:20%">ML</th>
                        <th style="width:20%">Px</th>
                        <th style="width:20%">Tot.</th>
                    </tr>
                    <tr>
                        <th class="tituloPago">Declaración</th>
                        <td style="text-align:center">{{ $pagos[2]->ml_declara }}</td>
                        <td style="text-align:center">{{ $pagos[2]->p_declara }}</td>
                        <td style="text-align:center">{{ $pagos[2]->ml_declara + $pagos[2]->p_declara }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Fichas</th>
                        <td style="text-align:center">{{ $pagos[2]->ml_fichas }}</td>
                        <td style="text-align:center">{{ $pagos[2]->P_ficha }}</td>
                        <td style="text-align:center">{{ $pagos[2]->ml_fichas + $pagos[2]->P_ficha }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Pagos</th>
                        <td style="text-align:center">{{ $pagos[2]->ml_pagos }}</td>
                        <td style="text-align:center">{{ $pagos[2]->p_pagos }}</td>
                        <td style="text-align:center; font-size:22px; color:red"><b>{{ $pagos[2]->ml_pagos + $pagos[2]->p_pagos }}</b></td>
                    </tr>
                </table>
            </div>
            @endif
            
            @if (isset($pagosDetails) && count($pagosDetails) > 2)
            
            <button class="{{ Config::get('style.btnEdit') }} mb-4" onclick="ver(2)">
                <span class="icon-eye">Ver detalle</span>
            </button>
            
            <div class="container" id="2" style="display:none">
                <table class="w-full table">
                    <tr class="titulo">
                        <th>Role</th>
                        <th>Enrolador</th>
                        <th>Declaración</th>
                        <th>Fichas</th>
                        <th>Pagos</th>
                    </tr>
                    @foreach($pagosDetails as $thePagosDetails)
                        @if(count($pagos) > 2)
                        @if($thePagosDetails->training_id == $pagos[2]->training_id)
                            <tr
                                @if ($thePagosDetails->PAGOS >= $thePagosDetails->statement) style="background-color:lightgreen" @endif
                                @if ($thePagosDetails->PAGOS === "0") style="background-color:lightpink" @endif
                            >
                                <th class="titulo" style="font-size:10px">{{ $thePagosDetails->role }}</th>
                                <td style="text-align:center; font-size:10px">{{ $thePagosDetails->enrolador }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->statement }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->fichas }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails->PAGOS }}</td>
                            </tr>
                        @endif
                        @endif
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    @endif
    
    @if(isset($dashboard_academy) && count($dashboard_academy) > 0)
        <div class="mt-2 mx-2 bg-green-50 border border-green-400 rounded-lg">
            <div class="container">
                <span class="w-1/3">Entrenadores en formación
                    @if (isset($pagos_academy) && count($pagos_academy) > 0)
                        @if ($pagos_academy[0]->p_pagos >= $pagos_academy[0]->p_declara)
                            <br>
                            <span class="parpadear text-red-800">
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                    VICTORIA
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                            </span>
                        @endif
                    @endif
                </span>
                <span class="w-1/3" style="text-align:center">Academia<br>DIEGO CORONEL LÓPEZ</span>
                <span class="w-1/3 text-right">{{$dashboard_academy[0]->participant_count}}
                    @if (isset($pagos_academy) && count($pagos_academy) > 0 && $dashboard_academy[0]->p_sunday_attended > 0)
                        <br>
                        <span class="text-red-800">{{ number_format(($pagos_academy[0]->p_pagos) / ($dashboard_academy[0]->p_sunday_attended), 2) }}</span>
                    @endif
                </span>
            </div>
            <div class="container">

                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 1</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_friday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_friday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 2</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_saturday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_saturday_statement}}</td>
                        </tr>
                    </table>
                </div>
                <div class="box border border-gray-400" >
                    <table class="w-full table">
                        <tr class="titulo">
                            <th colspan="4">Día 3</th>
                        </tr>
                        <tr class="titulo">
                            <th></th>
                            <th style="width:20%">Tot.</th>
                        </tr>
                        <tr>
                            <th class="titulo">Asistencia</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_sunday_attended}}</td>
                        </tr>
                        <tr>
                            <th class="titulo">Declaración</th>
                            <td style="text-align:center">{{$dashboard_academy[0]->p_sunday_statement}}</td>
                        </tr>
                    </table>
                </div>
                @if (isset($pagos_academy) && count($pagos_academy) > 0)
                <div class="box border border-gray-400" >
                <table class="w-full table">
                    <tr>
                        <th colspan="4"><b>PAGOS</b></th>
                    </tr>
                    <tr class="tituloPago">
                        <th></th>
                        <th style="width:20%">Tot.</th>
                    </tr>
                    <tr>
                        <th class="tituloPago">Declaración</th>
                        <td style="text-align:center">{{ $pagos_academy[0]->p_declara }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Fichas</th>
                        <td style="text-align:center">{{ $pagos_academy[0]->P_ficha }}</td>
                    </tr>
                    <tr>
                        <th class="tituloPago">Pagos</th>
                        <td style="text-align:center; font-size:22px; color:red"><b>{{ $pagos_academy[0]->p_pagos }}</b></td>
                    </tr>
                </table>
                </div>
                
                @endif
            </div>
            
            
            @if (isset($pagosDetails_academy) && count($pagosDetails_academy) > 0)
            
            <button class="{{ Config::get('style.btnEdit') }} mb-4" onclick="ver(3)">
                <span class="icon-eye">Ver detalle</span>
            </button>
            
            <div class="container" id="3" style="display:none">
                <table class="w-full table">
                    <tr class="titulo">
                        <th>Role</th>
                        <th>Enrolador</th>
                        <th>Declaración</th>
                        <th>Pagos</th>
                    </tr>
                    @foreach($pagosDetails_academy as $thePagosDetails_academy)
                        @if($thePagosDetails_academy->training_id == $pagosDetails_academy[0]->training_id)
                            <tr>
                                <th class="titulo" style="font-size:10px">{{ $thePagosDetails_academy->role }}</th>
                                <td style="text-align:center; font-size:10px">{{ $thePagosDetails_academy->enrolador }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails_academy->statement }}</td>
                                <td style="text-align:center; font-size:14px">{{ $thePagosDetails_academy->PAGOS }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    @endif
    
    @endif
    <div style="height:100px"></div>
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
