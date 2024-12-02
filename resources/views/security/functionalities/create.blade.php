<x-app-layout title="Functionalities" meta-description="Functionalities">

    <x-slot name="title">
        @lang('Functionalities')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Functionality')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:670px" method="POST"
        action="{{ route('Functionalities.store') }}">
        @csrf
        @include('security/functionalities.form-fields', [
            'functionality' => new App\Models\Functionality(),
        ])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Functionalities.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
