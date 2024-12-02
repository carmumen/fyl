@component('layouts.container')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-table-columns"></i>
            {{ __('Apps') }}
        </h2>
    </x-slot>

    <div class="py-12  w-full overflow-auto">
        @if(session()->has('aplication') && session('aplication'))
           
            @include('dashboard-app', ['aplication' => session('aplication')->toArray()])
        @else
            <div class="alert alert-warning">
                No se encontraron aplicaciones disponibles.
            </div>
        @endif
    </div>
@endcomponent


