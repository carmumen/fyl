<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Agrega los enlaces a los archivos CSS de Tailwind CSS aquí -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex h-32 justify-center items-center  mx-4">
        <div class="w-1/3 bg-blue-200 rounded-lg p-2 mx-2 border border-blue-400 shadow-md">
            <span class="block text-center text-blue-600 font-semibold">VIERNES</span>
            <span class="block text-center text-blue-800 font-bold">100</span>
            <span class="block text-center text-xs text-blue-600 font-semibold">Participantes</span>
        </div>
        <div class="w-1/3 bg-green-200 rounded-lg p-2 mx-2 border border-green-400 shadow-md">
            <span class="block text-center text-green-600 font-semibold">SÁBADO</span>
            <span class="block text-center text-green-800 font-bold">200</span>
            <span class="block text-center text-xs text-green-600 font-semibold">Participantes</span>
        </div>
        <div class="w-1/3 bg-pink-200 rounded-lg p-2 mx-2 border border-pink-400 shadow-md">
            <span class="block text-center text-pink-600 font-semibold">DOMINGO</span>
            <span class="block text-center text-pink-800 font-bold">300</span>
            <span class="block text-center text-xs text-pink-600 font-semibold">Participantes</span>
        </div>
    </div>

    <div id="google-chart"></div>

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
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

        // Aquí puedes cargar tus datos desde Laravel (por ejemplo, a través de una API).
        // En este ejemplo, se asume que los datos se cargan desde la propiedad chartData.
        const chartData = {!! json_encode($focusStatements) !!};
        console.log(chartData);
        drawChart(chartData);
    </script>
</body>

</html>
