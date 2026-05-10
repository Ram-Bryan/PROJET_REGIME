<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Connexion<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:520px; margin: 0 auto;">
    <div class="page-header" style="margin-bottom: 16px;">
        <h1>Connexion</h1>
        <p class="sub">Accédez à votre espace personnel.</p>
    </div>

    <form action="<?= site_url('/login') ?>" method="post" class="stack">
        <?= csrf_field() ?>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="120" autocomplete="email" value="<?= esc(old('email')) ?>" required>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6" autocomplete="current-password" required>
            <p class="field-hint">Minimum 6 caractères.</p>
        </div>

        <button type="submit" class="btn">Se connecter</button>
    </form>

    <p style="margin-top: 14px;">Pas encore de compte ? <a href="<?= site_url('/register') ?>">Créer un compte</a></p>
</section>
<?= $this->endSection() ?>
