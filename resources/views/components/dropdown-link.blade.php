<a {{ $attributes->merge(
    ['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700
                hover:text-semibold
                focus:outline-none
                transition duration-150
                ease-in-out']) }}>{{ $slot }}</a>