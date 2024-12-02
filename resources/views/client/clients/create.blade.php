<x-app-layout title="Clients" meta-description="Clients">

    <x-slot name="title">
        @lang('Clients')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Create Client')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('Clients.store') }}">
        @csrf
        @include('client/clients.form-fields', ['Client' => new App\Models\Client\Client()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Clients.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>
</x-app-layout>
