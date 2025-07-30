window.openEditModal = function (id, name) {
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

window.closeEditModal = function () {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editCategoryForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('categoryId').value;
            const name = document.getElementById('categoryName').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch(`/categories/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name })
            })
                .then(res => {
                    if (res.ok) {
                        closeEditModal();
                        location.reload(); // Or rerender only the row
                    } else {
                        alert('Failed to update category.');
                    }
                })
                .catch(() => alert('Something went wrong.'));
        });
    }
});
