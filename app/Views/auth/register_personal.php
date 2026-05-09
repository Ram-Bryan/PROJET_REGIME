<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Infos personnelles</title>
</head>
<body>
    <h1>Inscription - Étape 1 : Informations personnelles</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session('errors')): ?>
        <ul style="color: red;">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <form action="<?= site_url('/register') ?>" method="post">
        <?= csrf_field() ?>

        <div>
            <label for="nom">Nom complet</label><br>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label><br>
            <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6" required>
        </div>

        <div>
            <label for="genre">Genre</label><br>
            <select id="genre" name="genre" required>
                <option value="">-- Choisir --</option>
                <option value="Homme" <?= old('genre') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= old('genre') === 'Femme' ? 'selected' : '' ?>>Femme</option>
            </select>
        </div>

        <div>
            <label for="date_naissance">Date de naissance</label><br>
            <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance')) ?>" required>
        </div>

        <button type="submit">Continuer</button>
    </form>

    <p><a href="<?= site_url('/login') ?>">Déjà un compte ? Se connecter</a></p>
</body>
</html>
