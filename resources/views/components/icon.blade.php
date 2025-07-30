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
@elseif ($name === 'chevron-down')
    <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 9l-7 7-7-7"/>
    </svg

@elseif($name === 'folder')
    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
         stroke-width="2" viewBox="0 0 24 24">
        <path d="M3 4a1 1 0 011-1h5.5a1 1 0 01.7.3l1.5 1.5a1 1 0 00.7.3H20a1 1 0 011 1v2H3V4z"/>
        <path d="M3 9h18v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"/>
    </svg>
    @elseif($name === 'add')
    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
         stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 4v16m8-8H4"/>
    </svg>
    @elseif($name === 'edit')
    <svg class="w-5 h-5 mr-2 " fill="none" stroke="currentColor"
         stroke-width="2" viewBox="0 0 24 24">
        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
    </svg>
    @elseif($name === 'trash')
    <svg class="w-5 h-5 mr-2 " fill="none" stroke="currentColor"
         stroke-width="2" viewBox="0 0 24 24">
        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
    </svg>
@endif
