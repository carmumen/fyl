<x-app-layout>
    @php
        if (session('entidad') == 'PaymentSummary') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'PaymentSummary']);
            session(['search' => '']);
        }
    @endphp
    
    
    @php
        $fechaFinConteo = new DateTime('2024-09-06 18:00:00');
        $fechaFinStr = $fechaFinConteo->format('Y-m-d\TH:i:s');
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>
    <style>
        .fecha {
            /* Tamaño y forma */
            width: 100%;
            max-width: 300px;
            padding: 4px;
            border-radius: 8px;
            border: 1px solid #d1d5db; /* Color de borde suave */
            background-color: #f9fafb; /* Fondo gris claro */
            
            /* Estilo del texto */
            font-size: 0.7rem;
            color: #374151; /* Color de texto oscuro */
            
            /* Estilo de enfoque */
            transition: border-color 0.3s, box-shadow 0.3s;
        }
    
        .fecha:focus {
            border-color: #3b82f6; /* Color de borde en enfoque */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); /* Sombra en enfoque */
            outline: none; /* Quitar el borde por defecto en enfoque */
        }
    
        /* Para asegurar que se vea bien en dispositivos móviles */
        @media (max-width: 600px) {
            .fechaInicio {
                max-width: 100%;
            }
        }
    </style>
    
    <style>
        /* CSS para los campos de fecha */
        .fechaInicio, .fechaFin {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            font-size: 16px;
            color: #374151;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .fechaInicio:focus, .fechaFin:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Payment Summary')
        </h2>
        
    </x-slot>

    <header>
        
        <div id="mensaje" >
            <!--<center>
                <b style="color:red; font-size:20px">El sistema está actualmente en proceso de inactivación.</b> 
                
                <br>
                Estará disponible:
                <div id="temporizador" style="font-size: 2em; color:red">00:00</div>
                
            </center>-->
        </div>
        
        
        <div class="flex flex-wrap justify-between mx-8" style="height:40px">
            <div class="p-1">
                <nav class="space-x-4">
                    <span class=""></span>
                </nav>
            </div>
            @if (isset($payment_summary) && count($payment_summary) > 0)
                <div class="p-1">
                </div>
                
                <div class="p-1">
                </div>

                <div class="p-1">
                    <a class="{{ Config::get('style.btnSave') }}"
                        href="{{ url('/exportar-tabla' . '/resumen_pagos_general' . '/' . $campusId . '/' . request('program')). '|' . request('parameter'). '|'. request('campus_id'). '|'. request('fechaInicio'). '|'. request('fechaFin') }}">
                        
                        Exportar</a>
                </div>
            @endif
        </div>
    </header>
    
    <div class="px-1 py-1 mb-8 md:px-8 md:py-2 bg-white w-full overflow-auto">
        <div class="flex flex-wrap  justify-between">
            <table style="border:1px solid #075985; margin-bottom: 10px">
                <thead class=" top-0 bg-sky-800">
                    <tr>
                        <th colspan="3" scope="col" class="{{ Config::get('style.headerInt') }}">
                            Criterio de búsqueda
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100">
                    <tr style="border-top:1px solid #075985">
                        <th colspan="3">
                            <div class="flex flex-wrap  justify-between " style="padding:4px">
                                <label class="radio-label" style="color:#075985">
                                    Rango de fechas
                                </label>
                                <button class="{{ Config::get('style.btnSave') }}" onclick="Consultar()">Consultar</button>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <form id="consolida" method="GET" class="flex items-center space-x-2"
                            action="{{ route('ReportsPayments.payment_summary') }}">
                            @csrf
            
                            <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                            <input type="hidden" name="program" value="FOCUS" />
                            <input type="hidden" name="parameter" value="D" />
                        <td>
                            @if (isset($campus) && count($campus) > 0)
                                    <span style="padding-left:4px; padding-right:4px; color:#075985; font-size:0.8rem">Sede</span>
                                    <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                        name="campus_id" id="campus_id" required>
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($campus as $id => $name)
                                            <option value="{{ $id }}"
                                                @if ($id == old('campus_id', $campusId)) selected @endif>
                                                {{ __($name) }}
                                            </option>
                                        @endforeach
                                    </select>
                            @endif
                        </td>
                        <td></td>
                        <td>
                            <span style="padding-left:4px; padding-right:4px; color:#075985; font-size:0.8rem">Programa</span>
                            <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                name="program" id="program" required>
                                <option value="T" @if ($program == 'T') selected @endif>-TODOS-</option>
                                <option value="F" @if ($program == 'F') selected @endif>FOCUS</option>
                                <option value="Y" @if ($program == 'Y') selected @endif>YOUR</option>
                                <option value="L" @if ($program == 'L') selected @endif>LIFE</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                            <td style="padding:4px">
                                <span style="width:30px; color:#075985; font-size:0.8rem">Desde</span><br>
                                <input type="date" class="fechaInicio" id="fechaInicio" name="fechaInicio" value="{{ $fechaInicio }}">
                            </td>
                            <td></td>
                            <td style="padding:4px">
                                <span style="width:30px; color:#075985; font-size:0.8rem">Hasta</span><br>
                                <input type="date" class="fechaFin" id="fechaFin" name="fechaFin" value="{{ $fechaFin }}">
                            </td>
                        </form>
                    </tr>
                    
                </tbody>
            </table>
            
            @if (isset($payment_summary) && count($payment_summary) > 0)
                <table id="tablaDatos" class="divide-y divide-gray-200" style="margin-bottom: 10px">
                    <thead class="top-0 bg-sky-800">
                        <tr>
                            <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                @lang('Método de Pago')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                                @lang('Monto')
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100">
                        @foreach ($summary as $thesummary)
                            @if ($thesummary->Monto > 0)
                            <tr class="border-b border-gray-200">
                                <td class="{{ Config::get('style.rowLeft') }}">
                                    {{ $thesummary->MetodoPago }}
                                </td>
                                <td class="{{ Config::get('style.rowRight') }}">
                                    {{ number_format($thesummary->Monto, 2) }}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        <tr class="sticky top-0 bg-sky-800">
                            <td class="{{ Config::get('style.rowRight') }} text-white">
                                <b>TOTAL</b>
                            </td>
                            <td class="{{ Config::get('style.rowRight') }} text-white">
                                <b>{{ number_format($total, 2) }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
                
        @if (isset($payment_summary) && count($payment_summary) > 0)    
            <main class="border border-gray-200 md:rounded-lg mt-4 mb-4">
                <div class="overflow-x-auto">
                    <div id="conResultados">
                        
                        @include('fyl/reports.payment_general_table', $payment_summary)
                        
                        <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        </div>
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        @else
            <div class="flex items-center justify-center h-32">
                <p class="text-center text-xl text-sky-600">NO SE HAN REGISTRADO PAGOS</p>
            </div>
        @endif
    </div>
    
     
    <script>
        $(document).ready(function() {
            $('#generatePdfButton').click(function() {
                fetch('/ficha/' + 6, {
                        method: 'GET',
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        // Crea una URL de objeto para el blob
                        const url = window.URL.createObjectURL(blob);
                        // Crea un enlace para la descarga
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'ficha.pdf';
                        // Simula un clic en el enlace para iniciar la descarga
                        a.click();
                        // Libera la URL del objeto
                        window.URL.revokeObjectURL(url);
                    });
            });
        });
        
        function Consultar()
        {
            const campus = document.getElementById('campus_id').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            
            if (campus == "") {
                alert('Por favor, selecciona primero la sede.');
                return;
            }
            
            if (!fechaInicio) {
                alert('Por favor, selecciona la fecha de inicio.');
                return;
            }
            
            if (!fechaFin) {
                alert('Por favor, selecciona la fecha de fin.');
                return;
            }
            if(fechaInicio > fechaFin) {
                alert('La fecha desde NO debe ser mayor que la fecha hasta.');
                return;
            }
            submitData();
        }
        /*
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('life').submit();
        });
        */

        function copyClipboard(divId) {
            const elm = document.getElementById(divId);

            if (!elm) {
                console.error(`Element with ID '${divId}' not found.`);
                return;
            }

            const range = document.createRange();
            range.selectNode(elm);

            try {
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);

                document.execCommand('copy');
                console.log('Copiado al portapapeles');
                selection.removeAllRanges();

                alert('Copiado al portapapeles');
            } catch (err) {
                console.error('Error al copiar al portapapeles:', err);
            }
        }


        function submitData() {

            document.getElementById('consolida').submit();
        };
    </script>
    
    <script>
        function iniciarCuentaRegresiva(fechaFin) {
            const display = document.getElementById('temporizador');

            function actualizarTemporizador() {
                if (!display) {
                    console.error('El elemento con ID "temporizador" no se encuentra.');
                    return;
                }

                const ahora = new Date();
                const diferencia = fechaFin - ahora;

                if (diferencia <= 0) {
                    display.textContent = '¡Tiempo terminado!';
                    clearInterval(intervalo);
                    return;
                }

                // Calcula horas, minutos y segundos
                const segundosTotales = Math.floor(diferencia / 1000);
                const horas = Math.floor(segundosTotales / 3600);
                const minutos = Math.floor((segundosTotales % 3600) / 60);
                const segundos = segundosTotales % 60;

                const horasFormateadas = horas < 10 ? '0' + horas : horas;
                const minutosFormateados = minutos < 10 ? '0' + minutos : minutos;
                const segundosFormateados = segundos < 10 ? '0' + segundos : segundos;

                display.textContent = `${horasFormateadas}:${minutosFormateados}:${segundosFormateados}`;
            }

            const intervalo = setInterval(actualizarTemporizador, 1000);
            actualizarTemporizador(); // Llamar inmediatamente para evitar el retraso inicial
        }

        window.onload = function() {
            const fechaFinStr = "<?php echo $fechaFinStr; ?>";
            console.log('Fecha y hora de fin:', fechaFinStr);

            if (fechaFinStr) {
                const fechaFin = new Date(fechaFinStr);
                if (!isNaN(fechaFin.getTime())) {
                    iniciarCuentaRegresiva(fechaFin);
                } else {
                    alert('Fecha de fin no válida.');
                }
            } else {
                alert('No se proporcionó la fecha de fin.');
            }
        };
    </script>
    
    

</x-app-layout>
