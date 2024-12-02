<x-app-layout title="Payment" meta-description="Payment">

    <x-slot name="title">
        @lang('Facturación')
    </x-slot>

    <h1 class="px-8 py-2 text-2xl text-left text-sky-800 font-semibold">@lang('Editar información de facturación')</h1>

   
        
    
        <div class="p-8 border-b-2 text-lg font-mono bg-white">
            <div class="card mb-3">
                       
                <div class="p-8">
                    <div style="height: 30px">
                        @if (Session::has('success'))
                            <div id="successAlert" style="background-color: #93d693; color: #008000; padding:1px 8px; border-radius:5px">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        
                        @if (Session::has('error'))
                            <div id="errorAlert" style="background-color: #f9b8d3; color: red; padding:1px 8px; border-radius:5px">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                    <form id="form_payment" class="px-8 py-4 bg-white" method="POST" action="{{ route('PaymentU.update', $payment->payment_id) }}">
                        @csrf @method('PATCH')   
                        
                        <input type="hidden" 
                               id="payment_id"
                               name="payment_id"
                               value="{{ $payment->payment_id }}" />
                        
                        <div class="form-group-sm">
                            <label class="flex flex-col py-1 flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Identidad')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" 
                                    id="CC_RUC"
                                    name="CC_RUC" 
                                    value="{{ $payment->CC_RUC }}"
                                    minlength="10"
                                    maxlength="13" 
                                    onkeypress="return valideKey(event);"  
                                    required />
                                @error('CC_RUC')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        
                        <div class="form-group-sm">
                            <label class="flex flex-col py-1 flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Nombre Comercial')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" 
                                    id="nombre_comercial"
                                    name="nombre_comercial"
                                    value="{{ $payment->names_razon_social }}" />
                                @error('nombre_comercial')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        
                        <div class="form-group-sm">
                            <label class="flex flex-col py-1 flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Correo Electrónico')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" 
                                    id="email"
                                    name="email"
                                    value="{{ $payment->email }}"
                                    oninput="this.value = this.value.toLowerCase();"
                                    pattern="[^\s@]+@[^\s@]+\.[^\s@]+" 
                                    required />
                                @error('email')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        
                        <div class="form-group-sm">
                            <label class="flex flex-col py-1 flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Dirección')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" 
                                    id="address"
                                    name="address" 
                                    value="{{ $payment->address }}"
                                    required />
                                @error('address')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        
                        <div class="form-group-sm">
                            <label class="flex flex-col py-1 flex-1">
                                <span class="{{ Config::get('style.label') }}">@lang('Teléfono')</span>
                                <input class="{{ Config::get('style.cajaTexto') }} mr-4 " type="text" 
                                    id="phone"
                                    name="phone" 
                                    value="{{ $payment->phone }}"
                                    required />
                                @error('phone')
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                    </form> 
                    <form class="px-8" id="form_retorno" action="{{ route('Participants.retorno') }}" method="POST">
                        @csrf
                        <input type="hidden" value ="{{ $campusId }}" name="campusId" >
                        <input type="hidden" value ="{{ $trainingId }}" name="trainingId" >
                    </form>
                    
                    <div class="flex items-center justify-between mt-4 px-8">
                        <a class="{{ Config::get('style.btnSave') }} "
                            href="{{ route('Participants.payment', ['search' => $participant_id, 'campus' => $campusId, 'program' => $program, 'training' => $trainingId, 'training_id_enroller' => $trainingIdEnroller ?? '%']) }}">
                            <span>REGRESAR</span>
                        </a>  
                        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_payment">@lang('Save')</button>
                    </div> 
                    
                    
                </div>
            </div>
        </div>
    
    
    
    

</x-app-layout>
