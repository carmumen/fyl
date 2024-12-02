
<!-- Formulario de asignaciones para equipos -->
            
<div class="p-1">
    <table>
        <tr>
            <th>Equipo:</th>
            <td>
                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select ancho" name="training_id"
                    id="training_id">
                    <option value="">--Seleccione--</option>
                    @foreach ($training as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('training_id', $trainingId)) selected @endif>
                            {{ __($name) }}
                        </option>
                    @endforeach
                </select>
                @error('training_id')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Asignación:</th>
            <td>
                <select class="{{ Config::get('style.cajaTexto') }} contenedor-select ancho" name="asignacion_id"
                    id="asignacion_id">
                    <option value="">--Seleccione--</option>
                    @foreach ($asignaciones as $theasignacion)
                        <option value="{{ $theasignacion->id }}" @if ($theasignacion->id == old('asignacion_id')) selected @endif>
                            {{ $theasignacion->name }}
                        </option>
                    @endforeach
                </select>
                @error('asignacion_id')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Para:</th>
            <td>
                <select id="para" name="para" class="{{ Config::get('style.cajaTexto') }} contenedor-select" >
                    <option value="">--Seleccione--</option>
                    <option value="Master Life">
                        Master Life
                    </option>
                    <option value="Participante">
                        Participante
                    </option>
                </select>
                @error('para')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Desde:</th>
            <td>
                <input id="desde" name="desde" type="date" class="{{ Config::get('style.cajaTexto') }} " >
                @error('desde')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Hasta:</th>
            <td>
                <input id="hasta" name="hasta" type="date" class="{{ Config::get('style.cajaTexto') }}" >
                @error('hasta')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
    </table>
    
</div>

<style>
    th, td{
        text-align:left;
        padding:5px;
    }
    .ancho{
        width:100%;
    }
    
    @media only screen and (max-width: 768px) {
        .ancho {
            width: 100%;
            /* Puedes ajustar otros estilos aquí */
        }
    }
    

</style>

