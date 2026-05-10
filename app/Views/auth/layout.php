<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Projet Régime</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/variables.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body class="auth-page">
    <div class="auth-wrapper">
        <?= $this->renderSection('content') ?>
    </div>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
