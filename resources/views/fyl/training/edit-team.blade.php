<x-app-layout>

    <x-slot name="title">
        @lang('Training')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Team')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form method="POST" action="{{ route('OldTeam.update', $participants->number . '|' . $participants->DNI) }}">
        @csrf @method('PATCH')

        @include('fyl/training.form-fields-team', ['participants' => $participants])

        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('OldTeam.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>
    </form>

</x-app-layout>
