<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Mes régimes<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .badge-muted {
        background: #f2f4f7;
        color: #344054;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="page-header">
        <h1>Mes régimes</h1>
        <p class="sub">Historique de vos achats et régimes actifs.</p>
    </div>

    <div class="card">
        <?php if (empty($purchases)) : ?>
            <div class="empty">Aucun régime acheté pour le moment.</div>
        <?php else : ?>
            <table>
                    <thead>
                        <tr>
                            <th>Régime</th>
                            <th>Objectif</th>
                            <th>Variation estimée</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Date d'achat</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($purchases as $purchase) : ?>
                        <tr>
                            <td><a href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'])) ?>"><?= esc($purchase['nom_regime']) ?></a></td>
                            <td><?= esc($purchase['objective_label']) ?></td>
                            <td><span class="badge"><?= esc($purchase['variation_label']) ?></span></td>
                            <td><span class="badge badge-muted"><?= esc($purchase['nb_jours']) ?> j</span></td>
                            <td><?= esc(number_format((float) $purchase['montant_paye'], 0, ',', ' ')) ?> Ar</td>
                            <td><?= esc(date('d/m/Y', strtotime((string) $purchase['date_achat']))) ?></td>
                            <td><a href="<?= esc(site_url('mes-regimes/' . $purchase['id_commande'] . '/export-pdf')) ?>">Exporter</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
