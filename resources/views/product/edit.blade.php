{{-- resources/views/product/edit.blade.php --}}

@extends('layout.app')

@section('title', 'Edit Product')

@section('content')
    <x-section>
        <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Product</h2>

            <!-- Brand Input -->
            <div class="mb-4">
                <x-form-label for="brand">Brand</x-form-label>
                <x-form-input id="brand" name="brand" type="text" value="{{ old('brand', $product->brand) }}" required />
                @error('brand')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Model Input -->
            <div class="mb-4">
                <x-form-label for="model">Model</x-form-label>
                <x-form-input id="model" name="model" type="text" value="{{ old('model', $product->model) }}" required />
                @error('model')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price Input -->
            <div class="mb-4">
                <x-form-label for="price">Price</x-form-label>
                <x-form-input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required/>
                @error('price')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stock Input -->
            <div class="mb-4">
                <x-form-label for="stock">Stock</x-form-label>
                <x-form-input id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" required />
                @error('stock')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div class="mb-4">
                <x-form-label for="description">Description</x-form-label>
                <x-form-textarea id="description" name="description" rows="6">
                    {{ old('description', $product->description) }}
                </x-form-textarea>
                @error('description')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Input (Optional) -->
            <div class="mb-4">
                <x-form-label for="image">Product Image</x-form-label>
                <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring focus:ring-blue-200">
                @error('image')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Current Image Preview (if exists) -->
            @if($product->image_path)
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset($product->image_path) }}" alt="Current product image" class="w-24 h-24 object-cover rounded-lg mt-2">
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Update Product
            </button>
        </form>
    </x-section>
@endsection
