<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<x-app-layout title="Dashboard Focus" meta-description="Dashboard Focus">

    <x-slot name="title">
        @lang('Dashboard Focus')
    </x-slot>

    {{-- <div class="flex h-24 justify-center items-center mx-1">
            @foreach ($trainings as $training)
                <div class="w-1/3 rounded-lg p-2 mx-2 border border-blue-400 bg-blue-200 shadow-md">
                    <label class="block text-center font-semibold">
                        <input type="radio" name="training_id"
                        @if ($training->id == $trainingId) checked @endif
                        value="{{ $training->id }}">
                        {{ $training->training }}
                    </label>
                </div>
            @endforeach
        </div> --}}

    <div class="mt-2 mx-2 bg-green-100 border border-green-400 rounded-lg">
        <label class="pt-4 px-2 font-bold">Asistencia</label>
        <div class="flex h-24 justify-center items-center mx-1">
            @foreach ($attendance->toArray() as $attendances)
                <div
                    class="w-1/3 rounded-lg p-2 mx-2 border {{ Config::get('style.border' . $attendances->secuencial) }} {{ Config::get('style.background' . $attendances->secuencial) }} shadow-md">
                    <span
                        class="block text-center {{ Config::get('style.text600' . $attendances->secuencial) }} font-semibold">{{ $attendances->dia }}</span>
                    <span
                        class="block text-center {{ Config::get('style.text800' . $attendances->secuencial) }} font-bold">{{ $attendances->total_focus }}</span>
                    <span
                        class="block text-center {{ Config::get('style.text600' . $attendances->secuencial) }} font-semibold text-xs">Participantes</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-2 mx-2 bg-yellow-300 border-dashed border-2 border-blue-900 rounded-lg ">
        <label class="pt-4 px-2 font-bold text-blue-800">Pagos Totales</label>
        <input type="checkbox" id="reload" />
        <div class="flex h-16 justify-center items-center mx-1">
            <table class="w-full">
                <thead>
                    <tr class="">
                        <th class="py-2 text-blue-900">@lang('F')</th>
                        <th class="py-2 text-blue-900">@lang('F + Y')</th>
                        <th class="py-2 text-blue-900">@lang('F + Y + L')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="text-center px-4 text-2xl text-blue-800">
                            {{ $f }}
                        </td>
                        <td class="text-center px-4 text-2xl text-blue-800">
                            {{ $fy }}
                        </td>
                        <td class="text-center px-4 text-2xl text-blue-800">
                            {{ $fyl }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2 mx-2 bg-yellow-100 border border-yellow-400 rounded-lg">
        <label class="pt-4 px-2 font-bold">Pagos antes del cierre</label>
        <div class="flex h-24 justify-center items-center mx-1">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th class="py-2 px-4 text-xs border-b border-yellow-400">@lang('F')</th>
                        <th class="py-2 px-4 text-xs border-b border-yellow-400">@lang('F + Y')</th>
                        <th class="py-2 px-4 text-xs border-b border-yellow-400">@lang('F + Y + L')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment as $payments)
                        <tr>
                            <td class="py-2 px-4 text-right text-xs">
                                {{ $payments->dia }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $payments->focus }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $payments->focus_your }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $payments->focus_your_life }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2 mx-2 bg-blue-100 border border-blue-400 rounded-lg">
        <label class="pt-4 px-2 font-bold">Declaración Jornada</label>
        <div class="flex h-24 justify-center items-center mx-1">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th></th>
                        <th class="py-2 px-4 text-xs border-b border-blue-400">@lang('SI')</th>
                        <th class="py-2 px-4 text-xs border-b border-blue-400">@lang('NO')</th>
                        <th class="py-2 px-4 text-xs border-b border-blue-400">@lang('P')</th>
                        <th class="py-2 px-4 text-xs border-b border-blue-400">@lang('NI')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statementTable as $statementTables)
                        <tr class="border-b border-gray-200">
                            <td class="py-2 px-4 text-right text-xs">
                                {{ $statementTables->dia }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $statementTables->SI }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $statementTables->NO }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $statementTables->P }}
                            </td>
                            <td class="py-2 px-4 text-center text-xs">
                                {{ $statementTables->NI }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @php
        $legendaryGroups = collect($statementLegendary)->groupBy('legendary');
    @endphp

    <div class=" mt-2 p-2">
        <label class="pt-4 px-2 font-bold">Declaración Por Legendario</label>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($legendaryGroups as $legendary => $legendaryData)
                <div class="bg-blue-200 rounded-lg shadow-md p-4 border border-blue-400 ">
                    <span class="text-xs font-semibold mb-2">{{ $legendary }}</span>
                    <div class="overflow-x-auto ">
                        <table class="min-w-full">
                            <thead>
                                <tr class="">
                                    @foreach ($legendaryData->first() as $column => $value)
                                        @if ($column !== 'legendary')
                                            @if ($column == 'date')
                                                <th class="py-2 px-4 text-xs"></th>
                                            @else
                                                <th class="py-2 px-4 text-xs border-b border-blue-400">
                                                    {{ $column }}</th>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($legendaryData as $data)
                                    <tr>
                                        @foreach ($data as $column => $value)
                                            @if ($column !== 'legendary')
                                                @if ($column == 'date')
                                                    <td class="py-2 px-4 text-right text-xs"><b>{{ $value }}</b>
                                                    </td>
                                                @else
                                                    <td class="py-2 px-4 text-center text-xs">{{ $value }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>




    <div id="google-chart" style="height: 300px;"></div>

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $(document).ready(function() {
            // Obtener el estado almacenado en localStorage o establecerlo en 'false' si no existe
            var reloadChecked = localStorage.getItem('reloadChecked') === 'true' ? true : false;

            // Establecer el estado del checkbox según el valor obtenido de localStorage
            $('#reload').prop('checked', reloadChecked);

            $('#reload').change(function() {
                if ($(this).is(':checked')) {
                    localStorage.setItem('reloadChecked', 'true');
                    location.reload();
                } else {
                    localStorage.setItem('reloadChecked', 'false');
                }
            });

            setInterval(tiempoReal, 10000);

            function tiempoReal() {
                if ($('#reload').is(':checked')) {
                    localStorage.setItem('reloadChecked', 'true');
                    location.reload();
                }
            };

        });


        // Función para dibujar el gráfico
        function drawChart(chartData) {
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(function() {
                const data = new google.visualization.DataTable();
                data.addColumn('string', 'Día');
                data.addColumn('number', 'S');
                data.addColumn('number', 'N');
                data.addColumn('number', 'P');
                data.addColumn('number', 'NI');

                // Crear un objeto para rastrear las declaraciones por fecha
                const declarationsByDate = {};

                // Agregar los datos de la consulta al objeto de seguimiento
                for (let i = 0; i < chartData.length; i++) {
                    const dayData = chartData[i];
                    const date = dayData.day;

                    if (!declarationsByDate[date]) {
                        declarationsByDate[date] = {
                            S: 0,
                            N: 0,
                            P: 0,
                            NI: 0,
                        };
                    }

                    // Incrementar el contador de la declaración correspondiente
                    switch (dayData.statement) {
                        case 'SI':
                            declarationsByDate[date].S += dayData.cant;
                            break;
                        case 'NO':
                            declarationsByDate[date].N += dayData.cant;
                            break;
                        case 'P':
                            declarationsByDate[date].P += dayData.cant;
                            break;
                        case 'NI':
                            declarationsByDate[date].NI += dayData.cant;
                            break;
                    }
                }

                // Agregar los datos del objeto de seguimiento a la tabla de datos
                for (const date in declarationsByDate) {
                    const declarations = declarationsByDate[date];
                    data.addRow([date, declarations.S, declarations.N, declarations.P, declarations.NI]);
                }

                const options = {
                    title: 'Declaraciones por Día y Declaración',
                    hAxis: {
                        title: 'Día',
                    },
                    vAxis: {
                        title: 'Cantidad',
                    },
                };

                const chart = new google.visualization.ColumnChart(
                    document.getElementById('google-chart')
                );

                chart.draw(data, options);
            });
        }

        const chartData = {!! json_encode($focusStatement) !!};
        drawChart(chartData);
    </script>

</x-app-layout>
