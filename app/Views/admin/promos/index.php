<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Gestion des codes promo<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Codes promo<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Creez, modifiez et verifiez les codes promo dans le meme backoffice unifie.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/promos/validate') ?>" class="btn btn-secondary">Valider un code</a>
    <a href="<?= base_url('admin/promos/create') ?>" class="btn btn-primary">Nouveau code</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <h3 class="section-title">Liste des codes promo</h3>
        <p class="section-subtitle"><?= count($promos ?? []) ?> code(s) promo enregistres.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Utilisateur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($promos)): ?>
                        <?php foreach ($promos as $promo): ?>
                            <tr>
                                <td><?= esc((string) $promo['id_code']) ?></td>
                                <td><strong><?= esc($promo['code']) ?></strong></td>
                                <td><?= esc(number_format((float) $promo['montant'], 2, ',', ' ')) ?> Ar</td>
                                <td>
                                    <?php if ((int) ($promo['deja_utilise'] ?? 0) === 1): ?>
                                        <span class="badge warn">Utilise</span>
                                    <?php else: ?>
                                        <span class="badge success">Disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc((string) ($promo['id_utilisateur_utilisation'] ?? '-')) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('admin/promos/edit/' . $promo['id_code']) ?>" class="btn btn-secondary btn-small">Modifier</a>
                                        <form action="<?= base_url('admin/promos/delete/' . $promo['id_code']) ?>" method="post" onsubmit="return confirm('Supprimer ce code promo ?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-small">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucun code promo trouve.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>
