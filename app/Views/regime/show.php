<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($regime['nom_regime']) ?> - Détails</title>
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
            margin-bottom: 20px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--primary-weak);
            color: var(--primary);
            font-size: 12px;
            font-weight: 600;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }
        .item-title {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .item-value {
            font-size: 16px;
            font-weight: 600;
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
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid var(--primary);
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }
        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        th {
            color: var(--muted);
            font-weight: 600;
        }
        tr:last-child td { border-bottom: none; }
        .back {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .empty {
            text-align: center;
            padding: 32px 16px;
            color: var(--muted);
            font-size: 14px;
        }
        .option-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 12px;
            display: grid;
            gap: 6px;
        }
        .option-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
        .option-meta {
            color: var(--muted);
            font-size: 13px;
        }
        .success {
            color: #027a48;
            font-weight: 600;
            font-size: 13px;
        }
        .danger {
            color: #b42318;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a class="back" href="<?= esc(site_url('regimes')) ?>">← Retour aux régimes</a>
                <h1><?= esc($regime['nom_regime']) ?></h1>
                <p class="sub">Détails complets du régime et objectifs attendus</p>
            </div>
            <div class="header-actions">
                <div class="badge"><?= esc($regime['variation_label']) ?></div>
            </div>
        </div>

        <div class="card">
            <div class="grid">
                <div>
                    <div class="item-title">Variation de poids</div>
                    <div class="item-value"><?= esc($regime['variation_label']) ?></div>
                </div>
                <div>
                    <div class="item-title">Objectif</div>
                    <div class="item-value"><?= esc($objectiveLabel) ?></div>
                </div>
                <div>
                    <div class="item-title">Composition</div>
                    <div class="item-value">
                        <?= esc($regime['pourcentage_viande']) ?>% viande ·
                        <?= esc($regime['pourcentage_poisson']) ?>% poisson ·
                        <?= esc($regime['pourcentage_volaille']) ?>% volaille
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">À propos de ce régime</h2>
            <p class="sub" style="margin-bottom: 8px;">
                <?= esc($regime['nom_regime']) ?> est un programme alimentaire conçu pour <?= esc(strtolower($objectiveLabel)) ?>,
                basé sur une répartition précise des sources protéiques.
            </p>
            <ul style="margin: 0; padding-left: 18px; color: var(--muted); font-size: 14px;">
                <li>Variation estimée mensuelle: <strong><?= esc($regime['variation_label']) ?></strong></li>
                <li>Répartition: <?= esc($regime['pourcentage_viande']) ?>% viande, <?= esc($regime['pourcentage_poisson']) ?>% poisson, <?= esc($regime['pourcentage_volaille']) ?>% volaille.</li>
                <li>Accompagnement sport recommandé selon les activités proposées.</li>
            </ul>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Activités recommandées</h2>
            <?php if (empty($activites)) : ?>
                <div class="empty">Aucune activité associée à ce régime.</div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Activité</th>
                            <th>Fréquence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activites as $activite) : ?>
                            <tr>
                                <td><?= esc($activite['label_activite']) ?></td>
                                <td><?= esc($activite['nb_par_semaine']) ?>x/semaine</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Commander</h2>
            <?php if (empty($durees)) : ?>
                <div class="empty">Aucune durée disponible pour ce régime.</div>
            <?php else : ?>
                <form id="commande-form" method="post" action="<?= esc(site_url('regimes/purchase/' . $regime['id_regime'])) ?>">
                    <?php foreach ($durees as $index => $duree) : ?>
                        <label class="option-card">
                            <div class="option-header">
                                <input
                                    type="radio"
                                    name="duree"
                                    value="<?= esc($duree['id_duree_regime']) ?>"
                                    data-days="<?= esc($duree['nb_jours']) ?>"
                                    data-price="<?= esc($duree['prix']) ?>"
                                    <?= $index === 0 ? 'checked' : '' ?>
                                >
                                <?= esc($duree['nb_jours']) ?> jours
                            </div>
                            <div class="option-meta">→ <?= esc(number_format((float) $duree['prix'], 0, ',', ' ')) ?> Ar</div>
                            <div class="option-meta">→ Résultat estimé: <span class="estimate" data-days="<?= esc($duree['nb_jours']) ?>"></span></div>
                        </label>
                    <?php endforeach; ?>
                    <div id="objectif-status" class="success" style="display:none; margin-top: 8px;">✅ Objectif atteint</div>
                    <div id="objectif-status-fail" class="danger" style="display:none; margin-top: 8px;">❌ Objectif non atteint</div>
                    <div style="margin-top: 16px;">
                        <button class="btn" type="submit">Commander</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <script>
        (function() {
            const form = document.getElementById('commande-form');
            if (!form) return;

            const objectiveStatus = document.getElementById('objectif-status');
            const variationMonthly = <?= json_encode((float) $regime['variation_mensuelle_kg']) ?>;
            const user = <?= json_encode($user ?? null) ?>;
            const imcIdealMin = <?= json_encode($imcIdealMin) ?>;
            const imcIdealMax = <?= json_encode($imcIdealMax) ?>;

            const formatKg = (value) => {
                const sign = value > 0 ? '+' : '';
                return sign + value.toFixed(2).replace(/\.00$/, '').replace(/\.([1-9])0$/, '.$1') + 'kg';
            };

            const updateEstimates = () => {
                const estimateNodes = form.querySelectorAll('.estimate');
                estimateNodes.forEach((node) => {
                    const days = Number(node.dataset.days || 0);
                    const estimated = variationMonthly * (days / 30);
                    node.textContent = formatKg(estimated);
                });
            };

            const isObjectiveReached = (selectedDays) => {
                if (!user) return false;

                const variation = variationMonthly * (selectedDays / 30);
                const poidsActuel = Number(user.poids_kg || 0);
                const poidsObjectif = user.poids_objectif !== null ? Number(user.poids_objectif) : null;
                const tailleCm = Number(user.taille_cm || 0);
                const objectifId = Number(user.id_objectif || 0);

                if (objectifId === 1 && poidsObjectif !== null) {
                    const cible = poidsObjectif - poidsActuel;
                    return variation <= cible;
                }

                if (objectifId === 2 && poidsObjectif !== null) {
                    const cible = poidsObjectif - poidsActuel;
                    return variation >= cible;
                }

                if (objectifId === 3 && tailleCm > 0 && imcIdealMin !== null && imcIdealMax !== null) {
                    const tailleM = tailleCm / 100;
                    const nouveauPoids = poidsActuel + variation;
                    const imc = nouveauPoids / (tailleM * tailleM);
                    return imc >= imcIdealMin && imc <= imcIdealMax;
                }

                return false;
            };

            const updateObjectiveStatus = () => {
                const selected = form.querySelector('input[name="duree"]:checked');
                if (!selected) return;
                const days = Number(selected.dataset.days || 0);
                if (!user) {
                    objectiveStatus.style.display = 'none';
                    const failNode = document.getElementById('objectif-status-fail');
                    if (failNode) {
                        failNode.style.display = 'none';
                    }
                    return;
                }
                const reached = isObjectiveReached(days);
                objectiveStatus.style.display = reached ? 'block' : 'none';
                const failNode = document.getElementById('objectif-status-fail');
                if (failNode) {
                    failNode.style.display = reached ? 'none' : 'block';
                }
            };

            updateEstimates();
            updateObjectiveStatus();
            form.addEventListener('change', updateObjectiveStatus);
        })();
    </script>
</body>
</html>
