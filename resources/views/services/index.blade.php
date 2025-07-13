@extends('layout.app')

@section('title', 'Service')

@section('content')
    <x-section>
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold text-gray-800">Services</h1>

            <div class="flex space-x-2 items-center">
                <!-- Filter by Authenticated User -->
                <a href="{{ route('service.index', ['auth_user' => true]) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    My Services
                </a>
                <a href="{{ route('service.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                    All Services
                </a>
                <a href="{{ route('service.index', ['repaired' => true]) }}"
                   class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
                    Repaired Products
                </a>

                <!-- Sort Dropdown -->
                <form action="{{ route('service.index') }}" method="GET" class="inline">
                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="appearance-none border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        <option value="created_at-desc" {{ request('sort') === 'created_at-desc' ? 'selected' : '' }}>
                            Date (Newest First)
                        </option>
                        <option value="created_at-asc" {{ request('sort') === 'created_at-asc' ? 'selected' : '' }}>Date
                            (Oldest First)
                        </option>
                        <option value="device_name-asc" {{ request('sort') === 'device_name-asc' ? 'selected' : '' }}>
                            Device Name (A-Z)
                        </option>
                        <option value="device_name-desc" {{ request('sort') === 'device_name-desc' ? 'selected' : '' }}>
                            Device Name (Z-A)
                        </option>
                    </select>
                    @if(request('auth_user'))
                        <input type="hidden" name="auth_user" value="true">
                    @endif
                    @if(request('repaired'))
                        <input type="hidden" name="repaired" value="true">
                    @endif
                </form>

            </div>

            <!-- Add New Service Button -->
            <a href="{{ route('service.create') }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
                Add New Service
            </a>
        </div>

        <!-- Display Services -->
        @if($services->isEmpty())
            <p class="text-gray-600">No services found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <x-section>
                        <a href="{{ route('service.show', $service->id) }}"
                           class="block hover:bg-gray-100 p-4 rounded-md transition duration-200">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $service->device_name }}</h2>
                            <p class="text-gray-600 mt-2">{{ Str::limit($service->issue_description, 50) }}</p>
                            <p class="text-gray-500 text-sm mt-4">Submitted
                                by: {{ $service->authUser->name ?? 'Unknown' }}</p>
                            <p class="text-sm mt-2">
                                <span class="px-2 py-1 rounded
                                        {{ $service->status === \App\Models\ProductService::STATUS_REPAIRED ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $service->status === \App\Models\ProductService::STATUS_FINISHED ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $service->status === \App\Models\ProductService::STATUS_IN_PROGRESS ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $service->status === \App\Models\ProductService::STATUS_PENDING ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                                </span>
                            </p>

                        </a>

                        <div class="flex mt-4 space-x-2">
                            <a href="{{ route('service.edit', $service) }}"
                               class="text-blue-500 hover:text-blue-600 font-semibold">Edit</a>
                            <form method="POST" action="{{ route('service.destroy', $service->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-600 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </x-section>
                @endforeach
            </div>
        @endif
    </x-section>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $services->appends(request()->except('page'))->links() }}
    </div>
@endsection
