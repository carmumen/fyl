<x-app-layout title="Clients" meta-description="Clients">

    <x-slot name="title">
        @lang('Clients')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Client')</h1>
    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('Clients.update', $client) }}">
        @csrf @method('PATCH')

        @include('client/clients.form-fields', $client)

        <div class="flex items-center justify-between mt-4 px-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Clients.index', $client) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>
        </div>
    </form>

</x-app-layout>
