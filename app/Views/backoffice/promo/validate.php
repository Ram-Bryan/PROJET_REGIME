<?= $this->extend('backoffice/layout') ?>

<?php
    $stats = $stats ?? ['en_attente' => 0, 'codes_existants' => 0, 'codes_inexistants' => 0];
?>

<?= $this->section('title') ?>Validation code promo<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Validation code promo<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Traitez ici uniquement les demandes en attente envoyees depuis le frontoffice. Le badge vous indique tout de suite si le code existe deja dans votre liste de promos.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/promos') ?>" class="btn btn-secondary">Retour aux promos</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <h3 class="section-title">Demandes en attente</h3>
        <p class="section-subtitle">Acceptez pour crediter le client si le code est valable, ou refusez la demande si le code ne correspond pas.</p>

        <div class="request-metrics">
            <div class="request-metric">
                <p class="request-metric-label">Demandes</p>
                <p class="request-metric-value"><?= esc((string) ($stats['en_attente'] ?? 0)) ?></p>
            </div>
            <div class="request-metric">
                <p class="request-metric-label">Codes existants</p>
                <p class="request-metric-value"><?= esc((string) ($stats['codes_existants'] ?? 0)) ?></p>
            </div>
            <div class="request-metric">
                <p class="request-metric-label">Codes inexistants</p>
                <p class="request-metric-value"><?= esc((string) ($stats['codes_inexistants'] ?? 0)) ?></p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Code saisi</th>
                        <th>Montant</th>
                        <th>Etat du code</th>
                        <th>Demande</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($demandes)): ?>
                        <?php foreach ($demandes as $demande): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($demande['utilisateur_nom'] ?? 'Utilisateur inconnu') ?></strong>
                                    <div class="request-meta"><?= esc($demande['utilisateur_email'] ?? '') ?></div>
                                </td>
                                <td><span class="code-pill"><?= esc($demande['code_saisi'] ?? '') ?></span></td>
                                <td>
                                    <?php if (! empty($demande['promo_match'])): ?>
                                        <?= esc(number_format((float) ($demande['promo_match']['montant'] ?? 0), 2, ',', ' ')) ?> Ar
                                    <?php else: ?>
                                        <span class="request-meta">Aucun montant connu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (! empty($demande['code_existe'])): ?>
                                        <span class="badge success">Code existe</span>
                                    <?php else: ?>
                                        <span class="badge warn">Code inexistant</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="request-meta">
                                        Envoyee le <?= esc((string) ($demande['date_demande'] ?? '')) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <?php if (! empty($demande['code_existe'])): ?>
                                            <form action="<?= base_url('admin/promos/validate/approve/' . $demande['id_demande_code_promo']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-primary btn-icon" title="Accepter la demande">
                                                    <img src="<?= esc(base_url('assets/icons/check.svg')) ?>" alt="Accepter">
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?= base_url('admin/promos/validate/reject/' . $demande['id_demande_code_promo']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-icon" title="Refuser la demande">
                                                <img src="<?= esc(base_url('assets/icons/x.svg')) ?>" alt="Refuser">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucune demande en attente pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>
