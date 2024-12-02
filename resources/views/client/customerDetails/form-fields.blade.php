<div class="space-y-4" >
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/3  px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="DNI" 
                        {{-- maxlength="10" --}}
                        onkeypress="return valideKey(event),"
                        value=" {{ old('DNI', $customerDetail->DNI) }}" required/>
                @error('DNI')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/3  px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="surnames" 
                        value=" {{ old('surnames', $customerDetail->surnames) }}" required/>
                @error('surnames')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/3  px-4">
            <label class="flex flex-col ">
                <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="names" 
                        value=" {{ old('names', $customerDetail->names) }}" required/>
                @error('names')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/3 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Birthdate')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        id="birthdate" 
                        name="birthdate" 
                        value=" {{ old('birthdate', $customerDetail->birthdate) }}" required/>
                @error('birthdate')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/3 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Gender')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="gender_catalog_id" 
                        id="gender_catalog_id" 
                        value=" {{ old('gender_catalog_id', $customerDetail->gender_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($gender as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('gender_catalog_id', $customerDetail->gender_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/3 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Civil Status')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="civil_status_catalog_id" 
                        id="civil_status_catalog_id" 
                        value=" {{ old('civil_status_catalog_id', $customerDetail->civil_status_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($civil_status as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('civil_status_catalog_id', $customerDetail->civil_status_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        
    </div>
    
    <div class="flex flex-row flex-wrap">

        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="phone" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('phone', $customerDetail->phone) }}" required/>
                @error('phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-3/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="address" 
                        value=" {{ old('address', $customerDetail->address) }}" required/>
                @error('address')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <div class="flex flex-row flex-wrap">

        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Education Level')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="education_level_catalog_id" 
                        id="education_level_catalog_id" 
                        value=" {{ old('education_level_catalog_id', $customerDetail->education_level_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($education_level as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('education_level_catalog_id', $customerDetail->education_level_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="basis-1/2 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="email" 
                        value=" {{ old('email', $customerDetail->email) }}" required/>
                @error('email')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('State')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="status" 
                        required/>
                    <option value="ACTIVE" 
                        @if($customerDetail->status =="ACTIVE") selected @endif
                    >@lang('ACTIVE')</option>
                    <option value="INACTIVE" 
                        @if($customerDetail->status =="INACTIVE") selected @endif
                    >@lang('INACTIVE')</option>
                </select>
                @error('status')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>
    
</div>

<script>
    $(document).ready(function() {
        $( "#birthdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        }),
   
    }),
    
    $('.decimales').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.'),
    }),

    function valideKey(evt){
        var code = (evt.which) ? evt.which : evt.keyCode,
        
        if(code==8) { // backspace.
            return true,
        } else if(code>=48 && code<=57) { // is a number.
            return true,
        } else{ // other keys.
            return false,
        }
    }

 
</script>