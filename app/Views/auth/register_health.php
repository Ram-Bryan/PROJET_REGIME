<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Étape 2<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack" style="max-width:760px; margin: 0 auto;">
    <div class="page-header">
        <h1>Inscription - Étape 2</h1>
        <p class="sub">Complétez votre profil santé.</p>
    </div>

    <div class="card">
        <h2 style="margin:0 0 12px; font-size:18px;">Récapitulatif</h2>
        <div class="grid">
            <div>
                <div class="kv-title">Nom</div>
                <div class="kv-value"><?= esc($personal['nom']) ?></div>
            </div>
            <div>
                <div class="kv-title">Email</div>
                <div class="kv-value"><?= esc($personal['email']) ?></div>
            </div>
            <div>
                <div class="kv-title">Genre</div>
                <div class="kv-value"><?= esc($personal['genre']) ?></div>
            </div>
            <div>
                <div class="kv-title">Date de naissance</div>
                <div class="kv-value"><?= esc($personal['date_naissance']) ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="<?= site_url('/register/health') ?>" method="post" class="stack">
            <?= csrf_field() ?>
            <div class="grid">
                <div>
                    <label for="taille_cm">Taille (cm)</label>
                    <input type="number" step="0.01" min="1" id="taille_cm" name="taille_cm" value="<?= esc(old('taille_cm')) ?>" required>
                </div>
                <div>
                    <label for="poids_kg">Poids actuel (kg)</label>
                    <input type="number" step="0.01" min="1" id="poids_kg" name="poids_kg" value="<?= esc(old('poids_kg')) ?>" required>
                </div>
            </div>

            <div class="grid">
                <div>
                    <label for="poids_objectif">Poids objectif (kg)</label>
                    <input type="number" step="0.01" min="1" id="poids_objectif" name="poids_objectif" value="<?= esc(old('poids_objectif')) ?>" required>
                </div>
                <div>
                    <label for="id_objectif">Objectif</label>
                    <select id="id_objectif" name="id_objectif" required>
                        <option value="">-- Choisir un objectif --</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= esc($objectif['id_objectif']) ?>" <?= old('id_objectif') == $objectif['id_objectif'] ? 'selected' : '' ?>>
                                <?= esc($objectif['label_objectif']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Terminer l'inscription</button>
                <a href="<?= site_url('/register') ?>" class="btn btn-secondary">Retour étape 1</a>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
