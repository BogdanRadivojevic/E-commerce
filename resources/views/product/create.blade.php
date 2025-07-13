@extends('layout.app')

@section('title', 'Edit Product')

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
                <x-form-input id="model" name="model" type="text" required placeholder="Model" />
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

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.createElement('img');
        const previewContainer = document.getElementById('image-preview');

        // Clear existing preview
        previewContainer.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.alt = 'Selected Product Image';
                preview.style.maxWidth = '200px';
                preview.style.marginTop = '10px';
                previewContainer.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
