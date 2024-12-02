<x-app-layout title="Payments" meta-description="Payments">

    <x-slot name="title">
        @lang('Payments')
    </x-slot>

    <style>
        .overlay-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Fondo semi-transparente */
            display: flex;
            align-items: center;
            justify-content: center;



            background-color: transparent;
        }

        .overlay-spinner img {

            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Record Payments')</h1>



    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <div class="space-y-0  p-3 border-b-2 font-mono bg-white relative">

        <div class="overlay-spinner">
            <img src="{{ url('images/loading-gif-png-4.gif') }}" alt="Cargando...">
        </div>

        {{-- <div class="flex flex-wrap "> --}}
        <form id="form_payment" class="px-4 py-4 bg-white" method="POST" action="{{ route('Participants.payment_register') }}">
            @csrf
           
            <input type="hidden" name="participant_DNI" value=" {{ $participants->DNI }}" required />
            <div class="flex justify-between mx-10">
                <label class="flex flex-col py-1">
                    <span class="{{ Config::get('style.label') }}">@lang('Program')</span>
                    <span class="text-xxl"><b>{{ $program->name }}</b></span>
                </label>
                <label class="flex flex-col py-1">
                    <span class="{{ Config::get('style.label') }}">@lang('Participant')</span>
                    <span class="text-xxl"><b>{{ $participants->names . ' ' . $participants->surnames }}</b></span>
                </label>
                <label class="flex flex-col py-1">
                    <span class="{{ Config::get('style.label') }}">@lang('Enroller')</span>
                    <span
                        class="text-xxl"><b>{{ $participants->names_enroller . ' ' . $participants->surnames_enroller }}</b></span>
                </label>
            </div>
            
            @if($campus == 1 && $valida == 0)
                <div class="flex justify-between mx-10">
                    <span></span>
                    <span style="color:red" >Verificar número de cédula</span>
                    <span></span>
                </div>
            @endif
            
            <fieldset class="px-4 border border-solid border-gray-300 mb-1 bg-gray-100">
                <legend class="text-sm"><b>@lang('Payment Data')</b></legend>

                <label class="flex flex-col py-1">
                    <input type="hidden" id="training_id" name="training_id"
                        value=" {{ old('training_id', $trainingId) }}" />
                    <input type="hidden" id="campus_id" name="campus_id"
                        value=" {{ old('campus_id', $campus_id) }}" />
                    <input type="hidden" id="program_id" name="program_id"
                        value=" {{ old('program_id', $program->id) }}" />


                </label>



                <div class="flex flex-row flex-wrap py-1">
                    <label class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Payment date')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 datePickerClass" type="text"
                            name="payment_date" onkeypress="return valideKey(event);" required />
                        @error('payment_date')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    @if ($payment_participant)

                        <label class="flex flex-col py-1 w-1/5">
                            <input type="hidden" name="price_type" value=" {{ $payment_participant->price_type }}" />
                            <span class="{{ Config::get('style.label') }}">@lang('Price Type')</span>
                            <span>{{ $payment_participant->priceType }}</span>
                        </label>

                        <label class="flex flex-col py-1 w-1/5">
                            <input type="hidden" name="prices_id" value=" {{ $payment_participant->precio }}" />
                            <span class="{{ Config::get('style.label') }}">@lang('Price')</span>
                            <span>{{ $payment_participant->price }}</span>
                        </label>
                        @if ($balance > 0)
                            <label class="flex flex-col py-1 w-1/5">
                                <span class="{{ Config::get('style.label') }}">@lang('Saldo')</span>
                                <span><b class="text-red-800">{{ $balance }}</b></span>
                            </label>
                        @endif
                    @else
                        <label class="flex flex-col py-1 w-1/5">
                            <span class="{{ Config::get('style.label') }}">@lang('Price Type')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="price_type" name="price_type"
                                onchange="onSelectPriceTypeChange();" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($price_type as $id => $name)
                                    <option value="{{ $id }}">
                                        {{ __($name) }}</option>
                                @endforeach
                            </select>
                            @error('price_type')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>

                        <label class="flex flex-col py-1 w-1/5">
                            <span class="{{ Config::get('style.label') }}">@lang('Price')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="prices_id" name="prices_id">
                            </select>
                            @error('prices_id')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    @endif

                    <label class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Payment Method')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="catalog_id_payment_method"
                            name="catalog_id_payment_method" onchange="togglePaymentMethod();" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($payment_method as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                        </select>
                        @error('catalog_id_payment_method')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                            <script>
                                // Restaurar la fecha seleccionada por el usuario después de una validación fallida
                                var paymentDateInput = document.querySelector('input[name="payment_date"]');
                                paymentDateInput.value = "{{ old('payment_date') }}";
                            </script>
                        @enderror
                    </label>

                    <label id="cards1" class="flex flex-col py-1 w-1/5 ">
                        <span class="{{ Config::get('style.label') }}">@lang('Card')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="catalog_id_card"
                            name="catalog_id_card" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($card as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                        </select>
                        @error('catalog_id_card')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label id="cards2" class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Tipo Pago')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="catalog_id_tipo_pago"
                            name="catalog_id_tipo_pago" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($tipoPago as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                        </select>
                        @error('catalog_id_tipo_pago')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Authorization number')</span>
                        <input class="{{ Config::get('style.cajaTexto') }}  mr-4" type="text"
                            id="authorization_number" name="authorization_number"
                            onkeypress="return valideKey(event);" required />
                        @error('authorization_number')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <div id="banks" class="flex flex-col w-1/5">
                        <label class="flex flex-col py-1">
                            <span class="{{ Config::get('style.label') }}">@lang('Bank')</span>
                            <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="catalog_id_bank"
                                name="catalog_id_bank" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($bank as $id => $name)
                                    <option value="{{ $id }}">
                                        {{ __($name) }}</option>
                                @endforeach
                            </select>
                            @error('catalog_id_bank')
                                <small class="font-bold text-red-500/80">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <label class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Payment Record')</span>
                        <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="catalog_id_payment_record"
                            name="catalog_id_payment_record" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($payment_record as $id => $name)
                                <option value="{{ $id }}">
                                    {{ __($name) }}</option>
                            @endforeach
                        </select>
                        @error('catalog_id_payment_record')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col py-1 w-1/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Amount')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4" type="text" name="amount"
                            onkeypress="return valideKey(event);" required />
                        @error('amount')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>
                
                <div>
                    <label class="flex flex-col py-1">
                        <span class="{{ Config::get('style.label') }}">@lang('Comment')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4" type="text" id="comment" name="comment"/>
                        @error('comment')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>


            </fieldset>


            <fieldset class="px-4 border border-solid border-gray-300 mt-3">
                <legend class="text-sm"><b>@lang('Billing Information')</b></legend>

                <label for="consumidor" class="{{ Config::get('style.label') }}">Consumidor Final</label>
                <input type="checkbox" id="consumidor" name="consumidor">
                <input type="hidden" id="consumidorFinal" name="consumidorFinal" value="false">

                <div class="flex flex-row flex-wrap py-1">

                    <label class="flex flex-col py-1 flex-1 lg:w-1/3">
                        <span class="{{ Config::get('style.label') }}">@lang('CC/RUC')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" id="CC_RUC"
                            name="CC_RUC" value=" {{ old('CC_RUC', $participants->DNI) }}"
                            onkeypress="return valideKey(event);" onkeyup="onSelectCC_RUCChange()" required />
                        @error('CC_RUC')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col py-1 flex-1 lg:w-1/3">
                        <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text"
                            id="names_razon_social" name="names_razon_social"
                            value=" {{ old('names_razon_social', $participants->names . ' ' . $participants->surnames) }}"
                            required />
                        @error('names_razon_social')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="flex flex-col py-1 flex-1 lg:w-1/3">
                        <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" id="email"
                            name="email" value=" {{ old('email', $participants->email) }}" required />
                        @error('email')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>

                <div class="flex flex-row flex-wrap py-1">

                    <label class="flex flex-col py-1 flex-1 lg:w-3/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" id="address"
                            name="address" value=" {{ old('address', $participants->address) }}" required />
                        @error('address')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>


                    <label class="flex flex-col py-1 flex-1 lg:w-2/5">
                        <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                        <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" id="phone"
                            name="phone" value=" {{ old('phone', $participants->phone) }}"
                            onkeypress="return valideKey(event);" required />
                        @error('phone')
                            <small class="font-bold text-red-500/80">{{ $message }}</small>
                        @enderror
                    </label>
                </div>
                
                <input type="hidden" value ="{{ $campus }}" name="campusId" >
                <input type="hidden" value ="{{ $training_id_enroller }}" name="trainingId" >

            </fieldset>
            <input type="hidden" value ="{{ $campus }}" name="campus_id" >
            <!--<input type="hidden" value ="{{ $training_id }}" name="training_id" >-->
            <input type="hidden" value ="{{ $parameter }}" name="parameter" >
            <input type="hidden" value ="{{ $search }}" name="search" >
            <input type="hidden" value ="{{ $pag }}" name="pag" >

        </form>
        
        
        <form id="form_retorno" action="{{ route('Participants.obtenerEntrenamiento') }}" method="POST">
            @csrf
            <input type="hidden" value ="{{ $campus }}" name="campus_id" >
            <input type="hidden" value ="{{ $training_id }}" name="training_id" >
            <input type="hidden" value ="{{ $parameter }}" name="parameter" >
            <input type="hidden" value ="{{ $search }}" name="search" >
            <input type="hidden" value ="{{ $pag }}" name="pag" >
        </form>
        <div class="flex items-center justify-between m-4">
            <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_retorno">@lang('To return')</button> 
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="font-bold text-red-500/80">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_payment">@lang('Save')</button>
        </div>
        <br>

         
        <div class="flex flex-col mt-6 mb-8 px-4 ">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('ID')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Payment Date')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Program')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Payment Record')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Payment Method')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Authorization number')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Card')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Plazos')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Amount')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Factura')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }}">
                                    @lang('Comment')
                                </th>
                                @auth
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}"> I </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}"> E </th>
                                    <th scope="col" class="{{ Config::get('style.headerInt') }}"> X </th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($recordPayment as $recordPayments)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->id }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->payment_date }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->program }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->payment_record }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->payment_method }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->authorization_number }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->card }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->tipo_pago }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->amount }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->names_razon_social }}
                                    </td>
                                    <td class="{{ Config::get('style.rowInt') }}">
                                        {{ $recordPayments->comment }}
                                    </td>
                                    @auth
                                        <td style="text-align:center">
                                            <a class="{{ Config::get('style.btnEdit') }} "
                                                href="{{ route('factura.generar', $recordPayments->id) }}">
                                                <span class="icon-print text-sky-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                        
                                        <td style="text-align:center">
                                            <a class="{{ Config::get('style.btnEdit') }} "
                                                href="{{ route('Payment.editar', 
                                                                ['id' => $participants->id, 
                                                                 'campus' => $campus_id, 
                                                                 'program' => $program, 
                                                                 'program_name' => $program->name,
                                                                 'training' => $trainingId,
                                                                 'training_id_enroller' => $training_id_enroller, 
                                                                 'payment_id' => $recordPayments->id,
                                                                 'training_id' => $training_id,
                                                                 'parameter' => $parameter,
                                                                 'search' => $search,
                                                                 'pag' => $pag]) }}">
                                                
                                                <span class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                        
                                        <td style="text-align:center">
                                            <form
                                                action="{{ route('Participants.destroyPayment', $recordPayments->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el pago de {{ $recordPayments->names_razon_social }}?')">
                                                    <span
                                                        class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                </button>
                                            </form>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @error('teamFocus')
                    <small class="font-bold text-red-500/80 text-xs">{{ $message }}</small>
                @enderror
            </main>
        </div>
        <div id="contenedorImpresion" style="display:none">
            hola
        </div>
    </div>
    
    

