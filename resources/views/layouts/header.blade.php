<div class="headerPrincipal" x-data="{ open: false }">
    <div class="flex-container justify-between h-12 ">
        <div class="panel p-2">
            <a class="text-sky-600" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-table-columns"></i>
                <div class="hidden md:inline-block">&nbsp; @lang('Apps')</div>
            </a>
        </div>

        <div class="hidden panel m-2 pr-2 text-sky-600 font-bold uppercase ">
            {{ __(explode('.', Route::currentRouteName())[0]) }}
        </div>

        <div class="panel m-2 pr-2">
            @auth
                <div>
                    <x-dropdown align="left" width="40">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium
                                            rounded-md text-sky-600hover:text-gray-700
                                             focus:outline-none transition ease-in-out duration-150">

                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
            @guest
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    {{-- @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif --}}
                </div>
            @endguest
        </div>
    </div>
</div>
<div class="menu_bar">
    @if (session()->has('menuAplication'))
        <a href="#" class="bt-menu text-sx">
            <span class="icon-menu"></span>
            @foreach (session('menuAplication') as $a)
                @foreach (session('menuAplication') as $a)
                    <i class="{{ $a->icon }} fa-1x"></i>
                    {{ __($a->name) }}
                @endforeach
            @endforeach
        </a>
    @else
        <a href="{{ route('dashboard') }}" style="color:#0c4a6e">
            <i class="fa-solid fa-table-columns"></i>
            {{ __('Apps') }}
        </a>
    @endif
</div>
