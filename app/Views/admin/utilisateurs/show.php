<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Details de l'utilisateur<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Utilisateur : <?= esc($user['nom']) ?><?= $this->endSection() ?>
<?= $this->section('page_subtitle') ?>Informations detaillees et historique des regimes achetes.<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
    <a href="<?= base_url('admin/utilisateurs') ?>" class="btn btn-secondary">
        <img class="icon" src="<?= esc(base_url('assets/icons/arrow-left.svg')) ?>" alt="">
        Retour a la liste
    </a>
<?= $this->endSection() ?>

<?= $this->section('head') ?>
    <style>
        .detail-card {
            display: grid;
            gap: 16px;
        }
        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--line);
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 700;
            color: var(--muted);
            width: 150px;
            flex-shrink: 0;
        }
        .detail-value {
            font-weight: 600;
            color: var(--text);
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="grid-2">
        <div class="card">
            <h3 class="section-title">Informations generales</h3>
            <p class="section-subtitle">Apercu des caracteristiques de l'utilisateur.</p>
            
            <div class="detail-card">
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value"><?= esc($user['email']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Genre</span>
                    <span class="detail-value"><?= esc($user['genre']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date de naissance</span>
                    <span class="detail-value"><?= esc($user['date_naissance'] ?? 'Non renseigne') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status Gold</span>
                    <span class="detail-value">
                        <?php if ($user['is_gold']): ?>
                            <span class="badge success">Oui</span>
                        <?php else: ?>
                            <span class="badge neutral">Non</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Solde</span>
                    <span class="detail-value"><?= number_format((float)$user['argent'], 0, ',', ' ') ?> Ar</span>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Caracteristiques physiques</h3>
            <p class="section-subtitle">Donnees de poids et de taille utilisees pour les regimes.</p>

            <div class="detail-card">
                <div class="detail-row">
                    <span class="detail-label">Taille</span>
                    <span class="detail-value"><?= esc($user['taille_cm'] ?? '0') ?> cm</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Poids actuel</span>
                    <span class="detail-value"><?= esc($user['poids_kg'] ?? '0') ?> kg</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Poids objectif</span>
                    <span class="detail-value"><?= esc($user['poids_objectif'] ?? 'Non defini') ?> <?= $user['poids_objectif'] ? 'kg' : '' ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">IMC Actuel</span>
                    <span class="detail-value">
                        <?php
                            $imc = 0;
                            if (!empty($user['taille_cm']) && !empty($user['poids_kg'])) {
                                $tailleM = $user['taille_cm'] / 100;
                                $imc = $user['poids_kg'] / ($tailleM ** 2);
                            }
                            echo $imc > 0 ? number_format($imc, 2) : 'N/A';
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 18px;">
        <h3 class="section-title">Regimes Achetes</h3>
        <p class="section-subtitle">Historique des commandes de l'utilisateur.</p>

        <?php if (!empty($commandes)): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Date d'Achat</th>
                            <th>Regime</th>
                            <th>Duree (jours)</th>
                            <th>Prix Paye</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($commande['date_achat'])) ?></td>
                                <td><strong><?= esc($commande['nom_regime']) ?></strong></td>
                                <td><?= esc($commande['nb_jours']) ?></td>
                                <td><?= number_format((float)$commande['montant_paye'], 0, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="hint">Cet utilisateur n'a achete aucun regime pour le moment.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
