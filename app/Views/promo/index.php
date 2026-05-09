<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code promo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
        }

        .card {
            max-width: 520px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <h1>Ajouter un code promo</h1>

    <p>Votre solde actuel : <strong><?= esc((string) $argent) ?> Ar</strong></p>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <div class="card">
        <form method="POST" action="<?= site_url('/promo') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="code_promo">Code promo</label><br>
                <input type="text" id="code_promo" name="code_promo" value="<?= esc(old('code_promo')) ?>" required>
            </div>

            <button type="submit">Valider le code</button>
        </form>
    </div>

    <p style="margin-top: 16px;">
        <a href="<?= site_url('/dashboard') ?>">Retour au dashboard</a>
    </p>
</body>
</html>
