<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Modules')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Modules', 'pag' => $pag])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="max-w-screen-xl px-3 mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col mt-6 mb-8">
                <main class="border border-gray-200 md:rounded-lg">
                    <div id="conResultados">
                        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Aplication')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Parent Module')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Module')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Order')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Estado')
                                    </th>
                                    @auth
                                        <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100">
                                @foreach ($module as $modules)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ __($modules->aplication) }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ __($modules->parent_module) }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ __($modules->name) }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ __($modules->order) }}
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            {{ __($modules->state) }}
                                        </td>
                                        @auth
                                            <td class="w-24 inline-flex text-center py-1.5">
                                                <a class="{{ Config::get('style.btnEdit') }}"
                                                    href="{{ route('Modules.edit', $modules) }}">
                                                    <span class="icon-pencil"></span>
                                                </a>

                                                {{-- @if ($module->functionality_count == 0) --}}
                                                <form action="{{ route('Modules.destroy', $modules) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                        onclick="return confirm('¿Seguro que deseas eliminar el módulo?')">
                                                        <span class="icon-bin2"></span>
                                                    </button>
                                                </form>
                                                {{-- @endif --}}
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                            {{ $module->links() }}
                        </div>
                    </div>
                    <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400"></div>
                </main>
            </div>
        </div>

</x-app-layout>
