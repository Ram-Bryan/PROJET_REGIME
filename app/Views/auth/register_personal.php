<?= $this->extend('frontoffice/layout') ?>

<?= $this->section('title') ?>Inscription - Etape 1<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $p = is_array($personal ?? null) ? $personal : []; ?>
<section class="card auth-shell">
    <div class="auth-progress">
        <div class="auth-progress-meta">
            <span>Etape 1/3</span><span>Informations personnelles</span>
        </div>
        <div class="auth-progress-bar"><div class="auth-progress-fill" style="width:33.33%;"></div></div>
    </div>
    <div class="auth-grid">
        <div class="auth-promo">
            <h1 style="margin:0 0 8px;">Creer un compte</h1>
            <p class="sub">Champs obligatoires: nom, email, mot de passe.</p>
        </div>
        <div class="auth-form-panel">
            <form action="<?= site_url('/register') ?>" method="post" class="stack" data-ajax-form="true" id="register-personal-form" data-check-email-url="<?= site_url('/register/check-email') ?>">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>

                <div class="field-wrap">
                    <label for="nom">Nom complet <span style="color:#b42318;">*</span></label>
                    <input type="text" id="nom" name="nom" minlength="2" maxlength="100" placeholder="Ex: Jean Rakoto" value="<?= esc(old('nom', $p['nom'] ?? '')) ?>" required>
                    <span class="field-icon" data-icon="nom"></span>
                    <div class="field-error" data-field-error="nom"></div>
                </div>

                <div class="field-wrap">
                    <label>Genre</label>
                    <div class="radio-group">
                        <?php $genre = old('genre', $p['genre'] ?? 'Autre'); ?>
                        <label class="radio-item"><input type="radio" name="genre" value="Homme" <?= $genre === 'Homme' ? 'checked' : '' ?>>Homme</label>
                        <label class="radio-item"><input type="radio" name="genre" value="Femme" <?= $genre === 'Femme' ? 'checked' : '' ?>>Femme</label>
                        <label class="radio-item"><input type="radio" name="genre" value="Autre" <?= $genre === 'Autre' ? 'checked' : '' ?>>Autre</label>
                    </div>
                    <div class="field-error" data-field-error="genre"></div>
                </div>

                <div class="field-wrap">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance', $p['date_naissance'] ?? '')) ?>">
                    <span class="field-icon" data-icon="date_naissance"></span>
                    <div class="field-error" data-field-error="date_naissance"></div>
                </div>

                <div class="field-wrap">
                    <label for="email">Email <span style="color:#b42318;">*</span></label>
                    <input type="email" id="email" name="email" maxlength="120" placeholder="Ex: jean@email.com" value="<?= esc(old('email', $p['email'] ?? '')) ?>" required>
                    <span class="field-icon" data-icon="email"></span>
                    <div class="field-error" data-field-error="email"></div>
                </div>

                <div class="field-wrap">
                    <label for="mot_de_passe">Mot de passe <span style="color:#b42318;">*</span></label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" maxlength="72" placeholder="8+ caracteres, 1 majuscule, 1 chiffre" value="<?= esc(old('mot_de_passe', $p['mot_de_passe'] ?? '')) ?>" required>
                    <button type="button" class="eye-btn" id="toggle-password"><img src="<?= base_url('assets/icons/eye.svg') ?>" alt="Voir"></button>
                    <span class="field-icon" data-icon="mot_de_passe"></span>
                    <div class="field-hint" id="password-strength">Force: -</div>
                    <div class="field-error" data-field-error="mot_de_passe"></div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Continuer</button>
                    <a href="<?= site_url('/login') ?>" class="btn btn-secondary">Deja un compte</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/auth.js') ?>"></script>
<?= $this->endSection() ?>
