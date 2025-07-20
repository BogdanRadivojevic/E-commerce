<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 text-gray-800">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full p-4 transition-opacity duration-300 z-50"
     style="background-color: #333; opacity: 0.95;">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Brand/Logo -->
        <div class="text-xl font-bold text-white">
            <a href="/" class="hover:text-yellow-400">My Website</a>
        </div>

        <!-- Hamburger Icon -->
        <button id="menu-toggle" class="sm:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>

        <!-- Navigation Links -->
        <ul id="menu" class="hidden sm:flex flex-col sm:flex-row sm:space-x-6 list-none">
            <x-nav-link href="/" :active="request()->routeIs('product.index')">Home</x-nav-link>
            @guest
                <x-nav-link href="/login" :active="request()->routeIs('login')">Login</x-nav-link>
            @endguest
            @auth
                @if(auth()->user()->role->name === 'admin')
                    <x-nav-link href="/services" :active="request()->routeIs('service.index')">Service</x-nav-link>
                    <x-nav-link href="/dashboard" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                @endif
                <!-- Logout Button -->
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-white font-bold hover:text-yellow-400 transition-colors duration-300">
                            Logout
                        </button>
                    </form>
                </li>

                <!-- Notifications dropdown -->
                <li class="relative ml-4">
                    <button id="notif-button" class="relative text-white focus:outline-none"
                            onclick="toggleNotifDropdown()">
                        <!-- Bell icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a2 2 0 10-4 0v1.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>

                        <!-- Unread count badge -->
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp

                        @if($unreadCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-600 text-xs rounded-full px-1.5 py-0.5 font-bold leading-none">
                {{ $unreadCount }}
            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div id="notif-dropdown"
                         class="hidden absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                        </div>
                        <div class="divide-y">
                            @forelse(auth()->user()->notifications as $notification)
                                <div
                                    class="p-3 hover:bg-yellow-50 transition {{ is_null($notification->read_at) ? 'bg-yellow-100' : '' }}">
                                    <div class="flex flex-col space-y-1">
                <span class="text-sm text-gray-800">
                    Your device <strong>{{ $notification->data['device_name'] }}</strong> has been repaired!
                    <br>
                    Price: ${{ number_format($notification->data['price'], 2) }}
                </span>
                                        <span class="text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-gray-500 text-sm">
                                    No notifications
                                </div>
                            @endforelse
                        </div>
                    </div>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- Main Content -->
<main class="mt-20 container mx-auto px-4">
    @yield('content')
</main>

<!-- Cart Button (Fixed to the bottom right corner) -->
<a href="{{ route('cart.index') }}" class="flex items-center justify-center">
    <div
        class="fixed bottom-6 right-6 bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-full shadow-lg transition-all duration-300 cursor-pointer">
        <!-- Cart SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
             class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18l-1.5 9h-15L3 3z"/>
            <circle cx="9" cy="21" r="2"/>
            <circle cx="17" cy="21" r="2"/>
        </svg>
    </div>
</a>

<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        routes: {
            notificationsRead: '{{ route('notifications.read') }}',
        }
    };
</script>
</body>
</html>
