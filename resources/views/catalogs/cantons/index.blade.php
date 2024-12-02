<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Cantons')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Cantons'])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Country')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Province')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Name')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Code')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('status')
                                </th>
                                @auth
                                    <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($canton as $cantons)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $cantons->country }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $cantons->province }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $cantons->name }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $cantons->code }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($cantons->status) }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Cantons.edit', $cantons->id) }}">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>

                                            <form action="{{ route('Cantons.destroy', $cantons) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el País?')">
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
                    <div id="pagina" class=" text-sky-800 bg-gray-50">
                        {{ $canton->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50">
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
