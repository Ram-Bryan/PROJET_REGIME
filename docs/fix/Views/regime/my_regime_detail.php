<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($purchase['nom_regime']) ?> - Mon régime<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="hero">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1><?= esc($purchase['nom_regime']) ?></h1>
            <p class="sub">Détails complets de votre achat, du programme et de ses activités associées.</p>
        </div>
        <div class="hero-actions" style="position:relative; z-index:1;">
            <a class="btn" href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'] . '/export-pdf')) ?>">Exporter PDF</a>
            <a class="btn btn-secondary" href="<?= esc(site_url('mes-regimes')) ?>">Retour</a>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Résumé de l’achat</h2>
                <p class="sub">Les informations clés de votre régime acheté.</p>
            </div>
        </div>
        <div class="metric-grid">
            <div class="metric-card"><div class="metric-label">Objectif</div><div class="metric-value small"><?= esc($purchase['objective_label']) ?></div></div>
            <div class="metric-card"><div class="metric-label">Variation estimée</div><div class="metric-value"><?= esc($purchase['variation_label']) ?></div></div>
            <div class="metric-card"><div class="metric-label">Durée choisie</div><div class="metric-value"><?= esc($purchase['nb_jours']) ?> jours</div></div>
            <div class="metric-card"><div class="metric-label">Montant payé</div><div class="metric-value"><?= esc(number_format((float) $purchase['montant_paye'], 0, ',', ' ')) ?> Ar</div></div>
            <div class="metric-card"><div class="metric-label">Date d'achat</div><div class="metric-value small"><?= esc(date('d/m/Y', strtotime((string) $purchase['date_achat']))) ?></div></div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Description du régime</h2>
                <p class="sub">La logique du programme et sa composition.</p>
            </div>
        </div>
        <p class="sub" style="margin-bottom: 10px;">
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
        <div class="section-title">
            <div>
                <h2>Activités recommandées</h2>
                <p class="sub">Les activités les plus cohérentes avec ce régime.</p>
            </div>
        </div>
        <?php if (empty($activites)) : ?>
            <div class="empty">Aucune activité associée à ce régime.</div>
        <?php else : ?>
            <div class="table-wrap">
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
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
