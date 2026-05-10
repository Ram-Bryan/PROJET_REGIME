<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation Code Promo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc, #eef2f7); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .wrap { max-width: 720px; margin: 40px auto; padding: 0 20px; }
        .shell { background: white; border-radius: 18px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1); overflow: hidden; }
        .head { padding: 24px 28px; background: linear-gradient(135deg, #5d4037, #8d6e63); color: white; }
        .body { padding: 28px; }
        .result-box { border-radius: 14px; padding: 16px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="shell">
            <div class="head">
                <h1 class="h3 mb-1"><i class="fas fa-check-circle"></i> Validation code promo</h1>
                <p class="mb-0">Vérifiez si un code est valide et encore disponible.</p>
            </div>
            <div class="body">
                <?php if (!empty($validation)): ?>
                    <div class="alert alert-danger"><?= esc($validation->listErrors()) ?></div>
                <?php endif; ?>
                <form action="<?= base_url('admin/promos/validate') ?>" method="post" class="mb-4">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Code promo</label>
                        <input type="text" name="code" class="form-control text-uppercase" value="<?= esc(old('code')) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Valider</button>
                    <a href="<?= base_url('admin/promos') ?>" class="btn btn-outline-secondary ms-2">Retour</a>
                </form>

                <?php if (!empty($result)): ?>
                    <?php if (($result['status'] ?? '') === 'success'): ?>
                        <div class="alert alert-success result-box">
                            <strong><?= esc($result['message'] ?? 'Code valide.') ?></strong><br>
                            Code: <?= esc($result['promo']['code'] ?? '') ?><br>
                            Montant: <?= esc(number_format((float) ($result['promo']['montant'] ?? 0), 2, ',', ' ')) ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger result-box">
                            <strong><?= esc($result['message'] ?? 'Code invalide.') ?></strong>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
