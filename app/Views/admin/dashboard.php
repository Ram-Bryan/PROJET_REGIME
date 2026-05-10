<?= $this->extend('admin/layout') ?>

<?php
    $recentUsers = $recentUsers ?? [];
    $objectifs = $objectifs ?? [];
    $maxObjectif = 1;
    foreach ($objectifs as $objectif) {
        $maxObjectif = max($maxObjectif, (int) ($objectif['total'] ?? 0));
    }
?>

<?= $this->section('title') ?>Tableau de bord<?= $this->endSection() ?>
<?= $this->section('head') ?>
    <style>
        .dashboard-hero {
            padding: 26px;
            border-radius: 24px;
            background: linear-gradient(135deg, #163449 0%, #20506f 55%, #1f8f6a 100%);
            color: #ffffff;
            box-shadow: var(--shadow);
        }

        .dashboard-hero h3 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .dashboard-hero p {
            margin: 0;
            color: rgba(255, 255, 255, 0.84);
            max-width: 70ch;
        }

        .stats-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .stat-box {
            padding: 20px;
            border-radius: 20px;
            color: #ffffff;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-box h4 {
            margin: 0 0 8px;
            font-size: 14px;
            font-weight: 700;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-box p {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
        }

        .stat-a { background: linear-gradient(135deg, #183247, #20506f); }
        .stat-b { background: linear-gradient(135deg, #7c3aed, #4f46e5); }
        .stat-c { background: linear-gradient(135deg, #1f8f6a, #157454); }
        .stat-d { background: linear-gradient(135deg, #d97706, #b45309); }
        .stat-e { background: linear-gradient(135deg, #e11d48, #be123c); }
        .stat-f { background: linear-gradient(135deg, #0ea5e9, #0369a1); }

        .pie-chart-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            padding: 20px 0;
        }

        .pie-chart {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(var(--pie-gradients));
            box-shadow: var(--shadow);
            border: 4px solid var(--surface);
        }

        .pie-legend {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 4px;
        }

        @media (max-width: 980px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Tableau de bord<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Vue d'ensemble rapide de l'activite de la plateforme et des objectifs utilisateurs.<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="dashboard-hero">
        <h3>Bienvenue, <?= esc((string) session()->get('admin_name')) ?></h3>
        <p>Voici un apercu clair de la plateforme. Cette page reprend le meme layout final que le module Regime pour garder une navigation stable dans tout le backoffice.</p>
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
        <div class="card" style="grid-column: 1 / -1;">
            <h3 class="section-title">Repartition des objectifs</h3>
            <p class="section-subtitle">Graphique circulaire des objectifs choisis par les utilisateurs.</p>

            <?php if ($objectifs !== []): ?>
                <?php
                    $colors = ['#1f8f6a', '#183247', '#7c3aed', '#d97706', '#e11d48', '#0ea5e9'];
                    $totalUsersWithGoals = array_sum(array_column($objectifs, 'total'));
                    $pieGradients = [];
                    $cumulativePercent = 0;
                    
                    if ($totalUsersWithGoals > 0):
                        foreach ($objectifs as $index => $objectif) {
                            $percent = ((int) $objectif['total'] / $totalUsersWithGoals) * 100;
                            if ($percent == 0) continue;
                            
                            $color = $colors[$index % count($colors)];
                            $nextPercent = $cumulativePercent + $percent;
                            $pieGradients[] = "{$color} {$cumulativePercent}% {$nextPercent}%";
                            $cumulativePercent = $nextPercent;
                        }
                    endif;
                    $pieGradientStr = implode(', ', $pieGradients);
                ?>
                <div class="pie-chart-container" style="--pie-gradients: <?= $totalUsersWithGoals > 0 ? $pieGradientStr : '#e9eef3 0% 100%' ?>">
                    <div class="pie-chart"></div>
                    <div class="pie-legend">
                        <?php foreach ($objectifs as $index => $objectif): ?>
                            <?php $total = (int) ($objectif['total'] ?? 0); ?>
                            <?php if ($total > 0): ?>
                            <div class="legend-item">
                                <span class="legend-color" style="background: <?= $colors[$index % count($colors)] ?>;"></span>
                                <span><?= esc($objectif['label_objectif'] ?? 'Objectif') ?> (<?= $total ?>)</span>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="hint">Aucune donnee disponible.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Derniers utilisateurs</h3>
        <p class="section-subtitle">Les cinq inscriptions les plus recentes.</p>

        <?php if ($recentUsers !== []): ?>
            <div class="table-wrap">
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
