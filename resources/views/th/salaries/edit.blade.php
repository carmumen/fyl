<x-app-layout title="Salaries" meta-description="Salaries">

    <x-slot name="title">
        @lang('Salaries')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Salary')</h1>

    {{-- @dump($salary->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:380px" method="POST"
        action="{{ route('Salaries.update', $salary) }}">
        @csrf @method('PATCH')

        @include('th/salaries.form-fields', $salary)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Salaries.index', $salary) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
