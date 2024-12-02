

<div class="px-3 py-2 mx-auto font-bold text-white sm:px-6 lg:px-8 w-full ">
    {{-- <main id="apps" class="grid w-full gap-4 px-4 max-w-7xl sm:grid-cols-2 md:grid-cols-3 text-center"> --}}
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-4 gap-4">
            @if (isset($aplication) && count($aplication) > 0)
            
                @foreach ($aplication as $aplications)
                <div class="flex items-center justify-center bg-white shadow-md rounded-lg p-4 ">
                    <form id="{{ $aplications['id'] }}" method="GET" action="{{ route('Managment.aplication') }}">
                        <input type="hidden" name="id" value="{{ $aplications['id'] }}">
                        <button type="submit" title="{{ $aplications['name'] }}" class="text-sky-900">
                            <i class="{{ $aplications['icon'] }} fa-3x"></i><br />{{ __($aplications['name']) }}
                        </button>
                    </form>
                </div>
                @endforeach
            @endif
        </div>
    </main>
</div>


