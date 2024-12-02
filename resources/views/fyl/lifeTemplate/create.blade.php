<x-app-layout title="Life Template" meta-description="Life Template">

    <x-slot name="title">
        @lang('Life Template')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Life Template')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('LifeTemplate.store') }}">
        @csrf
        @include('fyl/lifeTemplate.form-fields', ['country' => new App\Models\Fyl\LifeTemplate()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('LifeTemplate.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
