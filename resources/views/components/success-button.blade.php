@php
    $defaultBgClass = str_contains($attributes->get('class'), 'bg-') ? '' : 'bg-green-600';
@endphp

<a
    {{ $attributes->merge(['class' => "$defaultBgClass text-white font-semibold rounded-lg px-4 py-2 hover:bg-green-700 transition duration-200"]) }}>
    {{ $slot }}
</a>
