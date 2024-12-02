<x-app-layout title="Cities" meta-description="Cities">

    <x-slot name="title">
        @lang('Cities')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit City')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('Cities.update', $city) }}">
        @csrf @method('PATCH')

        @include('catalogs/cities.form-fields', $city)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Cities.index', ['search' => $search]) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
