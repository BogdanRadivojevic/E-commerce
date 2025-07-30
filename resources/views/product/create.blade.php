@extends('layout.app')

@section('title', 'Add Product')

@section('content')
    <x-section>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Product</h2>

            <!-- Brand Input -->
            <div class="mb-4">
                <x-form-label for="brand">Brand</x-form-label>
                <x-form-input id="brand" name="brand" type="text" required placeholder="Brand" />
                @error('brand')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Model Input -->
            <div class="mb-4">
                <x-form-label for="model">Model</x-form-label>
      `          <x-form-input id="model" name="model" type="text" required placeholder="Model" />
                @error('model')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price Input -->
            <div class="mb-4">
                <x-form-label for="price">Price</x-form-label>
                <x-form-input id="price" name="price" type="number" step="0.01" required placeholder="Price" />
                @error('price')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stock Input -->
            <div class="mb-4">
                <x-form-label for="stock">Stock</x-form-label>
                <x-form-input id="stock" name="stock" type="number" required placeholder="Stock" />
                @error('stock')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div class="mb-4">
                <x-form-label for="description">Description</x-form-label>
                <x-form-textarea id="description" name="description" rows="6" placeholder="Description" required></x-form-textarea>

                @error('description')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category Dropdown -->
            <div class="mb-4">
                <x-form-label for="category_id">Category</x-form-label>
                <div class="relative">
                    <select id="category_id" name="category_id" required
                            class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-10 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 shadow-sm">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Custom dropdown arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                @error('category_id')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Input (Optional) -->
            <div class="mb-4">
                <x-form-label for="image">Product Image</x-form-label>
                <input type="file" id="image" name="image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring focus:ring-blue-200">
                <div id="image-preview"></div> <!-- Preview container -->
                @error('image')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Add product
            </button>
        </form>
    </x-section>
@endsection

