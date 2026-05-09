<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Régimes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-wrap {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-card {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(44, 62, 80, 0.18);
        }

        .header-card h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .panel {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .panel-header {
            padding: 18px 22px;
            border-bottom: 1px solid #edf1f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .table thead th {
            background: #f8fafc;
            color: #2c3e50;
            border-bottom: 1px solid #e9eef3;
        }

        .badge-soft {
            background: #e8f4fd;
            color: #2474a6;
            font-weight: 600;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-box {
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 14px;
            padding: 16px;
            margin: 0 22px 18px;
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="header-card">
            <h1><i class="fas fa-apple-alt"></i> Gestion des régimes</h1>
            <p class="mb-0">Créer, modifier, supprimer et consulter les régimes disponibles.</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1">Liste des régimes</h2>
                    <div class="text-muted">Résultats: <?= count($regimes ?? []) ?></div>
                </div>
                <a href="<?= base_url('admin/regimes/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau régime
                </a>
            </div>
            <div class="filter-box">
                <form method="get" action="<?= base_url('admin/regimes') ?>" class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom_regime" class="form-control" value="<?= esc($filters['nom_regime'] ?? '') ?>" placeholder="Rechercher un régime">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Variation poids min</label>
                        <input type="number" step="0.01" name="variation_min" class="form-control" value="<?= esc($filters['variation_min'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Variation poids max</label>
                        <input type="number" step="0.01" name="variation_max" class="form-control" value="<?= esc($filters['variation_max'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Durée min (jours)</label>
                        <input type="number" name="duree_min" class="form-control" value="<?= esc($filters['duree_min'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Durée max (jours)</label>
                        <input type="number" name="duree_max" class="form-control" value="<?= esc($filters['duree_max'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Prix min</label>
                        <input type="number" step="0.01" name="prix_min" class="form-control" value="<?= esc($filters['prix_min'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Prix max</label>
                        <input type="number" step="0.01" name="prix_max" class="form-control" value="<?= esc($filters['prix_max'] ?? '') ?>">
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <a href="<?= base_url('admin/regimes') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Variation poids</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Viande %</th>
                            <th>Poisson %</th>
                            <th>Volaille %</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($regimes)): ?>
                            <?php foreach ($regimes as $regime): ?>
                                <tr>
                                    <td><?= esc($regime['id_regime']) ?></td>
                                    <td>
                                        <strong><?= esc($regime['nom_regime']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft"><?= esc($regime['variation_poids']) ?></span>
                                    </td>
                                    <td><?= esc($regime['nb_jours'] ?? '-') ?></td>
                                    <td><?= esc(isset($regime['prix']) ? number_format((float) $regime['prix'], 2, ',', ' ') : '-') ?></td>
                                    <td><?= esc($regime['pourcentage_viande']) ?></td>
                                    <td><?= esc($regime['pourcentage_poisson']) ?></td>
                                    <td><?= esc($regime['pourcentage_volaille']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('admin/regimes/edit/' . $regime['id_regime']) ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="<?= base_url('admin/regimes/delete/' . $regime['id_regime']) ?>" method="post" onsubmit="return confirm('Supprimer ce régime ?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Aucun régime trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
