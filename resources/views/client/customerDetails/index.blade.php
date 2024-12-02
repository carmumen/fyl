<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Customer Details')
        </h2>
    </x-slot>

    <header class="ml-10 py-4 text-left">
        @auth
            <a class="{{ Config::get('style.btnCreate') }}" href="{{ route('CustomerDetails.create') }}"><span
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

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-sky-800">
                        <tr>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('DNI')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Surnames')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Names')
                            </th>
                            {{-- <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Birthdate')
                        </th>
                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Gender')
                        </th> --}}
                            {{-- <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Civil Status')
                        </th> --}}
                            {{-- <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                            @lang('Address')
                        </th> --}}
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Phone')
                            </th>
                            <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                @lang('Email')
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
                        @foreach ($customerDetail as $customerDetails)
                            <tr class="border-b border-gray-200">
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $customerDetails->DNI }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $customerDetails->surnames }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $customerDetails->names }}
                                </td>
                                {{-- <td class="{{ Config::get('style.rowCenter') }}">
                                {{ $customerDetails->birthdate }}
                            </td>
                            <td class="{{ Config::get('style.rowCenter') }}">
                                {{ $customerDetails->civil_status }}
                            </td>
                            <td class="{{ Config::get('style.rowCenter') }}">
                                {{ $customerDetails->address }}
                            </td> --}}
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $customerDetails->phone }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ $customerDetails->email }}
                                </td>
                                <td class="{{ Config::get('style.rowCenter') }}">
                                    {{ __($customerDetails->status) }}
                                </td>
                                @auth
                                    <td class="w-24 inline-flex text-center py-1.5">
                                        <a class="{{ Config::get('style.btnEdit') }}"
                                            href="{{ route('customerDetails.edit', $customerDetails->id) }}">
                                            <span
                                                class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                        </a>

                                        <form action="{{ route('customerDetails.destroy', $customerDetails) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                onclick="return confirm('¿Seguro que deseas eliminar el customerDetaile?')">
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
                {{-- <div class="px-4 py-3 text-sky-800 bg-gray-50"> --}}
                {{ $customerDetail->links() }}
                {{-- </div> --}}
            </main>
        </div>

</x-app-layout>
