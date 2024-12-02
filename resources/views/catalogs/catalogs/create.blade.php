<x-app-layout title="Catalogs" meta-description="Catalogs">

    <x-slot name="title">
        @lang('Catalogs')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Catalog')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:420px" method="POST"
        action="{{ route('Catalogs.store') }}">
        @csrf
        @include('catalogs/catalogs.form-fields', ['catalog' => new App\Models\Global\Catalog()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Catalogs.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
