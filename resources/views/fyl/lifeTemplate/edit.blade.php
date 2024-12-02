<x-app-layout title="Life Template" meta-description="Life Template">

    <x-slot name="title">
        @lang('Life Template')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Life Template')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:auto" method="POST"
        action="{{ route('LifeTemplate.update', $lifeTemplate) }}">
        @csrf @method('PATCH')

        @include('fyl/lifeTemplate.form-fields', $lifeTemplate)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('LifeTemplate.index', $lifeTemplate) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
