<x-app-layout title="FDS" meta-description="FDS">

    <x-slot name="title">
        @lang('FDS')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Crear FDS')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <form class="px-8 py-4 mx-auto  bg-white rounded shadow w-3/5" style="height:700px" method="POST"
        action="{{ route('Fds.store') }}">
        @csrf

        <input type="hidden" id='action' name='action' value="new" />
        <p style="text-align:center; color:#FF0000; margin-bottom: 20px">Para registrar el equipo de fin de semana, primero asegúrate de haber registrado las fechas de inicio y fin tanto del entrenamiento LIFE como del nuevo entrenamiento en juego en el menú "Oficina → Entrenamiento".</p>
        @include('fyl/fds.form-fields', ['fds' => new App\Models\Fyl\Fds()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Fds.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
