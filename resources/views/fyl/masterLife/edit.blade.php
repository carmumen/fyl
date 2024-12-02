<x-app-layout title="Master Life" meta-description="Master Life">

    <x-slot name="title">
        @lang('Master Life')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Master Life')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:auto" method="POST"
        action="{{ route('MasterLife.update', $masterLife) }}">
        @csrf @method('PATCH')

        @include('fyl/masterLife.form-fields', $masterLife)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('MasterLife.index', $masterLife) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
