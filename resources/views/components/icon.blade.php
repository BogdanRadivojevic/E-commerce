{{-- fixme: change icons that is used in dashboard --}}
@if ($name === 'cube')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        {{ $attributes }}>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12L12 15.5L4 12L12 8.5L20 12Z"/>
    </svg>
@elseif ($name === 'shopping-cart')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        {{ $attributes }}>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-1.5 9h-15L3 3z"/>
    </svg>
@elseif ($name === 'dollar-sign')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        {{ $attributes }}>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 1v22M16 4H8m0 0L4 9l4 5m8-5l4-5-4-5"/>
    </svg>
@elseif ($name === 'service')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        {{ $attributes }}>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15.232 5.232a4 4 0 00-5.657 5.657L3 17l1.414 1.414 6.575-6.575a4 4 0 005.657-5.657L16 4l-2.828 1.232zM9 21h6"/>
    </svg>
@elseif ($name === 'togglePassword')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        {{ $attributes }}>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12m0 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 0m8 4-4.5-4.5m0 0m-1.5-1.5 1.5 1.5m-1.5 0-4.5-4.5"/>
    </svg>
@endif
