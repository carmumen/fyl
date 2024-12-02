<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Profile')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="profile_id" 
                id="profile_id" 
                value=" {{ old('profile_id', $userProfile->profile_id) }}" required/>
            @if(is_countable($profile) && count($profile) > 0) 
                <option value="">-- Seleccione --</option>
                @foreach($profile as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('profile_id', $userProfile->profile_id)) selected @endif
                    >{{ $name }}</option>
                @endforeach
            @endif
        </select>
         @error(__('profile_id'))
            <br>
            <small class="font-bold text-red-500/80">@lang( $message )</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('User')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                name="user_id" 
                id="user_id" 
                value=" {{ old('user_id', $userProfile->user_id) }}" />
            @if(is_countable($user) && count($user) >= 1) 
                <option value="">-- Seleccione --</option>
                @foreach($user as $id => $name)
                    <option value="{{ $id }}"
                        @if($id == old('user_id', $userProfile->user_id)) selected @endif
                    >{{ $name }}</option>
                @endforeach
            @endif
        </select>
         @error(__('user_id'))
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
                 @if($userProfile->state =="ACTIVE") selected @endif
            >@lang('ACTIVE')</option>
            <option value="INACTIVE" 
                 @if($userProfile->state =="INACTIVE") selected @endif
            >@lang('INACTIVE')</option>
        </select>
        @error(__('state'))
            <br>
            <small class="font-bold text-red-500/80">@lang('The relationship Profile User already exists!')</small>
        @enderror
    </label>
</div>
