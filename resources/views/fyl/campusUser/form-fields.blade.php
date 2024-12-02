

<div class="space-y-4">
    <div class="flex items-center justify-center mt-4 text-2xl">
        <span>@lang('Campus')</span>&nbsp;&nbsp;
        <span>{{ $campusUser[0]->campus }}</span>
        <input type="hidden" name="campus_id" value="{{ $campusUser[0]->campus_id }}" />
    </div>
    </br>
    <div class="container">
    <div class="mx-5 ml-10 alto" style="max-height: 400px; overflow-y: auto;">
        <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-gray-100">
                @php
                    // Calculamos el número total de filas necesarias
                    $rowCount = ceil(count($campusUser) / 4);
                @endphp
                
                {{-- Iteramos sobre cada fila de la tabla --}}
                @for ($i = 0; $i < $rowCount; $i++)
                    <tr class="border-b border-gray-200">
                        {{-- Iteramos sobre cada columna de la fila --}}
                        @for ($j = 0; $j < 4; $j++)
                            @php
                                // Calculamos el índice del usuario dentro de $campusUser
                                $index = $i + $j * $rowCount;
                            @endphp
                            {{-- Verificamos si existe un usuario para este índice --}}
                            @if ($index < count($campusUser))
                                @php
                                    $user = $campusUser[$index];
                                @endphp
                                <td style="width:20%; vertical-align:top; padding:0px 5px">
                                    <label class="{{ Config::get('style.cajaTexto') }}">
                                        <input type="checkbox" name="selected_users[{{ $user->user_id }}]"
                                            value="{{ $user->user_id }}"
                                            @if ($user->marca == true) checked @endif />
                                        {{ $user->name }}
                                    </label>
                                </td>
                            @else
                                {{-- Si no hay usuario para este índice, mostramos una celda vacía --}}
                                <td></td>
                            @endif
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>


</div>
