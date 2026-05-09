<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes régimes</title>
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
        .badge-muted {
            background: #f2f4f7;
            color: #344054;
        }
        .empty {
            text-align: center;
            padding: 32px 16px;
            color: var(--muted);
            font-size: 14px;
        }
        .back {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .alert-success {
            background: #ecfdf3;
            color: #027a48;
            border: 1px solid #abefc6;
        }
        .alert-error {
            background: #fef3f2;
            color: #b42318;
            border: 1px solid #fecdca;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a class="back" href="<?= esc(site_url('regimes')) ?>">← Voir la liste des régimes</a>
                <h1>Mes régimes</h1>
                <p class="sub">Historique de vos achats et régimes actifs</p>
            </div>
        </div>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <div class="card">
            <?php if (empty($purchases)) : ?>
                <div class="empty">Aucun régime acheté pour le moment.</div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Régime</th>
                            <th>Objectif</th>
                            <th>Variation estimée</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Date d'achat</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $purchase) : ?>
                            <tr>
                                <td>
                                    <a href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'])) ?>">
                                        <?= esc($purchase['nom_regime']) ?>
                                    </a>
                                </td>
                                <td><?= esc($purchase['objective_label']) ?></td>
                                <td><span class="badge"><?= esc($purchase['variation_label']) ?></span></td>
                                <td><span class="badge badge-muted"><?= esc($purchase['nb_jours']) ?> j</span></td>
                                <td><?= esc(number_format((float) $purchase['montant_paye'], 0, ',', ' ')) ?> Ar</td>
                                <td><?= esc(date('d/m/Y', strtotime((string) $purchase['date_achat']))) ?></td>
                                <td>
                                    <a href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'] . '/export-pdf')) ?>">Exporter</a>
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
