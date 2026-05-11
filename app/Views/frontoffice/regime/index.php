<?= $this->extend('frontoffice/layout') ?>

<?= $this->section('title') ?>Régimes<?= $this->endSection() ?>

<?= $this->section('head') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="hero">
        <div class="page-header">
            <h1>Régimes</h1>
            <p class="sub">Explorez les formules disponibles, filtrez par durée ou objectif, et visualisez rapidement les durées et activités associées.</p>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Filtres</h2>
                <p class="sub">Affinez la liste selon votre besoin.</p>
            </div>
        </div>
        <form method="get" class="filters" id="filters">
                <div class="filter-group">
                    <label for="duree">Durée disponible</label>
                    <select name="duree" id="duree">
                        <option value="">Toutes les durées</option>
                        <?php foreach ($dureeOptions as $option) : ?>
                            <option value="<?= esc($option) ?>" <?= ($selectedDuree === $option) ? 'selected' : '' ?>>
                                <?= esc($option) ?> jours
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Objectif</label>
                    <div class="radio-group">
                        <?php foreach ($objectifOptions as $objectif) : ?>
                            <label class="radio-item">
                                <input type="radio" name="objectif" value="<?= esc($objectif['id_objectif']) ?>" <?= ($selectedObjectif === (int) $objectif['id_objectif']) ? 'checked' : '' ?>>
                                <?= esc($objectif['label_objectif']) ?>
                            </label>
                        <?php endforeach; ?>
                        <label class="radio-item">
                            <input type="radio" name="objectif" value="" <?= empty($selectedObjectif) ? 'checked' : '' ?>>
                            Tous
                        </label>
                    </div>
                </div>
        </form>
        <?php if (empty($regimes)) : ?>
            <div class="empty">Aucun régime disponible.</div>
        <?php else : ?>
            <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Variation estimée</th>
                        <th>Composition</th>
                        <th>Durées</th>
                        <th>Nb activités</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="regime-rows">
                    <?php foreach ($regimes as $regime) : ?>
                        <?php $durees = $regimeDurees[$regime['id_regime']] ?? []; ?>
                        <tr>
                            <td>
                                <span class="regime-name"><?= esc($regime['nom_regime']) ?></span>
                            </td>
                            <td><span class="badge"><?= esc($regime['variation_label']) ?></span></td>
                            <td>
                                <div class="composition-mini" style="--pie-gradients: <?= esc($regime['composition_gradient'] ?? '#e9eef3 0% 100%') ?>"></div>
                            </td>
                            <td>
                                <?php if (empty($durees)) : ?>
                                    <span class="badge badge-muted">Aucune</span>
                                <?php else : ?>
                                    <div class="badge-group">
                                        <?php foreach ($durees as $duree) : ?>
                                            <span class="badge badge-muted"><?= esc($duree) ?> j</span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge badge-muted"><?= esc($regime['activity_count']) ?></span></td>
                            <td>
                                <a href="<?= site_url('/regimes/' . $regime['id_regime']) ?>" class="btn btn-ghost btn-icon" title="Voir le détail">
                                    <img src="<?= esc(base_url('assets/icons/eye.svg')) ?>" alt="Voir">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
        (function() {
            const filters = document.getElementById('filters');
            const rows = document.getElementById('regime-rows');
            const detailBase = <?= json_encode(rtrim(site_url('regimes'), '/')) ?>;

            if (!filters || !rows) return;

            const renderRows = (regimes, regimeDurees) => {
                rows.innerHTML = '';

                if (!regimes.length) {
                    const emptyRow = document.createElement('tr');
                    const emptyCell = document.createElement('td');
                    emptyCell.colSpan = 6;
                    emptyCell.className = 'empty';
                    emptyCell.textContent = 'Aucun régime disponible.';
                    emptyRow.appendChild(emptyCell);
                    rows.appendChild(emptyRow);
                    return;
                }

                regimes.forEach((regime) => {
                    const row = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    const nameText = document.createElement('span');
                    nameText.className = 'regime-name';
                    nameText.textContent = regime.nom_regime;
                    nameCell.appendChild(nameText);
                    row.appendChild(nameCell);

                    const variationCell = document.createElement('td');
                    const variationBadge = document.createElement('span');
                    variationBadge.className = 'badge';
                    variationBadge.textContent = regime.variation_label;
                    variationCell.appendChild(variationBadge);
                    row.appendChild(variationCell);

                    const compositionCell = document.createElement('td');
                    const composition = document.createElement('div');
                    composition.className = 'composition-mini';
                    composition.style.setProperty('--pie-gradients', regime.composition_gradient || '#e9eef3 0% 100%');
                    compositionCell.appendChild(composition);
                    row.appendChild(compositionCell);

                    const durationsCell = document.createElement('td');
                    const durees = regimeDurees[regime.id_regime] || [];
                    if (durees.length) {
                        const group = document.createElement('div');
                        group.className = 'badge-group';
                        durees.forEach((duree) => {
                            const badge = document.createElement('span');
                            badge.className = 'badge badge-muted';
                            badge.textContent = `${duree} j`;
                            group.appendChild(badge);
                        });
                        durationsCell.appendChild(group);
                    } else {
                        const badge = document.createElement('span');
                        badge.className = 'badge badge-muted';
                        badge.textContent = 'Aucune';
                        durationsCell.appendChild(badge);
                    }
                    row.appendChild(durationsCell);

                    const countCell = document.createElement('td');
                    const countBadge = document.createElement('span');
                    countBadge.className = 'badge badge-muted';
                    countBadge.textContent = regime.activity_count || 0;
                    countCell.appendChild(countBadge);
                    row.appendChild(countCell);

                    const actionCell = document.createElement('td');
                    const actionLink = document.createElement('a');
                    actionLink.href = `${detailBase}/${regime.id_regime}`;
                    actionLink.className = 'btn btn-ghost btn-icon';
                    actionLink.title = 'Voir le détail';
                    const eye = document.createElement('img');
                    eye.src = '<?= esc(base_url('assets/icons/eye.svg')) ?>';
                    eye.alt = 'Voir';
                    actionLink.appendChild(eye);
                    actionCell.appendChild(actionLink);
                    row.appendChild(actionCell);
                    rows.appendChild(row);
                });
            };

            const applyFilters = () => {
                const formData = new FormData(filters);
                const params = new URLSearchParams(formData);

                fetch(`/regimes?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then((response) => response.json())
                    .then((data) => {
                        renderRows(data.regimes || [], data.regimeDurees || {});
                    })
                    .catch(() => {
                        renderRows([], {});
                    });
            };

            filters.addEventListener('change', applyFilters);
        })();
    </script>
    <?= $this->endSection() ?>
