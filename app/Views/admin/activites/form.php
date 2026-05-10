<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Activite sportive') ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= esc($title ?? 'Activite sportive') ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Renseignez le libelle de l'activite et sa frequence hebdomadaire.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/activites') ?>" class="btn btn-secondary">Retour aux activites</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card" style="max-width:760px;">
        <?php if (! empty($validation)): ?>
            <div class="flash error" style="margin-bottom:18px;"><?= esc($validation->listErrors()) ?></div>
        <?php endif; ?>

        <form action="<?= esc($action) ?>" method="post" class="stack">
            <?= csrf_field() ?>
            <div class="field">
                <label for="label_activite">Libelle de l'activite</label>
                <input id="label_activite" type="text" name="label_activite" value="<?= esc(old('label_activite', $activite['label_activite'] ?? '')) ?>" required>
            </div>
            <div class="field">
                <label for="nb_par_semaine">Nombre de fois par semaine</label>
                <input id="nb_par_semaine" type="number" name="nb_par_semaine" min="1" value="<?= esc(old('nb_par_semaine', $activite['nb_par_semaine'] ?? '')) ?>" required>
            </div>
            <div class="actions-inline" style="justify-content:flex-end;">
                <a href="<?= base_url('admin/activites') ?>" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>
