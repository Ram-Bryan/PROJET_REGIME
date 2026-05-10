<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Codes Promo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .page-wrap { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .header-card { background: linear-gradient(135deg, #5d4037, #8d6e63); color: white; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(93, 64, 55, 0.18); }
        .panel { background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); overflow: hidden; }
        .panel-header { padding: 18px 22px; border-bottom: 1px solid #edf1f5; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
        .table thead th { background: #f8fafc; color: #2c3e50; border-bottom: 1px solid #e9eef3; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .status-used { background: #fdecea; color: #b23b2a; font-weight: 600; }
        .status-free { background: #e8f8ef; color: #1e7e34; font-weight: 600; }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="header-card">
            <h1><i class="fas fa-ticket-alt"></i> Gestion des codes promo</h1>
            <p class="mb-0">Créer, modifier, supprimer et valider les codes promo.</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="panel mb-3">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1">Liste des codes promo</h2>
                    <div class="text-muted">Total: <?= count($promos ?? []) ?></div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/promos/validate') ?>" class="btn btn-outline-secondary"><i class="fas fa-check-circle"></i> Valider un code</a>
                    <a href="<?= base_url('admin/promos/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Nouveau code</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Montant</th>
                            <th>État</th>
                            <th>Utilisateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($promos)): ?>
                            <?php foreach ($promos as $promo): ?>
                                <tr>
                                    <td><?= esc($promo['id_code']) ?></td>
                                    <td><strong><?= esc($promo['code']) ?></strong></td>
                                    <td><?= esc(number_format((float) $promo['montant'], 2, ',', ' ')) ?></td>
                                    <td>
                                        <?php if ((int) ($promo['deja_utilise'] ?? 0) === 1): ?>
                                            <span class="badge status-used">Utilisé</span>
                                        <?php else: ?>
                                            <span class="badge status-free">Disponible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($promo['id_utilisateur_utilisation'] ?? '-') ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('admin/promos/edit/' . $promo['id_code']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i></a>
                                            <form action="<?= base_url('admin/promos/delete/' . $promo['id_code']) ?>" method="post" onsubmit="return confirm('Supprimer ce code promo ?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Aucun code promo trouvé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
