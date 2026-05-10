<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($regime['nom_regime']) ?> - Détails<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .option-card {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 12px;
        display: grid;
        gap: 6px;
        background: #fff;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease, transform .2s ease;
    }
    .option-card:hover {
        border-color: #94a3b8;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
        transform: translateY(-1px);
    }
    .option-card:has(input[type="radio"]:checked) {
        border-color: var(--primary);
        background: #eff6ff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .12);
    }
    .option-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: var(--text);
    }
    .option-card:has(input[type="radio"]:checked) .option-header {
        color: var(--primary);
    }
    .option-meta {
        color: var(--muted);
        font-size: 13px;
    }
    .success {
        color: #027a48;
        font-weight: 600;
        font-size: 13px;
    }
    .danger {
        color: #b42318;
        font-weight: 600;
        font-size: 13px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="page-header">
        <h1><?= esc($regime['nom_regime']) ?> <span class="badge"><?= esc($regime['variation_label']) ?></span></h1>
        <p class="sub">Détails complets du régime et objectifs attendus.</p>
    </div>

        <div class="card">
            <div class="grid">
                <div>
                    <div class="kv-title">Variation de poids</div>
                    <div class="kv-value"><?= esc($regime['variation_label']) ?></div>
                </div>
                <div>
                    <div class="kv-title">Objectif</div>
                    <div class="kv-value"><?= esc($objectiveLabel) ?></div>
                </div>
                <div>
                    <div class="kv-title">Composition</div>
                    <div class="kv-value" style="font-size:14px;">
                        <?= esc($regime['pourcentage_viande']) ?>% viande ·
                        <?= esc($regime['pourcentage_poisson']) ?>% poisson ·
                        <?= esc($regime['pourcentage_volaille']) ?>% volaille
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">À propos de ce régime</h2>
            <p class="sub" style="margin-bottom: 8px;">
                <?= esc($regime['nom_regime']) ?> est un programme alimentaire conçu pour <?= esc(strtolower($objectiveLabel)) ?>,
                basé sur une répartition précise des sources protéiques.
            </p>
            <ul style="margin: 0; padding-left: 18px; color: var(--muted); font-size: 14px;">
                <li>Variation estimée mensuelle: <strong><?= esc($regime['variation_label']) ?></strong></li>
                <li>Répartition: <?= esc($regime['pourcentage_viande']) ?>% viande, <?= esc($regime['pourcentage_poisson']) ?>% poisson, <?= esc($regime['pourcentage_volaille']) ?>% volaille.</li>
                <li>Accompagnement sport recommandé selon les activités proposées.</li>
            </ul>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Activités recommandées</h2>
            <?php if (empty($activites)) : ?>
                <div class="empty">Aucune activité associée à ce régime.</div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Activité</th>
                            <th>Fréquence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activites as $activite) : ?>
                            <tr>
                                <td><?= esc($activite['label_activite']) ?></td>
                                <td><?= esc($activite['nb_par_semaine']) ?>x/semaine</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Commander</h2>
            <?php if (empty($durees)) : ?>
                <div class="empty">Aucune durée disponible pour ce régime.</div>
            <?php else : ?>
                <form id="commande-form" method="post" action="<?= esc(site_url('regimes/purchase/' . $regime['id_regime'])) ?>" data-ajax-form="true">
                    <?php foreach ($durees as $index => $duree) : ?>
                        <label class="option-card">
                            <div class="option-header">
                                <input
                                    type="radio"
                                    name="id_duree_regime"
                                    value="<?= esc($duree['id_duree_regime']) ?>"
                                    data-days="<?= esc($duree['nb_jours']) ?>"
                                    data-price="<?= esc($duree['prix']) ?>"
                                    <?= $index === 0 ? 'checked' : '' ?>
                                >
                                <?= esc($duree['nb_jours']) ?> jours
                            </div>
                            <div class="option-meta">→ <?= esc(number_format((float) $duree['prix'], 0, ',', ' ')) ?> Ar</div>
                            <div class="option-meta">→ Résultat estimé: <span class="estimate" data-days="<?= esc($duree['nb_jours']) ?>"></span></div>
                        </label>
                    <?php endforeach; ?>
                    <div class="field-error" data-field-error="id_duree_regime"></div>
                    <div class="form-feedback" data-form-feedback></div>
                    <div id="objectif-status" class="success" style="display:none; margin-top: 8px;">✅ Objectif atteint</div>
                    <div id="objectif-status-fail" class="danger" style="display:none; margin-top: 8px;">❌ Objectif non atteint</div>
                    <div style="margin-top: 16px;">
                        <button class="btn" type="submit" data-confirm-message="Confirmer cet achat de régime ?">Commander</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
        (function() {
            const form = document.getElementById('commande-form');
            if (!form) return;

            const objectiveStatus = document.getElementById('objectif-status');
            const variationMonthly = <?= json_encode((float) $regime['variation_mensuelle_kg']) ?>;
            const user = <?= json_encode($user ?? null) ?>;
            const imcIdealMin = <?= json_encode($imcIdealMin) ?>;
            const imcIdealMax = <?= json_encode($imcIdealMax) ?>;

            const formatKg = (value) => {
                const sign = value > 0 ? '+' : '';
                return sign + value.toFixed(2).replace(/\.00$/, '').replace(/\.([1-9])0$/, '.$1') + 'kg';
            };

            const updateEstimates = () => {
                const estimateNodes = form.querySelectorAll('.estimate');
                estimateNodes.forEach((node) => {
                    const days = Number(node.dataset.days || 0);
                    const estimated = variationMonthly * (days / 30);
                    node.textContent = formatKg(estimated);
                });
            };

            const isObjectiveReached = (selectedDays) => {
                if (!user) return false;

                const variation = variationMonthly * (selectedDays / 30);
                const poidsActuel = Number(user.poids_kg || 0);
                const poidsObjectif = user.poids_objectif !== null ? Number(user.poids_objectif) : null;
                const tailleCm = Number(user.taille_cm || 0);
                const objectifId = Number(user.id_objectif || 0);

                if (objectifId === 1 && poidsObjectif !== null) {
                    const cible = poidsObjectif - poidsActuel;
                    return variation <= cible;
                }

                if (objectifId === 2 && poidsObjectif !== null) {
                    const cible = poidsObjectif - poidsActuel;
                    return variation >= cible;
                }

                if (objectifId === 3 && tailleCm > 0 && imcIdealMin !== null && imcIdealMax !== null) {
                    const tailleM = tailleCm / 100;
                    const nouveauPoids = poidsActuel + variation;
                    const imc = nouveauPoids / (tailleM * tailleM);
                    return imc >= imcIdealMin && imc <= imcIdealMax;
                }

                return false;
            };

            const updateObjectiveStatus = () => {
                const selected = form.querySelector('input[name="id_duree_regime"]:checked');
                if (!selected) return;
                const days = Number(selected.dataset.days || 0);
                if (!user) {
                    objectiveStatus.style.display = 'none';
                    const failNode = document.getElementById('objectif-status-fail');
                    if (failNode) {
                        failNode.style.display = 'none';
                    }
                    return;
                }
                const reached = isObjectiveReached(days);
                objectiveStatus.style.display = reached ? 'block' : 'none';
                const failNode = document.getElementById('objectif-status-fail');
                if (failNode) {
                    failNode.style.display = reached ? 'none' : 'block';
                }
            };

            updateEstimates();
            updateObjectiveStatus();
            form.addEventListener('change', updateObjectiveStatus);
        })();
</script>
<?= $this->endSection() ?>