</x-app-layout>

    <style>
        /* Estilos de impresión */
        @media print {
            body * {
                visibility: hidden;
            }
            #contenedorImpresion, #contenedorImpresion * {
                visibility: visible;
            }
            #contenedorImpresion {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

<script>
    


    $(document).ready(function() {
        $(".datePickerClass").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            firstDay: 1
        });

        $('input').val(function(_, value) {
            return $.trim(value);
        });

        $('#price_type').on('change', onSelectPriceTypeChange);

        $('#consumidor').on('change', function() {
            if ($(this).is(':checked')) {
                $('#consumidorFinal').val('true');
            } else {
                $('#consumidorFinal').val('false');
            }

            var consumidor = document.getElementById('consumidor');
            var CC_RUC = document.getElementById('CC_RUC');
            var names_razon_social = document.getElementById('names_razon_social');
            var email = document.getElementById('email');
            var address = document.getElementById('address');
            var phone = document.getElementById('phone');
            var consumidorFinal = document.getElementById('consumidorFinal');

            if (consumidor.checked === true) {
                CC_RUC.value = "";
                names_razon_social.value = "";
                email.value = "";
                address.value = "";
                phone.value = "";
                consumidorFinalvalue = true;
                CC_RUC.removeAttribute('required');
                names_razon_social.removeAttribute('required');
                email.removeAttribute('required');
                address.removeAttribute('required');
                phone.removeAttribute('required');
                consumidorFinalvalue = false;
            } else {
                CC_RUC.value += "{{ $participants->DNI }}";
                names_razon_social.value =
                    "{{ $participants->names . ' ' . $participants->surnames }}";
                email.value = "{{ $participants->email }}";
                address.value = "{{ $participants->address }}";
                phone.value = "{{ $participants->phone }}";
                CC_RUC.setAttribute('required', 'required');
                names_razon_social.setAttribute('required', 'required');
                email.setAttribute('required', 'required');
                address.setAttribute('required', 'required');
                phone.setAttribute('required', 'required');
            }
        });
        
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

        hideLoadingSpinner();
        
        

    });

    function showLoadingSpinner() {
        document.querySelector('.overlay-spinner').style.display = 'block';
    }

    // Ocultar el GIF de espera después de que se haya completado la acción
    function hideLoadingSpinner() {
        document.querySelector('.overlay-spinner').style.display = 'none';
    }


    function onSelectPriceTypeChange() {
        var price_type = $('#price_type').val();
        var campus_id = $('#campus_id').val();
        var program_id = $('#program_id').val();

        if (price_type == "") return;

        // Muestra el GIF de espera antes de la acción
        showLoadingSpinner();

        var url = '/prices/' + campus_id + '/' + program_id + '/' + price_type;
        var html_select = '<option value="">-- Seleccione --</option>';
        var selectedOptionValue = "{{ session('selected_option') }}";

        // Devolver una promesa que se resolverá cuando la carga haya terminado
        return new Promise(function(resolve, reject) {
            $.get(url, function(data) {
                    for (var i = 0; i < data.length; ++i) {
                        html_select += '<option value="' + data[i].price + '"';
                        if (selectedOptionValue !== null && data[i].price == selectedOptionValue) {
                            html_select += ' selected';
                        }
                        html_select += '>' + data[i].name + '</option>';
                    }
                    $('#prices_id').html(html_select);

                    // Cuando la carga haya terminado con éxito, resolvemos la promesa
                    resolve();
                })
                .fail(function(error) {
                    // En caso de error, rechazamos la promesa
                    reject(error);
                })
                .always(function() {
                    // Oculta el GIF de espera después de la acción (también en caso de error)
                    hideLoadingSpinner();
                });
        });
    }


    function onSelectCC_RUCChange() {
        var CC_RUC = $('#CC_RUC').val();
        $('#names_razon_social').val("");
        $('#email').val("");
        $('#address').val("");
        $('#phone').val("");

        var url = '/CC_RUC_client/' + CC_RUC;

        $.get(url, function(data) {
            if (data.length > 0) {
                $('#names_razon_social').val(data[0].names_razon_social);
                $('#email').val(data[0].email);
                $('#address').val(data[0].address);
                $('#phone').val(data[0].phone);
            } else {
                $('#names_razon_social').html("Cliente no encontrado");
                $('#email').val("");
                $('#address').val("");
                $('#phone').val("");
            }
        });
    }
    $('.decimales').on('input', function() {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });

    function valideKey(evt) {
        var code = (evt.which) ? evt.which : evt.keyCode;

        if (code == 8) { // backspace.
            return true;
        } else if (code >= 48 && code <= 57) { // is a number.
            return true;
        } else if (code == 46) { // is a number.
            return true;
        } else { // other keys.
            return false;
        }
    }

    function togglePaymentMethod() {
        var payment_method = document.getElementById('catalog_id_payment_method');
        var cards1 = document.getElementById('cards1');
        var cards2 = document.getElementById('cards2');
        var banks = document.getElementById('banks');
        var card = document.getElementById('catalog_id_card');
        var term = document.getElementById('catalog_id_tipo_pago');
        var authorization = document.getElementById('authorization_number');
        var bank = document.getElementById('catalog_id_bank');

        cards1.classList.add('hidden'); // Agrega la clase 'hidden' para ocultar
        cards2.classList.add('hidden'); // Agrega la clase 'hidden' para ocultar
        banks.classList.add('hidden');

        card.removeAttribute('required');
        term.removeAttribute('required');
        authorization.removeAttribute('required');
        bank.removeAttribute('required');

        switch (payment_method.value) {
            case "12":
                cards1.classList.remove('hidden'); // Elimina la clase 'hidden' para mostrar
                cards2.classList.remove('hidden'); // Elimina la clase 'hidden' para mostrar
                banks.classList.remove('hidden');
                card.setAttribute('required', 'required');
                term.setAttribute('required', 'required');
                authorization.setAttribute('required', 'required');
                bank.value = "";
                break;
            case "13":
                banks.classList.remove('hidden');
                bank.setAttribute('required', 'required');
                card.value = "";
                term.value = "";
                authorization.value = "";
                break;
            case "14":
                banks.classList.remove('hidden');
                bank.setAttribute('required', 'required');
                card.value = "";
                term.value = "";
                authorization.value = "";
                break;
            case "15":
                banks.classList.remove('hidden');
                bank.setAttribute('required', 'required');
                card.value = "";
                term.value = "";
                authorization.value = "";
                break;
            case "16":
                card.value = "";
                term.value = "";
                authorization.value = "";
                bank.value = "";
                break;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var paymentDateInput = document.querySelector('input[name="payment_date"]');

        if (paymentDateInput.value.length < 10) {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = String(currentDate.getMonth() + 1).padStart(2, '0');
            var day = String(currentDate.getDate()).padStart(2, '0');

            var formattedDate = year + '-' + month + '-' + day;

            // Asignar la fecha actual al campo de entrada
            paymentDateInput.value = formattedDate;

        }

        // Obtener la fecha actual en el formato deseado (puede variar según tus necesidades)

        var dropdown = document.getElementById('prices_id');

        dropdown.addEventListener('change', function() {
            var selectedValue = dropdown.value;

            // Envía una solicitud AJAX al servidor para actualizar la sesión
            $.ajax({
                type: 'POST',
                url: '{{ route('Participants.updatePriceFlash') }}',
                data: {
                    selectedValue: selectedValue,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Sesión actualizada');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error al actualizar la sesión');
                }
            });
        });
    });

    window.onload = function() {
        togglePaymentMethod();
        onSelectPriceTypeChange();
    };
    
  
    function imprimirDiv(idDiv) {
        var contenidoDiv = document.getElementById(idDiv).innerHTML;
        var ventanaImpresion = window.open('', '_blank');
        ventanaImpresion.document.write('<html><head><title>Imprimir</title></head><body>');
        ventanaImpresion.document.write(contenidoDiv);
        ventanaImpresion.document.write('</body></html>');
        ventanaImpresion.document.close();
        ventanaImpresion.print();
    }

