<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Gastos')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Gastos'])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="sticky top-0 bg-sky-800">
                            
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                    @lang('No.')
                                </th>
                                @auth
                                    <th sscope="col" class="{{ Config::get('style.headerInt') }}">Editar</th>
                                @endauth

                                <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-12">
                                    <b>@lang('Date')</b>
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-12">
                                    <b>@lang('Motion')</b>
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenterXs') }} w-12">
                                    <b>@lang('Campus')</b>
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                    <b>@lang('Receipt')</b>
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                    <b>@lang('Tipo')</b>
                                </th>
                                
                                <th scope="col" colspan="2" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Category')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Supplier')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Description')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerInt') }} w-12">
                                    <b>@lang('Amount')</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @if (isset($egresos) && count($egresos) > 0)
                            @foreach ($egresos as $the_egresos)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                       
                                    </td>
                                    @auth
                                        <td class="{{ Config::get('style.rowCenter') }}" >
                                            <a class="{{ Config::get('style.btnEdit') }} "
                                                href="">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>
                                        </td>
                                    @endauth
                                    <td class="{{ Config::get('style.rowCenterXs') }} w-12">
                                       
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                       
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                       
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        
                                    </td>
                                    <td class="{{ Config::get('style.rowLeftXs') }}">
                                       
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" >
                                        
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                      
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>

</x-app-layout>