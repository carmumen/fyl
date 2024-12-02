<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Aplication')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="aplication_id" 
                id="aplication_id" 
                value=" {{ old('aplication_id', $profileFunctionalities->aplication_id) }}" required/>
                <option value="">-- Seleccione --</option>
            @foreach($aplication as $id => $name)
                <option value="{{ $id }}"
                    @if($id == old('aplication_id', $profileFunctionalities->aplication_id)) selected @endif
                >{{ __($name) }}</option>
            @endforeach
        </select>
         @error(__('aplication_id'))
            <br>
            <small class="font-bold text-red-500/80">@lang( $message )</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Profile')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="profile_id" 
                id="profile_id" 
                value=" {{ old('profile_id', $profileFunctionalities->profile_id) }}" required/>
            @if(is_countable($profile) && count($profile) > 0) 
                <option value="">-- Seleccione --</option>
                @foreach($profile as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('profile_id', $profileFunctionalities->profile_id)) selected @endif
                    >{{ __($name) }}</option>
                @endforeach
            @endif
        </select>
         @error(__('profile_id'))
            <br>
            <small class="font-bold text-red-500/80">@lang( $message )</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Functionality')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="functionality_id" 
                id="functionality_id" 
                value=" {{ old('functionality_id', $profileFunctionalities->functionality_id) }}" />
            @if(is_countable($functionality) && count($functionality) >= 1) 
                <option value="">-- Seleccione --</option>
                @foreach($functionality as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('functionality_id', $profileFunctionalities->functionality_id)) selected @endif
                    >{{ __($name) }}</option>
                @endforeach
            @endif
        </select>
         @error(__('functionality_id'))
            <br>
            <small class="font-bold text-red-500/80">@lang( $message )</small>
        @enderror
    </label>
    
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="state" 
                required/>
            <option value="ACTIVE" 
                 @if($profileFunctionalities->state =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($profileFunctionalities->state =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error(__('state'))
            <br>
            <small class="font-bold text-red-500/80">@lang('The relationship Profile Functionality already exists!')</small>
        @enderror
    </label>
</div>
<script>
    $(document).ready(function () {
        $('#aplication_id').on('change', onSelectAplicationChange);
    });

    function onSelectAplicationChange() {
        var aplication_id = $('#aplication_id').val();
        var url_profile = '/profileAplication/'+aplication_id;
        var url_functionality = '/functionalityAplication/'+aplication_id;
        $('#profile_id').empty();
        $('#functionality_id').empty();
        var html_select_profile = '<option value="">-- Seleccione --</option>';
        var html_select_functionality = '<option value="">-- Seleccione --</option>';
        
        $.get( url_profile, function( data ) {
            for( var i=0; i<data.length; ++i )
                html_select_profile += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            $('#profile_id').html(html_select_profile);
        });

        $.get( url_functionality, function( data ) {
            for( var i=0; i<data.length; ++i )
                html_select_functionality += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            $('#functionality_id').html(html_select_functionality);
        });
    }

</script>