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
            <?php if (empty($regimes)) : ?>
                <div class="empty">Aucun régime disponible.</div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Variation poids (kg)</th>
                            <th>Composition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($regimes as $regime) : ?>
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
                                    <a href="<?= site_url('/regimes/purchase/' . $regime['id_regime']) ?>">Acheter</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
