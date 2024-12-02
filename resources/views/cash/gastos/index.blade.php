<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Gastos')
        </h2>
    </x-slot>
    <style>
        .form-label {
            margin-bottom: 1px;
            /* Ajusta el espacio vertical aquí */
            margin-top: 4px;
            font-size: 0.8rem;
        }
        .bg-app{
            background-color: #8064a2;
        }
        .btnEditar,
        .btnEditar:hover,
        .btnEditar:focus {
            color:#8064a2;
            background-color: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            transition: transform 0.2s;
        }
        
        .btnEditar:hover {
          transform: scale(1.1); /* Cambia el tamaño del botón al 110% en el hover */
        }
        
        .bd-example {
            padding:0.5rem;
            margin-right: 0;
            margin-left: 0;
            border-width: 1px;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem
        }
        .nav-link {
      color: #8064a2; /*#085985;*/
    }

  
    .nav-link:hover {
        background-color: #97e6ed;
    }
    
    

    .views .activar {
        display: block ;
    }
    
    
   /* Estilos para el modal */
    .modal {
      display: none; /* Por defecto, oculto */
      position: fixed;
      z-index: 1; /* Ubicar el modal por encima del resto del contenido */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro semi-transparente */
    }
    
    /* Centrar el modal vertical y horizontalmente */
    .modal-content {
      position: absolute;
      left: 50%;
      top: 35%;
      transform: translate(-50%, -50%);
      background-color: #fefefe;
      padding: 20px;
      border-radius: 8px; /* Bordes redondeados */
    }
    
    /* Estilos para el botón de cierre del modal */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }



    
    </style>

    <div class="{{ Config::get('style.containerIndex') }}" style="height: 88vh">
        <div class="container-fluid">
            @if (Session::has('success'))
                <div id="successAlert" class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            
            @if (Session::has('error'))
                <div id="errorAlert" class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            
            <script>
                // Función para ocultar automáticamente el mensaje después de 5 segundos
                setTimeout(function() {
                    $('#successAlert').fadeOut('slow');
                    $('#errorAlert').fadeOut('slow');
                }, 5000); // 5000 milisegundos = 5 segundos
            </script>
            
                
            
            <div class="col-sm-3  mb-3">
                <form id="gastos" method="GET" action="{{ route('Gastos.index') }}">
                    @csrf
                    <label for="campus_id" class="form-label">Sede:</label>
                    <input type="hidden" 
                            id="tabPrincipal" 
                            name="active_tab_id" 
                            value="tab4"/>
                    <select class="form-control form-control-sm contenedor-select" 
                            id="campus_id"
                            name="campus_id">
                        <option value="">--Seleccione--</option>
                        @foreach ($campus as $id => $name)
                            <option value="{{ $id }}"
                                @if($id == old('id', $campusId)) selected @endif>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <ul class="nav nav-tabs flex-column flex-sm-row" id="myTabs">
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab1' ? 'active' : '' }}" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">EDOCTA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab2' ? 'active' : '' }}" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">Reporte Ingresos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab3' ? 'active' : '' }}" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">Reporte Egresos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab4' ? 'active' : '' }}" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">Registro Egresos</a>
              </li>
              <!--
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab5' ? 'active' : '' }}" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">Devoluciones en Entrenamiento</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'tab6' ? 'active' : '' }}" id="tab6-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="true">Cuentas por Cobrar</a>
              </li>
              -->
            </ul>
            
            <!--<div id="spinner" class="overlay-spinner">
                <img src="{{ url('images/loading-gif-png-4.gif') }}" alt="Cargando...">
            </div>-->
                    
            @if(isset($gasto))
            
            @php
                $campusSeleccionado = null;
                foreach ($campus as $id => $name) {
                    if ($id == $campusId) {
                        $parts = explode(" - ", $name); // Divide el nombre en dos partes: país y ciudad
                        $country = explode(" ", $parts[0])[0]; // Obtiene solo el país (puede haber más de una palabra)
                        $city = $parts[1]; // Obtiene la ciudad
                        $campusSeleccionado = array("$id,$country,$city");
                    }
                }
            @endphp
            
            <div class="tab-content border border-top-0 p-3 views">
                
                <div class="tab-pane fade {{ $activeTab == 'tab1' ? 'show active' : '' }}" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        @include('cash/gastos.edocta', $campusSeleccionado)
                </div>
                
                <div class="tab-pane fade {{ $activeTab == 'tab2' ? 'show active' : '' }}" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    @include('cash/gastos.reporteIngresos', $campusSeleccionado)
                </div>
                
                <div class="tab-pane fade {{ $activeTab == 'tab3' ? 'show active' : '' }}" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                    @include('cash/gastos.reporteEgresos', $campusSeleccionado)
                </div>
                
                <div class="tab-pane fade {{ $activeTab == 'tab4' ? 'show active' : '' }}" id="tab4" role="tabpanel" aria-labelledby="tab4-tab" style="position: sticky; top: 0;">
                    {{-- @include('cash/gastos.registroEgresos', $campusSeleccionado) --}}
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
                </div>
                
                <div class="tab-pane fade {{ $activeTab == 'tab5' ? 'show active' : '' }}" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                    Devoluciones en entrenamiento
                </div>
                
                <div class="tab-pane fade {{ $activeTab == 'tab6' ? 'show active' : '' }}" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">
                    Cuentas por Cobrar
                </div>
            </div>
            
            <div id="modalTipo" class="modal">
            <div class="modal-content col-md-5 col-offset-5" >
                <div class="card mb-3">
                    <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
                        Nueva Categoría
                        <span class="close text-white">&times;</span>
                    </div>
                    <div class="p-3">
                        <form id="form_categoria" method="POST" action="">
                            @csrf 
                            <div class="form-group-sm">
                                <label for="codigo" class="form-label">Categoría:</label>
                                <div class="input-group mb-3">
                                    <input type="hidden" 
                                            id="campus" 
                                            name="campus_id" 
                                            value="{{ old('campus_id', $campusId ? $campusId : '') }}"
                                            />
                                    <input type="hidden" 
                                            id="tipo-gasto" 
                                            name="tipo-gasto" 
                                            required />
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="nueva-categoria" 
                                            name="nueva-categoria"  
                                            required />
                                    @error('nueva-categoria')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    
                                </div>
                                <!-- Botón de Enviar -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" onclick="confirmaCategoria()"
                                        class="btn text-white"  
                                        style="background-color: #0284C7;">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div id="modalProveedor" class="modal">
            <div class="modal-content col-md-5 col-offset-5" >
                <div class="card mb-3">
                    <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #8064a2;">
                        Nuevo Proveedor
                        <span class="close text-white">&times;</span>
                    </div>
                    <div class="p-3">
                        <form id="form_proveedor" method="POST" action=""> 
                            @csrf 
                            <div class="form-group-sm">
                                <label for="tipo_identidad" class="form-label">Tipo de Identidad:</label>
                                <div class="input-group mb-3">
                                    <input type="hidden" 
                                                    id="campusProveedor" 
                                                    name="campus_id" 
                                                    value="{{ old('campus_id', $campusId ? $campusId : '') }}"
                                                    />
                                    <select class="form-control form-control-sm"  
                                            id="tipo_identidad" 
                                            name="tipo_identidad" 
                                            required />
                                        <option value="1">RUC</option>
                                        <option value="2">CÉDULA</option>
                                    </select>
                                    @error('tipo_identidad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="identidad" class="form-label">Identidad:</label>
                                <div class="input-group mb-3">
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="identidadP" 
                                            name="identidadP" 
                                            minlength="10"
                                            maxlength="13" 
                                            onkeypress="return valideKey(event);" 
                                            required />
                                    @error('identidad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="nombre_comercialP" class="form-label">Nombre Comercial:</label>
                                <div class="input-group mb-3">
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="nombre_comercialP" 
                                            name="nombre_comercialP"  
                                            required />
                                    @error('nombre_comercialP')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <div class="input-group mb-3">
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="direccion" 
                                            name="direccion"  
                                             />
                                    @error('direccion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <div class="input-group mb-3">
                                    <input type="email" 
                                            class="form-control form-control-sm" 
                                            id="email" 
                                            name="email"  
                                            oninput="this.value = this.value.toLowerCase();"
                                            pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
                                            title="Por favor, introduce una dirección de correo electrónico válida"
                                             />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <div class="input-group mb-3">
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="telefono" 
                                            name="telefono"
                                            onkeypress="return valideKey(event);"
                                             />
                                    @error('telefono')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label for="estado" class="form-label">Estado:</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-control-sm"  
                                            id="estado" 
                                            name="estado" 
                                            required />
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>
                                    @error('estado')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                                <!-- Botón de Enviar -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" onclick="validarYAgregarProveedor()"
                                        class="btn text-white"  
                                        style="background-color: #0284C7;">Enviar</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            
            @endif
        </div>
        

        
        
    </div>
    
    
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        
            $(window).on('load', function() {
                //$('#spinner').hide(); // Ocultar el spinner cuando la página se haya cargado completamente
            });
            
            // Mostrar el spinner GIF mientras la página se está cargando
            $(document).ready(function() {
                
                //$('#spinner').show();

            });
            
            
            const selectCampus = document.getElementById('campus_id');
    
            selectCampus.addEventListener('change', function() {
                // Accede al formulario y envíalo
                document.getElementById('gastos').submit();
            });
                        
            $(document).ready(function() {
                //$('#spinner').show();
                $('#myTabs a').on('click', function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                })
                
                $('.nav-link').css('background-color', '#f0f0f0');
                $('.nav-link.active').css('background-color', '');
                
                $('.nav-link').click(function(){
                    // Remover la clase 'active' de todos los enlaces
                    $('.nav-link').removeClass('active');
                    // Agregar la clase 'active' solo al enlace clickeado
                    $(this).addClass('active');
                    // Remover el estilo de fondo de todos los enlaces
                    $('.nav-link').css('background-color', '#f0f0f0');
                    // Establecer el estilo de fondo solo para el enlace activo
                    $(this).css('background-color', '');
                    
                    var id = $(this).attr("mostrar");
        
                    $(this).addClass("activar").siblings().removeClass("activar");
                    $(".views>div").removeClass("activar").siblings(id).addClass("activar");
                });
                
                $('#cat_id_tipo_gasto').on('change', onSelectTipoGastoChange);
                
                if ($('#cat_id_tipo_gasto').val() !== '') { onSelectTipoGastoChange(); }
                
                var currentDate = new Date().toISOString().slice(0,10);
                
                $(".datePickerClass").val(currentDate);

                $(".datePickerClass").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    firstDay: 1
                });
                
              // Evento para capturar el clic en el botón "Editar"
                $('.btnEditar').click(function() {
                    // Obtener los datos de la fila correspondiente
                    var fila = $(this).closest('tr');
                    var fecha = fila.find('td:eq(1)').text();
                    var nombre_comercial = fila.find('td:eq(4)').text();
                    var descripcion = fila.find('td:eq(5)').text();
                    var total = fila.find('td:eq(6)').text();
                    var cat_id_tipo_gasto = fila.find('td:eq(7)').text();
                    var cat_id_categoria = fila.find('td:eq(8)').text();
                    var proveedor_id = fila.find('td:eq(9)').text();
                    var gasto_id = fila.find('td:eq(10)').text();
                    var campus = fila.find('td:eq(11)').text();
                    
                    // Mostrar los datos en el formulario
                    $('#fecha').val(fecha.trim());
                    
                    $('#cat_id_tipo_gasto').val(cat_id_tipo_gasto.trim());
                    
                    cargaTipoGastoChange(function() {
                        $('#cat_id_categoria').val(cat_id_categoria.trim());
                    });
                    
                    $('#proveedor_id').val(proveedor_id.trim());
                    $('#nombre_comercial').val(nombre_comercial.trim());
                 
                    $('#descripcion').val(descripcion.trim());
                    $('#total').val(total.trim());
                    $('#gasto_id').val(gasto_id.trim());
                    $('#campus').val(campus.trim());
                    
                   // $('#cat_id_categoria').val(cat_id_categoria.trim());
                    
                });
                
            });
            
           
            
            function onSelectTipoGastoChange() {
                var cat_id_tipo_gasto = $('#cat_id_tipo_gasto').val();
                if (cat_id_tipo_gasto == "") return;
                var url = '/categoria/' + cat_id_tipo_gasto;
                
                $.get(url, function(data) {
                    var select = document.getElementById("cat_id_categoria");
                    if(select)
                    {
                        select.innerHTML = ""; // Limpiar el select antes de agregar las nuevas opciones
                        
                        var nuevoItem = document.createElement("option");
                        nuevoItem.text = "-- Seleccione --";
                        nuevoItem.value = "";
                        select.appendChild(nuevoItem);
                        
                        data.forEach(function(item) {
                            var option = document.createElement("option");
                            option.text = item.name;
                            option.value = item.id;
                            
                            var oldValue = $('#cat_id_categoria').data('old-value');
                            if (oldValue == option.value) {
                                option.selected = true;
                            }
                
                            select.appendChild(option);
                        });
                    }
                        
                });
            }
            
            function cargaTipoGastoChange(callback) {
                var cat_id_tipo_gasto = $('#cat_id_tipo_gasto').val();
                if (cat_id_tipo_gasto == "") return;
            
                var url = '/categoria/' + cat_id_tipo_gasto;
                
                $.get(url, function(data) {
                    var select = document.getElementById("cat_id_categoria");
                    if(select)
                    {
                        select.innerHTML = ""; // Limpiar el select antes de agregar las nuevas opciones
                        
                        var nuevoItem = document.createElement("option");
                        nuevoItem.text = "-- Seleccione --";
                        nuevoItem.value = "";
                        select.appendChild(nuevoItem);
                        
                        data.forEach(function(item) {
                            var option = document.createElement("option");
                            option.text = item.name;
                            option.value = item.id;
                            select.appendChild(option);
                        });
            
                        // Si se proporcionó una función de devolución de llamada, ejecútala
                        if (callback && typeof callback === 'function') {
                            callback();
                        }
                    }
                });
            }
    
                
            document.addEventListener('DOMContentLoaded', function () {
                
                $('.inputDecimal').on('input', function() {
                    // Reemplazar cualquier carácter que no sea número o punto con una cadena vacía
                    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
                    
                    // Limitar la longitud total a 10 caracteres
                    if ($(this).val().length > 10) {
                        $(this).val($(this).val().slice(0, 10));
                    }
            
                    // Si hay más de un punto decimal, eliminar los caracteres adicionales
                    if ($(this).val().split('.').length > 2) {
                        var partes = $(this).val().split('.');
                        $(this).val(partes[0] + '.' + partes.slice(1).join(''));
                    }
                });
               
            });
            
            openModalProveedorBtn
            // Obtener el botón para abrir el modal
            var openModalProveedorBtn = document.getElementById("openModalProveedorBtn");
            
            // Obtener el modal
            var modalProveedor = document.getElementById("modalProveedor");
            
            if(openModalProveedorBtn)
            {
                // Cuando el usuario haga clic en el botón, abrir el modal
                openModalProveedorBtn.onclick = function() {
                    modalProveedor.style.display = "block";
                }
            }
            
            
            // Obtener el botón para abrir el modal
            var openModalBtn = document.getElementById("openModalBtn");
            
            // Obtener el modal
            var modal = document.getElementById("modalTipo");
            
            // Obtener el botón de cierre del modal
            //var closeBtn = document.getElementsByClassName("close")[0];
            var closeBtns = document.getElementsByClassName("close");
            var closeBtn0 = closeBtns[0];
            var closeBtn1 = closeBtns[1];
            
            if(openModalBtn)
            {
                // Cuando el usuario haga clic en el botón, abrir el modal
                openModalBtn.onclick = function() {
                    var tipo = document.getElementById("tipo-gasto");
                    var selectElement = document.getElementById("cat_id_tipo_gasto");
                    var selectedValue = selectElement.value;
                    if( selectedValue != "")
                        tipo.value = selectedValue;
                    else
                    {
                        alert('Seleccione el Tipo de Gasto');
                        return;
                    }
                    modal.style.display = "block";
                    var nueva = document.getElementById("nueva-categoria");
                    nueva.focus();
                }
            }
            
            if(closeBtn0)
            {
                // Cuando el usuario haga clic en el botón de cierre, cerrar el modal
                closeBtn0.onclick = function() {
                  modal.style.display = "none";
                }
            }
            
            if(closeBtn1)
            {
                // Cuando el usuario haga clic en el botón de cierre, cerrar el modal
                closeBtn1.onclick = function() {
                  modalProveedor.style.display = "none";
                }
            }
            
            // Cuando el usuario haga clic en cualquier lugar fuera del modal, cerrarlo
            window.onclick = function(event) {
              if (event.target == modal || event.target == modalProveedor) {
                modal.style.display = "none";
                modalProveedor.style.display = "none";
              }
            }
            
            function confirmaCategoria() 
            {
                var selectElement = document.getElementById("cat_id_tipo_gasto");
                var selectedText = selectElement.options[selectElement.selectedIndex].text;
                var nueva = document.getElementById("nueva-categoria").value;
                var mensaje = 'Confirma que vas a crear la categoria ' + nueva.toUpperCase() + ' para el Tipo de Gasto ' +selectedText.toUpperCase();
                if (confirm(mensaje)) {
                   agregarCatagoria();
                } 
            }
            
            function agregarCatagoria()
            {
                var tipoGasto = $('#tipo-gasto').val();
                var nuevaCategoria = $('#nueva-categoria').val();
                
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
            
                $.ajax({
                    url: '{{ route("GastosCategoria.crear_categoria") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Incluir el token CSRF en los encabezados
                    },
                    data: {
                        'tipo-gasto': tipoGasto,
                        'nueva-categoria': nuevaCategoria
                    },
                    success: function(response) {
                        // Manejar la respuesta exitosa, si es necesario
                        alert('Categoría creada correctamente.');
                        
                        onSelectTipoGastoChange();
                        modal.style.display = "none";
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores, si es necesario
                        alert('Error al crear la categoría: ' + error);
                    }
                });
            }
            
            
            function valideKey(evt) {
                var code = (evt.which) ? evt.which : evt.keyCode;
        
                if (code == 8) { // backspace.
                    return true;
                } else if (code >= 48 && code <= 57) { // is a number.
                    return true;
                } else { // other keys.
                    return false;
                }
            }
            
            function validarYAgregarProveedor() {
                // Obtener valores de los campos
                var identidad = document.getElementById("identidadP").value;
                var nombre_comercial = document.getElementById("nombre_comercialP").value;
            
                // Validar campos
                if (identidad.trim() === "") {
                    alert("Por favor, ingrese la identidad del proveedor.");
                    return; // Detener la ejecución si la identidad del proveedor está vacía
                }
                if (nombre_comercial.trim() === "") {
                    alert("Por favor, ingrese el nombre comercial.");
                    return; // Detener la ejecución si el nombre comercial está vacío
                }
            
                // Si los campos son válidos, llamar a la función para agregar el proveedor
                agregarProveedor();
            }
            
            
            function agregarProveedor()
            {
                var campus_id = $('#campusProveedor').val();
                var tipo_identidad = $('#tipo_identidad').val();
                var identidad = $('#identidadP').val();
                var nombre_comercial = $('#nombre_comercialP').val();
                var direccion = $('#direccion').val();
                var email = $('#email').val();
                var telefono = $('#telefono').val();
                var estado = $('#estado').val();
                
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/cash/crear-proveedor',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Incluir el token CSRF en los encabezados
                    },
                    data: {
                        'campus_id': campus_id,
                        'tipo_identidad': tipo_identidad,
                        'identidad': identidad,
                        'nombre_comercial': nombre_comercial,
                        'direccion': direccion,
                        'email': email,
                        'telefono': telefono,
                        'estado': estado,
                    },
                    success: function(response) {
                        console.log(response);
                        // Manejar la respuesta exitosa, si es necesario
                        alert('Proveedor creado correctamente.');
                        setTimeout(function() {
                        }, 300);
                        
                        modalProveedor.style.display = "none";
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        // Manejar errores, si es necesario
                        alert('Error al crear el Proveedor: ' + error);
                    }
                });
            }
            
            
            function cambioEnCampus() {
                var selectElement = document.getElementById("campus_id");
                var selectedValue = selectElement.value;
                
                $('#campus').val(selectedValue);
            }

        </script>
        
        <script>
            $(document).ready(function() {
                $("#nombre_comercial").autocomplete({
                    source: "{{ route('GastosProveedor.proveedor') }}",
                    minLength: 1,
                    select: function(event, ui) {
                        $('#proveedor_id').val(ui.item.id); // Utiliza ui.item.id para obtener el ID
                        $('#nombre_comercial').val(ui.item.label); // Utiliza ui.item.label para obtener el nombre comercial
                        return false;
                    },
                    // Definir _renderItem dentro del callback de autocomplete
                    _renderItem: function(ul, item) {
                        return $("<li>")
                            .append("<div>" + item.label + "</div>")
                            .appendTo(ul);
                    }
                });
            });
        </script>
        
        <script>
    $(document).on('click', '#pagina a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        console.log(url);
        cargarPagina(url);
    });
    
    function cargarPagina(url) {
        $.ajax({
            url: url,
            success: function(response) {
                
            // Buscar la tabla y la paginación en la respuesta
            var tabla = $(response).find('#tab4 .table-info');
            var paginacion = $(response).find('#tab4 #pagina');
            
            // Actualizar el contenido de la tabla y la paginación
            $('#tab4 .table-info').html(tabla.html());
            $('#tab4 #pagina').html(paginacion.html());
            }
        });
    }
</script>
       
</x-app-layout>