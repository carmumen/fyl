<x-app-layout title="Salaries" meta-description="Salaries">

    <x-slot name="title">
        @lang('Salaries')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Salary')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:380px" method="POST"
        action="{{ route('Salaries.store') }}">
        @csrf
        <div class="my-4"><b style="color:red">Nota:</b> Solo se puede registrar salarios a empleados que tienen
            registrada la ocupación </div>

        @include('th/salaries.form-fields', ['department' => new App\Models\TH\Department()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Salaries.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
