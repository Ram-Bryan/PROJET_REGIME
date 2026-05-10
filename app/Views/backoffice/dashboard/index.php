<?= $this->extend('backoffice/layout') ?>

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
    
<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Tableau de bord<?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Vue d'ensemble rapide de l'activite de la plateforme et des objectifs utilisateurs.<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="dashboard-hero">
        <h3>Bienvenue, <?= esc((string) session()->get('admin_name')) ?></h3>
        <p>Voici un apercu clair de la plateforme. Cette page reprend le meme layout final que le module Regime pour garder une navigation stable dans tout le backoffice.</p>
    </div>

    <div class="stats-grid">
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

    <div class="grid-2">
        <div class="card">
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
