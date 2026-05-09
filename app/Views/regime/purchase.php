<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acheter un régime</title>
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
            --danger: #d92d20;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .container {
            max-width: 840px;
            margin: 48px auto;
            padding: 0 20px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.06);
        }
        .muted { color: var(--muted); }
        .pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--primary-weak);
            color: var(--primary);
            font-weight: 700;
            font-size: 12px;
        }
        .grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin: 20px 0;
        }
        .box {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px;
        }
        label { display: block; font-weight: 600; margin-bottom: 8px; }
        select, button {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font: inherit;
        }
        button {
            background: var(--primary);
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 700;
        }
        button:hover { filter: brightness(0.98); }
        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .alert-success { background: #ecfdf3; color: #027a48; }
        .alert-error { background: #fef3f2; color: var(--danger); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Acheter un régime</h1>
            <p class="muted">Sélectionnez une durée pour le régime <?= esc($regime['nom_regime']) ?>.</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <div class="grid">
                <div class="box">
                    <div class="muted">Régime</div>
                    <strong><?= esc($regime['nom_regime']) ?></strong>
                </div>
                <div class="box">
                    <div class="muted">Variation poids</div>
                    <strong><?= esc($regime['variation_poids']) ?> kg</strong>
                </div>
                <div class="box">
                    <div class="muted">Mode d'accès</div>
                    <strong><?= $isGold ? 'Gold' : 'Standard' ?></strong>
                    <div class="muted">Réduction: <?= esc((string) $discountPercent) ?>%</div>
                </div>
                <div class="box">
                    <div class="muted">Solde disponible</div>
                    <strong><?= esc((string) $argent) ?> Ar</strong>
                </div>
            </div>

            <?php if (empty($durees)): ?>
                <p class="alert alert-error">Aucune durée disponible pour ce régime.</p>
            <?php else: ?>
                <form method="POST" action="<?= site_url('/regimes/purchase/' . $regime['id_regime']) ?>">
                    <?= csrf_field() ?>
                    <div class="box">
                        <label for="id_duree_regime">Durée du régime</label>
                        <select id="id_duree_regime" name="id_duree_regime" required>
                            <option value="">-- Choisir une durée --</option>
                            <?php foreach ($durees as $duree): ?>
                                <option value="<?= esc($duree['id_duree_regime']) ?>" <?= old('id_duree_regime') === (string) $duree['id_duree_regime'] ? 'selected' : '' ?>>
                                    <?= esc($duree['nb_jours']) ?> jours - <?= esc($duree['prix_final']) ?> Ar
                                    <?php if ($isGold): ?>
                                        (au lieu de <?= esc($duree['prix']) ?> Ar)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="margin-top: 18px;">
                        <button type="submit">Confirmer l'achat</button>
                    </div>
                </form>
            <?php endif; ?>

            <p style="margin-top: 18px;"><a href="<?= site_url('/regimes') ?>">Retour à la liste des régimes</a></p>
        </div>
    </div>
</body>
</html>
