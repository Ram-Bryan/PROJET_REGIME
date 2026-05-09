<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Activité sportive') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #eef3f7, #f8fafc); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .wrap { max-width: 760px; margin: 40px auto; padding: 0 20px; }
        .shell { background: white; border-radius: 18px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1); overflow: hidden; }
        .head { padding: 24px 28px; background: linear-gradient(135deg, #1f3b4d, #2f6f88); color: white; }
        .body { padding: 28px; }
        .form-label { font-weight: 600; color: #2c3e50; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="shell">
            <div class="head">
                <h1 class="h3 mb-1"><?= esc($title ?? 'Activité sportive') ?></h1>
                <p class="mb-0">Renseignez le libellé et la fréquence hebdomadaire.</p>
            </div>
            <div class="body">
                <?php if (!empty($validation)): ?>
                    <div class="alert alert-danger"><?= esc($validation->listErrors()) ?></div>
                <?php endif; ?>
                <form action="<?= esc($action) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Libellé de l’activité</label>
                        <input type="text" name="label_activite" class="form-control" value="<?= esc(old('label_activite', $activite['label_activite'] ?? '')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de fois par semaine</label>
                        <input type="number" name="nb_par_semaine" class="form-control" min="1" value="<?= esc(old('nb_par_semaine', $activite['nb_par_semaine'] ?? '')) ?>" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="<?= base_url('admin/activites') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
