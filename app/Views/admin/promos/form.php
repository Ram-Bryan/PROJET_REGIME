<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Code promo') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc, #eef2f7); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .wrap { max-width: 760px; margin: 40px auto; padding: 0 20px; }
        .shell { background: white; border-radius: 18px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1); overflow: hidden; }
        .head { padding: 24px 28px; background: linear-gradient(135deg, #5d4037, #8d6e63); color: white; }
        .body { padding: 28px; }
        .form-label { font-weight: 600; color: #2c3e50; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="shell">
            <div class="head">
                <h1 class="h3 mb-1"><?= esc($title ?? 'Code promo') ?></h1>
                <p class="mb-0">Créez ou modifiez un code promo.</p>
            </div>
            <div class="body">
                <?php if (!empty($validation)): ?>
                    <div class="alert alert-danger"><?= esc($validation->listErrors()) ?></div>
                <?php endif; ?>
                <form action="<?= esc($action) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control text-uppercase" value="<?= esc(old('code', $promo['code'] ?? '')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant</label>
                        <input type="number" step="0.01" name="montant" class="form-control" value="<?= esc(old('montant', $promo['montant'] ?? '')) ?>" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="deja_utilise" name="deja_utilise" <?= !empty($promo['deja_utilise']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="deja_utilise">Déjà utilisé</label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="<?= base_url('admin/promos') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
