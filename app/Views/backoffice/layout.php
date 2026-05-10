<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Administration régime' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/backoffice.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body class="backoffice-body">
<?= $this->include('backoffice/partials/sidebar') ?>

    <div class="admin-shell">

        <main class="bo-content">
            <div class="page-head">
                <div>
                    <h2><?= $this->renderSection('page_title') ?: 'Page admin' ?></h2>
                    <p><?= $this->renderSection('page_subtitle') ?></p>
                </div>
                <div class="actions-inline"><?= $this->renderSection('page_actions') ?></div>
            </div>

            <div class="flash-stack">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash error"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
            </div>

            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <div class="confirm-modal" id="confirm-modal" aria-hidden="true">
        <div class="confirm-card" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
            <div class="confirm-head">
                <img src="<?= esc(base_url('assets/icons/shield-alert.svg')) ?>" alt="">
                <strong id="confirm-title">Confirmation</strong>
            </div>
            <div class="confirm-body" id="confirm-message">Confirmer cette action ?</div>
            <div class="confirm-actions">
                <button type="button" class="btn btn-secondary" id="confirm-cancel">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirm-ok">Confirmer</button>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/global.js') ?>"></script>
    <script src="<?= base_url('assets/js/backoffice.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
