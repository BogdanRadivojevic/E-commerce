@extends('layout.app')

@section('title', 'Login')

@section('content')
    <x-section>
        This is the welcome page<br />
        Here will be displayed products

        @auth
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        @endauth


    </x-section>
@endsection
