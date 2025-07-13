@extends('layout.app')

@section('title', 'Service Details')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Service Details</h1>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Device Name:</h2>
            <p class="text-gray-600">{{ $service->device_name }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Issue Description:</h2>
            <p class="text-gray-600">{{ $service->issue_description }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Client:</h2>
            <p class="text-gray-600">{{ $service->serviceUser->name }} - {{ $service->serviceUser->email }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Submitted By:</h2>
            <p class="text-gray-600">{{ $service->authUser->name }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Created At:</h2>
            <p class="text-gray-600">{{ $service->created_at->format('d M, Y H:i') }}</p>
        </div>

        @if($service->status == App\Models\ProductService::STATUS_REPAIRED)
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Repaired for:</h2>
                <p class="text-gray-600">{{ $service->price }}</p>
            </div>
        @endif

        <div class="mt-6 flex justify-between">
            <a href="{{ route('service.index') }}" class="text-blue-500 hover:underline">Back to Services</a>

{{--            @if (Auth::user()->hasRole('admin'))--}}
                <div class="flex space-x-4">


                    @if(!($service->status == App\Models\ProductService::STATUS_REPAIRED))
                    <x-success-button href="{{ route('service.editFinish', $service) }}" class="bg-green-500 rounded-md  hover:bg-green-900">
                        Finish
                    </x-success-button>
                    @endif

                    <a href="{{ route('service.edit', $service) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('service.destroy', $service->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>
        </div>
    </div>
@endsection
