<x-app-layout title="Users" meta-description="Users">

    <x-slot name="title">
        @lang('Users')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create User')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <form class="px-8 py-4 mx-auto bg-white rounded shadow w-3/5" style="height:340px" method="POST"
        action="{{ route('Users.store') }}">
        @csrf
        @include('security/users.form-fields', ['user' => new App\Models\User()])
        <div class="flex items-center justify-between mt-4">
            <a class="{{ Config::get('style.btnReturn') }}" href="{{ route('Users.index') }}">@lang('To return')</a>
            <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
        </div>
    </form>


</x-app-layout>
