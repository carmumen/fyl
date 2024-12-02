<x-app-layout title="Campus" meta-description="Campus">

    <x-slot name="title">
        @lang('Usuarios')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Funcionalidades')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    
    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <div>
                <a href="{{ route('ProfilesFocus.index') }}">
                    <span class="{{ Config::get('style.btnCreate') }} text-white hover:bg-red-500 hover:text-white py-2">Regresar</span>
                </a>
                <span style="font-size:24px; margin-left:20px">Perfil: <b>{{ __($profileFunctionalities[0]->perfil) }}</b></span>
            </div>
            
            <main class="px-4 py-2">
                
                <div class="flex items-start ">
                    
                    <form id="form" action="{{ route('ProfilesFocus.addFun') }}" method="POST" >
                        @csrf
                        
                        <input type="hidden" name="profile_id" value="{{ $profileFunctionalities[0]->perfil_id }}" />
                            
                        <label class="flex flex-col py-4">
                            <select class="{{ Config::get('style.cajaTexto') }}"
                                    name="functionality_id"
                                    value="" />
                                    <option value="">-- Seleccione --</option>
                                @foreach($functionalities as $id => $name)
                                    <option value="{{ $id }}"
                                    >{{ __($name) }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                        
                    <button form="form" type="submit" title="Agregar Funcionalidad">
                        <span class="icon-plus {{ Config::get('style.btnCreate') }} text-white hover:bg-red-500 hover:text-white py-2 mx-8"></span>
                    </button>
                    
                    
                </div>
                    
                
                
                
                <div class="flex items-center">
                    <div class="flex items-center">
                        <table id="tablaDatos" class="text-center divide-y divide-gray-200">
                            <thead class="bg-sky-800">
                                <tr>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }} w-16">
                                        @lang('Eliminar')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Funcionalidad')
                                    </th>
                                </tr>
                            </thead>
                           
                            <tbody class="bg-gray-100">
                                @foreach ($profileFunctionalities as $theProfileFunctionalities)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }} py-1">
                                            <form action="{{ route('ProfilesFocus.destroyFun', $theProfileFunctionalities->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar la funcionalidad?')">
                                                    <span
                                                        class="icon-cross px-2 {{ Config::get('style.btnEditar') }} text-red-900"
                                                        style="font-size: 1rem"></span>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <span class="text-lg px-8">{{ $theProfileFunctionalities->funcionalidad }}</span>
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
