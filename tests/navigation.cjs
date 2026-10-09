const fs = require('node:fs');
const assert = require('node:assert/strict');
const { test } = require('node:test');
const pages = fs.readdirSync('resources/views').filter(file => file.endsWith('.blade.php')).map(file => 'resources/views/' + file);
const routes = new Set([...fs.readFileSync('routes/web.php', 'utf8').matchAll(/'(\/[^']+\.php)'/g)].map(match => match[1]));
const home = fs.readFileSync('resources/views/home.blade.php', 'utf8');
test('static navigation targets real local routes and existing section IDs', () => {
    for (const file of pages) {
        const source = fs.readFileSync(file, 'utf8');
        for (const match of source.matchAll(/href="([^"]*)"/g)) {
            const target = match[1];
            if (target.includes('<?php') || target.includes('${') || /^https?:|^mailto:|^tel:/.test(target)) continue;
            assert(target !== '' && target !== '#', `${file} contains an empty link`);
            const [path, fragment] = target.split('#');
            if (!path && fragment) { assert(source.includes(`id="${fragment}"`), `${file} missing #${fragment}`); continue; }
            const normalized = '/' + path.replace(/^\.\//, '').replace(/^\//, '').split('?')[0];
            if (normalized.endsWith('.php')) assert(routes.has(normalized), `${file}: missing route ${normalized}`);
            else assert(normalized === '/index.html' || fs.existsSync('public' + normalized), `${file}: missing file ${normalized}`);
            if (fragment && normalized === '/index.html') assert(home.includes(`id="${fragment}"`), `Missing homepage section ${fragment}`);
        }
    }
});
