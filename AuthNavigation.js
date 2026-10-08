(() => {
    let request = 0;
    async function refresh() {
        const current = ++request;
        document.querySelectorAll('[data-auth]').forEach(element => { element.hidden = true; });
        try {
            const response = await fetch('/auth-status.php', { credentials: 'same-origin', cache: 'no-store' });
            if (!response.ok) return;
            const state = await response.json();
            if (current !== request) return;
            document.querySelectorAll('[data-auth]').forEach(element => {
                element.hidden = (element.dataset.auth === 'member') !== state.authenticated;
            });
        } catch { /* Leave uncertain account actions hidden rather than display the wrong state. */ }
    }
    refresh();
    window.addEventListener('pageshow', refresh);
    window.addEventListener('focus', refresh);
})();
