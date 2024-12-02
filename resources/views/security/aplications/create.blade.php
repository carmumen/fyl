<x-app-layout title="Aplications" meta-description="Aplications">

    <x-slot name="title">
        @lang('Aplications')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Aplication')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:550px" method="POST"
        action="{{ route('Aplications.store') }}">
        @csrf
        @include('security/aplications.form-fields', ['aplication' => new App\Models\Aplication()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Aplications.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