function imprimir(recordPayments) {
    var data = recordPayments;

    var contenidoHTML = `
        <h1>Detalles del Pago</h1>
        <p>Fecha de Pago: ${data.payment_date}</p>
        <p>Programa: ${data.program}</p>
        <p>Registro de Pago: ${data.payment_record}</p>
        <!-- Agrega más detalles según tus necesidades -->
    `;

    var contenedorImpresion = document.getElementById('contenedorImpresion');
    contenedorImpresion.innerHTML = contenidoHTML;

    var iframeImpresion = document.createElement('iframe');
    iframeImpresion.style.display = 'none';
    iframeImpresion.style.width = '100%';  // Establece el ancho del iframe
    iframeImpresion.style.height = 'auto';  // Establece la altura del iframe como automática
    iframeImpresion.style.margin = '20px';  // Establece los márgenes del iframe

    document.body.appendChild(iframeImpresion);

    // Escribe el contenido del div en el iframe
    iframeImpresion.contentDocument.write(contenedorImpresion.innerHTML);

    // Escucha el evento de carga del iframe
    iframeImpresion.onload = function () {
        // Establece la altura del iframe según la altura del contenido
        iframeImpresion.style.height = '300px';

        // Llama a window.print() en el iframe
        iframeImpresion.contentWindow.print();

        // Elimina el iframe después de la impresión
        document.body.removeChild(iframeImpresion);
    };
}

</script>



