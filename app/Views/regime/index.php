<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Régimes</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f6f7fb;
            --card: #ffffff;
            --text: #101828;
            --muted: #667085;
            --border: #eaecf0;
            --primary: #2b59ff;
            --primary-weak: #e8eeff;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .container {
            max-width: 960px;
            margin: 48px auto;
            padding: 0 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
        }
        .sub {
            color: var(--muted);
            margin: 6px 0 0;
            font-size: 14px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.06);
        }
        .filters {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-bottom: 20px;
        }
        .filter-group label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }
        select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 14px;
        }
        .radio-group {
            display: flex;
            gap: 12px;
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .radio-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--text);
            padding: 6px 10px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        th {
            color: var(--muted);
            font-weight: 600;
        }
        tr:last-child td { border-bottom: none; }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--primary-weak);
            color: var(--primary);
            font-size: 12px;
            font-weight: 600;
        }
        .badge-muted {
            background: #f2f4f7;
            color: #344054;
        }
        .badge-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .empty {
            text-align: center;
            padding: 32px 16px;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Régimes</h1>
                <p class="sub">Liste des régimes disponibles</p>
            </div>
        </div>
        <div class="card">
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
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Variation poids (kg)</th>
                            <th>Composition</th>
                            <th>Durées</th>
                        </tr>
                    </thead>
                    <tbody id="regime-rows">
                        <?php foreach ($regimes as $regime) : ?>
                            <?php $durees = $regimeDurees[$regime['id_regime']] ?? []; ?>
                            <tr>
                                <td><?= esc($regime['nom_regime']) ?></td>
                                <td>
                                    <span class="badge">
                                        <?= esc($regime['variation_poids']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= esc($regime['pourcentage_viande']) ?>% viande,
                                    <?= esc($regime['pourcentage_poisson']) ?>% poisson,
                                    <?= esc($regime['pourcentage_volaille']) ?>% volaille
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script>
        (function() {
            const filters = document.getElementById('filters');
            const rows = document.getElementById('regime-rows');

            if (!filters || !rows) return;

            const renderRows = (regimes, regimeDurees) => {
                rows.innerHTML = '';

                if (!regimes.length) {
                    const emptyRow = document.createElement('tr');
                    const emptyCell = document.createElement('td');
                    emptyCell.colSpan = 4;
                    emptyCell.className = 'empty';
                    emptyCell.textContent = 'Aucun régime disponible.';
                    emptyRow.appendChild(emptyCell);
                    rows.appendChild(emptyRow);
                    return;
                }

                regimes.forEach((regime) => {
                    const row = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    nameCell.textContent = regime.nom_regime;
                    row.appendChild(nameCell);

                    const variationCell = document.createElement('td');
                    const variationBadge = document.createElement('span');
                    variationBadge.className = 'badge';
                    variationBadge.textContent = regime.variation_poids;
                    variationCell.appendChild(variationBadge);
                    row.appendChild(variationCell);

                    const compositionCell = document.createElement('td');
                    compositionCell.textContent = `${regime.pourcentage_viande}% viande, ${regime.pourcentage_poisson}% poisson, ${regime.pourcentage_volaille}% volaille`;
                    row.appendChild(compositionCell);

                    const dureeCell = document.createElement('td');
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
                        dureeCell.appendChild(group);
                    } else {
                        const badge = document.createElement('span');
                        badge.className = 'badge badge-muted';
                        badge.textContent = 'Aucune';
                        dureeCell.appendChild(badge);
                    }
                    row.appendChild(dureeCell);

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
</body>
</html>
