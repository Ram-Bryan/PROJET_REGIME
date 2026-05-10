<?= $this->extend('frontoffice/layout') ?>

<?= $this->section('title') ?>Connexion<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card auth-shell">
    <div class="auth-grid">
        <div class="auth-promo">
            <div>
                <div class="badge">Espace membre</div>
                <div class="page-header">
                    <h1>Connexion</h1>
                    <p class="sub">Accédez à votre espace personnel, vos régimes et votre suivi en quelques secondes.</p>
                </div>
            </div>
            <div class="sub">Connexion sécurisée • expérience mobile propre • accès rapide aux actions clés</div>
        </div>

        <div class="auth-form-panel">
            <form action="<?= site_url('/login') ?>" method="post" class="stack" data-ajax-form="true">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" maxlength="120" autocomplete="email" placeholder="Ex: jean@gmail.com" value="<?= esc(old('email')) ?>" required>
                    <div class="field-error" data-field-error="email"></div>
                </div>

                <div class="field-wrap">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" autocomplete="current-password" required>
                    <button type="button" class="eye-btn" id="toggle-login-password"><img src="<?= base_url('assets/icons/eye.svg') ?>" alt="Voir"></button>
                    <div class="field-error" data-field-error="mot_de_passe"></div>
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>

            <p style="margin-top: var(--space-4);">Pas encore de compte ? <a href="<?= site_url('/register') ?>">Créer un compte</a></p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/auth.js') ?>"></script>
<?= $this->endSection() ?>

