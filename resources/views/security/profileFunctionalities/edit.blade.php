<x-app-layout title="Functionality Profile" meta-description="Functionality Profiles">

    <x-slot name="title">
        @lang('Functionality Profiles')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Functionality Profile')</h1>

    {{-- @dump($profile->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ __(session('info')) }}
        </div>
    @endif
    {{-- @dump($profileFunctionalities->toArray()) --}}
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:430px" method="POST"
        action="{{ route('ProfileFunctionalities.update', $profileFunctionalities) }}">
        @csrf @method('PATCH')

        @include('security/profileFunctionalities.form-fields', $profileFunctionalities)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('ProfileFunctionalities.index', $profileFunctionalities) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
