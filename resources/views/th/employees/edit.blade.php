<x-app-layout>

    <x-slot name="title">
        @lang('Employees')
    </x-slot>

    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Employee')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    @include('th/employees.form-fields', ['employee' => $employee, 'accion' => 'editar', 'tab' => '1'])


</x-app-layout>
