<x-app-layout>

    <x-slot name="title">
        @lang('Training')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Edit Program')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    @include('fyl/training.form-fields', ['training' => $training, 'accion' => 'editar', 'tab' => '1'])

</x-app-layout>
