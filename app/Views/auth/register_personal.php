<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Étape 1<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:920px; margin: 0 auto; padding: 0; overflow:hidden;">
    <div style="display:grid; grid-template-columns: 1fr 1fr; min-height:100%;">
        <div style="padding:28px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.96), rgba(96, 165, 250, 0.74)); color:#fff; display:flex; flex-direction:column; justify-content:space-between; gap:24px;">
            <div>
                <div class="badge" style="background: rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.18);">Créer un compte</div>
                <div class="page-header" style="margin-top:18px;">
                    <h1>Inscription - Étape 1</h1>
                    <p class="sub" style="color: rgba(255,255,255,0.84);">Commencez votre parcours avec des informations propres et une navigation fluide.</p>
                </div>
            </div>
            <div class="sub" style="color: rgba(255,255,255,0.8);">Étape 1 sur 2 • informations personnelles</div>
        </div>

        <div style="padding:28px;">
            <?php if (session('errors')): ?>
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('/register') ?>" method="post" class="stack" data-ajax-form="true">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>

                <div class="grid">
                    <div>
                        <label for="nom">Nom complet</label>
                        <input type="text" id="nom" name="nom" minlength="2" maxlength="80" autocomplete="name" value="<?= esc(old('nom')) ?>" required>
                        <div class="field-error" data-field-error="nom"></div>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" maxlength="120" autocomplete="email" value="<?= esc(old('email')) ?>" required>
                        <div class="field-error" data-field-error="email"></div>
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6" maxlength="72" autocomplete="new-password" required>
                        <p class="field-hint">Minimum 6 caractères.</p>
                        <div class="field-error" data-field-error="mot_de_passe"></div>
                    </div>
                    <div>
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">-- Choisir --</option>
                            <option value="Homme" <?= old('genre') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                            <option value="Femme" <?= old('genre') === 'Femme' ? 'selected' : '' ?>>Femme</option>
                        </select>
                        <div class="field-error" data-field-error="genre"></div>
                    </div>
                </div>

                <div>
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance')) ?>" required>
                    <div class="field-error" data-field-error="date_naissance"></div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Continuer</button>
                    <a href="<?= site_url('/login') ?>" class="btn btn-secondary">Déjà un compte</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
