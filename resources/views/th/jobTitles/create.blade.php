<x-app-layout title="Job Titles" meta-description="Job Titles">

    <x-slot name="title">
        @lang('Job Titles')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Job Title')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:510px" method="POST"
        action="{{ route('JobTitles.store') }}">
        @csrf
        @include('th/jobTitles.form-fields', ['jobTitle' => new App\Models\TH\JobTitle()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('JobTitles.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>