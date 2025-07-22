@extends('layout.app')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4 mt-12">
        <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">Register</h2>

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input id="name" type="text" name="name" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring focus:ring-blue-200"
                       placeholder="Enter your name">
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring focus:ring-blue-200"
                       placeholder="Enter your email">
            </div>

            <!-- Password Field -->
            <div class="mb-4 relative">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input id="password" type="password" name="password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                       placeholder="Enter your password">
                <button type="button" id="toggle-password"
                        class="absolute top-8 right-3 text-gray-500 focus:outline-none">
                    <x-icon name="togglePassword" class="w-5 h-5"></x-icon>
                </button>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm
                    Password</label>
                  <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring focus:ring-blue-200"
                       placeholder="Re-enter your password">
            </div>

            <!-- Role Field -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">User Role</label>
                <div class="flex items-center">
                    <input id="customer" type="radio" name="role" value="customer" class="mr-2">
                    <label for="customer" class="text-gray-700">Customer</label>
                </div>
                <div class="flex items-center mt-2">
                    <input id="admin" type="radio" name="role" value="admin" class="mr-2">
                    <label for="admin" class="text-gray-700">Admin</label>
                </div>
                @error('role')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Register
                </button>
                <a href="{{ route('login') }}"
                   class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Already have an account? Login
                </a>
            </div>
        </form>
    </div>
@endsection
