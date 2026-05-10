<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Étape 1<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:700px; margin: 0 auto;">
    <div class="page-header" style="margin-bottom:16px;">
        <h1>Inscription - Étape 1</h1>
        <p class="sub">Renseignez vos informations personnelles.</p>
    </div>

    <?php if (session('errors')): ?>
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('/register') ?>" method="post" class="stack">
        <?= csrf_field() ?>

        <div class="grid">
            <div>
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required>
            </div>
        </div>

        <div class="grid">
            <div>
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="6" required>
            </div>
            <div>
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">-- Choisir --</option>
                    <option value="Homme" <?= old('genre') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                    <option value="Femme" <?= old('genre') === 'Femme' ? 'selected' : '' ?>>Femme</option>
                </select>
            </div>
        </div>

        <div>
            <label for="date_naissance">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance')) ?>" required>
        </div>

        <div class="actions">
            <button type="submit" class="btn">Continuer</button>
        </div>
    </form>

    <p style="margin-top:14px;">Déjà un compte ? <a href="<?= site_url('/login') ?>">Se connecter</a></p>
</section>
<?= $this->endSection() ?>
