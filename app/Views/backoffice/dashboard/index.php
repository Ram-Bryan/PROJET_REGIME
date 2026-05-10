<?= $this->extend('backoffice/layout') ?>

<?= $this->section('title') ?>Tableau de bord<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Tableau de bord<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Vue d'ensemble rapide de l'activite de la plateforme et des objectifs utilisateurs.<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="dashboard-hero">
        <h3>Bienvenue, <?= esc((string) ($adminName ?? session()->get('admin_name'))) ?></h3>
        <p>Voici un apercu clair de la plateforme. Consultez les statistiques, la repartition des objectifs et le chiffre d'affaires.</p>
    </div>

    <div class="stats-grid" style="margin-top:18px;">
        <div class="stat-box stat-e">
            <h4>Chiffre d'affaire</h4>
            <p><?= number_format((float)$chiffreAffaire, 0, ',', ' ') ?> Ar</p>
        </div>
        <div class="stat-box stat-c">
            <h4>Ventes</h4>
            <p><?= esc((string) $salesCount) ?></p>
        </div>
        <div class="stat-box stat-a">
            <h4>Utilisateurs</h4>
            <p><?= esc((string) $usersCount) ?></p>
        </div>
        <div class="stat-box stat-b">
            <h4>Comptes Gold</h4>
            <p><?= esc((string) $goldCount) ?></p>
        </div>
        <div class="stat-box stat-d">
            <h4>Objectifs</h4>
            <p><?= esc((string) $objectivesCount) ?></p>
        </div>
        <div class="stat-box stat-f">
            <h4>Nombre de regimes</h4>
            <p><?= esc((string) $regimesCount) ?></p>
        </div>
    </div>

    <div class="grid-2" style="margin-top:18px;">
        <div class="card">
            <h3 class="section-title-bo">Repartition des objectifs</h3>
            <p class="section-subtitle-bo">Graphique circulaire des objectifs choisis par les utilisateurs.</p>
            <div class="pie-chart-container" id="pie-chart-container">
                <div class="pie-chart"></div>
                <div class="pie-legend"></div>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title-bo">Tendance du chiffre d'affaires</h3>
            <p class="section-subtitle-bo">Evolution du chiffre d'affaires mensuel sur les 6 derniers mois.</p>
            <div class="trend-chart-container">
                <canvas id="trend-chart" style="width:100%;height:250px;"></canvas>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:18px;">
        <h3 class="section-title-bo">Derniers utilisateurs</h3>
        <p class="section-subtitle-bo">Les cinq inscriptions les plus recentes.</p>

        <?php if (($recentUsers ?? []) !== []): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $user): ?>
                            <tr>
                                <td><?= esc($user['nom'] ?? '') ?></td>
                                <td><?= esc($user['email'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="hint">Aucun utilisateur recent.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/charts.js') ?>"></script>
<script>
    renderPieChart({
        containerId: 'pie-chart-container',
        data: <?= json_encode($pieData ?? []) ?>
    });

    renderTrendChart({
        canvasId: 'trend-chart',
        labels: <?= json_encode($trendLabels ?? []) ?>,
        values: <?= json_encode($trendValues ?? []) ?>,
        color: '#1f8f6a'
    });
</script>
<?= $this->endSection() ?>
