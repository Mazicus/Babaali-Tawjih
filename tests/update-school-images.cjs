const fs = require('node:fs');
const schools = JSON.parse(fs.readFileSync('public/data/schools.json', 'utf8'));
const sources = JSON.parse(fs.readFileSync('public/img/schools/sources.json', 'utf8'));
const shared = { 14: 11, 15: 1, 16: 2, 17: 3, 18: 4, 19: 5, 20: 6,
  63: 62, 65: 62, 66: 62, 67: 62, 68: 62, 70: 62, 71: 62, 72: 62 };
const existing = { 1: 'FMPA.jpg', 2: 'FMPM.jpg', 3: 'FMPC.jpeg', 4: 'FMPR.jpg', 5: 'FMPO.jpg', 8: 'FMPE.png' };
const captions = { 21: 'ISPITS Agadir · un des établissements du réseau',
  43: 'Centre BTS du lycée Al Khawarizmi · Casablanca',
  46: 'Centre CPGE du lycée Moulay Youssef · Rabat',
  54: 'ERSSM · formation des élèves officiers',
  62: 'Campus UM6P · Benguerir', 69: 'Campus UM6P · Rabat' };
for (const school of schools) {
  const photoId = shared[school.id] || school.id;
  school.image = existing[photoId] ? `/img/assets/Eco-Sup/${existing[photoId]}` : `/img/schools/${photoId}.webp`;
  school.imageSource = sources.find(s => s.id === photoId)?.source || school.link;
  school.imageCaption = captions[photoId] || (shared[school.id] ? `Campus ${schools.find(s => s.id === photoId).name}` : school.name);
  school.imageAlt = school.id === 54 ? 'Élèves officiers de l’École Royale du Service de Santé Militaire' : `Vue de l’établissement · ${school.imageCaption}`;
}
fs.writeFileSync('public/data/schools.json', JSON.stringify(schools, null, 2) + '\n');
let script = fs.readFileSync('public/Schools.js', 'utf8');
script = script.replace(/            \/\/ Function images[\s\S]*?            \/\/ Rendering/, `            // Campus photos and provenance live in the shared school catalog.\n            const escapeAttribute = value => String(value).replaceAll('&', '&amp;').replaceAll('"', '&quot;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');\n\n            // Rendering`);
script = script.replace('<div class="ecole-card-image"><img src="${getUniversityImage(ecole)}" data-fallback="/img/Graduate.png" alt="Illustration du domaine de formation" loading="lazy"></div>', '<figure class="ecole-card-image"><img src="${escapeAttribute(ecole.image)}" alt="${escapeAttribute(ecole.imageAlt)}" loading="lazy" decoding="async" width="1200" height="800"><figcaption>${ecole.imageCaption}</figcaption></figure>');
script = script.replace("                if (image.tagName === 'IMG' && image.dataset.fallback) {", "                if (image.tagName === 'IMG' && image.closest('.ecole-card-image')) {\n                    image.hidden = true;\n                    image.closest('.ecole-card-image').classList.add('photo-unavailable');\n                    return;\n                }\n                if (image.tagName === 'IMG' && image.dataset.fallback) {");
fs.writeFileSync('public/Schools.js', script);
console.log(`Updated ${schools.length} school cards with campus photos`);
