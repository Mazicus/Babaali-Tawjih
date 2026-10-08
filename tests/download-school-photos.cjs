const fs = require('node:fs');
const sources = JSON.parse(fs.readFileSync('img/schools/sources.json', 'utf8'));
(async () => {
  const pending = sources.filter(s => s.replace || !fs.existsSync(`img/schools/${s.id}.original`));
  for (let start = 0; start < pending.length; start += 6) {
    await Promise.all(pending.slice(start, start + 6).map(async s => {
      try {
        const response = await fetch(s.url, { signal: AbortSignal.timeout(25000), headers: { 'User-Agent': 'Mozilla/5.0' } });
        if (!response.ok || !response.headers.get('content-type')?.startsWith('image/')) throw new Error(`HTTP ${response.status}`);
        const bytes = Buffer.from(await response.arrayBuffer());
        fs.writeFileSync(`img/schools/${s.id}.original`, bytes);
        console.log(`Downloaded ${s.id}: ${bytes.length} bytes`);
      } catch (e) { console.log(`FAILED ${s.id}: ${e.message}`); }
    }));
  }
})();
