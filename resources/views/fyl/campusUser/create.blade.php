<x-app-layout title="Campus Employee" meta-description="Campus Employee">

    <x-slot name="title">
        @lang('Campus Employee')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Campus Employee')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('CampusEmployee.store') }}">
        @csrf
        @include('fyl/campusEmployee.form-fields', ['campus' => new App\Models\Fyl\CampusEmployee()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('CampusEmployee.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
