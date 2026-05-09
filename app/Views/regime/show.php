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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a class="back" href="<?= esc(site_url('regimes')) ?>">← Retour aux régimes</a>
                <h1><?= esc($regime['nom_regime']) ?></h1>
                <p class="sub">Détails du régime et tarifs par durée</p>
            </div>
            <div class="badge"><?= esc($regime['variation_label']) ?></div>
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
            <h2 style="margin: 0 0 12px; font-size: 18px;">Tarifs par durée</h2>
            <?php if (empty($durees)) : ?>
                <div class="empty">Aucun tarif disponible pour ce régime.</div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Durée (jours)</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($durees as $duree) : ?>
                            <tr>
                                <td><?= esc($duree['nb_jours']) ?> jours</td>
                                <td><?= esc(number_format((float) $duree['prix'], 0, ',', ' ')) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Acheter ce régime</h2>
            <p class="sub">Passez à l’écran d’achat pour choisir une durée et confirmer votre commande.</p>
            <p><a class="back" href="<?= esc(site_url('regimes/purchase/' . $regime['id_regime'])) ?>">Voir les options d'achat</a></p>
        </div>
    </div>
</body>
</html>
