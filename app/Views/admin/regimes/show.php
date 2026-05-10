<?= $this->extend('admin/layout') ?>

<?php $variation = (float) ($regime['variation_mensuelle_kg'] ?? 0); ?>

<?= $this->section('title') ?>Regime detail<?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= esc($regime['nom_regime'] ?? 'Regime detail') ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Read-only detail view with nutrition mix, projected weight effect, linked sports, and duration offers.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/regimes') ?>" class="btn btn-secondary">Back to list</a>
    <a href="<?= base_url('admin/regimes/edit/' . $regime['id_regime']) ?>" class="btn btn-primary">Edit regime</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="grid-4">
        <div class="metric">
            <p class="metric-label">Variation mensuelle</p>
            <p class="metric-value"><?= $variation > 0 ? '+' : '' ?><?= esc(number_format($variation, 2, ',', ' ')) ?> kg</p>
            <p class="metric-note">Reference label: kg / mois</p>
        </div>
        <div class="metric">
            <p class="metric-label">Activites liees</p>
            <p class="metric-value"><?= esc((string) count($regime['activities'] ?? [])) ?></p>
            <p class="metric-note">Sports assigned to this regime</p>
        </div>
        <div class="metric">
            <p class="metric-label">Durees disponibles</p>
            <p class="metric-value"><?= esc((string) count($regime['durations'] ?? [])) ?></p>
            <p class="metric-note">Commercial offers configured</p>
        </div>
        <div class="metric">
            <p class="metric-label">Composition total</p>
            <p class="metric-value">
                <?= esc((string) ((float) $regime['pourcentage_viande'] + (float) $regime['pourcentage_poisson'] + (float) $regime['pourcentage_volaille'])) ?>%
            </p>
            <p class="metric-note">Expected total: 100%</p>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Nutrition</h3>
        <p class="section-subtitle">Structured composition view for quick review.</p>
        <div class="grid-3">
            <div class="metric">
                <p class="metric-label">Viande</p>
                <p class="metric-value"><?= esc((string) $regime['pourcentage_viande']) ?>%</p>
            </div>
            <div class="metric">
                <p class="metric-label">Poisson</p>
                <p class="metric-value"><?= esc((string) $regime['pourcentage_poisson']) ?>%</p>
            </div>
            <div class="metric">
                <p class="metric-label">Volaille</p>
                <p class="metric-value"><?= esc((string) $regime['pourcentage_volaille']) ?>%</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Effet sur le poids</h3>
        <p class="section-subtitle">Linear estimate based on the declared monthly variation.</p>
        <div class="grid-3">
            <?php foreach ($estimates as $estimate): ?>
                <div class="metric">
                    <p class="metric-label"><?= esc((string) $estimate['days']) ?> jours</p>
                    <p class="metric-value"><?= $estimate['value'] > 0 ? '+' : '' ?><?= esc(number_format((float) $estimate['value'], 2, ',', ' ')) ?> kg</p>
                    <p class="metric-note">Projection only</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Activites associees</h3>
        <p class="section-subtitle">Linked sports shown in a light read-only format.</p>

        <?php if (! empty($regime['activities'])): ?>
            <div class="list-inline">
                <?php foreach ($regime['activities'] as $activity): ?>
                    <span class="pill">
                        <?= esc($activity['label_activite']) ?> - <?= esc((string) $activity['nb_par_semaine']) ?>/semaine
                    </span>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="hint">No sport is linked to this regime yet.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3 class="section-title">Durees disponibles</h3>
        <p class="section-subtitle">Commercial duration grid for the backoffice review.</p>

        <?php if (! empty($regime['durations'])): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nb jours</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($regime['durations'] as $duration): ?>
                            <tr>
                                <td><?= esc((string) $duration['nb_jours']) ?> jours</td>
                                <td><?= esc(number_format((float) $duration['prix'], 0, ',', ' ')) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="hint">No duration-price row is configured yet.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3 class="section-title">Suggested users</h3>
        <p class="section-subtitle">Simple inferred hints based on the current variation value.</p>
        <ul class="error-list" style="color:var(--text);">
            <?php foreach ($suggestedUsers as $suggestion): ?>
                <li><?= esc($suggestion) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?= $this->endSection() ?>
