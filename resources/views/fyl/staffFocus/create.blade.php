<x-app-layout title="Campus" meta-description="Campus">

    <x-slot name="title">
        @lang('Staff')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Staff')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('Staff.store') }}">
        @csrf
        @include('fyl/staff.form-fields', ['campus' => new App\Models\Fyl\StaffFocus()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Staff.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
