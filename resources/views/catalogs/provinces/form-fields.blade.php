<div class="space-y-4">

    <label class="flex flex-col">
        <input type="hidden" 
                id="country_id"
                name="country_id" 
                value=" {{ old('country_id', $province->country_id) }}"/>
        <span class="{{ Config::get('style.label') }}">@lang('Country')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                id="searchCountry" 
                name="searchCountry"
                onkeyup="spaces(this.id)"
                value=" {{ old('country', $province->country) }}"/>
    </label>

    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/3 pr-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Code')</span>
                <input class="{{ Config::get('style.cajaTexto') }} validador" 
                        type="text" 
                        name="code" 
                        value=" {{ old('code', $province->code) }}" required/>
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
                        value=" {{ old('name', $province->name) }}" required/>
                @error('name')
                    <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>

    <div class="flex flex-row flex-wrap">
        <div class="flex-1 md:basis-1/3 pr-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Acronym')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" 
                        type="text" 
                        name="acronym" 
                        value=" {{ old('acronym', $province->acronym) }}" required/>
                @error('acronym')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    
        <div class="flex-1 md:basis-1/3  pr-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Code RDEP')</span>
                <input class="{{ Config::get('style.cajaTexto') }} validador" 
                        type="text" 
                        name="code_RDEP" 
                        value=" {{ old('code_RDEP', $province->code_RDEP) }}" />
                @error('code_RDEP')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
        
        <div class="flex-1 md:basis-1/3 ">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Code MAP')</span>
                <input class="{{ Config::get('style.cajaTexto') }} validador" 
                        type="text" 
                        name="code_MAP" 
                        value=" {{ old('code_MAP', $province->code_MAP) }}" />
                @error('code_MAP')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
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
                 @if($province->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($province->status =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error('status')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>
<script>
    $('.validador').on('input', function () {
        this.value = this.value.replace(/[^0-9()\/]/g, '');
    });

    $( "#searchCountry" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: '/searchCountry/'+request.term,
            type: 'GET',
            dataType: "json",
             minLength: 2,
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
            $('#searchCountry').val(ui.item.label);
            $('#country_id').val(ui.item.id);
            return false;
        }
      });

    function spaces(e) {
        let x = document.getElementById(e);
        x.value = x.value.trim();
    }

</script>
