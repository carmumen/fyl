<x-app-layout title="Focus Participant" meta-description="Focus Participant">

    <x-slot name="title">
        @lang('Focus Participant')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Focus Participant')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('FocusParticipants.store') }}">
        @csrf
        @include('fyl/focusParticipants.form-fields', [
            'focusParticipants' => new App\Models\Fyl\FocusParticipants(),
        ])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('FocusParticipants.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
