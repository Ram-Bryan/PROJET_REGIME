<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Gestion des activites<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Activites sportives<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Creez, modifiez et liez les activites sportives aux regimes depuis le meme layout backoffice.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/activites/create') ?>" class="btn btn-primary">Nouvelle activite</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <h3 class="section-title">Liste des activites</h3>
        <p class="section-subtitle"><?= count($activites ?? []) ?> activite(s) enregistree(s).</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libelle</th>
                        <th>Frequence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($activites)): ?>
                        <?php foreach ($activites as $activite): ?>
                            <tr>
                                <td><?= esc((string) $activite['id_activite']) ?></td>
                                <td><strong><?= esc($activite['label_activite']) ?></strong></td>
                                <td><?= esc((string) $activite['nb_par_semaine']) ?> fois / semaine</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('admin/activites/edit/' . $activite['id_activite']) ?>" class="btn btn-secondary btn-small">Modifier</a>
                                        <form action="<?= base_url('admin/activites/delete/' . $activite['id_activite']) ?>" method="post" onsubmit="return confirm('Supprimer cette activite ?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-small">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucune activite sportive trouvee.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Lier une activite a un regime</h3>
        <p class="section-subtitle">Selectionnez un regime puis une activite a associer.</p>

        <form id="regimeActivityForm" method="post" action="#" class="grid-3">
            <?= csrf_field() ?>
            <div class="field">
                <label for="regimeSelect">Regime</label>
                <select id="regimeSelect" required>
                    <option value="">Choisir un regime</option>
                    <?php foreach ($regimes ?? [] as $regime): ?>
                        <option value="<?= esc($regime['id_regime']) ?>"><?= esc($regime['nom_regime']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="id_activite">Activite</label>
                <select id="id_activite" name="id_activite" required>
                    <option value="">Choisir une activite</option>
                    <?php foreach ($activites ?? [] as $activite): ?>
                        <option value="<?= esc($activite['id_activite']) ?>"><?= esc($activite['label_activite']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary" style="width:100%;">Ajouter au regime</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        (function () {
            const form = document.getElementById('regimeActivityForm');
            const regimeSelect = document.getElementById('regimeSelect');

            form?.addEventListener('submit', function (event) {
                const regimeId = regimeSelect?.value;
                if (!regimeId) {
                    event.preventDefault();
                    alert('Choisissez un regime avant d ajouter une activite.');
                    return;
                }

                form.action = '<?= base_url('admin/regimes') ?>/' + regimeId + '/activites';
            });
        }());
    </script>
<?= $this->endSection() ?>
