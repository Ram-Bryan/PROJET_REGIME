<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Validation code promo<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Validation code promo<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Verifiez si un code promo est valide et encore disponible.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/promos') ?>" class="btn btn-secondary">Retour aux promos</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card" style="max-width:760px;">
        <?php if (! empty($validation)): ?>
            <div class="flash error" style="margin-bottom:18px;"><?= esc($validation->listErrors()) ?></div>
        <?php endif; ?>

        <form action="<?= base_url('admin/promos/validate') ?>" method="post" class="stack">
            <?= csrf_field() ?>
            <div class="field">
                <label for="code">Code promo</label>
                <input id="code" type="text" name="code" value="<?= esc(old('code')) ?>" required>
            </div>
            <div class="actions-inline" style="justify-content:flex-start;">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>

        <?php if (! empty($result)): ?>
            <div class="card" style="margin-top:18px; border-color: <?= ($result['status'] ?? '') === 'success' ? '#b5e3cb' : '#f1bbbb' ?>;">
                <h3 class="section-title"><?= esc($result['message'] ?? 'Resultat') ?></h3>
                <?php if (($result['status'] ?? '') === 'success'): ?>
                    <p class="section-subtitle" style="margin-bottom:10px;">Code: <?= esc($result['promo']['code'] ?? '') ?></p>
                    <strong><?= esc(number_format((float) ($result['promo']['montant'] ?? 0), 2, ',', ' ')) ?> Ar</strong>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
