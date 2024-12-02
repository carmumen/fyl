<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Campus User')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'CampusUser'])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('País')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('City')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Campus')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Address')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Phone')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Users')
                                </th>
                                @auth
                                    <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($campus as $theCampus)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->pais }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->city }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->name }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->address }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->phone }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theCampus->cant }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('CampusUser.edit', $theCampus->id) }}">
                                                <span
                                                    class="icon-plus text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50">
                        {{-- {{ $campus->links() }} --}}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50">
                </div>
            </main>
        </div>

</x-app-layout>
