@extends('layout.app')

@section('title', 'Edit Service')

@section('content')
    <x-section>
        <form action="{{ route('service.finish', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Service</h2>

            <!-- Device Name Input -->
            <div class="mb-4">
                <x-form-label for="device-name">Device Name</x-form-label>
                <x-form-input id="device-name" name="device_name" type="text" required value="{{ old('device_name', $service->device_name) }}" />
                @error('brand')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>


            <!-- Description Textarea -->
            <div class="mb-4">
                <x-form-label for="issue-description">Issue</x-form-label>
                <x-form-textarea id="issue-description" name="issue_description" rows="6" placeholder="Issue" required>
                    {{ old('issue_description', $service->issue_description) }}
                </x-form-textarea>

                @error('issue_description')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-form-label for="price">Price</x-form-label>
                <x-form-input type="number" id="price" name="price" required placeholder="Price"/>
            </div>

            {{-- todo: da se doda u order --}}

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Update Service
            </button>

        </form>
    </x-section>
@endsection
