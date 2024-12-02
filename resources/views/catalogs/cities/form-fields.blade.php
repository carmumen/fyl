<div class="space-y-4">
   <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Country')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="country_id" 
                id="country_id" 
                value=" {{ old('country_id', $city->country_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($countries->toArray() as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('country_id', $city->country_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Province')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="province_id" 
                id="province_id" 
                value=" {{ old('province_id', $city->province_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($provinces->toArray() as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('province_id', $city->province_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Canton')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="canton_id" 
                id="canton_id" 
                value=" {{ old('canton_id', $city->canton_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($cantons->toArray() as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('canton_id', $city->canton_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>


    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/3 pr-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Code')</span>
                <input class="{{ Config::get('style.cajaTexto') }} validador" 
                        type="text" 
                        name="code" 
                        value=" {{ old('code', $city->code) }}" required/>
                @error('code')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex-1 md:basis-2/3">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Name')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="name" 
                        value=" {{ old('name', $city->name) }}" required/>
                @error('name')
                    <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " 
                type="text" 
                name="status" 
                required/>
            <option value="ACTIVE" 
                 @if($city->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($city->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>
<script>

    $(document).ready(function () {

        $('#country_id').on('change', onSelectCountryChange);
        $('#province_id').on('change', onSelectProvinceChange);
        
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

    $('.validador').on('input', function () {
        this.value = this.value.replace(/[^0-9()\/]/g, '');
    });

    function spaces(e) {
        let x = document.getElementById(e);
        x.value = x.value.trim();
    }

</script>
