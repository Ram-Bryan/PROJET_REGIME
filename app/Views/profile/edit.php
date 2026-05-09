<?php echo view('header'); ?>

<div class="container">
    <div class="row my-4">
        <div class="col-md-8 mx-auto">
            <h1>Modifier mon Profil</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= site_url('/profile/update') ?>" class="needs-validation">
                <?= csrf_field() ?>

                <!-- Section Informations Personnelles -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informations Personnelles</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= old('nom', esc($user['nom'])) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="genre" class="form-label">Genre *</label>
                                <select class="form-select" id="genre" name="genre" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Homme" <?= old('genre', $user['genre']) === 'Homme' ? 'selected' : '' ?>>Homme</option>
                                    <option value="Femme" <?= old('genre', $user['genre']) === 'Femme' ? 'selected' : '' ?>>Femme</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_naissance" class="form-label">Date de Naissance *</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= old('date_naissance', esc($user['date_naissance'])) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Santé -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informations Santé</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="taille_cm" class="form-label">Taille (cm) *</label>
                                <input type="number" step="0.01" class="form-control" id="taille_cm" name="taille_cm" value="<?= old('taille_cm', esc($user['taille_cm'])) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="poids_kg" class="form-label">Poids Actuel (kg) *</label>
                                <input type="number" step="0.01" class="form-control" id="poids_kg" name="poids_kg" value="<?= old('poids_kg', esc($user['poids_kg'])) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="poids_objectif" class="form-label">Poids Objectif (kg) *</label>
                                <input type="number" step="0.01" class="form-control" id="poids_objectif" name="poids_objectif" value="<?= old('poids_objectif', esc($user['poids_objectif'])) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_objectif" class="form-label">Objectif *</label>
                                <select class="form-select" id="id_objectif" name="id_objectif" required>
                                    <option value="">-- Sélectionner --</option>
                                    <?php foreach ($objectifs as $objectif): ?>
                                        <option value="<?= $objectif['id_objectif'] ?>" <?= old('id_objectif', (string) $user['id_objectif']) === (string) $objectif['id_objectif'] ? 'selected' : '' ?>>
                                            <?= esc($objectif['label_objectif']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Sécurité -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Vérification Identité</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel * (requis pour confirmer les modifications)</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <small class="form-text text-muted">Pour des raisons de sécurité, veuillez entrer votre mot de passe actuel.</small>
                        </div>
                    </div>
                </div>

                <!-- Section Actions -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="<?= site_url('/profile') ?>" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo view('footer'); ?>
