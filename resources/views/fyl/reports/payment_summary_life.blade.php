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
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* Añade 5px de espacio alrededor del contenido */
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Payment Summary')
        </h2>
    </x-slot>

    <header>
        <div class="flex flex-wrap justify-between mx-8">
            <div class="p-1">
                {{-- @dump($trainingId) --}}
                <nav class="space-x-4">
                    <span class="">
                        @if (isset($training) && count($training) > 0)
                            <form id="life" method="GET" class="flex items-center space-x-2"
                                action="{{ route('ReportsLife.payment_summary_life') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="program" value="LIFE" />
                                <input type="hidden" name="parameter" value="C" />
                                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select"
                                    name="training_id" id="training_id" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach ($training as $id => $name)
                                        <option value="{{ $id }}"
                                            @if ($id == old('training_id', $trainingId)) selected @endif>
                                            {{ __($name) }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <button class="icon-upload text-2xl text-sky-800 hover:underline" type="submit"
                                    form="life"></button> --}}
                            </form>
                        @endif
                    </span>
                </nav>
            </div>
            @if (isset($payment_summary) && count($payment_summary) > 0)
                <div class="p-1">
                    <a class="{{ Config::get('style.btnSave') }}"
                        href="{{ url('/exportar-tabla' . '/resumen_pago_life' . '/' . $trainingId . '/LIFE|' . request('parameter')) }}">
                        Exportar</a>

                </div>

                <div class="p-1">

                </div>
            @endif
        </div>

    </header>

    @if (isset($payment_summary) && count($payment_summary) > 0)
        <div class="px-1 py-1 mb-8 md:px-8 md:py-2 bg-white w-full overflow-auto">
            <form id="consolida" method="GET" class="flex items-center space-x-2"
                action="{{ route('ReportsLife.payment_summary_life') }}">
                @csrf

                <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                <input type="hidden" name="program" value="LIFE" />
                <div class="flex flex-row  justify-between px-4" style="width:300px">
                    <label class="radio-label">
                        <input type="radio" name="parameter" value="C" onchange="submitData()"
                            {{ request('parameter', 'C') == 'C' ? 'checked' : '' }}>
                        Consolidado
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="parameter" value="D" onchange="submitData()"
                            {{ request('parameter') == 'D' ? 'checked' : '' }}>
                        Detallado
                    </label>
                </div>
            </form>
            <div class="flex flex-col mt-6 mb-8">
                <div class="mb-4 justify-center">
                    <table id="tablaDatos" class="w-1/4 divide-y divide-gray-200">
                        <thead class="sticky top-0 bg-sky-800">
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
                </div>
                <main class="border border-gray-200 md:rounded-lg">
                    <div class="overflow-x-auto">
                        <div id="conResultados">

                            @include('fyl/reports.payment_summary_life_table', $payment_summary)


                            <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                                {{-- {{ $payment_summary->links() }} --}}
                            </div>
                        </div>
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                    </div>
                </main>
            </div>
        </div>
    @endif

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
    </script>

    <script>
        const selectElement = document.getElementById('training_id');

        selectElement.addEventListener('change', function() {
            // Accede al formulario y envíalo
            document.getElementById('life').submit();
        });

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

</x-app-layout>
