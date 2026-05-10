<?= $this->extend('admin/layout') ?>

<?php
    $stats = $stats ?? ['en_attente' => 0, 'codes_existants' => 0, 'codes_inexistants' => 0];
?>

<?= $this->section('title') ?>Validation code promo<?= $this->endSection() ?>
<?= $this->section('head') ?>
    <style>
        .request-metrics {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 18px;
        }

        .request-metric {
            padding: 18px;
            border-radius: 18px;
            background: var(--surface-soft);
            border: 1px solid var(--line);
        }

        .request-metric p {
            margin: 0;
        }

        .request-metric-label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .request-metric-value {
            margin-top: 10px;
            font-size: 28px;
            font-weight: 800;
        }

        .code-pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 12px;
            border-radius: 999px;
            background: #eef2f6;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .request-meta {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        @media (max-width: 920px) {
            .request-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?= $this->endSection() ?>
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
