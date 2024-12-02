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

    <form id="form_participant" class="px-8 py-4 bg-white" method="POST" action="{{ route('Participants.update', $participants) }}">
        @csrf @method('PATCH')
        @include('fyl/participants.form-fields', $participants)
    </form>
    <form id="form_retorno" action="{{ route('Participants.retorno') }}" method="POST">
        @csrf
        <input type="hidden" value ="{{ $campusId }}" name="campusId" >
        <input type="hidden" value ="{{ $trainingId }}" name="trainingId" >
    </form>
    <div class="flex items-center justify-between mt-4">
        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_retorno">@lang('To return')</button> 
        <button class="{{ Config::get('style.btnSave') }}" type="submit" form="form_participant">@lang('Save')</button>
    </div>


</x-app-layout>
