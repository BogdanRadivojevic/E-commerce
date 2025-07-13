<a
    {{ $attributes->merge(
    ['class' => ' bg-blue-600 text-white font-semibold rounded-lg px-4 py-2 hover:bg-blue-700 transition duration-200 ' .
     ($attributes->get('class') ?? '')]) }}>
    {{ $slot }}
</a>
