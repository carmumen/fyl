<div class="py-3 bg-gray-300 text-white text-left">
    @if (session()->has('menuAplication'))
        <div class="text-sky-900 pt-1 px-2">
            @foreach (session('menuAplication') as $a)
                <i class="{{ $a->icon }} fa-2x"></i>
                {{ __($a->name) }}
            @endforeach
        </div>
    @endif
</div>
<ul>
    @if (session()->has('menus'))

        @foreach (session('modules') as $key => $item)
            {{-- @if ($item->parent == 0) --}}
                <li class="menu">
                    <a href="#">
                        <label>{{ __($item->nameParent) }}</label>
                        <span class="padre icon-circle-down"></span>
                    </a>
                    <ul class="childrenPadre">
                        @foreach (session('menus') as $key2 => $item2)
                            @if ($item->nameParent == $item2->nameParent)
                                {{-- <li class="menu">
                                    <a href="{{ route($item2->route) }}">
                                        <span class="{{ $item2->icon }}"></span>
                                        <label>{{ __($item2->name) }}</label>
                                    </a>
                                </li> --}}
                                @if ($item2->parent == 0)
                                    <li>
                                        <a href="{{ route($item2->route) }}">
                                            <span class="{{ $item2->icon }}"></span>
                                            <label>{{ __($item2->name) }}</label>
                                        </a>
                                    </li>
                                @else
                                    <li class="submenu">
                                        <a href="#">
                                            <label>{{ $item2->nameParent }}</label>
                                            <span class="icon-circle-down"></span>
                                        </a>
                                        <ul class="children">
                                            @foreach (session('menus') as $key2 => $submenu)
                                                @if ($item2->parent == $submenu->parent)
                                                    <li>
                                                        <a href="{{ route($item2->route) }}">
                                                            <span class="icon-circle-right pr-5"></span>
                                                            <label>{{ __($item2->name) }}</label>
                                                        </a>
                                                        <input type="hidden" name="id"
                                                            value="{{ $key2++ }}">
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </li>
                {{-- @else
                <li class="submenu">
                    <a href="#">
                        <label>{{ $item->nameParent }}</label>
                        <span class="icon-circle-down"></span>
                    </a>
                    <ul class="children">
                        @foreach (session('menus') as $key => $submenu)
                            @if ($item->parent == $submenu->parent)
                                <li>
                                    <a href="{{ route($item->route) }}">
                                        <span class="icon-circle-right pr-5"></span>
                                        <label>{{ __($item->name) }}</label>
                                    </a>
                                    <input type="hidden" name="id" value="{{ $key++ }}">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li> --}}
            {{-- @endif --}}
        @endforeach
    @endif
</ul>

<script>
    $(document).ready(main);

    var contador = 1;

    function main() {
        $('.menu_bar').click(function() {
            if (contador == 1) {
                $('.navegador').animate({
                    left: '0'
                })
                contador = 0
            } else {
                contador = 1
                $('.navegador').animate({
                    left: '-100%'
                })
            }
        })

        $('.menu').click(function() {
            $(this).children('.childrenPadre').slideToggle();
        })

        // Mostramos y ocultamos submenus
        $('.submenu').click(function() {
            $(this).children('.children').slideToggle();
        })
    }
</script>
