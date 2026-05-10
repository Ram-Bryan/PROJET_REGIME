<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($purchase['nom_regime']) ?> - Mon régime<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="page-header">
        <h1><?= esc($purchase['nom_regime']) ?></h1>
        <p class="sub">Détails complets de votre achat et du programme.</p>
        <div class="actions">
            <a class="btn" href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'] . '/export-pdf')) ?>">Exporter PDF</a>
        </div>
    </div>

        <div class="card">
            <div class="grid">
                <div>
                    <div class="kv-title">Objectif</div>
                    <div class="kv-value"><?= esc($purchase['objective_label']) ?></div>
                </div>
                <div>
                    <div class="kv-title">Variation estimée</div>
                    <div class="kv-value"><?= esc($purchase['variation_label']) ?></div>
                </div>
                <div>
                    <div class="kv-title">Durée choisie</div>
                    <div class="kv-value"><?= esc($purchase['nb_jours']) ?> jours</div>
                </div>
                <div>
                    <div class="kv-title">Montant payé</div>
                    <div class="kv-value"><?= esc(number_format((float) $purchase['montant_paye'], 0, ',', ' ')) ?> Ar</div>
                </div>
                <div>
                    <div class="kv-title">Date d'achat</div>
                    <div class="kv-value"><?= esc(date('d/m/Y', strtotime((string) $purchase['date_achat']))) ?></div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Description du régime</h2>
            <p class="sub" style="margin-bottom: 8px;">
                <?= esc($purchase['nom_regime']) ?> est un programme adapté pour <?= esc(strtolower($purchase['objective_label'])) ?>,
                basé sur une répartition précise des sources protéiques.
            </p>
            <ul style="margin: 0; padding-left: 18px; color: var(--muted); font-size: 14px;">
                <li>Répartition: <?= esc($purchase['pourcentage_viande']) ?>% viande, <?= esc($purchase['pourcentage_poisson']) ?>% poisson, <?= esc($purchase['pourcentage_volaille']) ?>% volaille.</li>
                <li>Variation estimée mensuelle: <strong><?= esc($purchase['variation_label']) ?></strong></li>
                <li>Objectif aligné avec votre achat.</li>
            </ul>
        </div>

        <div class="card">
            <h2 style="margin: 0 0 12px; font-size: 18px;">Activités recommandées</h2>
            <?php if (empty($activites)) : ?>
                <div class="sub">Aucune activité associée à ce régime.</div>
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
</section>
<?= $this->endSection() ?>
