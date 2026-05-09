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

    <a href="<?= site_url('/logout') ?>">Se déconnecter</a>
</body>
</html>
