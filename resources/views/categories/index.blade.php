@extends('layout.app')

@section('title', 'Categories')

@section('content')
    <x-section>
        {{-- Top bar --}}
        <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>

            <x-primary-button href="{{ route('categories.create') }}">
                + Add Category
            </x-primary-button>
        </div>

        {{-- Flash --}}
        @if(session('message'))
            <div id="flash"
                 class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('message') }}
            </div>
        @endif

        {{-- Table / Empty state --}}
        @forelse($categories as $category)
            @if ($loop->first)
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead>
                                    <tr class="flex border-b font-medium">
                                        <th class="flex-1 px-6 py-4 text-left">ID</th>
                                        <th class="flex-1 px-6 py-4 text-center">Name</th>
                                        <th class="flex-1 px-6 py-4 text-right pr-10">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @endif

                                    <tr class="flex items-center border-b" data-row-id="{{ $category->id }}">
                                        <td class="flex-1 px-6 py-4 font-medium text-left whitespace-nowrap">
                                            {{ $category->id }}
                                        </td>
                                        <td class="flex-1 px-6 py-4 text-center whitespace-nowrap"
                                            id="cat-name-{{ $category->id }}">
                                            {{ $category->name }}
                                        </td>
                                        <td class="flex-1 px-6 py-4 text-right whitespace-nowrap pr-10">
                                            <div class="inline-flex space-x-2 justify-end">
                                                <button type="button"
                                                        onclick="openEditModal({{ $category->id }}, @js($category->name))"
                                                        class="flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md transition">
                                                    <x-icon name="edit" class="w-4 h-4 mr-1" />
                                                    Edit
                                                </button>

                                                <form action="{{ route('categories.destroy', $category) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md transition">
                                                        <x-icon name="trash" class="w-4 h-4 mr-1" />
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($loop->last)
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="text-center text-gray-600">
                No categories yet.
                <a href="{{ route('categories.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Create the first one
                </a>
            </div>
        @endforelse
    </x-section>

    {{-- Modal --}}
    <div id="editModal"
         class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50"
         role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
        <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md"
             onclick="event.stopPropagation()">
            <h2 id="editModalTitle" class="text-lg font-bold mb-4">Edit Category</h2>

            <form id="editCategoryForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="categoryId">

                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700">
                        Category Name
                    </label>
                    <input type="text" id="categoryName" name="name"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200"
                           required>
                    <p id="editError" class="text-red-600 text-sm mt-2 hidden"></p>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button id="editSubmit" type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Inline scripts (kept simple; feel free to move to app.js) --}}
    <script>
        const modal = document.getElementById('editModal');
        const form  = document.getElementById('editCategoryForm');
        const nameInput = document.getElementById('categoryName');
        const idInput   = document.getElementById('categoryId');
        const errorEl   = document.getElementById('editError');
        const submitBtn = document.getElementById('editSubmit');

        function openEditModal(id, name) {
            idInput.value = id;
            nameInput.value = name;
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => nameInput.focus(), 0);
        }

        function closeEditModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            form.reset();
        }

        // Close on backdrop click / Esc
        modal.addEventListener('click', closeEditModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeEditModal();
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const id   = idInput.value;
            const name = nameInput.value.trim();
            if (!name) return;

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

            try {
                const res = await fetch(`{{ url('/categories') }}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': window.Laravel?.csrfToken ?? '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ name })
                });

                if (res.ok) {
                    const data = await res.json();
                    // Optimistically update the name in the table
                    const cell = document.getElementById(`cat-name-${id}`);
                    if (cell) cell.textContent = data.category?.name ?? name;

                    // Toast-ish feedback
                    showFlash('Category updated successfully');

                    closeEditModal();
                } else if (res.status === 422) {
                    const j = await res.json();
                    const msg = j?.errors?.name?.[0] ?? 'Validation error';
                    errorEl.textContent = msg;
                    errorEl.classList.remove('hidden');
                } else {
                    errorEl.textContent = 'Something went wrong. Please try again.';
                    errorEl.classList.remove('hidden');
                }
            } catch (err) {
                errorEl.textContent = 'Network error. Please try again.';
                errorEl.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        });

        function showFlash(message) {
            let el = document.getElementById('flash');
            if (!el) {
                el = document.createElement('div');
                el.id = 'flash';
                el.className = 'mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800';
                const section = document.querySelector('main .bg-white');
                (section?.parentNode ?? document.body).insertBefore(el, section);
            }
            el.textContent = message;
            // Auto-hide after 3s
            setTimeout(() => el.remove(), 3000);
        }
    </script>
@endsection
