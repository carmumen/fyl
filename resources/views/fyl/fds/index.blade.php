<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('FDS')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Fds'])
    </header>
    
    @if (Session::has('success'))
                <div id="successAlert" class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            
            @if (Session::has('error'))
                <div id="errorAlert" class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('No.')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Campus')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Training In Game')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Start Date')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('End Date')
                                </th>
                                @auth
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Team')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Observers')
                                    </th>
                                    <th scope="col" class="w-24 relative py-3.5 px-4">
                                        @lang('Edit')
                                    </th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($fds as $theFds)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theFds->secuencial }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theFds->name }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theFds->training_in_game }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $theFds->start_date }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($theFds->end_date) }}
                                    </td>
                                    @auth
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('FdsTeam.teams', $theFds->id) }}">
                                                <span
                                                    class="icon-plus text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('FdsTeam.teams', $theFds->id) }}">
                                                <span
                                                    class="icon-plus text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Fds.edit', $theFds->id) }}">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>

                                            <form action="{{ route('Fds.destroy', $theFds->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el FDS?')">
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
                        {{ $fds->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50">
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
