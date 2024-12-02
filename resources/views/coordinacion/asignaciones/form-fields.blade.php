
            
<div class="p-1">
    <table>
        <tr>
            <th>Tipo:</th>
            <td>
                <select id="tipo" name="tipo" class="{{ Config::get('style.cajaTexto') }} contenedor-select" >
                    <option value="">--Seleccione el Tipo--</option>
                    <option value="Libro">
                        Libro
                    </option>
                    <option value="Película">
                        Película
                    </option>
                </select>
                @error('tipo')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Nombre:</th>
            <td>
                <input id="nombre" name="nombre" type="text" class="{{ Config::get('style.cajaTexto') }} link" >
                @error('nombre')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Link:</th>
            <td>
                <input id="link_formulario" name="link_formulario" type="text" class="{{ Config::get('style.cajaTexto') }} link"  placeholder="Ingrese el enlace">
                @error('link_formulario')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <th>Estado:</th>
            <td>
                <select id="estado" name="estado" class="{{ Config::get('style.cajaTexto') }} contenedor-select" >
                    <option value="">--Seleccione el Estado--</option>
                    <option value="Activo">
                        Activo
                    </option>
                    <option value="Inactivo">
                        Inactivo
                    </option>
                </select>
                @error('estado')
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
    .link{
        width:500px;
    }
    @media only screen and (max-width: 768px) {
        .link {
            width: 100%;
            /* Puedes ajustar otros estilos aquí */
        }
    }
</style>

