<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Code promo') ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= esc($title ?? 'Code promo') ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Creez ou modifiez un code promo en gardant le meme layout admin.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/promos') ?>" class="btn btn-secondary">Retour aux promos</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card" style="max-width:760px;">
        <?php if (! empty($validation)): ?>
            <div class="flash error" style="margin-bottom:18px;"><?= esc($validation->listErrors()) ?></div>
        <?php endif; ?>

        <form action="<?= esc($action) ?>" method="post" class="stack">
            <?= csrf_field() ?>
            <div class="field">
                <label for="code">Code</label>
                <input id="code" type="text" name="code" value="<?= esc(old('code', $promo['code'] ?? '')) ?>" required>
            </div>
            <div class="field">
                <label for="montant">Montant</label>
                <input id="montant" type="number" step="0.01" name="montant" value="<?= esc(old('montant', $promo['montant'] ?? '')) ?>" required>
            </div>
            <label class="pill" style="display:inline-flex; align-items:center; gap:10px; width:max-content;">
                <input type="checkbox" value="1" name="deja_utilise" <?= ! empty($promo['deja_utilise']) ? 'checked' : '' ?>>
                Deja utilise
            </label>
            <div class="actions-inline" style="justify-content:flex-end;">
                <a href="<?= base_url('admin/promos') ?>" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>
