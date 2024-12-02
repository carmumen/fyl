<x-app-layout title="User Profile" meta-description="User Profile">

    <x-slot name="title">
        @lang('User Profile')
    </x-slot>

    <h1 class="my-4 font-serif text-3xl text-center text-sky-600">@lang('Edit User Profile')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ __(session('info')) }}
        </div>
    @endif
    <form class="max-w-xl px-8 py-4 mx-auto bg-white rounded shadow" method="POST"
        action="{{ route('UserProfiles.update', $userProfile) }}">
        @csrf

        @include('security/userProfiles.form-fields', $userProfile)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('UserProfiles.index', $userProfile) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
