<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .empty-state {
            margin-top: 20px;
            padding: 16px;
            background: #f9f9f9;
            border: 1px dashed #ccc;
        }
    </style>
</head>
<body>
    <h1>Historique des transactions</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <p>Aucune transaction trouvée pour le moment.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date d'achat</th>
                    <th>Régime</th>
                    <th>Durée</th>
                    <th>Prix durée</th>
                    <th>Montant payé</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?= esc($transaction['date_achat']) ?></td>
                        <td><?= esc($transaction['nom_regime'] ?? 'Non défini') ?></td>
                        <td><?= isset($transaction['nb_jours']) ? esc($transaction['nb_jours']) . ' jours' : 'Non défini' ?></td>
                        <td><?= isset($transaction['prix_duree']) ? esc($transaction['prix_duree']) . ' Ar' : 'Non défini' ?></td>
                        <td><?= esc($transaction['montant_paye']) ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top: 16px;">
        <a href="<?= site_url('/dashboard') ?>">Retour au dashboard</a>
    </p>
</body>
</html>
