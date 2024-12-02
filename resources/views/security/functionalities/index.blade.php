<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Functionalities')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Functionalities', 'pag' => $pag])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200 rounded">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerSecuencial') }} text-white">
                                    @lang('No.')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Aplication')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Module')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Functionality')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Route')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Order')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('State')
                                </th>
                                @auth
                                    <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($functionality as $functionalities)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowSequential') }}">
                                        {{ $functionalities->secuencial }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $functionalities->aplication }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($functionalities->modules) }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($functionalities->name) }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $functionalities->route }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $functionalities->order }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($functionalities->state) }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Functionalities.edit', $functionalities) }}">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>

                                            <form action="{{ route('Functionalities.destroy', $functionalities) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar la funcionalidad?')">
                                                    <span
                                                        class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                </button>
                                            </form>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{ $functionality->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>

</x-app-layout>
