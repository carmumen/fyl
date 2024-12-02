<x-app-layout title="Participants" meta-description="Participants">

    <x-slot name="title">
        @lang('Participants')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Participants')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 bg-white" method="POST"
        action="{{ route('Enroller.update', $participants) }}">
        @csrf @method('PATCH')

        @include('fyl/enroller.form-fields', $participants)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Enroller.index', $participants->campus_id) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
