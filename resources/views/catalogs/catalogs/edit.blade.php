<x-app-layout title="Catalogs" meta-description="Catalogs">

    <x-slot name="title">
        @lang('Catalogs')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Catalog')</h1>

    {{-- @dump($catalog->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:420px" method="POST"
        action="{{ route('Catalogs.update', $catalog) }}">
        @csrf @method('PATCH')

        @include('catalogs/catalogs.form-fields', $catalog)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Catalogs.index', $catalog) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
