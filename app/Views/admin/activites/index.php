<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Activités Sportives</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-wrap { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .header-card {
            background: linear-gradient(135deg, #1f3b4d, #2f6f88);
            color: white; border-radius: 16px; padding: 28px; margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(31, 59, 77, 0.18);
        }
        .panel { background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); overflow: hidden; margin-bottom: 24px; }
        .panel-header { padding: 18px 22px; border-bottom: 1px solid #edf1f5; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
        .table thead th { background: #f8fafc; color: #2c3e50; border-bottom: 1px solid #e9eef3; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-box { background: #f8fafc; border: 1px solid #edf1f5; border-radius: 14px; padding: 16px; margin: 0 22px 18px; }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="header-card">
            <h1><i class="fas fa-running"></i> Gestion des activités sportives</h1>
            <p class="mb-0">Créer, modifier et supprimer les activités, puis les affecter à un régime sélectionné.</p>
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
                    <h2 class="h5 mb-1">Liste des activités</h2>
                    <div class="text-muted">Total: <?= count($activites ?? []) ?></div>
                </div>
                <a href="<?= base_url('admin/activites/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle activité</a>
            </div>

            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Libellé</th>
                            <th>Par semaine</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($activites)): ?>
                            <?php foreach ($activites as $activite): ?>
                                <tr>
                                    <td><?= esc($activite['id_activite']) ?></td>
                                    <td><strong><?= esc($activite['label_activite']) ?></strong></td>
                                    <td><?= esc($activite['nb_par_semaine']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('admin/activites/edit/' . $activite['id_activite']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i></a>
                                            <form action="<?= base_url('admin/activites/delete/' . $activite['id_activite']) ?>" method="post" onsubmit="return confirm('Supprimer cette activité ?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Aucune activité trouvée.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1">Affecter une activité à un régime</h2>
                    <div class="text-muted">Sélectionnez un régime puis une activité à lier.</div>
                </div>
            </div>
            <div class="filter-box">
                <form id="regimeActivityForm" method="post" action="#" class="row g-3 align-items-end">
                    <?= csrf_field() ?>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Régime</label>
                        <select id="regimeSelect" class="form-select" required>
                            <option value="">Choisir un régime</option>
                            <?php foreach ($regimes ?? [] as $regime): ?>
                                <option value="<?= esc($regime['id_regime']) ?>"><?= esc($regime['nom_regime']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Activité</label>
                        <select name="id_activite" class="form-select" required>
                            <option value="">Choisir une activité</option>
                            <?php foreach ($activites ?? [] as $activite): ?>
                                <option value="<?= esc($activite['id_activite']) ?>"><?= esc($activite['label_activite']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <button type="submit" class="btn btn-primary w-100">Ajouter au régime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('regimeActivityForm');
        const regimeSelect = document.getElementById('regimeSelect');

        form?.addEventListener('submit', function(event) {
            const regimeId = regimeSelect?.value;
            if (!regimeId) {
                event.preventDefault();
                alert('Choisissez un régime avant d’ajouter une activité.');
                return;
            }
            form.action = '<?= base_url('admin/regimes') ?>/' + regimeId + '/activites';
        });
    </script>
</body>
</html>
