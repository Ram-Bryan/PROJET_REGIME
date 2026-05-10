<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Modifier mon profil<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $validationErrors = session()->getFlashdata('errors') ?? []; ?>
<section class="stack" style="max-width:980px; margin: 0 auto;">
    <div class="hero">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1>Modifier mon profil</h1>
            <p class="sub">Mettez à jour vos informations en toute sécurité avec un parcours clair et sans friction.</p>
        </div>
        <div class="hero-actions" style="position:relative; z-index:1;">
            <a href="<?= site_url('/profile') ?>" class="btn btn-secondary">Retour au profil</a>
            <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>

    <form method="POST" action="<?= site_url('/profile/update') ?>" class="stack">
        <?= csrf_field() ?>

        <div class="card stack">
            <div class="section-title">
                <div>
                    <h2>Informations personnelles</h2>
                    <p class="sub">Les champs de base de votre identité.</p>
                </div>
            </div>
            <div>
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" minlength="2" maxlength="80" autocomplete="name" value="<?= old('nom', esc($user['nom'])) ?>" required>
                <?php if (isset($validationErrors['nom'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['nom']) ?></div><?php endif; ?>
            </div>
            <div class="grid">
                <div>
                    <label for="genre">Genre *</label>
                    <select id="genre" name="genre" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Homme" <?= old('genre', $user['genre']) === 'Homme' ? 'selected' : '' ?>>Homme</option>
                        <option value="Femme" <?= old('genre', $user['genre']) === 'Femme' ? 'selected' : '' ?>>Femme</option>
                    </select>
                    <?php if (isset($validationErrors['genre'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['genre']) ?></div><?php endif; ?>
                </div>
                <div>
                    <label for="date_naissance">Date de naissance *</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= old('date_naissance', esc($user['date_naissance'])) ?>" required>
                    <?php if (isset($validationErrors['date_naissance'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['date_naissance']) ?></div><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card stack">
            <div class="section-title">
                <div>
                    <h2>Informations santé</h2>
                    <p class="sub">Votre base pour les recommandations et le calcul d’IMC.</p>
                </div>
            </div>
            <div class="grid">
                <div>
                    <label for="taille_cm">Taille (cm) *</label>
                    <input type="number" step="0.01" min="50" max="260" id="taille_cm" name="taille_cm" value="<?= old('taille_cm', esc($user['taille_cm'])) ?>" required>
                    <?php if (isset($validationErrors['taille_cm'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['taille_cm']) ?></div><?php endif; ?>
                </div>
                <div>
                    <label for="poids_kg">Poids actuel (kg) *</label>
                    <input type="number" step="0.01" min="20" max="350" id="poids_kg" name="poids_kg" value="<?= old('poids_kg', esc($user['poids_kg'])) ?>" required>
                    <?php if (isset($validationErrors['poids_kg'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['poids_kg']) ?></div><?php endif; ?>
                </div>
            </div>
            <div class="grid">
                <div>
                    <label for="poids_objectif">Poids objectif (kg) *</label>
                    <input type="number" step="0.01" min="20" max="350" id="poids_objectif" name="poids_objectif" value="<?= old('poids_objectif', esc($user['poids_objectif'] ?? '')) ?>" required>
                    <?php if (isset($validationErrors['poids_objectif'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['poids_objectif']) ?></div><?php endif; ?>
                </div>
                <div>
                    <label for="id_objectif">Objectif *</label>
                    <select id="id_objectif" name="id_objectif" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_objectif'] ?>" <?= old('id_objectif', (string) $user['id_objectif']) === (string) $objectif['id_objectif'] ? 'selected' : '' ?>>
                                <?= esc($objectif['label_objectif']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validationErrors['id_objectif'])): ?><div class="sub" style="color:#b42318;"><?= esc($validationErrors['id_objectif']) ?></div><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card stack">
            <div class="section-title">
                <div>
                    <h2>Vérification identité</h2>
                    <p class="sub">Confirmez vos modifications avec votre mot de passe.</p>
                </div>
            </div>
            <div>
                <label for="current_password">Mot de passe actuel *</label>
                <input type="password" id="current_password" name="current_password" required>
                <p class="sub">Requis pour confirmer les modifications.</p>
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn">Enregistrer</button>
            <a href="<?= site_url('/profile') ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
