<x-app-layout>
    @php
        if (session('entidad') == 'LifeParticipants') {
            $search = session('search');
            if ($search === null) {
                $search = '';
            } else {
                if (Str::length($search) == 1) {
                    $search = '';
                }
            }
        } else {
            session(['entidad' => 'LifeParticipants']);
            session(['search' => '']);
        }
    @endphp
    <style>
        .contenedor-select {
            padding-right: 30px;
            /* A���ade 5px de espacio alrededor del contenido */
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Reportes FOCUS')
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
                                action="{{ route('ReportsFocusTab.index') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="program" value="FOCUS" />
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

        </div>

    </header>
<div class="tabs-container">    
    <div class="tabs">
      <div class="tab" onclick="openTab('tab1')">Tab 1</div>
      <div class="tab" onclick="openTab('tab2')">Tab 2</div>
      <div class="tab" onclick="openTab('tab3')">Tab 3</div>
    </div>
    <div style="width:100vw; overflow:auto">
        <div class="tab-content" id="tab1" style="display:none;">
          <p>This is the content of Tab 1.</p>
        </div>
        
        <div class="tab-content" id="tab2" style="display:none; background-color:red">
          <p>This is the content of Tab 2.</p>
        </div>
        <div class="tab-content" id="tab3">
          @if (isset($payment_summary) && count($payment_summary) > 0)
                        <div class="px-1 py-1 mb-8 md:px-8 md:py-2 bg-white w-full overflow-auto">
                            <form id="consolida" method="GET" class="flex items-center space-x-2"
                                action="{{ route('ReportsFocusTab.index') }}">
                                @csrf
                
                                <input type="hidden" name="training_id" value="{{ $trainingId }}" />
                                <input type="hidden" name="program" value="FOCUS" />
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
                                                <tr class="border-b border-gray-200">
                                                    <td class="{{ Config::get('style.rowLeft') }}">
                                                        {{ $thesummary->MetodoPago }}
                                                    </td>
                                                    <td class="{{ Config::get('style.rowRight') }}">
                                                        {{ number_format($thesummary->Monto, 2) }}
                                                    </td>
                                                </tr>
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
                
                                            @include('fyl/reports.payment_summary_table', $payment_summary)
                
                
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
        </div>
    </div>
</div>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
}

.tabs-container {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.tabs {
  display: flex;
  background-color:blue;
  height:40px;
}

.tab {
  cursor: pointer;
  padding: 10px;
  border: 1px solid #ccc;
  background-color: #f2f2f2;
  height:40px;
}

.tab:hover {
  background-color: #ddd;
}

.tab-content {
  display: flex;
  
  padding: 10px;
  border: 1px solid #ccc;
  margin-top: 10px;
}

.tab-content p {
  margin: 0;
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
  // Muestra la primera pestaña al cargar la página
  openTab("tab1");
});

function openTab(tabId) {
  // Oculta todos los contenidos de las pestañas
  var tabContents = document.querySelectorAll(".tab-content");
  tabContents.forEach(function (tabContent) {
    tabContent.style.display = "none";
  });

  // Muestra el contenido de la pestaña seleccionada
  document.getElementById(tabId).style.display = "block";
  document.getElementById(tabId).style.margin = 0;
}

    </script>

</x-app-layout>
