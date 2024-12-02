<x-app-layout title="Modules" meta-description="Modules">

    <x-slot name="title">
        @lang('Modules')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Module')</h1>

    {{-- @dump($module->toArray()) --}}

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:530px" method="POST"
        action="{{ route('Modules.update', $module) }}">
        @csrf @method('PATCH')

        @include('security/modules.form-fields', $module)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Modules.index', $module) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>
