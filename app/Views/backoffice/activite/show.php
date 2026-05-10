<?= $this->extend('backoffice/layout') ?>

<?= $this->section('title') ?>Detail de l'activite<?= $this->endSection() ?>

<?= $this->section('page_title') ?><?= esc($activite['label_activite'] ?? 'Detail de l activite') ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Lecture seule de l'activite et des regimes qui l'utilisent deja.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/activites') ?>" class="btn btn-secondary">Retour a la liste</a>
    <a href="<?= base_url('admin/activites/edit/' . $activite['id_activite']) ?>" class="btn btn-primary">Modifier</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="activity-detail-hero">
        <h3><?= esc($activite['label_activite']) ?></h3>
        <p>Frequence recommandee: <?= esc((string) $activite['nb_par_semaine']) ?> fois par semaine.</p>
    </div>

    <div class="grid-2">
        <div class="metric">
            <p class="metric-label">Frequence hebdomadaire</p>
            <p class="metric-value"><?= esc((string) $activite['nb_par_semaine']) ?></p>
            <p class="metric-note">Nombre de seances conseillees par semaine</p>
        </div>
        <div class="metric">
            <p class="metric-label">Regimes lies</p>
            <p class="metric-value"><?= esc((string) count($linkedRegimes ?? [])) ?></p>
            <p class="metric-note">Nombre de regimes qui utilisent cette activite</p>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Regimes associes</h3>
        <p class="section-subtitle">Chaque regime ci-dessous renvoie vers son detail admin.</p>

        <?php if (! empty($linkedRegimes)): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Regime</th>
                            <th>Variation mensuelle</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($linkedRegimes as $regime): ?>
                            <?php
                                $variation = $regime['variation_mensuelle_kg'] ?? $regime['variation_poids'] ?? 0;
                                $variation = (float) $variation;
                            ?>
                            <tr>
                                <td>
                                    <a class="regime-link" href="<?= base_url('admin/regimes/view/' . $regime['id_regime']) ?>">
                                        <?= esc($regime['nom_regime']) ?>
                                    </a>
                                </td>
                                <td><?= $variation > 0 ? '+' : '' ?><?= esc(number_format($variation, 2, ',', ' ')) ?> kg / mois</td>
                                <td>
                                    <a href="<?= base_url('admin/regimes/view/' . $regime['id_regime']) ?>" class="btn btn-secondary btn-small">Voir le regime</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="hint">Aucun regime n'utilise encore cette activite.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
