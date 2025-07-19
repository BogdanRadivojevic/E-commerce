import './bootstrap';
import './navbar.js';
import './userSearch.js'
import './productImagePreview.js'


document.addEventListener('DOMContentLoaded', () => {
    // todo: maybe i should delete this or
    // todo: should move this to a separate file
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');

    if (togglePassword && passwordField) {
        togglePassword.addEventListener('click', () => {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
        });
    }
});
