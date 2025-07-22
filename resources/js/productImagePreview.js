document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    if (!imageInput) return; // Just in case

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = ''; // clear the old image

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.alt = 'Selected Product Image';

                // 👇 Match the styling of the current image
                preview.classList.add(
                    'w-24',
                    'h-24',
                    'object-cover',
                    'rounded-lg',
                    'mt-2'
                );

                previewContainer.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
});
