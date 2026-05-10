<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Gestion du Régime</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body class="admin-login-body">
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <h1>
                    <img src="<?= esc(base_url('assets/icons/lock.svg')) ?>" alt="">
                    Admin Panel
                </h1>
                <p>Gestion du Régime</p>
            </div>

            <div class="admin-login-body-inner">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>

                <form id="admin-login-form" action="<?= base_url('/admin/authenticate') ?>" method="post" class="stack" novalidate>
                    <?= csrf_field() ?>

                    <div>
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.com" required autocomplete="email">
                    </div>

                    <div class="field-wrap">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="eye-btn" id="togglePassword">
                            <img src="<?= esc(base_url('assets/icons/eye.svg')) ?>" alt="Voir">
                        </button>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">
                        <span id="btnText">Se connecter</span>
                    </button>
                </form>
            </div>

            <div class="admin-login-footer">
                <p>© <?= date('Y') ?> Gestion du Régime. Tous droits réservés.</p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
</body>
</html>
