document.addEventListener('DOMContentLoaded', () => {
    const notifButton = document.getElementById('notif-button');
    const notifDropdown = document.getElementById('notif-dropdown');

    if (notifButton && notifDropdown) {
        notifButton.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle('hidden');

            if (!notifDropdown.classList.contains('hidden')) {
                fetch(window.Laravel.routes.notificationsRead, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(res => {
                    if (res.ok) {
                        const badge = notifButton.querySelector('span');
                        if (badge) {
                            badge.remove();
                        }
                    }
                });
            }
        });

        window.addEventListener('click', (e) => {
            if (!notifButton.contains(e.target) && !notifDropdown.contains(e.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    }
});
