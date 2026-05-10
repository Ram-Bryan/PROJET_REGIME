<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Régime') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #f8fafc);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrap {
            max-width: 920px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card-shell {
            background: white;
            border-radius: 18px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1);
            overflow: hidden;
        }

        .card-head {
            padding: 24px 28px;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
        }

        .card-body {
            padding: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card-shell">
            <div class="card-head">
                <h1 class="h3 mb-1"><?= esc($title ?? 'Régime') ?></h1>
                <p class="mb-0">Remplissez les informations du régime ci-dessous.</p>
            </div>
            <div class="card-body">
                <?php if (!empty($validation)): ?>
                    <div class="alert alert-danger">
                        <?= esc($validation->listErrors()) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= esc($action) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Nom du régime</label>
                            <input type="text" name="nom_regime" class="form-control" value="<?= esc(old('nom_regime', $regime['nom_regime'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Variation du poids</label>
                            <input type="number" step="0.01" name="variation_poids" class="form-control" value="<?= esc(old('variation_poids', $regime['variation_poids'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pourcentage viande</label>
                            <input type="number" step="0.01" name="pourcentage_viande" class="form-control" value="<?= esc(old('pourcentage_viande', $regime['pourcentage_viande'] ?? 0)) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pourcentage poisson</label>
                            <input type="number" step="0.01" name="pourcentage_poisson" class="form-control" value="<?= esc(old('pourcentage_poisson', $regime['pourcentage_poisson'] ?? 0)) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pourcentage volaille</label>
                            <input type="number" step="0.01" name="pourcentage_volaille" class="form-control" value="<?= esc(old('pourcentage_volaille', $regime['pourcentage_volaille'] ?? 0)) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                        <a href="<?= base_url('admin/regimes') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
