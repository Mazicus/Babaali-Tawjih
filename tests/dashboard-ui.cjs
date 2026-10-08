const fs = require('node:fs');
const vm = require('node:vm');
const assert = require('node:assert/strict');
const { test } = require('node:test');
const tick = () => new Promise(setImmediate);
const html = fs.readFileSync('index.html', 'utf8');
const schools = JSON.parse(fs.readFileSync('data/schools.json', 'utf8'));
const sectors = JSON.parse(fs.readFileSync('data/sectors.json', 'utf8'));

test('public directory renders the shared catalog and favorites after filtering', async () => {
    const elements = new Map();
    const get = id => {
        if (!elements.has(id)) elements.set(id, { value: '', listeners: {}, addEventListener(event, fn) { this.listeners[event] = fn; } });
        return elements.get(id);
    };
    let refreshes = 0;
    const scripts = [...html.matchAll(/<script>([\s\S]*?)<\/script>/g)];
    assert.equal(scripts.length, 1);
    await vm.runInNewContext(scripts[0][1], {
        document: { getElementById: get, querySelector: () => null, querySelectorAll: () => [], addEventListener() {} },
        fetch: async url => ({ ok: true, json: async () => url.includes('sectors') ? sectors : schools }),
        window: { schoolFavorites: { refresh: () => refreshes++ } },
    });
    assert.equal(get('resultCount').textContent, schools.length);
    assert.equal((get('ecolesSections').innerHTML.match(/class="school-favorite"/g) || []).length, schools.length);
    for (const school of schools) assert(get('ecolesSections').innerHTML.includes(`data-school-id="${school.id}"`));
    get('searchEcoles').value = 'FMP Agadir';
    get('searchEcoles').listeners.input();
    assert.equal(get('resultCount').textContent, 1);
    assert.equal((get('ecolesSections').innerHTML.match(/class="school-favorite"/g) || []).length, 1);
    assert.equal(refreshes, 2);
});

function favoritesUI(fetch) {
    const buttons = [1, 2].map(id => ({
        dataset: { schoolId: String(id) }, attrs: {}, icon: {}, label: {},
        setAttribute(key, value) { this.attrs[key] = value; },
        querySelector(selector) { return selector === 'i' ? this.icon : this.label; },
        closest() { return { querySelector: () => ({ textContent: 'School ' + id }) }; },
    }));
    const area = { children: [], replaceChildren(...children) { this.children = children; }, append(child) { this.children.push(child); } };
    let onClick;
    vm.runInNewContext(fs.readFileSync('Favorites.js', 'utf8'), {
        URLSearchParams,
        document: {
            querySelectorAll: () => buttons, getElementById: () => area,
            createTextNode: text => ({ textContent: text }), createElement: () => ({ setAttribute() {}, addEventListener() {} }),
            addEventListener: (event, fn) => { onClick = fn; },
        },
        window: {}, fetch,
    });
    return { buttons, area, click: id => onClick({ target: { closest: () => buttons[id - 1] } }) };
}
const response = (ids, status = 200) => ({ ok: status === 200, status, json: async () => ({ authenticated: true, csrf: 'token', ids }) });

test('favorite save/remove updates button state only after successful persistence', async () => {
    const actions = [];
    const ui = favoritesUI(async (url, options) => {
        if (!options.method) return response([1]);
        actions.push(options.body.get('action'));
        assert.equal(options.body.get('csrf'), 'token');
        return response(options.body.get('action') === 'save' ? [1, 2] : [2]);
    });
    await tick();
    assert.equal(ui.buttons[0].attrs['aria-pressed'], 'true');
    await ui.click(2);
    assert.equal(ui.buttons[1].attrs['aria-pressed'], 'true');
    await ui.click(1);
    assert.equal(ui.buttons[0].attrs['aria-pressed'], 'false');
    assert.deepEqual(actions, ['save', 'remove']);
});

test('out-of-order favorite responses do not erase a concurrent successful save', async () => {
    const pending = new Map();
    const ui = favoritesUI(async (url, options) => {
        if (!options.method) return response([]);
        return new Promise(resolve => pending.set(Number(options.body.get('school_id')), resolve));
    });
    await tick();
    const first = ui.click(1), second = ui.click(2);
    pending.get(2)(response([1, 2]));
    await second;
    pending.get(1)(response([1]));
    await first;
    assert(ui.buttons.every(button => button.attrs['aria-pressed'] === 'true'));
});

test('signed-out visitors get a login link without posting favorites', async () => {
    let posts = 0;
    const ui = favoritesUI(async (url, options) => {
        if (options.method) posts++;
        return { ok: true, json: async () => ({ authenticated: false, ids: [] }) };
    });
    await tick();
    await ui.click(1);
    assert.equal(posts, 0);
    assert(ui.area.children.some(child => child.href === '/login.php'));
});

test('failed persistence leaves the favorite unsaved and shows the server error', async () => {
    const ui = favoritesUI(async (url, options) => !options.method ? response([]) : {
        ok: false, status: 419, json: async () => ({ error: 'Rechargez la page.' }),
    });
    await tick();
    await ui.click(2);
    assert.equal(ui.buttons[1].attrs['aria-pressed'], 'false');
    assert(ui.area.children.some(child => child.textContent.includes('Rechargez')));
});
