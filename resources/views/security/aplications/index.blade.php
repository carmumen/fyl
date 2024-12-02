<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Aplications')
        </h2>
    </x-slot>

    <header class="ml-10 py-4 text-left">
        @auth
            <a class="{{ Config::get('style.btnCreate') }}" href="{{ route('Aplications.create') }}"><span
                    class="icon-plus"></span>&nbsp; @lang('New')
            </a>
            @if (session('status'))
                <div class="text-green-600 h-3">
                    {{ __(session('status')) }}
                </div>
            @endif
            @if (session('errors'))
                <div class="font-bold text-red-500 h-3">
                    {{ __(session('errors')) }}
                </div>
            @endif
        @endauth
    </header>
    <div class="max-w-screen-xl px-3 py-2 mx-auto font-bold text-white sm:px-6 lg:px-8 w-full overflow-auto">
        <main class="grid w-full gap-4 mt-6 px-4 max-w-7xl md:grid-cols-2 lg:grid-cols-3 text-center">
            @foreach ($aplication as $aplications)
                <div class="max-w-3xl px-4 py-2 space-y-2 bg-white rounded shadow">

                    <h2 class="text-xl text-sky-600 hover:underline uppercase">
                        <a href="{{ route('Aplications.show', $aplications) }}">
                            <i class="{{ $aplications->icon }} fa-2x"></i><br />
                            {{ __($aplications->name) }}
                        </a>
                    </h2>
                    <div class="flex flex-col max-w-xl px-8 py-4 mx-auto bg-white rounded shadow h-30">
                        <p class="flex-1 leading-normal text-center text-slate-600">
                            {{ substr($aplications->description, 0, 90) . '...' }}
                        </p>
                        <div class="text-center text-gray-600">
                            {{ __($aplications->state) }}
                        </div>
                    </div>
                    @auth
                        <div class="flex justify-between">

                            <a class="inline-flex items-center text-xs font-semibold tracking-widest text-center uppercase transition duration-150 ease-in-out text-slate-500 hover:text-slate-600 focus:outline-none focus:border-slate-200"
                                href="{{ route('Aplications.edit', $aplications) }}">@lang('Edit')</a>&nbsp;

                            @if ($aplications->module_count == 0)
                                <form action="{{ route('Aplications.destroy', $aplications) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="inline-flex items-center text-xs font-semibold tracking-widest text-center text-red-500 uppercase transition duration-150 ease-in-out hover:text-red-600 focus:outline-none"
                                        type="submit"
                                        onclick="return confirm('¿Seguro que deseas eliminar la aplicación?')">
                                        @lang('Delete')
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endauth
                </div>
            @endforeach
        </main>
    </div>

</x-app-layout>
