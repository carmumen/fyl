<x-app-layout title="Countries" meta-description="Countries">

    <x-slot name="title">
        @lang('Countries')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Country')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:550px" method="POST"
        action="{{ route('Countries.store') }}">
        @csrf
        @include('catalogs/countries.form-fields', ['country' => new App\Models\Global\Country()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Countries.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
