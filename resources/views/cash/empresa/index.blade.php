<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Empresa')
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
            background-color: #0284C7;
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
            
            <div class="card mb-3">
                <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #0284C7;">
                    Configuración de Empresa
                </div>
                <div class="card-body p-4">
                    <form id="form_empresa" method="POST" action="{{ route('Empresa.store') }}">
                        @csrf
                        <div class="row pb-3">
                            <!-- Columna 1 -->
                            <div class="col-md-4">
                                <!-- RUC -->
                                <div class="form-group-sm">
                                    <label for="ruc" class="form-label">RUC:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="ruc" 
                                            name="ruc" 
                                            value="{{ old('ruc', $empresa ? $empresa->ruc : '') }}" 
                                            oninput="this.value = this.value.toUpperCase();"
                                             />
                                    @error('ruc')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Razón Social -->
                                <div class="form-group-sm">
                                    <label for="razonSocial" class="form-label">Razón Social:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="razonSocial"
                                            name="razonSocial" 
                                            value="{{ old('razonSocial', $empresa ? $empresa->razonSocial : '') }}" 
                                            required />
                                    @error('razonSocial')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Nombre Comercial -->
                                <div class="form-group-sm">
                                    <label for="nombreComercial" class="form-label">Nombre Comercial:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="nombreComercial" 
                                            name="nombreComercial"
                                            value="{{ old('nombreComercial', $empresa ? $empresa->nombreComercial : '') }}"  
                                            required />
                                    @error('nombreComercial')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Ciudad -->
                                <div class="form-group-sm">
                                    <label for="ciudad" class="form-label">Ciudad:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="ciudad" 
                                            name="ciudad" 
                                            value="{{ old('ciudad', $empresa ? $empresa->ciudad : '') }}"  
                                            required />
                                    @error('ciudad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Columna 2 -->
                            <div class="col-md-4">
                                <!-- Teléfono -->
                                <div class="form-group-sm">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="telefono"
                                            name="telefono" 
                                            value="{{ old('telefono', $empresa ? $empresa->telefono : '') }}" 
                                            required />
                                    @error('telefono')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Dirección -->
                                <div class="form-group-sm">
                                    <label for="direccion" class="form-label">Dirección:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="direccion"
                                            name="direccion" 
                                            value="{{ old('direccion', $empresa ? $empresa->direccion : '') }}"
                                            required />
                                    @error('direccion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Número de Establecimiento -->
                                <div class="form-group-sm">
                                    <label for="numeroEstablecimiento" class="form-label">Número de
                                        Establecimiento:</label>
                                    <input type="text" 
                                            class="form-control form-control-sm" 
                                            id="numeroEstablecimiento"
                                            name="numeroEstablecimiento" 
                                            value="{{ old('numeroEstablecimiento', $empresa ? $empresa->numeroEstablecimiento : '') }}"
                                            required />
                                    @error('numeroEstablecimiento')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Obligado a llevar Contabilidad -->
                                <div class="form-group-sm">
                                    <label for="obligadoContabilidad" class="form-label">Obligado a llevar
                                        Contabilidad:</label>
                                    <select class="form-control form-control-sm" 
                                            id="obligadoContabilidad"
                                            name="obligadoContabilidad"
                                            value="{{ old('obligadoContabilidad', $empresa ? $empresa->obligadoContabilidad : '') }}"
                                            required >
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Columna 3 -->
                            <div class="col-md-4">
                                <!-- Contribuyente Especial -->
                                <div class="form-group-sm">
                                    <label for="contribuyenteEspecial" class="form-label">Contribuyente
                                        Especial:</label>
                                    <select class="form-control form-control-sm" id="contribuyenteEspecial"
                                        name="contribuyenteEspecial">
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <!-- Tipo de Contribuyente Especial -->
                                <div class="form-group-sm">
                                    <label for="tipoContribuyenteEspecial" class="form-label">Tipo de Contribuyente
                                        Especial:</label>
                                    <select class="form-control form-control-sm" 
                                            id="tipoContribuyenteEspecial"
                                            name="tipoContribuyenteEspecial"
                                            value="{{ old('tipoContribuyenteEspecial', $empresa ? $empresa->tipoContribuyenteEspecial : '') }}" >
                                        <option value="si">Contribuyente Régimen RIMPE</option>
                                        <option value="no">Contribuyente Negocio Popular - Régimen RIMPE</option>
                                    </select>
                                </div>
                                <!-- Exportador -->
                                <div class="form-group-sm">
                                    <label for="exportador" class="form-label">Exportador:</label>
                                    <select class="form-control form-control-sm" 
                                            id="exportador" 
                                            name="exportador"
                                            value="{{ old('exportador', $empresa ? $empresa->exportador : '') }}" >
                                        <option value="No habitual">No habitual</option>
                                        <option value="Habitual">Habitual</option>
                                    </select>
                                </div>
                                <!-- Agente de Retención -->
                                <div class="form-group-sm">
                                    <label for="agenteRetencion" class="form-label">Agente de Retención:</label>
                                    <select class="form-control form-control-sm" 
                                            id="agenteRetencion"
                                            name="agenteRetencion"
                                            value="{{ old('agenteRetencion', $empresa ? $empresa->agenteRetencion : '') }}" >
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Botón de Enviar -->
                        <button type="submit"
                                form="form_empresa"
                                class="btn text-white"  
                                style="background-color: #0284C7;">Enviar</button>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    @if($empresa)
                    <div class="card">
                        <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #0284C7;">
                            Certificado Digital
                        </div>
                        <div class="card-body p-4">
                            <form id="formFirma" method="POST" action="{{ route('Empresa.uploadFirma') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row pb-3">
                                    <!-- Columna 1 -->
                                    <div class="col-md-12">
                                        <!-- FIRMA -->
                                        
                                            <div class="form-group-sm">
                                                <label for="firma" class="form-label">Firma:</label>
                                                <input type="file" 
                                                        class="form-control" 
                                                        id="firma" 
                                                        name="firma"
                                                        accept=".p12"
                                                        required />
                                                @error('direccion')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group-sm">
                                                <div style="padding:10px">
                                                    <span>{{ $firma ? basename($firma->firma) : '' }}</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Fecha Expiración -->
                                            <div class="form-group-sm">
                                                <label for="fecha_expiracion" class="form-label">Fecha Expiración:</label>
                                                <input type="text" 
                                                        class="form-control form-control-sm datePickerClass" 
                                                        id="fecha_expiracion"
                                                        name="fecha_expiracion"
                                                        value="{{ old('fecha_expiracion', $firma ? $firma->fecha_expiracion : '') }}"
                                                        required />
                                                @error('fecha_expiracion')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <!-- Clave -->
                                            <div class="form-group-sm">
                                                <label for="clave" class="form-label">Clave:</label>
                                                <input type="text" 
                                                        class="form-control form-control-sm" 
                                                        id="clave" 
                                                        name="clave"
                                                        value="{{ old('clave', $firma ? $firma->clave : '') }}"
                                                        required />
                                                @error('clave')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        
                                    </div>
                                </div>
                                <!-- Botón de Enviar -->
                                
                                <button type="submit" 
                                        form="formFirma" 
                                        class="btn text-white" 
                                        style="background-color: #0284C7;">Enviar</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($empresa)
                    <div class="card">
                        <div class="card-header bg-app text-white" style="padding: 6px 20px; background-color: #0284C7;">
                            Datos de Facturación
                        </div>
                        <div class="card-body p-4">
                            <form id="formFactura" method="POST" action="{{ route('Empresa.datosFactura') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row pb-3">
                                    <!-- Columna 1 -->
                                    <div class="col-md-12">
                                        <!-- Establecimiento - Punto Emisión por defecto -->
                                        <div class="form-group-sm">
                                            <label for="punto_emision" class="form-label">Establecimiento - Punto Emisión por defecto:</label>
                                            <input type="text" 
                                                    class="form-control form-control-sm" 
                                                    id="punto_emision" 
                                                    name="punto_emision"
                                                    pattern="\d{3}-\d{3}"
                                                    value="{{ old('punto_emision', $factura ? $factura->punto_emision : '') }}"
                                                    required />
                                            @error('punto_emision')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <!-- Fecha Expiración -->
                                        <div class="form-group-sm">
                                            <label for="secuencial_inicial" class="form-label">Secuencial Inicial:</label>
                                            <input type="text" 
                                                    class="form-control form-control-sm" 
                                                    id="secuencial_inicial"
                                                    name="secuencial_inicial"
                                                    value="{{ old('secuencial_inicial', $factura ? $factura->secuencial_inicial : '') }}"
                                                    required />
                                            @error('secuencial_inicial')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <!-- Logo -->
                                        
                                        
                                            <div class="form-group-sm">
                                                <div class="row">
                                                <div class="col col-10">
                                                <label for="logo_path" class="form-label">Logo:</label>
                                                <input type="file" 
                                                        class="form-control" 
                                                        id="logo_path" 
                                                        name="logo_path"
                                                        accept="image/jpeg, image/png, image/gif, image/bmp"/>
                                                @error('logo_path')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="col col-2">
                                                <div style="padding:10px">
                                                    @if($factura && $factura->logo_path)
                                                        <img width="40px" src="{{ Storage::url('logo/logo.jpg') }}" alt="Imagen"/>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group-sm">
                                            
                                        </div>
                                        
                                        <!-- Mensaje -->
                                        <div class="form-group-sm">
                                            <label for="mensaje" class="form-label">Mensaje:</label>
                                            <input type="text" 
                                                    class="form-control form-control-sm" 
                                                    id="mensaje" 
                                                    name="mensaje"
                                                    value="{{ old('mensaje', $factura ? $factura->mensaje : '') }}"/>
                                            @error('mensaje')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Botón de Enviar -->
                                <button type="submit" 
                                        form="formFactura" 
                                        class="btn text-white" 
                                        style="background-color: #0284C7;">Enviar</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Script de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


        <script>
            $(document).ready(function() {
                
                 $(".datePickerClass").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "yy-mm-dd"
                });
            });
            
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('ruc').addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
                document.getElementById('telefono').addEventListener('input', function () {
                    //this.value = this.value.replace(/[^0-9]/g, '');
                    this.value = this.value.replace(/[^0-9\s]/g, '');
                });
                document.getElementById('numeroEstablecimiento').addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Limitar el valor a 3 dígitos
                    if (this.value.length > 3) {
                        this.value = this.value.slice(0, 3);
                    }
                });
                document.getElementById('punto_emision').addEventListener('input', function () {
                    // Eliminar caracteres que no sean números o guiones
                    this.value = this.value.replace(/[^\d-]/g, '');
                
                    // Limitar el valor a 7 caracteres (3 dígitos + 1 guion + 3 dígitos)
                    if (this.value.length > 7) {
                        this.value = this.value.slice(0, 7);
                    }
                });
                document.getElementById('secuencial_inicial').addEventListener('input', function () {
                    // Eliminar caracteres que no sean números o guiones
                    this.value = this.value.replace(/[^\d]/g, '');
                
                    // Limitar el valor a 7 caracteres (3 dígitos + 1 guion + 3 dígitos)
                    if (this.value.length > 9) {
                        this.value = this.value.slice(0, 9);
                    }
                });
            });
            
            
            
            
            
        </script>
</x-app-layout>