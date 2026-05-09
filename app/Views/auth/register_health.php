<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Infos santé</title>
</head>
<body>
    <h1>Inscription - Étape 2 : Informations santé</h1>

    <h2>Récapitulatif des informations personnelles</h2>
    <ul>
        <li>Nom : <?= esc($personal['nom']) ?></li>
        <li>Email : <?= esc($personal['email']) ?></li>
        <li>Genre : <?= esc($personal['genre']) ?></li>
        <li>Date de naissance : <?= esc($personal['date_naissance']) ?></li>
    </ul>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <form action="<?= site_url('/register/health') ?>" method="post">
        <?= csrf_field() ?>

        <div>
            <label for="taille_cm">Taille (cm)</label><br>
            <input type="number" step="0.01" min="1" id="taille_cm" name="taille_cm" value="<?= esc(old('taille_cm')) ?>" required>
        </div>

        <div>
            <label for="poids_kg">Poids actuel (kg)</label><br>
            <input type="number" step="0.01" min="1" id="poids_kg" name="poids_kg" value="<?= esc(old('poids_kg')) ?>" required>
        </div>

        <div>
            <label for="poids_objectif">Poids objectif (kg)</label><br>
            <input type="number" step="0.01" min="1" id="poids_objectif" name="poids_objectif" value="<?= esc(old('poids_objectif')) ?>" required>
        </div>

        <div>
            <label for="id_objectif">Objectif</label><br>
            <select id="id_objectif" name="id_objectif" required>
                <option value="">-- Choisir un objectif --</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id_objectif']) ?>" <?= old('id_objectif') == $objectif['id_objectif'] ? 'selected' : '' ?>>
                        <?= esc($objectif['label_objectif']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Terminer l'inscription</button>
    </form>

    <p><a href="<?= site_url('/register') ?>">Retour à l'étape 1</a></p>
</body>
</html>
