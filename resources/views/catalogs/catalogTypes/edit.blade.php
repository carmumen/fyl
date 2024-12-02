<x-app-layout title="CatalogTypes" meta-description="CatalogTypes">

    <x-slot name="title">
        @lang('CatalogTypes')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Catalog Type')</h1>

    {{-- @dump($catalogType->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:380px" method="POST"
        action="{{ route('CatalogTypes.update', $catalogType) }}">
        @csrf @method('PATCH')

        @include('catalogs/catalogTypes.form-fields', $catalogType)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('CatalogTypes.index', $catalogType) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
