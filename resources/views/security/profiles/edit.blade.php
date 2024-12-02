<x-app-layout title="Profiles" meta-description="Profiles">

    <x-slot name="title">
        @lang('Profiles')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">Edit Profile</h1>

    {{-- @dump($profile->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:340px" method="POST"
        action="{{ route('Profiles.update', $profile) }}">
        @csrf @method('PATCH')

        @include('security/profiles.form-fields', $profile)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Profiles.index', $profile) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
