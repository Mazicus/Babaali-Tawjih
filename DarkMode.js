document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('theme-switch');
    const applyTheme = (dark) => {
        document.body.classList.toggle('darkmode', dark);
        if (toggle) {
            toggle.setAttribute('aria-pressed', String(dark));
            toggle.setAttribute('aria-label', dark ? 'Activer le thème clair' : 'Activer le thème sombre');
        }
    };
    try {
        applyTheme(localStorage.getItem('babaali-theme') === 'dark');
    } catch {
        applyTheme(document.body.classList.contains('darkmode'));
    }
    if (!toggle) return;
    toggle.addEventListener('click', () => {
        const dark = !document.body.classList.contains('darkmode');
        applyTheme(dark);
        try {
            localStorage.setItem('babaali-theme', dark ? 'dark' : 'light');
        } catch {
            // Theme switching still works when browser storage is unavailable.
        }
    });
});
