<x-app-layout title="Cantons" meta-description="Cantons">

    <x-slot name="title">
        @lang('Cantons')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Canton')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('Cantons.store') }}">
        @csrf
        @include('catalogs/cantons.form-fields', ['country' => new App\Models\Global\Canton()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Cantons.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
