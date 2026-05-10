<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Mon Profil<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="page-header">
        <h1>Mon profil</h1>
        <p class="sub">Consultez vos informations personnelles et santé.</p>
    </div>

    <div class="card">
        <h2 style="margin:0 0 12px; font-size:18px;">Informations personnelles</h2>
        <div class="grid">
            <div><div class="kv-title">Nom</div><div class="kv-value"><?= esc($user['nom']) ?></div></div>
            <div><div class="kv-title">Email</div><div class="kv-value" style="font-size:14px;"><?= esc($user['email']) ?></div></div>
            <div><div class="kv-title">Genre</div><div class="kv-value"><?= esc($user['genre']) ?></div></div>
            <div><div class="kv-title">Date de naissance</div><div class="kv-value" style="font-size:14px;"><?= esc($user['date_naissance']) ?></div></div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin:0 0 12px; font-size:18px;">Informations santé</h2>
        <div class="grid">
            <div><div class="kv-title">Taille</div><div class="kv-value"><?= esc($user['taille_cm']) ?> cm</div></div>
            <div><div class="kv-title">Poids actuel</div><div class="kv-value"><?= esc($user['poids_kg']) ?> kg</div></div>
            <div><div class="kv-title">Poids objectif</div><div class="kv-value"><?= isset($user['poids_objectif']) && $user['poids_objectif'] !== null ? esc($user['poids_objectif']) . ' kg' : 'Non défini' ?></div></div>
            <div><div class="kv-title">IMC</div><div class="kv-value"><?= $imc !== null ? number_format($imc, 2, ',', ' ') : 'Non calculable' ?></div></div>
            <div><div class="kv-title">Objectif</div><div class="kv-value" style="font-size:14px;"><?= $objectif !== null ? esc($objectif['label_objectif']) : 'Non défini' ?></div></div>
            <div><div class="kv-title">Statut</div><div class="kv-value"><?= $user['is_gold'] ? '<span class="badge">Gold</span>' : 'Standard' ?></div></div>
        </div>

        <div class="actions">
            <a href="<?= site_url('/profile/edit') ?>" class="btn">Modifier le profil</a>
            <a href="<?= site_url('/mes-regimes') ?>" class="btn btn-secondary">Mes régimes</a>
            <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
