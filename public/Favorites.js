(() => {
    let state = { authenticated: false, ids: [], csrf: '' };
    let ready = false;
    let failed = false;
    const busy = new Set();
    const seed = document.getElementById('saved-school-data');
    if (seed?.textContent) {
        state = { authenticated: true, ids: JSON.parse(seed.textContent).map(school => school.id), csrf: '' };
    }
    const buttons = () => document.querySelectorAll('.school-favorite');
    const message = (text, login = false, dashboard = false) => {
        const area = document.getElementById('favorite-status');
        if (!area) return;
        area.replaceChildren(document.createTextNode(text + ' '));
        if (login) {
            const link = document.createElement('a');
            link.href = '/login.php';
            link.textContent = 'Se connecter';
            area.append(link);
        }
        if (dashboard) {
            const link = document.createElement('a');
            link.href = '/Dashboard.php#favorites';
            link.textContent = 'Voir mes écoles';
            area.append(link);
        }
        const dismiss = document.createElement('button');
        dismiss.type = 'button';
        dismiss.className = 'favorite-dismiss';
        dismiss.setAttribute('aria-label', 'Fermer le message');
        dismiss.textContent = '×';
        dismiss.addEventListener('click', () => area.replaceChildren());
        area.append(dismiss);
    };
    function refresh() {
        buttons().forEach(button => {
            const id = Number(button.dataset.schoolId);
            const saved = state.ids.includes(id);
            button.disabled = !ready || busy.has(id);
            button.setAttribute('aria-pressed', String(saved));
            button.setAttribute('aria-label', (saved ? 'Retirer des favoris : ' : 'Enregistrer : ') + (button.closest('.ecole-card')?.querySelector('.card-title')?.textContent || 'cet établissement'));
            button.querySelector('i').className = saved ? 'fas fa-heart' : 'far fa-heart';
            button.querySelector('span').textContent = saved ? 'Enregistré' : 'Enregistrer';
        });
    }
    async function load() {
        const response = await fetch('/favorites.php', { credentials: 'same-origin', cache: 'no-store' });
        if (!response.ok) throw new Error('load');
        state = await response.json();
        ready = true;
        failed = false;
        refresh();
    }
    window.schoolFavorites = { refresh };
    load().catch(() => {
        ready = true;
        failed = true;
        refresh();
        message('Les favoris sont momentanément indisponibles. Réessayez en cliquant sur Enregistrer.');
    });
    document.addEventListener('click', async event => {
        const button = event.target.closest('.school-favorite');
        if (!button) return;
        const id = Number(button.dataset.schoolId);
        if (busy.has(id)) return;
        busy.add(id);
        refresh();
        try {
            if (failed) await load();
            if (!state.authenticated) {
                message('Connectez-vous pour enregistrer vos écoles dans votre espace personnel.', true);
                return;
            }
            const saved = state.ids.includes(id);
            const response = await fetch('/favorites.php', {
                headers: { Accept: 'application/json' }, method: 'POST', credentials: 'same-origin', cache: 'no-store',
                body: new URLSearchParams({ _token: state.csrf, school_id: String(id), action: saved ? 'remove' : 'save' }),
            });
            const data = await response.json().catch(() => ({ error: 'Les favoris sont momentanément indisponibles. Veuillez réessayer.' }));
            if (response.status === 401) {
                state = { authenticated: false, ids: [], csrf: '' };
                message('Votre session a expiré. Connectez-vous pour enregistrer vos favoris.', true);
                return;
            }
            if (!response.ok) throw new Error(data.error || 'Impossible d’enregistrer ce favori.');
            // Merge only this school's result; concurrent saves may finish out of order.
            state.ids = state.ids.filter(value => value !== id);
            if (data.ids.includes(id)) state.ids.push(id);
            state.csrf = data.csrf;
            window.dispatchEvent(new CustomEvent('favorites:changed', { detail: { ids: [...state.ids] } }));
            message(saved ? 'École retirée de vos favoris.' : 'École enregistrée dans votre espace personnel.', false, !saved);
        } catch (error) {
            message(error.message === 'load' ? 'Les favoris sont momentanément indisponibles. Réessayez.' : error.message);
        } finally {
            busy.delete(id);
            refresh();
        }
    });
})();
