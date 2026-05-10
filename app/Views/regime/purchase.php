<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Acheter un régime<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .box {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 14px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack" style="max-width:860px; margin:0 auto;">
    <div class="page-header">
        <h1>Acheter un régime</h1>
        <p class="sub">Sélectionnez une durée pour le régime <?= esc($regime['nom_regime']) ?>.</p>
    </div>

    <div class="card stack">
        <div class="grid">
            <div class="box">
                <div class="kv-title">Régime</div>
                <div class="kv-value"><?= esc($regime['nom_regime']) ?></div>
            </div>
            <div class="box">
                <div class="kv-title">Variation poids</div>
                <div class="kv-value"><?= esc($regime['variation_poids']) ?> kg</div>
            </div>
            <div class="box">
                <div class="kv-title">Mode d'accès</div>
                <div class="kv-value"><?= $isGold ? 'Gold' : 'Standard' ?></div>
                <div class="sub">Réduction : <?= esc((string) $discountPercent) ?>%</div>
            </div>
            <div class="box">
                <div class="kv-title">Solde disponible</div>
                <div class="kv-value"><?= esc((string) $argent) ?> Ar</div>
            </div>
        </div>

        <?php if (empty($durees)): ?>
            <div class="empty">Aucune durée disponible pour ce régime.</div>
        <?php else: ?>
            <form method="POST" action="<?= site_url('/regimes/purchase/' . $regime['id_regime']) ?>" class="stack">
                <?= csrf_field() ?>
                <div class="box">
                    <label for="id_duree_regime">Durée du régime</label>
                    <select id="id_duree_regime" name="id_duree_regime" required>
                        <option value="">-- Choisir une durée --</option>
                        <?php foreach ($durees as $duree): ?>
                            <option value="<?= esc($duree['id_duree_regime']) ?>" <?= old('id_duree_regime') === (string) $duree['id_duree_regime'] ? 'selected' : '' ?>>
                                <?= esc($duree['nb_jours']) ?> jours - <?= esc($duree['prix_final']) ?> Ar
                                <?php if ($isGold): ?>
                                    (au lieu de <?= esc($duree['prix']) ?> Ar)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="actions">
                    <button type="submit" class="btn" data-confirm-message="Voulez-vous confirmer cet achat ?">Confirmer l'achat</button>
                    <a href="<?= site_url('/regimes') ?>" class="btn btn-secondary">Retour aux régimes</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
