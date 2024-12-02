<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Campus')
        </h2>
    </x-slot>

    <header>
       
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div class="flex flex-wrap justify-start p-1"  >
                        
                        <div class="p-1">
                            <table id="tablaDatos" class="text-center divide-y divide-gray-200">
                                <thead class="bg-sky-800">
                                    <tr>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }} w-16">
                                            @lang('Usuarios')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }} w-16">
                                            @lang('Funcionalidades')
                                        </th>
                                        <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                            @lang('Perfil')
                                        </th>
                                    </tr>
                                </thead>
                               
                                <tbody class="bg-gray-100">
                                    @foreach ($profiles as $theProfile)
                                        <tr class="border-b border-gray-200">
                                            <td class="{{ Config::get('style.rowCenter') }} w-16 py-1">
                                                <a class=""
                                                    href="{{ route('ProfilesFocus.edit', $theProfile->id) }}">
                                                    <span class="icon-user {{ Config::get('style.btnEditar') }} px-1 " style="font-size:1rem"></span>
                                                </a>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }} w-16 py-1">
                                                <a class=""
                                                    href="{{ route('ProfilesFocus.editFun', $theProfile->id) }}">
                                                    <span class="icon-windows8 {{ Config::get('style.btnEditar') }} px-1 " style="font-size:1rem"></span>
                                                </a>
                                            </td>
                                            <td class="{{ Config::get('style.rowCenter') }}">
                                                <span class="text-lg px-8">{{ $theProfile->perfil }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </main>
        </div>
    </div>



</x-app-layout>
