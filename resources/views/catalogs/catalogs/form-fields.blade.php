<div class="space-y-4">

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Catalog Type')</span>
        <select class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="catalog_types_id"
                id="catalog_types_id"
                value=" {{ old('catalog_types_id', $catalog->catalog_types_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($catalogType as $id => $name)
                <option value="{{ $id }}"
                    {{-- @if($id == old('catalog_types_id', $catalog->catalog_types_id)) selected @endif --}}
                >{{ __($name) }}</option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Catalog')</span>
		<input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="name"
                value=" {{ old('name', $catalog->name) }}" required/>
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Acronym')</span>
		<input class="{{ Config::get('style.cajaTexto') }}"
                type="text"
                name="acronym"
                value=" {{ old('acronym', $catalog->acronym) }}" required/>
        @error('acronym')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
        <select class="{{ Config::get('style.cajaTexto') }} "
                type="text"
                name="status"
                required/>
            <option value="ACTIVE"
                 @if($catalog->status =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE"
                 @if($catalog->status =="INACTIVE") selected @endif
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
       // $('#catalog_types_id').on('change', onSelectCatalogTypesChange);
    });

    function onSelectCatalogTypesChange() {
        var catalog_types_id = $('#catalog_types_id').val();
        var url = '/catTypeId/'+catalog_types_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#catalog_types_id').empty();
        $.get( url , function( data ) {
            //console.log(data);
            for( var i=0; i<data.length; ++i )
                html_select += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            //console.log(html_select),
            $('#catalog_types_id').html(html_select);
        });
    }

</script>
