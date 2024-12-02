<x-app-layout title="Life Participant" meta-description="Life Participant">

    <x-slot name="title">
        @lang('Life Participant')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Life Participant')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('LifeParticipants.store') }}">
        @csrf
        @include('fyl/LifeParticipants.form-fields', [
            'LifeParticipants' => new App\Models\Fyl\LifeParticipants(),
        ])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('LifeParticipants.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
