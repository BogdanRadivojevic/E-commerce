@extends('layout.app')

@section('title', 'Create Service')

@section('content')
    <x-section>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                @foreach ($errors->all() as $error)
                    <span class="block sm:inline">{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Service</h2>

            <!-- Device Name Input -->
            <div class="mb-4">
                <x-form-label for="device-name">Device Name</x-form-label>
                <x-form-input id="device-name" name="device_name" type="text" required placeholder="Device Name" />
                @error('brand')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>


            <!-- Description Textarea -->
            <div class="mb-4">
                <x-form-label for="issue-description">Issue</x-form-label>
                <x-form-textarea id="issue-description" name="issue_description" rows="6" placeholder="Issue" required></x-form-textarea>

                @error('issue_description')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-form-label for="service_user">User Email</x-form-label>
                <x-form-input id="service_user" name="service_user" type="text" required placeholder="User" autocomplete="off" />
                <div id="user-suggestions" class="bg-white border rounded shadow max-h-60 overflow-y-auto hidden"></div>
                <!-- Add a hidden field to store user ID -->
                <input type="hidden" name="service_user_id" id="service_user_id">
                @error('service_user_id')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Add service
            </button>
        </form>
    </x-section>
@endsection
