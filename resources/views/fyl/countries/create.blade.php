<x-app-layout title="Countries" meta-description="Countries">

    <x-slot name="title">
        @lang('Countries')
    </x-slot>

    <h1 class="my-4 font-serif text-3xl text-center text-sky-600">@lang('Create Country')</h1>
    {{-- @dump($Profile->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="max-w-xl px-8 py-4 mx-auto bg-white rounded shadow" method="POST"
        action="{{ route('Countries.store') }}">
        @csrf
        @include('security/countries.form-fields', ['country' => new App\Models\Country()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Countries.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
