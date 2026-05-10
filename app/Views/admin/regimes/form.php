<?= $this->extend('admin/layout') ?>

<?php
    $selectedActivities = is_array($selectedActivities ?? null) ? $selectedActivities : [];
    $selectedActivities = array_map('strval', $selectedActivities);
    $durationRows = $durationRows ?? [];
    if ($durationRows === []) {
        $durationRows = [['nb_jours' => '', 'prix' => '']];
    }

    $validationErrors = [];
    if (! empty($validation)) {
        $validationErrors = array_values($validation->getErrors());
    }

    $formErrors = array_values($formErrors ?? []);
    $allErrors = array_values(array_unique(array_merge($validationErrors, $formErrors)));
?>

<?= $this->section('title') ?><?= esc($title ?? 'Admin regime form') ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= esc($title ?? 'Admin regime form') ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Manage the regime itself, related sports, and duration-price offers in one place.<?= $this->endSection() ?>
<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/regimes') ?>" class="btn btn-secondary">Back to list</a>
    <?php if (! empty($regime['id_regime'])): ?>
        <a href="<?= base_url('admin/regimes/view/' . $regime['id_regime']) ?>" class="btn btn-secondary">Read only detail</a>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if ($allErrors !== []): ?>
        <div class="card" style="border-color:#f1bbbb;">
            <h3 class="section-title">Check the form</h3>
            <p class="section-subtitle">Some values still need attention before we can save this regime.</p>
            <ul class="error-list">
                <?php foreach ($allErrors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= esc($action) ?>" method="post" class="stack">
        <?= csrf_field() ?>

        <div class="card">
            <h3 class="section-title">Core info</h3>
            <p class="section-subtitle">Start with the core regime definition and a clear monthly weight variation label.</p>

            <div class="grid-2">
                <div class="field">
                    <label for="nom_regime">Nom regime</label>
                    <input id="nom_regime" type="text" name="nom_regime" value="<?= esc(old('nom_regime', $regime['nom_regime'] ?? '')) ?>" required>
                </div>
                <div class="field">
                    <label for="variation_mensuelle_kg">Variation mensuelle (kg / mois)</label>
                    <input id="variation_mensuelle_kg" type="number" step="0.01" name="variation_mensuelle_kg" value="<?= esc(old('variation_mensuelle_kg', $regime['variation_mensuelle_kg'] ?? '')) ?>" required>
                    <p class="hint">Use a negative value for weight loss and a positive value for weight gain.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Nutrition composition</h3>
            <p class="section-subtitle">Keep the breakdown balanced. The three percentages must total 100%.</p>

            <div class="grid-3">
                <div class="field">
                    <label for="pourcentage_viande">% viande</label>
                    <input id="pourcentage_viande" type="number" step="0.01" min="0" max="100" name="pourcentage_viande" value="<?= esc(old('pourcentage_viande', $regime['pourcentage_viande'] ?? '0')) ?>" required>
                </div>
                <div class="field">
                    <label for="pourcentage_poisson">% poisson</label>
                    <input id="pourcentage_poisson" type="number" step="0.01" min="0" max="100" name="pourcentage_poisson" value="<?= esc(old('pourcentage_poisson', $regime['pourcentage_poisson'] ?? '0')) ?>" required>
                </div>
                <div class="field">
                    <label for="pourcentage_volaille">% volaille</label>
                    <input id="pourcentage_volaille" type="number" step="0.01" min="0" max="100" name="pourcentage_volaille" value="<?= esc(old('pourcentage_volaille', $regime['pourcentage_volaille'] ?? '0')) ?>" required>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Activites sportives</h3>
            <p class="section-subtitle">Select every activity that should be linked to this regime.</p>

            <?php if (! empty($activities)): ?>
                <div class="choice-grid">
                    <?php foreach ($activities as $activity): ?>
                        <?php $activityId = (string) $activity['id_activite']; ?>
                        <label class="choice">
                            <input type="checkbox" name="activites[]" value="<?= esc($activityId) ?>" <?= in_array($activityId, $selectedActivities, true) ? 'checked' : '' ?>>
                            <span class="choice-card">
                                <strong class="choice-title"><?= esc($activity['label_activite']) ?></strong>
                                <span class="choice-meta"><?= esc((string) $activity['nb_par_semaine']) ?> time(s) per week</span>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="hint">No activity is available yet. You can still save the regime, then add activities from the activites admin page.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:end; gap:16px; flex-wrap:wrap; margin-bottom:18px;">
                <div>
                    <h3 class="section-title" style="margin-bottom:4px;">Durees + prix</h3>
                    <p class="section-subtitle" style="margin-bottom:0;">This is the key pricing matrix. Add or remove rows as needed.</p>
                </div>
                <button type="button" class="btn btn-secondary" id="add-duration-row">Add row</button>
            </div>

            <div class="table-wrap">
                <table id="duration-table">
                    <thead>
                        <tr>
                            <th>Nb jours</th>
                            <th>Prix (Ar)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($durationRows as $index => $row): ?>
                            <tr>
                                <td>
                                    <div class="field">
                                        <input type="number" min="1" name="durees[<?= $index ?>][nb_jours]" value="<?= esc((string) ($row['nb_jours'] ?? '')) ?>" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="field">
                                        <input type="number" min="0.01" step="0.01" name="durees[<?= $index ?>][prix]" value="<?= esc((string) ($row['prix'] ?? '')) ?>" required>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-small remove-duration-row">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="actions-inline" style="justify-content:flex-end;">
            <a href="<?= base_url('admin/regimes') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save regime</button>
        </div>
    </form>

    <template id="duration-row-template">
        <tr>
            <td>
                <div class="field">
                    <input type="number" min="1" name="__NAME_DAYS__" value="" required>
                </div>
            </td>
            <td>
                <div class="field">
                    <input type="number" min="0.01" step="0.01" name="__NAME_PRICE__" value="" required>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-small remove-duration-row">Remove</button>
            </td>
        </tr>
    </template>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        (function () {
            const tableBody = document.querySelector('#duration-table tbody');
            const addButton = document.getElementById('add-duration-row');
            const template = document.getElementById('duration-row-template');
            let nextRowIndex = tableBody ? tableBody.querySelectorAll('tr').length : 0;

            function updateRemoveButtons() {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row) => {
                    const button = row.querySelector('.remove-duration-row');
                    if (!button) {
                        return;
                    }
                    button.disabled = rows.length === 1;
                });
            }

            function addRow() {
                const index = nextRowIndex;
                nextRowIndex += 1;
                const html = template.innerHTML
                    .replace('__NAME_DAYS__', 'durees[' + index + '][nb_jours]')
                    .replace('__NAME_PRICE__', 'durees[' + index + '][prix]');

                const wrapper = document.createElement('tbody');
                wrapper.innerHTML = html.trim();
                tableBody.appendChild(wrapper.firstElementChild);
                updateRemoveButtons();
            }

            addButton?.addEventListener('click', addRow);

            tableBody?.addEventListener('click', function (event) {
                const button = event.target.closest('.remove-duration-row');
                if (!button) {
                    return;
                }

                const rows = tableBody.querySelectorAll('tr');
                if (rows.length === 1) {
                    return;
                }

                button.closest('tr')?.remove();
                updateRemoveButtons();
            });

            updateRemoveButtons();
        }());
    </script>
<?= $this->endSection() ?>
