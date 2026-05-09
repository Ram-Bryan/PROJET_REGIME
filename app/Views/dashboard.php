<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Bienvenue, <strong><?= esc($nom) ?></strong></p>
    <p>Email: <?= esc($email) ?></p>
    <p>Rôle: <?= esc($role) ?></p>

    <?php if (session()->get('imc') !== null): ?>
        <p>IMC: <?= esc((string) session()->get('imc')) ?></p>
    <?php endif; ?>

    <?php if (session()->get('objectif_label')): ?>
        <p>Objectif: <?= esc((string) session()->get('objectif_label')) ?></p>
    <?php endif; ?>

    <a href="<?= site_url('/logout') ?>">Se déconnecter</a>
</body>
</html>
