(async () => {
            const directory = document.getElementById('ecolesSections');
            if (!directory) return;
            const savedSeed = document.getElementById('saved-school-data');
            // Shared catalog used by the public directory and personal favorites.
            const response = await fetch('/data/schools.json');
            if (!response.ok) throw new Error('Catalogue indisponible.');
            const allSchools = await response.json();
            let selectedIds = savedSeed ? JSON.parse(savedSeed.textContent).map(school => school.id) : null;
            let ecolesData = savedSeed ? allSchools.filter(school => selectedIds.includes(school.id)) : allSchools;

            // Secteur data
            const sectorsResponse = await fetch('/data/sectors.json');
            if (!sectorsResponse.ok) throw new Error('Secteurs indisponibles.');
            const sectorConfig = await sectorsResponse.json();

            // Group by sector
            function groupBySector(data) {
                const groups = {};
                data.forEach(item => {
                    if (!groups[item.sector]) {
                        groups[item.sector] = [];
                    }
                    groups[item.sector].push(item);
                });
                return groups;
            }

            // Function images
            function getUniversityImage(ecole) {
                const localImages = {
                    'FMP Agadir': '/img/assets/Eco-Sup/FMPA.jpg',
                    'FMP Marrakech': '/img/assets/Eco-Sup/FMPM.jpg',
                    'FMP Casablanca': '/img/assets/Eco-Sup/FMPC.jpeg',
                    'FMP Rabat': '/img/assets/Eco-Sup/FMPR.jpg',
                    'FMP Oujda': '/img/assets/Eco-Sup/FMPO.jpg',
                    'FMP Errachidia': '/img/assets/Eco-Sup/FMPE.png'
                };
                if (localImages[ecole.name]) return localImages[ecole.name];
                const imageMap = {
                    'FMP Agadir': 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=400&h=300&fit=crop&auto=format',
                    'FMP Marrakech': 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=400&h=300&fit=crop&auto=format',
                    'FMP Casablanca': 'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=400&h=300&fit=crop&auto=format',
                    'FMP Rabat': 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=400&h=300&fit=crop&auto=format',
                    'FMP Oujda': 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?w=400&h=300&fit=crop&auto=format',
                    'FMP Tanger': 'https://images.unsplash.com/photo-1666214280391-8ff5bd3c0bf0?w=400&h=300&fit=crop&auto=format',
                    'FMP Fès': 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&h=300&fit=crop&auto=format',
                    'FMD Casablanca': 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&h=300&fit=crop&auto=format',
                    'FMD Rabat': 'https://images.unsplash.com/photo-1609840114035-3c981b782dcf?w=400&h=300&fit=crop&auto=format',
                    'PH Casablanca': 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=400&h=300&fit=crop&auto=format',
                    'PH Rabat': 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=400&h=300&fit=crop&auto=format',
                    'ENCG Casablanca': 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop&auto=format',
                    'ISCAE Casablanca': 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop&auto=format',
                    'ISCAE Rabat': 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop&auto=format',
                    'ENA Rabat': 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=400&h=300&fit=crop&auto=format',
                    'ENA Fès': 'https://images.unsplash.com/photo-1503387837-b154d5074bd2?w=400&h=300&fit=crop&auto=format',
                    'INAU Rabat': 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop&auto=format',
                    'ENSA Agadir': 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&auto=format',
                    'ENSAM Meknès': 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=300&fit=crop&auto=format',
                    'FST Marrakech': 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=400&h=300&fit=crop&auto=format',
                    'EST Casablanca': 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=400&h=300&fit=crop&auto=format',
                    'ENAM Meknès': 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=400&h=300&fit=crop&auto=format',
                    'IAV Hassan II Rabat': 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop&auto=format',
                    'CPGE': 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=300&fit=crop&auto=format',
                    'LYDEX Benguerir': 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop&auto=format',
                    'ERA Marrakech': 'https://images.unsplash.com/photo-1541844053589-346841d0b34c?w=400&h=300&fit=crop&auto=format',
                    'ARM Meknès': 'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400&h=300&fit=crop&auto=format',
                    'ISITT Tanger': 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&h=300&fit=crop&auto=format',
                    'UIASS Rabat': 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400&h=300&fit=crop&auto=format',
                    'UM6SS Casablanca': 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=300&fit=crop&auto=format',
                    'UIR Rabat': 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=400&h=300&fit=crop&auto=format',
                    'FMS Benguerir': 'https://images.unsplash.com/photo-1666887360610-84e3bd985971?w=400&h=300&fit=crop&auto=format',
                    'SASE Benguerir': 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=400&h=300&fit=crop&auto=format',
                    'EMINES Benguerir': 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=400&h=300&fit=crop&auto=format',
                    'CS Benguerir': 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop&auto=format',
                };
                const fallbacks = {
                    sante: 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=400&h=300&fit=crop&auto=format',
                    commerce: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop&auto=format',
                    architecture: 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?w=400&h=300&fit=crop&auto=format',
                    ingenierie: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=300&fit=crop&auto=format',
                    agriculture: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop&auto=format',
                    preparatoire: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=300&fit=crop&auto=format',
                    militaire: 'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400&h=300&fit=crop&auto=format',
                    tourisme: 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&h=300&fit=crop&auto=format',
                    prive: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400&h=300&fit=crop&auto=format',
                    um6p: 'https://images.unsplash.com/photo-1562774053-701939374585?w=400&h=300&fit=crop&auto=format'
                };
                return imageMap[ecole.name] || fallbacks[ecole.sector] || 'https://images.unsplash.com/photo-1523050854058-8df90110c7f1?w=400&h=300&fit=crop&auto=format';
            }

            // Rendering
            function renderSections(data) {
                const container = document.getElementById('ecolesSections');
                if (!container) return;

                const groups = groupBySector(data);
                const sectorKeys = Object.keys(sectorConfig);

                let totalItems = 0;
                let html = '';

                sectorKeys.forEach((key) => {
                    const items = groups[key] || [];
                    if (items.length === 0) return;

                    totalItems += items.length;
                    const config = sectorConfig[key];
                    const isPrimary = config.color === 'primary';
                    const sectionClass = isPrimary ? 'section-primary' : 'section-secondary';

                    html += `
                        <div class="ecole-subsection ${sectionClass}" data-sector-key="${key}">
                            <div class="section-header">
                                <div class="section-header-content">
                                    <div class="section-icon">
                                        <i class="${config.icon}"></i>
                                    </div>
                                    <div class="section-title-wrapper">
                                        <h3>${config.label}</h3>
                                        <span class="section-count">${items.length} établissements</span>
                                    </div>
                                </div>
                                <button type="button" class="section-toggle" aria-expanded="true" aria-controls="ecole-collapse-${key}" aria-label="Réduire la section ${config.label}">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="section-image" aria-hidden="true">
                                    <img src="${config.image}" data-fallback="/img/Graduate.png" alt="" loading="lazy">
                                </div>
                            </div>
                            <div class="ecole-section-collapse" id="ecole-collapse-${key}">
                                <div class="ecole-section-collapse-inner">
                                    <hr class="section-divider">
                                    <div class="ecole-section">
                                        <div class="section-grid">
                                            ${items.map(ecole => {
                                        const sectorLabel = sectorConfig[ecole.sector]?.label || ecole.sector;
                                        const sectorShort = sectorLabel.split(' ')[0].replaceAll(",", "");
                                        const typeLabel = ecole.type === 'public' ? 'Public' : 'Privé';
                                        const driveLink = ecole.drive || ecole.link;
                                        const hasDrive = Boolean(ecole.drive);
                                        return `
                                        <article class="ecole-card" data-school-id="${ecole.id}" data-sector="${ecole.sector}" data-duration="${ecole.durationValue}" data-type="${ecole.type}">
                                            <div class="ecole-card-image"><img src="${getUniversityImage(ecole)}" data-fallback="/img/Graduate.png" alt="Illustration du domaine de formation" loading="lazy"></div>
                                            <button type="button" class="ecole-card-toggle" aria-expanded="false" aria-controls="ecole-panel-${ecole.id}" id="ecole-toggle-${ecole.id}">
                                                <span class="ecole-card-badges">
                                                    <span class="sector-tag">${sectorShort}</span>
                                                    <span class="type-tag ${ecole.type}">${typeLabel}</span>
                                                </span>
                                                <h3 class="card-title">${ecole.name}</h3>
                                                <ul class="card-summary-list">
                                                    <li class="detail-item">
                                                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                                        <span>${ecole.diploma}</span>
                                                    </li>
                                                    <li class="detail-item">
                                                        <i class="fas fa-clock" aria-hidden="true"></i>
                                                        <span>${ecole.duration}</span>
                                                    </li>
                                                    <li class="detail-item">
                                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                                        <span>${ecole.location}</span>
                                                    </li>
                                                </ul>
                                                <span class="ecole-card-chevron" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
                                            </button>
                                            <div class="ecole-card-panel" aria-hidden="true" inert id="ecole-panel-${ecole.id}" role="region" aria-labelledby="ecole-toggle-${ecole.id}">
                                                <div class="ecole-card-panel-inner">
                                                    <ul class="card-full-list">
                                                        <li class="detail-item">
                                                            <i class="fas fa-layer-group" aria-hidden="true"></i>
                                                            <span><strong>Secteur :</strong> ${sectorLabel}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                                            <span><strong>Diplôme :</strong> ${ecole.diploma}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                                            <span><strong>Durée :</strong> ${ecole.duration}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                                            <span><strong>Ville :</strong> ${ecole.location}</span>
                                                        </li>
                                                        ${ecole.fees ? `
                                                        <li class="detail-item">
                                                            <i class="fas fa-coins" aria-hidden="true"></i>
                                                            <span><strong>Frais :</strong> ${ecole.fees}</span>
                                                        </li>` : ''}
                                                    </ul>
                                                    <a href="${ecole.link}" target="_blank" rel="noopener noreferrer" class="btn-card">
                                                        En savoir plus <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <button type="button" class="school-favorite" data-school-id="${ecole.id}" aria-pressed="false" aria-label="Enregistrer ${ecole.name}" disabled><i class="far fa-heart" aria-hidden="true"></i><span>Enregistrer</span></button>
                                            <a href="${driveLink}" target="_blank" rel="noopener noreferrer" class="ecole-card-drive" aria-label="${hasDrive ? 'Documents Drive' : 'Site officiel'} - ${ecole.name}">
                                                <i class="${hasDrive ? 'fa-brands fa-google-drive' : 'fas fa-arrow-up-right-from-square'}" aria-hidden="true"></i>
                                                <span>${hasDrive ? 'Documents sur Drive' : 'Site officiel de l’établissement'}</span>
                                            </a>
                                        </article>
                                    `;
                                    }).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                document.getElementById('resultCount').textContent = totalItems;
                if (!data.length) {
                    html = '<div class="directory-empty">' + (savedSeed && !selectedIds.length ? '<h3>Votre sélection commence ici.</h3><p>Enregistrez vos écoles depuis le catalogue pour les retrouver ici.</p><a class="btn-card" href="/index.html#ecoles">Explorer le catalogue</a>' : '<p>Aucun établissement ne correspond à vos critères.</p>') + '</div>';
                }
                container.innerHTML = html;
                window.schoolFavorites?.refresh();
            }

            // Filter
            function getFilteredData() {
                const searchQuery = document.getElementById('searchEcoles')?.value.toLowerCase().trim() || '';

                const checkedSectors = [...document.querySelectorAll('#filterDropdown .filter-group:first-child input[type="checkbox"]:checked')]
                    .map(el => el.value);
                const checkedDurations = [...document.querySelectorAll('#filterDropdown .filter-group:nth-child(2) input[type="checkbox"]:checked')]
                    .map(el => el.value);
                const checkedTypes = [...document.querySelectorAll('#filterDropdown .filter-group:nth-child(3) input[type="checkbox"]:checked')]
                    .map(el => el.value);

                let filtered = [...ecolesData];

                if (searchQuery) {
                    filtered = filtered.filter(ecole =>
                        ecole.name.toLowerCase().includes(searchQuery) ||
                        ecole.diploma.toLowerCase().includes(searchQuery) ||
                        ecole.location.toLowerCase().includes(searchQuery) ||
                        (sectorConfig[ecole.sector]?.label.toLowerCase().includes(searchQuery)) ||
                        (ecole.acronym && ecole.acronym.toLowerCase().includes(searchQuery))
                    );
                }

                if (checkedSectors.length > 0) {
                    filtered = filtered.filter(ecole => checkedSectors.includes(ecole.sector));
                }

                if (checkedDurations.length > 0) {
                    filtered = filtered.filter(ecole => {
                        const durations = ecole.durationValue.split(',');
                        return checkedDurations.some(d => durations.includes(d));
                    });
                }

                if (checkedTypes.length > 0) {
                    filtered = filtered.filter(ecole => checkedTypes.includes(ecole.type));
                }

                return filtered;
            }

            function applyFilters() {
                const filtered = getFilteredData();
                renderSections(filtered);
            }

            document.addEventListener('error', event => {
                const image = event.target;
                if (image.tagName === 'IMG' && image.dataset.fallback) {
                    const fallback = image.dataset.fallback;
                    delete image.dataset.fallback;
                    image.src = fallback;
                }
            }, true);
            // Event listeners
            document.getElementById('searchEcoles')?.addEventListener('input', applyFilters);
            document.getElementById('filterToggle')?.addEventListener('click', function() {
                const dropdown = document.getElementById('filterDropdown');
                dropdown.classList.toggle('show');
                this.classList.toggle('active');
                this.setAttribute('aria-expanded', String(dropdown.classList.contains('show')));
            });

            document.querySelector('.btn-filter-apply')?.addEventListener('click', applyFilters);

            document.querySelector('.btn-filter-reset')?.addEventListener('click', function() {
                document.querySelectorAll('#filterDropdown input[type="checkbox"]').forEach(el => el.checked = false);
                document.getElementById('searchEcoles').value = '';
                applyFilters();
            });

            document.addEventListener('click', function(e) {
                const filterContainer = document.querySelector('.search-container');
                const dropdown = document.getElementById('filterDropdown');
                if (filterContainer && dropdown) {
                    if (!filterContainer.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                        document.getElementById('filterToggle')?.classList.remove('active');
                    }
                }
            });

            // Ecole card - progressive disclosure (expand/collapse)
            document.getElementById('ecolesSections')?.addEventListener('click', function (e) {
                const sectionToggle = e.target.closest('.section-toggle');
                if (sectionToggle) {
                    const subsection = sectionToggle.closest('.ecole-subsection');
                    if (!subsection) return;
                    const isCollapsed = subsection.classList.toggle('is-collapsed');
                    sectionToggle.setAttribute('aria-expanded', String(!isCollapsed));
                    return;
                }

                const toggle = e.target.closest('.ecole-card-toggle');
                if (!toggle) return;
                const card = toggle.closest('.ecole-card');
                if (!card) return;
                const isExpanded = card.classList.toggle('is-expanded');
                toggle.setAttribute('aria-expanded', String(isExpanded));
                const panel = card.querySelector('.ecole-card-panel');
                panel.inert = !isExpanded;
                panel.setAttribute('aria-hidden', String(!isExpanded));
            });

            window.addEventListener('favorites:changed', event => {
                if (!savedSeed) return;
                selectedIds = event.detail.ids.filter(id => allSchools.some(school => school.id === id));
                ecolesData = allSchools.filter(school => selectedIds.includes(school.id));
                document.querySelectorAll('.favorites-count').forEach(element => { element.textContent = selectedIds.length; });
                applyFilters();
            });
            // Initialisation
            renderSections(ecolesData);
            })().catch(() => {
                document.getElementById('ecolesSections').textContent = 'Le catalogue est momentanément indisponible. Veuillez réessayer.';
            });
