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

            // Campus photos and provenance live in the shared school catalog.
            const escapeAttribute = value => String(value).replaceAll('&', '&amp;').replaceAll('"', '&quot;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');

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
                        <div class="ecole-subsection ${sectionClass} is-collapsed" data-sector-key="${key}">
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
                                <button type="button" class="section-toggle" aria-expanded="false" aria-controls="ecole-collapse-${key}" data-section-label="${escapeAttribute(config.label)}" aria-label="Développer la section ${config.label}">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="section-image" aria-hidden="true">
                                    <img src="${config.image}" data-fallback="/img/Graduate.png" alt="" loading="lazy">
                                </div>
                            </div>
                            <div class="ecole-section-collapse" id="ecole-collapse-${key}" aria-hidden="true" inert>
                                <div class="ecole-section-collapse-inner">
                                    <div class="ecole-section">
                                        <div class="section-grid">
                                            ${items.map(ecole => {
                                        const sectorLabel = sectorConfig[ecole.sector]?.label || ecole.sector;
                                        const sectorShort = sectorLabel.split(' ')[0].replaceAll(",", "");
                                        const typeLabel = ecole.type === 'public' ? 'Public' : 'Privé';
                                        const documentsLink = `https://wa.me/212700059552?text=${encodeURIComponent('Bonjour, je souhaite recevoir les documents pour ' + ecole.name + '.')}`;
                                        return `
                                        <article class="ecole-card" data-school-id="${ecole.id}" data-sector="${ecole.sector}" data-duration="${ecole.durationValue}" data-type="${ecole.type}">
                                            <figure class="ecole-card-image"><img src="${escapeAttribute(ecole.image)}" alt="${escapeAttribute(ecole.imageAlt)}" loading="lazy" decoding="async" width="1200" height="800"><figcaption>${escapeAttribute(ecole.imageCaption)}</figcaption></figure>
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
                                                        En savoir plus <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <button type="button" class="school-favorite" data-school-id="${ecole.id}" aria-pressed="false" aria-label="Enregistrer ${ecole.name}" disabled><i class="far fa-heart" aria-hidden="true"></i><span>Enregistrer</span></button>
                                            <a href="${escapeAttribute(documentsLink)}" target="_blank" rel="noopener noreferrer" class="ecole-card-drive" aria-label="Demander les documents sur WhatsApp - ${escapeAttribute(ecole.name)}">
                                                <i class="fa-brands fa-google-drive" aria-hidden="true"></i>
                                                <span>Demander les documents</span>
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
                if (image.tagName === 'IMG' && image.closest('.ecole-card-image')) {
                    image.hidden = true;
                    image.closest('.ecole-card-image').classList.add('photo-unavailable');
                    return;
                }
                if (image.tagName === 'IMG' && image.closest('.ecole-card-image')) {
                    image.hidden = true;
                    image.closest('.ecole-card-image').classList.add('photo-unavailable');
                    return;
                }
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
                    sectionToggle.setAttribute('aria-label', `${isCollapsed ? 'Développer' : 'Réduire'} la section ${sectionToggle.dataset.sectionLabel}`);
                    const sectionPanel = subsection.querySelector('.ecole-section-collapse');
                    sectionPanel.inert = isCollapsed;
                    sectionPanel.setAttribute('aria-hidden', String(isCollapsed));
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
