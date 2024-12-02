<x-app-layout title="Employee Occupation" meta-description="Employee Occupation">

    <x-slot name="title">
        @lang('Employee Occupation')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Create Employee Occupation')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 bg-white" method="POST" action="{{ route('EmployeeOccupations.store') }}">
        @csrf
        @include('th/EmployeeOccupations.form-fields', [
            'EmployeeOccupation' => new App\Models\TH\EmployeeOccupation(),
        ])
        <div class="flex items-center justify-between mt-4  px-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('EmployeeOccupations.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>
</x-app-layout>
