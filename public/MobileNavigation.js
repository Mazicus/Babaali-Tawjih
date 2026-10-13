(() => {
    const toggle = document.querySelector('.menu-btn');
    const checkbox = document.getElementById('menu');
    const nav = document.getElementById('nav');
    if (!toggle || !checkbox || !nav) return;
    const mobile = window.matchMedia('(max-width: 991px)');
    const focusable = () => [...nav.querySelectorAll('a, button')].filter(el => el.getClientRects().length && !el.disabled);
    function sync() {
        const open = mobile.matches && checkbox.checked;
        toggle.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('mobile-nav-open', open);
        nav.inert = mobile.matches && !open;
    }
    function close() {
        checkbox.checked = false;
        sync();
        toggle.focus();
    }
    toggle.addEventListener('click', () => {
        checkbox.checked = !checkbox.checked;
        sync();
        if (checkbox.checked) focusable()[0]?.focus();
    });
    nav.querySelector('.close-btn').addEventListener('click', close);
    checkbox.addEventListener('change', sync);
    document.querySelector('.nav-backdrop').addEventListener('click', event => {
        event.preventDefault();
        close();
    });
    nav.addEventListener('click', event => {
        if (mobile.matches && event.target.closest('a')) close();
    });
    document.addEventListener('keydown', event => {
        if (!mobile.matches || !checkbox.checked) return;
        if (event.key === 'Escape') { event.preventDefault(); close(); }
        if (event.key === 'Tab') {
            const items = focusable();
            const first = items[0], last = items[items.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
        }
    });
    mobile.addEventListener('change', () => { checkbox.checked = false; sync(); });
    sync();
})();
