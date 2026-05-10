<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Étape 2<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:980px; margin: 0 auto; padding: 0; overflow:hidden;">
    <div style="display:grid; grid-template-columns: 0.95fr 1.05fr; min-height:100%;">
        <div style="padding:28px; background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(37, 99, 235, 0.9)); color:#fff; display:flex; flex-direction:column; justify-content:space-between; gap:24px;">
            <div>
                <div class="badge" style="background: rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.18);">Étape 2</div>
                <div class="page-header" style="margin-top:18px;">
                    <h1>Compléter votre santé</h1>
                    <p class="sub" style="color: rgba(255,255,255,0.84);">Nous utilisons ces données pour personnaliser vos régimes et votre suivi.</p>
                </div>
            </div>

            <div class="card" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.14); box-shadow:none; color:#fff;">
                <div class="metric-label" style="color: rgba(255,255,255,0.72);">Récapitulatif</div>
                <div class="stack" style="gap:10px; margin-top:12px;">
                    <div><strong>Nom :</strong> <?= esc($personal['nom']) ?></div>
                    <div><strong>Email :</strong> <?= esc($personal['email']) ?></div>
                    <div><strong>Genre :</strong> <?= esc($personal['genre']) ?></div>
                    <div><strong>Date de naissance :</strong> <?= esc($personal['date_naissance']) ?></div>
                </div>
            </div>
        </div>

        <div style="padding:28px;">
            <form action="<?= site_url('/register/health') ?>" method="post" class="stack" data-ajax-form="true">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>
                <div class="grid">
                    <div>
                        <label for="taille_cm">Taille (cm)</label>
                        <input type="number" step="0.01" min="50" max="260" id="taille_cm" name="taille_cm" value="<?= esc(old('taille_cm')) ?>" required>
                        <div class="field-error" data-field-error="taille_cm"></div>
                    </div>
                    <div>
                        <label for="poids_kg">Poids actuel (kg)</label>
                        <input type="number" step="0.01" min="20" max="350" id="poids_kg" name="poids_kg" value="<?= esc(old('poids_kg')) ?>" required>
                        <div class="field-error" data-field-error="poids_kg"></div>
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label for="poids_objectif">Poids objectif (kg)</label>
                        <input type="number" step="0.01" min="20" max="350" id="poids_objectif" name="poids_objectif" value="<?= esc(old('poids_objectif')) ?>" required>
                        <div class="field-error" data-field-error="poids_objectif"></div>
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
                            <div class="field-error" data-field-error="id_objectif"></div>
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Terminer l'inscription</button>
                    <a href="<?= site_url('/register') ?>" class="btn btn-secondary">Retour étape 1</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
