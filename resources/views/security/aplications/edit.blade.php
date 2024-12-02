<x-app-layout title="Aplications" meta-description="Aplications">

    <x-slot name="title">
        Aplicaciones
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Aplication')</h1>

    {{-- @dump($Aplication->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:550px" method="POST"
        action="{{ route('Aplications.update', $Aplication) }}">
        @csrf @method('PATCH')

        @include('security/aplications.form-fields', $Aplication)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Aplications.index', $Aplication) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
