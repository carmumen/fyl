<div class="space-y-4" >
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/4  px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="DNI" 
                        {{-- maxlength="10" --}}
                        onkeypress="return valideKey(event),"
                        value=" {{ old('DNI', $client->DNI) }}" required/>
                @error('DNI')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4  px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="surnames" 
                        value=" {{ old('surnames', $client->surnames) }}" required/>
                @error('surnames')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4  px-4">
            <label class="flex flex-col ">
                <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="names" 
                        value=" {{ old('names', $client->names) }}" required/>
                @error('names')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4  px-4">
            <label class="flex flex-col ">
                <span class="{{ Config::get('style.label') }}">@lang('Nickname')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="nickname" 
                        value=" {{ old('nickname', $client->nickname) }}" required/>
                @error('nickname')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Birthdate')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        id="birthdate" 
                        name="birthdate" 
                        value=" {{ old('birthdate', $client->birthdate) }}" required/>
                @error('birthdate')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Gender')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="gender_catalog_id" 
                        id="gender_catalog_id" 
                        value=" {{ old('gender_catalog_id', $client->gender_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($gender as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('gender_catalog_id', $client->gender_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Civil Status')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="civil_status_catalog_id" 
                        id="civil_status_catalog_id" 
                        value=" {{ old('civil_status_catalog_id', $client->civil_status_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($civil_status as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('civil_status_catalog_id', $client->civil_status_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('EducationLevel')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="education_level_catalog_id" 
                        id="education_level_catalog_id" 
                        value=" {{ old('education_level_catalog_id', $client->education_level_catalog_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($education_level as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('education_level_catalog_id', $client->education_level_catalog_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="address" 
                        value=" {{ old('address', $client->address) }}" required/>
                @error('address')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Mobile Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="mobile_phone" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('mobile_phone', $client->mobile_phone) }}" required/>
                @error('mobile_phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Home Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="home_phone" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('home_phone', $client->home_phone) }}" />
                @error('home_phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Work Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="work_phone" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('work_phone', $client->work_phone) }}" />
                @error('work_phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="email" 
                        value=" {{ old('email', $client->email) }}" required/>
                @error('email')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        
    </div>

    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact Name')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="emergency_contact_name" 
                        value=" {{ old('emergency_contact_name', $client->emergency_contact_name) }}" required/>
                @error('emergency_contact_name')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="emergency_contact_phone" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('emergency_contact_phone', $client->emergency_contact_phone) }}" />
                @error('emergency_contact_phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Reference Contact Name')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="reference_contact_name" 
                        value=" {{ old('reference_contact_name', $client->reference_contact_name) }}" />
                @error('reference_contact_name')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Reference Contact Phone')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="reference_contact_phone" 
                        value=" {{ old('reference_contact_phone', $client->reference_contact_phone) }}" required/>
                @error('reference_contact_phone')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        
    </div>

    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/2 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Occupation or Profession')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="occupation_or_profession" 
                        value=" {{ old('occupation_or_profession', $client->occupation_or_profession) }}" required/>
                @error('occupation_or_profession')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-1/2 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Company')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="company" 
                        value=" {{ old('company', $client->company) }}" />
                @error('company')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        
    </div>

    <div class="flex flex-row flex-wrap">

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Country')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="country_id" 
                        id="country_id" 
                        value=" {{ old('country_id', $client->country_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($countries->toArray() as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('country_id', $client->country_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Department or Province')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="province_id" 
                        id="province_id" 
                        value=" {{ old('province_id', $client->province_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($provinces->toArray() as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('province_id', $client->province_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Canton')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="canton_id" 
                        id="canton_id" 
                        value=" {{ old('canton_id', $client->canton_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($cantons->toArray() as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('canton_id', $client->canton_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('City')</span>
                <select class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="city_id" 
                        id="city_id" 
                        value=" {{ old('city_id', $client->city_id) }}" required/>
                        <option value="">-- Seleccione --</option>
                    @foreach($cities->toArray() as $id => $name)
                        <option value="{{ $id }}"
                            @if($id == old('canton_id', $client->canton_id)) selected @endif
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        
    </div>

    <div class="flex flex-row flex-wrap">
        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Psychiatric Illness')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="psychiatric_illness" 
                        required/>
                    <option value="NO" 
                        @if($client->psychiatric_illness =="NO") selected @endif
                    >@lang('NO')</option>
                    <option value="SI" 
                        @if($client->psychiatric_illness =="SI") selected @endif
                    >@lang('SI')</option>
                </select>
                @error('psychiatric_illness')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-3/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Psychiatric Illness Details')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="psychiatric_illness_detail" 
                        onkeypress="return valideKey(event),"
                        value=" {{ old('psychiatric_illness_detail', $client->psychiatric_illness_detail) }}" />
                @error('psychiatric_illness_detail')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        
    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Medical History That Should Be Known')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="medical_history_that_should_be_known" 
                        value=" {{ old('medical_history_that_should_be_known', $client->medical_history_that_should_be_known) }}" required/>
                @error('medical_history_that_should_be_known')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>
    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Medication That Alters Habitual Behavior')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="medication_that_alters_habitual_behavior" 
                        value=" {{ old('medication_that_alters_habitual_behavior', $client->medication_that_alters_habitual_behavior) }}" required/>
                @error('medication_that_alters_habitual_behavior')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    
    <div class="flex flex-row flex-wrap">
        <div class="flex-1 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Medical History That Should Be Known')</span>
                <input class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="medical_history_that_should_be_known" 
                        value=" {{ old('medical_history_that_should_be_known', $client->medical_history_that_should_be_known) }}" required/>
                @error('medical_history_that_should_be_known')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <div class="flex flex-row flex-wrap">

        <div class="flex-1 md:basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('State')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="status" 
                        required/>
                    <option value="ACTIVE" 
                        @if($client->status =="ACTIVE") selected @endif
                    >@lang('ACTIVE')</option>
                    <option value="INACTIVE" 
                        @if($client->status =="INACTIVE") selected @endif
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
    $(document).ready(function () {
         $( "#birthdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        }),

        $('#country_id').on('change', onSelectCountryChange);
        $('#province_id').on('change', onSelectProvinceChange);
        $('#canton_id').on('change', onSelectCantonChange);
        
    });

    function onSelectCountryChange() {
        var country_id = $('#country_id').val();
        var url = '/searchProvince/'+country_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#province_id').empty();
        $.get( url , function( data ) {
            //console.log(data);
            for( var i=0; i<data.length; ++i )
                html_select += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            //console.log(html_select),
            $('#province_id').html(html_select);
        });
    }

    function onSelectProvinceChange() {
        var province_id = $('#province_id').val();
        var url = '/searchCanton/'+province_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#canton_id').empty();
        $.get( url , function( data ) {
            //console.log(data);
            for( var i=0; i<data.length; ++i )
                html_select += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            //console.log(html_select),
            $('#canton_id').html(html_select);
        });
    }

    function onSelectCantonChange() {
        var canton_id = $('#canton_id').val();
        var url = '/searchCity/'+canton_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#city_id').empty();
        $.get( url , function( data ) {
            //console.log(data);
            for( var i=0; i<data.length; ++i )
                html_select += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            //console.log(html_select),
            $('#city_id').html(html_select);
        });
    }
    
    $('.decimales').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });

    function valideKey(evt){
        var code = (evt.which) ? evt.which : evt.keyCode;
        
        if(code==8) { // backspace.
            return true;
        } else if(code>=48 && code<=57) { // is a number.
            return true;
        } else{ // other keys.
            return false;
        }
    }

 
</script>