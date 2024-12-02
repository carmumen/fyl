<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Profiles')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Profiles', 'pag' => $pag])
        @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col"
                                    class="px-12 py-3.5 text-sm font-bold text-left rtl:text-right text-white uppercase">
                                    @lang('Aplication')
                                </th>
                                <th scope="col"
                                    class="py-3.5 px-12 text-sm font-bold text-left rtl:text-right text-white uppercase">
                                    @lang('Profile')
                                </th>
                                <th scope="col"
                                    class="py-3.5 px-6 text-sm font-bold text-left rtl:text-right text-white uppercase">
                                    @lang('Estado')
                                </th>
                                @auth
                                    <th scope="col" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($profile as $profiles)
                                <tr class="border-b border-gray-200">
                                    <td class="px-3 text-gray-500">
                                        {{ $profiles->aplication }}
                                    </td>
                                    <td class="px-3 text-gray-500 hover:underline ">
                                        {{ $profiles->name }}
                                    </td>
                                    <td class="px-3 text-gray-500">
                                        {{ $profiles->state }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Profiles.edit', $profiles) }}">
                                                <span class="icon-pencil"></span>
                                            </a>

                                            <form action="{{ route('Profiles.destroy', $profiles) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el perfil?')">
                                                    <span class="icon-bin2"></span>
                                                </button>
                                            </form>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{ $profile->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
        
        
    


</x-app-layout>
