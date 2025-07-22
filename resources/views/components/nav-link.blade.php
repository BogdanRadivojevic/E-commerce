@props(['active'])

<li class="mr-5">
    <a class="{{ $active ? "font-bold transition-colors text-yellow-400" : "text-white font-bold hover:text-yellow-400 transition-colors duration-300"}}"
        aria-current="{{ $active ? 'page' : 'false' }}"
        {{ $attributes }}>
        {{ $slot }}
    </a>
</li>

