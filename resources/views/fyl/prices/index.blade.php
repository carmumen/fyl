<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Prices')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Prices'])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Campus')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Program')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Price Type')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Description')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Programs')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }} w-12">
                                    @lang('Price')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }} w-12">
                                    @lang('Precio Contifico')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Status')
                                </th>
                                @auth
                                    <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($prices as $thePrices)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thePrices->campus }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thePrices->program }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thePrices->price_type }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thePrices->description }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $thePrices->programs_included }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }} w-12">
                                        {{ $thePrices->price }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }} w-12">
                                        {{ $thePrices->pvp_contifico }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($thePrices->status) }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Prices.edit', $thePrices->id) }}">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>

                                            <form action="{{ route('Prices.destroy', $thePrices->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el Precio?')">
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
                        {{ $prices->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>

</x-app-layout>
