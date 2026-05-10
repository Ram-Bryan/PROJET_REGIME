<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Admin regimes<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Regime library<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Review the regime catalog with decision-focused columns and keep the filters centered on variation, durations, and pricing.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/regimes/create') ?>" class="btn btn-primary">
        <img class="icon" src="<?= esc(base_url('assets/icons/plus.svg')) ?>" alt="">
        <span>New regime</span>
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <h3 class="section-title">Filters</h3>
        <p class="section-subtitle">Keep the result list focused without exposing raw database fields.</p>

        <form method="get" action="<?= base_url('admin/regimes') ?>" class="stack">
            <div class="grid-4">
                <div class="field">
                    <label for="nom_regime">Regime name</label>
                    <input id="nom_regime" type="text" name="nom_regime" value="<?= esc($filters['nom_regime'] ?? '') ?>" placeholder="Search by name">
                </div>
                <div class="field">
                    <label for="variation_min">Variation min</label>
                    <input id="variation_min" type="number" step="0.01" name="variation_min" value="<?= esc($filters['variation_min'] ?? '') ?>" placeholder="-3">
                </div>
                <div class="field">
                    <label for="variation_max">Variation max</label>
                    <input id="variation_max" type="number" step="0.01" name="variation_max" value="<?= esc($filters['variation_max'] ?? '') ?>" placeholder="4">
                </div>
                <div class="field">
                    <label for="duree_min">Min days</label>
                    <input id="duree_min" type="number" name="duree_min" value="<?= esc($filters['duree_min'] ?? '') ?>" placeholder="30">
                </div>
                <div class="field">
                    <label for="duree_max">Max days</label>
                    <input id="duree_max" type="number" name="duree_max" value="<?= esc($filters['duree_max'] ?? '') ?>" placeholder="90">
                </div>
                <div class="field">
                    <label for="prix_min">Min price</label>
                    <input id="prix_min" type="number" step="0.01" name="prix_min" value="<?= esc($filters['prix_min'] ?? '') ?>" placeholder="50000">
                </div>
                <div class="field">
                    <label for="prix_max">Max price</label>
                    <input id="prix_max" type="number" step="0.01" name="prix_max" value="<?= esc($filters['prix_max'] ?? '') ?>" placeholder="120000">
                </div>
                <div class="field">
                    <label>&nbsp;</label>
                    <div class="actions-inline" style="justify-content:start;">
                        <button type="submit" class="btn btn-primary">Apply</button>
                        <a href="<?= base_url('admin/regimes') ?>" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:end; gap:16px; flex-wrap:wrap; margin-bottom:18px;">
            <div>
                <h3 class="section-title" style="margin-bottom:4px;">Regimes</h3>
                <p class="section-subtitle" style="margin-bottom:0;"><?= count($regimes ?? []) ?> result(s)</p>
            </div>
            <span class="badge">Decision view only</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nom du regime</th>
                        <th>Variation mensuelle</th>
                        <th>Composition</th>
                        <th>Nb d'activites liees</th>
                        <th>Nb de durees disponibles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($regimes)): ?>
                        <?php foreach ($regimes as $regime): ?>
                            <?php $variation = (float) ($regime['variation_mensuelle_kg'] ?? 0); ?>
                            <tr>
                                <td>
                                    <strong><?= esc($regime['nom_regime']) ?></strong>
                                </td>
                                <td>
                                    <span class="badge <?= $variation < 0 ? 'warn' : '' ?>">
                                        <?= $variation > 0 ? '+' : '' ?><?= esc(number_format($variation, 2, ',', ' ')) ?> kg / mois
                                    </span>
                                </td>
                                <td>
                                    <?= esc((string) $regime['pourcentage_viande']) ?>% viande /
                                    <?= esc((string) $regime['pourcentage_poisson']) ?>% poisson /
                                    <?= esc((string) $regime['pourcentage_volaille']) ?>% volaille
                                </td>
                                <td><?= esc((string) ($regime['nb_activites'] ?? 0)) ?></td>
                                <td><?= esc((string) ($regime['nb_durees'] ?? 0)) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('admin/regimes/view/' . $regime['id_regime']) ?>" class="btn btn-secondary btn-small">View</a>
                                        <a href="<?= base_url('admin/regimes/edit/' . $regime['id_regime']) ?>" class="btn btn-secondary btn-small">Edit</a>
                                        <form action="<?= base_url('admin/regimes/delete/' . $regime['id_regime']) ?>" method="post" onsubmit="return confirm('Delete this regime?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No regime matches the current filters.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>
