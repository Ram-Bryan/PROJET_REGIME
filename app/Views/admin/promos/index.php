<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Gestion des codes promo<?= $this->endSection() ?>
<?= $this->section('head') ?>
    <style>
        .filters-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .filter-pair {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .radio-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding-top: 6px;
        }

        .radio-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--surface-soft);
            font-size: 14px;
            font-weight: 700;
        }

        .radio-chip input {
            margin: 0;
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

        .icon-action img {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 920px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Codes promo<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Gardez la liste des codes claire, filtrez rapidement leur etat et laissez la consommation se faire via la validation admin.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/promos/validate') ?>" class="btn btn-secondary">Demandes a valider</a>
    <a href="<?= base_url('admin/promos/create') ?>" class="btn btn-primary">Nouveau code</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <h3 class="section-title">Filtres</h3>
        <p class="section-subtitle">Affinez la liste par montant et etat d'utilisation.</p>

        <form method="get" action="<?= base_url('admin/promos') ?>" class="stack">
            <div class="filters-grid">
                <div class="field">
                    <label>Montant (Ar)</label>
                    <div class="filter-pair">
                        <input type="number" step="0.01" name="montant_min" value="<?= esc($filters['montant_min'] ?? '') ?>" placeholder="Min">
                        <input type="number" step="0.01" name="montant_max" value="<?= esc($filters['montant_max'] ?? '') ?>" placeholder="Max">
                    </div>
                </div>
                <div class="field" style="grid-column: span 2;">
                    <label>Etat</label>
                    <div class="radio-row">
                        <?php $etat = $filters['etat'] ?? 'tous'; ?>
                        <label class="radio-chip">
                            <input type="radio" name="etat" value="tous" <?= $etat === 'tous' ? 'checked' : '' ?>>
                            Tout
                        </label>
                        <label class="radio-chip">
                            <input type="radio" name="etat" value="disponible" <?= $etat === 'disponible' ? 'checked' : '' ?>>
                            Disponible
                        </label>
                        <label class="radio-chip">
                            <input type="radio" name="etat" value="utilise" <?= $etat === 'utilise' ? 'checked' : '' ?>>
                            Utilise
                        </label>
                    </div>
                </div>
            </div>

            <div class="actions-inline" style="justify-content:flex-start;">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="<?= base_url('admin/promos') ?>" class="btn btn-secondary">Reinitialiser</a>
            </div>
        </form>
    </div>

    <div class="card">
        <h3 class="section-title">Liste des codes promo</h3>
        <p class="section-subtitle"><?= count($promos ?? []) ?> resultat(s).</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Utilise par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($promos)): ?>
                        <?php foreach ($promos as $promo): ?>
                            <tr>
                                <td><span class="code-pill"><?= esc($promo['code']) ?></span></td>
                                <td><?= esc(number_format((float) $promo['montant'], 2, ',', ' ')) ?> Ar</td>
                                <td>
                                    <?php if ((int) ($promo['deja_utilise'] ?? 0) === 1): ?>
                                        <span class="badge warn">Utilise</span>
                                    <?php else: ?>
                                        <span class="badge success">Disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc((string) ($promo['utilisateur_nom'] ?? '')) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('admin/promos/edit/' . $promo['id_code']) ?>" class="btn btn-secondary btn-icon icon-action" title="Modifier le code promo">
                                            <img src="<?= esc(base_url('assets/icons/pencil.svg')) ?>" alt="Modifier">
                                        </a>
                                        <form action="<?= base_url('admin/promos/delete/' . $promo['id_code']) ?>" method="post" onsubmit="return confirm('Supprimer ce code promo ?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-icon icon-action" title="Supprimer le code promo">
                                                <img src="<?= esc(base_url('assets/icons/trash-2.svg')) ?>" alt="Supprimer">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Aucun code promo ne correspond aux filtres actuels.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>
