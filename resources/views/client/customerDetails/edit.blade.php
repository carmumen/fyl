<x-app-layout title="Customer Details" meta-description="Customer Details">

    <x-slot name="title">
        @lang('Customer Details')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Customer Detail')</h1>
    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('CustomerDetails.update', $client) }}">
        @csrf @method('PATCH')

        @include('client/customerDetails.form-fields', $client)

        <div class="flex items-center justify-between mt-4 px-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('CustomerDetails.index', $client) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>
        </div>
    </form>

</x-app-layout>
