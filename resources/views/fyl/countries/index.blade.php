<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('User Profile')
        </h2>
    </x-slot>

    <header class="px-6 py-4 space-y-2 text-center">
        @auth
            <a class="{{ Config::get('style.btnCreate') }}" href="{{ route('UserProfiles.create') }}"> @lang('Create User Profile')
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

    <div class="max-w-screen-xl px-3 mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col mt-6 mb-8">
            <main class="overflow-hidden border border-gray-200 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-sky-800">
                        <tr>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Profile')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('User')
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
                        @foreach ($userProfiles as $userProfile)
                            <tr class="border-b border-gray-200">
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $userProfile->profile }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ __($userProfile->user) }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $userProfile->state }}
                                </td>
                                @auth
                                    <td class="w-24 inline-flex text-center py-1.5">
                                        <a class="{{ Config::get('style.btnEdit') }}"
                                            href="{{ route('UserProfiles.edit', $userProfile) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('UserProfiles.destroy', $userProfile) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                onclick="return confirm('¿Seguro que deseas eliminar el perfil?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3 text-sky-800 bg-gray-50">
                    {{ $userProfiles->links() }}
                </div>
            </main>
        </div>

</x-app-layout>
