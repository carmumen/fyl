<x-app-layout title="User Profile" meta-description="User Profile">

    <x-slot name="title">
        @lang('User Profile')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create User Profile')</h1>
    {{-- @dump($Profile->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:340px" method="POST"
        action="{{ route('UserProfiles.store') }}">
        @csrf
        @include('security/userProfiles.form-fields', ['userProfile' => new App\Models\UserProfile()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('UserProfiles.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
<script>
    $(document).ready(function() {
        //alert();
        chargeUserProfileChange();
    });

    function chargeUserProfileChange() {
        var url_profile = '/profileUserProfile/';
        var url_user = '/userUserProfile/';
        $('#profile_id').empty();
        $('#user_id').empty();
        var html_select_profile = '<option value="">-- Seleccione --</option>';
        var html_select_user = '<option value="">-- Seleccione --</option>';

        $.get(url_profile, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select_profile += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#profile_id').html(html_select_profile);
        });

        $.get(url_user, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select_user += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#user_id').html(html_select_user);
        });
    }
</script>
