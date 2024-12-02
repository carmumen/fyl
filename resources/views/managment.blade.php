<x-app-layout>
    
  @if(session('fechas'))
    @php
        $fechasArray = session('fechas');
    @endphp
    
    <div class="{{ Config::get('style.containerIndex') }}" style="height:85vh">
        <p style="text-align:center; font-size:2rem; color:#0284C7; margin:3rem">Entrenamientos</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($fechasArray as $fecha)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-500 text-white p-4">
                <h2 class="text-xl font-bold">{{ $fecha->ciudad }}</h2>
            </div>
            <div class="p-4">
                <table class="w-full">
                    <tbody class="bg-gray-100">
                        <tr class="border-b border-gray-200" style="height:40px;">
                            <td class="{{ Config::get('style.rowLeft') }}" style="font-size:1.2rem; padding: 10px">
                                {{ $fecha->entrenamiento }}
                            </td>
                            <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1.2rem; padding: 10px">
                                {{ $fecha->fechaInicio }}
                            </td>
                            <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1.2rem; padding: 10px">
                                {{ $fecha->fechaFin }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-200 p-4">
                @php
                    $color = strpos($fecha->TIEMPO, 'Han pasado') !== false ? 'orange' : 'green';
                @endphp
                <p class="text-lg font-semibold" style="color: {{ $color }};">
                    {{ $fecha->TIEMPO }}
                </p>
            </div>
        </div>
    @endforeach
</div>
    </div>
    
    
    
    

@endif
</x-app-layout>
