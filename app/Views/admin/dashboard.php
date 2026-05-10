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
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .stat-box {
            padding: 20px;
            border-radius: 20px;
            color: #ffffff;
            box-shadow: var(--shadow);
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

        .objectif-bars {
            display: grid;
            gap: 14px;
        }

        .objectif-row {
            display: grid;
            gap: 8px;
        }

        .objectif-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-weight: 700;
        }

        .objectif-track {
            height: 12px;
            border-radius: 999px;
            background: #e9eef3;
            overflow: hidden;
        }

        .objectif-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #1f8f6a, #2f6f88);
        }

        .quick-list {
            display: grid;
            gap: 12px;
        }

        .quick-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            background: var(--surface-soft);
            border: 1px solid var(--line);
            font-weight: 700;
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
        <div class="stat-box stat-a">
            <h4>Utilisateurs</h4>
            <p><?= esc((string) $usersCount) ?></p>
        </div>
        <div class="stat-box stat-b">
            <h4>Comptes Gold</h4>
            <p><?= esc((string) $goldCount) ?></p>
        </div>
        <div class="stat-box stat-c">
            <h4>Ventes</h4>
            <p><?= esc((string) $salesCount) ?></p>
        </div>
        <div class="stat-box stat-d">
            <h4>Objectifs</h4>
            <p><?= esc((string) $objectivesCount) ?></p>
        </div>
    </div>

    <div class="grid-2" style="margin-top:18px;">
        <div class="card">
            <h3 class="section-title">Repartition des objectifs</h3>
            <p class="section-subtitle">Lecture sans CDN ni librairie externe.</p>

            <?php if ($objectifs !== []): ?>
                <div class="objectif-bars">
                    <?php foreach ($objectifs as $objectif): ?>
                        <?php $total = (int) ($objectif['total'] ?? 0); ?>
                        <div class="objectif-row">
                            <div class="objectif-meta">
                                <span><?= esc($objectif['label_objectif'] ?? 'Objectif') ?></span>
                                <span><?= esc((string) $total) ?></span>
                            </div>
                            <div class="objectif-track">
                                <div class="objectif-fill" style="width: <?= esc((string) round(($total / $maxObjectif) * 100, 2)) ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="hint">Aucune donnee disponible.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 class="section-title">Indicateurs rapides</h3>
            <p class="section-subtitle">Resume des chiffres principaux.</p>

            <div class="quick-list">
                <div class="quick-item"><span>Utilisateurs</span><strong><?= esc((string) $usersCount) ?></strong></div>
                <div class="quick-item"><span>Gold</span><strong><?= esc((string) $goldCount) ?></strong></div>
                <div class="quick-item"><span>Ventes</span><strong><?= esc((string) $salesCount) ?></strong></div>
                <div class="quick-item"><span>Objectifs</span><strong><?= esc((string) $objectivesCount) ?></strong></div>
            </div>
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
