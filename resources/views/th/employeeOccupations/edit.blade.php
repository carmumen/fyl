<x-app-layout title="Employee Occupation" meta-description="Employee Occupation">

    <x-slot name="title">
        @lang('Employee Occupation')
    </x-slot>
    {{-- @dump($employeeOccupation->toArray()), --}}
    <h1 class="px-8 py-3 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Employee Occupation')</h1>
    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 bg-white" method="POST"
        action="{{ route('EmployeeOccupations.update', $employeeOccupation) }}">
        @csrf @method('PATCH')

        @include('th/EmployeeOccupations.form-fields', $employeeOccupation)

        <div class="flex items-center justify-between mt-4 px-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('EmployeeOccupations.index', $employeeOccupation) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>
        </div>
    </form>

</x-app-layout>
