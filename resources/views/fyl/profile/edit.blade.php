<x-app-layout title="Campus" meta-description="Campus">

    <x-slot name="title">
        @lang('Usuarios')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Usuarios')</h1>

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
                <span style="font-size:24px; margin-left:20px">Perfil: <b>{{ __($usersProfile[0]->perfil) }}</b></span>
            </div>
            
            <main class="px-4 py-2">
                
                <div class="flex items-start ">
                        
                    <form id="form" action="{{ route('ProfilesFocus.addUser') }}" method="POST" >
                        @csrf
                        
                        <input type="hidden" name="profile_id" value="{{ $usersProfile[0]->perfil_id }}" />
                            
                        <label class="flex flex-col py-4">
                            <select class="{{ Config::get('style.cajaTexto') }}"
                                    name="user_id"
                                    value="" />
                                    <option value="">-- Seleccione --</option>
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}"
                                    >{{ __($name) }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                        
                    <button form="form" type="submit" title="Agregar Usuario">
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
                                        @lang('Usuario')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Quito')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Cuenca')
                                    </th>
                                    <th scope="col" class="{{ Config::get('style.headerCenter') }}">
                                        @lang('Bogota')
                                    </th>
                                </tr>
                            </thead>
                           
                            <tbody class="bg-gray-100">
                                @foreach ($usersProfile as $theUser)
                                    <tr class="border-b border-gray-200">
                                        <td class="{{ Config::get('style.rowCenter') }} py-1">
                                            <form action="{{ route('ProfilesFocus.destroy', $theUser->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¬øSeguro que deseas eliminar el Usuario?')">
                                                    <span
                                                        class="icon-cross px-1 {{ Config::get('style.btnEditar') }} text-red-900"
                                                        style="font-size: 1rem"></span>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <span class="text-lg px-8">{{ $theUser->usuario }}</span>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnCheck') }} "
                                                href="{{ route('ProfilesFocus.sedeUsuario', $theUser->user_id.'_1_'.$theUser->quito.'_'.$usersProfile[0]->perfil_id) }}">
                                                @if ($theUser->quito != 0)
                                                    <i class="icon-checkbox-checked" style="color:#2563EB; font-size:1rem"></i>
                                                @else
                                                    <i class="icon-checkbox-unchecked" style="color:#2563EB; font-size:1rem" ></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnCheck') }} "
                                                href="{{ route('ProfilesFocus.sedeUsuario', $theUser->user_id.'_3_'.$theUser->cuenca.'_'.$usersProfile[0]->perfil_id) }}">
                                                @if ($theUser->cuenca != 0)
                                                    <i class="icon-checkbox-checked" style="color:#2563EB; font-size:1rem"></i>
                                                @else
                                                    <i class="icon-checkbox-unchecked" style="color:#2563EB; font-size:1rem" ></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="{{ Config::get('style.rowCenter') }}">
                                            <a class="{{ Config::get('style.btnCheck') }} "
                                                href="{{ route('ProfilesFocus.sedeUsuario', $theUser->user_id.'_2_'.$theUser->bogota.'_'.$usersProfile[0]->perfil_id) }}">
                                                @if ($theUser->bogota != 0)
                                                    <i class="icon-checkbox-checked" style="color:#2563EB; font-size:1rem"></i>
                                                @else
                                                    <i class="icon-checkbox-unchecked" style="color:#2563EB; font-size:1rem" ></i>
                                                @endif
                                            </a>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var formId = this.getAttribute('data-form-id'); // Obtè´±n el id del formulario
                    var form = document.getElementById(formId); // Selecciona el formulario
        
                    if (form) {
                        form.submit(); // Envè´øa el formulario
                    }
                });
            });
        });
    </script>

</x-app-layout>
