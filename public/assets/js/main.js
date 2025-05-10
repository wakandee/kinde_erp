document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-dark');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');
        });
    }
});
