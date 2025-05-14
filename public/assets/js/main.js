  document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll('.alert');
    const displayDuration = 4000; // 4 seconds

    alerts.forEach(function (alert) {
        // Auto-dismiss after the display duration
        const autoDismiss = setTimeout(function () {
            fadeOut(alert);
        }, displayDuration);

        // Manual dismissal
        const closeBtn = alert.querySelector('.closebtn');
        closeBtn.addEventListener('click', function () {
            clearTimeout(autoDismiss);
            fadeOut(alert);
        });
    });

    // Fade out function
    function fadeOut(element) {
        element.style.opacity = '0';
        setTimeout(function () {
            element.style.display = 'none';
        }, 500); // Match the CSS transition duration
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-dark');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');

            // Toggle theme classes
            body.classList.toggle('dark-mode');
            body.classList.toggle('light-mode');

            const isDark = body.classList.contains('dark-mode');
            const newTheme = isDark ? 'dark' : 'light';
            const newIcon = isDark ? 'sun' : 'moon';

            // Replace icon correctly
            if (themeIcon) {
                const newIconElem = document.createElement('i');
                newIconElem.id = 'theme-icon';
                newIconElem.setAttribute('data-lucide', newIcon);
                themeIcon.replaceWith(newIconElem);

                // Re-render Lucide icon
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }

            // Save to server
            const baseUrl = window.APP_CONFIG?.baseUrl || '/';
            const endpoint = baseUrl + 'ui-preference/theme';

            fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `theme=${newTheme}`
            }).catch(err => console.error('Failed to save theme preference', err));
        });
    }
});

