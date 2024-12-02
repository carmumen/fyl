<div class="card mb-3">
    <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
        Registro de Egresos
    </div>
    <div class="card-body p-4">
        <form id="form_gasto" method="POST" action="{{ route('Gastos.store') }}">
            @csrf
            <div class="row d-flex align-items-stretch">
                <!-- Fila 1 -->
                <div class="col-md-2">
                    <!-- FECHA -->
                    <div class="form-group-sm">
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="text" style="width: 100px"
                                class="form-control form-control-sm datePickerClass" 
                                id="fecha" 
                                name="fecha" 
                                value="{{ old('fecha', $gasto ? $gasto->fecha : '') }}"  
                                required />
                        @error('fecha')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <!-- TIPO GASTO -->
                    <div class="form-group-sm">
                        <input type="hidden" 
                                id="tab_3" 
                                name="active_tab_id" 
                                value="tab3"/>
                        <input type="hidden" 
                                id="gasto_id" 
                                name="id" 
                                value="{{ old('id','') }}"
                                />
                        <input type="hidden" 
                                id="campus" 
                                name="campus_id" 
                                value="{{ old('campus_id', $campusId ? $campusId : '') }}"
                                />
                        <label for="codigo" class="form-label">Tipo de Gasto:</label>
                        <select class="form-control form-control-sm" 
                                name="cat_id_tipo_gasto" 
                                id="cat_id_tipo_gasto" 
                                required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($tipo_gasto as $id => $name)
                                <option value="{{ $id }}" {{ old('cat_id_tipo_gasto') == $id ? 'selected' : '' }}>
                                    {{ __($name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('$tipo_gastos')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- CATEGORIA -->
                    <div class="form-group-sm">
                        <label for="cat_id_categoria" class="form-label">Categoría:</label>
                        <div class="input-group mb-3">
                            <select class="form-control form-control-sm"  
                                    
                                    type="text" 
                                    name="cat_id_categoria"
                                    id="cat_id_categoria"
                                    data-old-value="{{ old('cat_id_categoria') }}"
                                    required />
                                <option value="">-- Seleccione --</option>
                            </select>
                            <button id="openModalBtn" type="button" class="btn btn-sm btn-primary">+</button>
                        </div>
                            
                        @error('categoria_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- PROVEEDOR -->
                    <div class="form-group-sm">
                        <label for="proveedor_id" class="form-label">Proveedor:</label>
                        <div class="input-group mb-3">
                            <input type="hidden" 
                                class="form-control form-control-sm" 
                                id="proveedor_id" 
                                name="proveedor_id" 
                                value="{{ old('proveedor_id', $gasto ? $gasto->proveedor_id : '') }}"  
                                required />
                            <input type="text" 
                                class="form-control form-control-sm" 
                                id="nombre_comercial" 
                                name="nombre_comercial" 
                                 autocomplete="off"
                                required />
                            <button id="openModalProveedorBtn" type="button" class="btn btn-sm btn-primary">+</button>
                        </div>
                        @error('proveedor_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- DESCRIPCION -->
                    <div class="form-group-sm">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <input type="text" 
                                class="form-control form-control-sm" 
                                id="descripcion" 
                                name="descripcion" 
                                value="{{ old('descripcion', $gasto ? $gasto->descripcion : '') }}"  
                                required />
                        @error('descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <!-- TOTAL -->
                    <div class="form-group-sm">
                        <label for="total" class="form-label">Total:</label>
                        <input type="text"  style="width: 120px"
                                class="form-control form-control-sm inputDecimal" 
                                id="total" 
                                name="total" 
                                value="{{ old('total', $gasto ? $gasto->total : '') }}"  
                                required />
                        @error('total')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <!-- Botón de Enviar -->
            
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit"
                        form="form_gasto"
                        class="btn text-white"  
                        style="background-color: #0284C7;">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
        Detalle de Gastos
    </div>
    <div class="card-body p-4">

        <table class="table table-sm ">
            <thead class="table-primary table-sm" style="background-color:#8064a2; color:white">
                <tr style="border: 1px solid #8064a2;">
                    <td class="text-center">Editar</td>
                    <td class="text-center">Fecha</td>
                    <td class="text-center">Tipo de Gasto</td>
                    <td class="text-center">Categoría</td>
                    <td class="text-center">Proveedor</td>
                    <td class="text-center">Descripción</td>
                    <td class="text-center">Total</td>
                </tr>   
            </thead>
            <tbody class="table-info table-sm" style="background-color:#edfcff;">
                @foreach ($gastos as $the_gastos)
                <tr class="border-b border-gray-200">
                    @auth
                        <td class="text-center">
                            <button class="btnEditar"><i class="fa-solid fa-pen-to-square" ></i></button>
                        </td>
                    @endauth
                    <td class="text-center">
                        {{ $the_gastos->fecha }} <!-- 1 -->
                    </td>
                    <td class="text-center">
                        <input type="hidden" id="cat_id_tipo_gasto" name="cat_id_tipo_gasto" value="{{ $the_gastos->cat_id_tipo_gasto }}"/>
                        {{ $the_gastos->tipoGasto }}
                    </td>
                    <td class="text-center">
                        <input type="hidden" id="cat_id_categoria" name="cat_id_categoria" value="{{ $the_gastos->cat_id_categoria }}"/>
                        {{ $the_gastos->categoria }}
                    </td>
                    <td class="text-center">
                        {{ $the_gastos->proveedor }}
                    </td>
                    <td class="text-center">
                        {{ $the_gastos->descripcion }}
                    </td>
                    <td class="text-center">
                        {{ $the_gastos->total }}
                    </td>
                    <td class="text-center" style="display:none">
                        {{ $the_gastos->cat_id_tipo_gasto }}
                    </td>
                    <td class="text-center" style="display:none">
                        {{ $the_gastos->cat_id_categoria }}
                    </td>
                    <td class="text-center" style="display:none">
                        {{ $the_gastos->proveedor_id }}
                    </td>
                    <td class="text-center" style="display:none">
                        {{ $the_gastos->id }} 
                    </td>
                    <td class="text-center" style="display:none">
                        {{ $the_gastos->campus_id }} 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
            {{ $gastos->appends(['campus_id' => $campusId,'active_tab_id' => 'tab4'])->links() }}
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#pagina a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        cargarPagina(url);
    });
    
    function cargarPagina(url) {
        $.ajax({
            url: url,
            success: function(response) {
                $('#tab4').html(response);
            }
        });
    }
</script>