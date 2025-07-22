document.addEventListener('DOMContentLoaded', () => {
    const userInput = document.getElementById('service_user');
    const suggestions = document.getElementById('user-suggestions');

    userInput.addEventListener('input', function () {
        const query = this.value;

        if (query.length > 0) { // Only search when more than 2 characters are entered
            fetch(`/users/search?search=${query}`)
                .then(response => response.json())
                .then(data => {
                    suggestions.innerHTML = ''; // Clear previous suggestions

                    if (data.length > 0) {
                        suggestions.classList.remove('hidden'); // Show suggestions
                        data.forEach(user => {
                            const div = document.createElement('div');
                            div.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-gray-100');

                            // Create a span for the user's name and email
                            const nameSpan = document.createElement('span');
                            nameSpan.textContent = user.name;

                            const emailSpan = document.createElement('span');
                            emailSpan.textContent = ` (${user.email})`; // Display the email in parentheses
                            emailSpan.classList.add('text-sm', 'text-gray-600'); // Style the email to be less prominent

                            // Add name and email to the div
                            div.appendChild(nameSpan);
                            div.appendChild(emailSpan);

                            // When a suggestion is clicked
                            div.addEventListener('click', function () {
                                userInput.value = user.name; // Set user input to the selected name
                                document.getElementById('service_user_id').value = user.id; // Set hidden field with the selected user's ID
                                suggestions.classList.add('hidden'); // Hide suggestions
                            });

                            suggestions.appendChild(div); // Add the suggestion to the dropdown
                        });
                    } else {
                        suggestions.classList.add('hidden'); // Hide if no results
                    }
                })
                .catch(error => {
                    console.error("Error fetching users:", error);
                });
        } else {
            suggestions.classList.add('hidden'); // Hide if input is too short
        }
    });
});
