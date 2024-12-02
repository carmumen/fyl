<x-app-layout title="CatalogTypes" meta-description="CatalogTypes">

    <x-slot name="title">
        @lang('CatalogTypes')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Catalog Type')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:380px" method="POST"
        action="{{ route('CatalogTypes.store') }}">
        @csrf
        @include('catalogs/catalogTypes.form-fields', [
            'catalogType' => new App\Models\Global\CatalogType(),
        ])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('CatalogTypes.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
