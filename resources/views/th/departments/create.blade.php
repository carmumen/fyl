<x-app-layout>

    {{-- <x-slot name="title">
        @lang('Departments')
    </x-slot> --}}

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Department')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:380px" method="POST"
        action="{{ route('Departments.store') }}">
        @csrf
        @include('th/departments.form-fields', ['department' => new App\Models\TH\Department()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Departments.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>

</x-app-layout>
