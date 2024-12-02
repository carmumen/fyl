<x-app-layout title="Profiles" meta-description="Profiles">

    <x-slot name="title">
        @lang('Profiles')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Profile')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:340px" method="POST"
        action="{{ route('Profiles.store') }}">
        @csrf
        @include('security/profiles.form-fields', ['profile' => new App\Models\Profile()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Profiles.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
