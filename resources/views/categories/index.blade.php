@extends('layout.app')

@section('title', 'Categories')

@section('content')
    <x-section>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead>
                            <tr class="flex border-b font-medium dark:border-neutral-500">
                                <th class="flex-1 px-6 py-4 text-left">ID</th>
                                <th class="flex-1 px-6 py-4 text-center">Name</th>
                                <th class="flex-1 px-6 py-4 text-right pr-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr class="flex items-center border-b dark:border-neutral-500">
                                    <td class="flex-1 px-6 py-4 font-medium text-left whitespace-nowrap">{{ $category->id }}</td>
                                    <td class="flex-1 px-6 py-4 text-center whitespace-nowrap">{{ $category->name }}</td>
                                    <td class="flex-1 px-6 py-4 text-right whitespace-nowrap pr-10">
                                        <div class="inline-flex space-x-2 justify-end">
                                            <button type="button"
                                                    onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')"
                                                    class="flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md transition">
                                                <x-icon name="edit" class="w-4 h-4 mr-1" />
                                                Edit
                                            </button>
                                            <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md transition">
                                                    <x-icon name="trash" class="w-4 h-4 mr-1 " />
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    <!-- Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Edit Category</h2>
            <form id="editCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="categoryId">
                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="categoryName" name="name"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200"
                           required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
