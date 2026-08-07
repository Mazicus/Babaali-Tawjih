document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('theme-switch');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
        document.body.classList.toggle('darkmode');
    });
});