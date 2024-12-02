<x-app-layout title="Proveedor" meta-description="Proveedor">

    <x-slot name="title">
        @lang('Proveedor')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Editar Proveedor')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:auto" method="POST"
        action="{{ route('Proveedores.update', $proveedor) }}">
        @csrf @method('PATCH')

        @include('cash/proveedor.form-fields', $proveedor)
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('Proveedores.index', $proveedor) }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

        </div>

    </form>

</x-app-layout>