<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
</head>
<body>
<div class="container">
    <div class="row my-4">
        <div class="col-md-8 mx-auto">
            <h1>Mon Profil</h1>

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

            <!-- Section Informations Personnelles -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Nom</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['nom']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['email']) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Genre</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['genre']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Date de Naissance</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['date_naissance']) ?></p>
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
                            <label class="form-label"><strong>Taille (cm)</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['taille_cm']) ?> cm</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Poids Actuel (kg)</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['poids_kg']) ?> kg</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Poids Objectif (kg)</strong></label>
                            <p class="form-control-plaintext"><?= esc($user['poids_objectif']) ?> kg</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>IMC Actuel</strong></label>
                            <p class="form-control-plaintext">
                                <?php if ($imc !== null): ?>
                                    <strong><?= number_format($imc, 2, ',', ' ') ?></strong>
                                <?php else: ?>
                                    Non calculable
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Objectif</strong></label>
                            <p class="form-control-plaintext">
                                <?php if ($objectif !== null): ?>
                                    <?= esc($objectif['label_objectif']) ?>
                                <?php else: ?>
                                    Non défini
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Status Gold</strong></label>
                            <p class="form-control-plaintext">
                                <?= $user['is_gold'] ? '<span class="badge bg-warning">Gold ✓</span>' : '<span class="badge bg-secondary">Standard</span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Actions -->
            <div class="d-flex gap-2">
                <a href="<?= site_url('/profile/edit') ?>" class="btn btn-primary">Modifier le profil</a>
                <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Retour au tableau de bord</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
