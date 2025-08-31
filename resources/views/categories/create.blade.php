@extends('layout.app')

@section('title', 'Create Category')

@section('content')
    <x-section>
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                @foreach ($errors->all() as $error)
                    <span class="block sm:inline"> {{ $error }} </span>
                @endforeach
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Add Category</h2>

                <a href="{{ route('categories.index') }}"
                   class="text-blue-600 hover:text-blue-800">
                    Back
                </a>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <x-form-label for="name">Name</x-form-label>
                <x-form-input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    placeholder="e.g. Phone Cases" />
                @error('name')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Add category
            </button>
        </form>
    </x-section>
@endsection
