<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Members')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Users', 'pag' => $pag])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="sticky top-0 bg-sky-800">
                            <tr>
                                @auth
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:100px">
                                        @lang('Edit')
                                    </th>
                                @endauth
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" >
                                    @lang('Name')
                                </th>
                               <th scope="col" class="{{ Config::get('style.headerCenter') }}" >
                                    @lang('Email')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:100px">
                                    @lang('Tipo')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="width:100px">
                                    @lang('State')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($User as $Users)
                                <tr class="border-b border-gray-200">
                                    @auth
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Users.edit', $Users) }}">
                                                <span class="icon-pencil"></span>
                                            </a>
                                        </td>
                                    @endauth
                                    <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1rem; padding:1rem">
                                        {{ $Users->name }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1rem; padding:1rem">
                                        {{ $Users->email }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1rem; padding:1rem">
                                        {{ $Users->user_type }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="font-size:1rem; padding:1rem">
                                        {{ __($Users->status) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{ $User->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>

</x-app-layout>
