<x-app-layout title="FDS" meta-description="FDS">

    <x-slot name="title">
        @lang('FDS')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Editar FDS')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:auto" method="POST"
        action="{{ route('Fds.update', $fds) }}">
        @csrf @method('PATCH')

        <input type="hidden" id='action' name='action' value="edit" />

        @include('fyl/fds.form-fields', $fds)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Fds.index', $fds) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
