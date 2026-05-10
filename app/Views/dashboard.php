<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p class="sub">Bienvenue, <?= esc($nom) ?>.</p>
    </div>

    <div class="grid">
        <div class="card">
            <div class="kv-title">Email</div>
            <div class="kv-value" style="font-size:14px;"><?= esc($email) ?></div>
        </div>
        <div class="card">
            <div class="kv-title">Rôle</div>
            <div class="kv-value"><?= esc($role) ?></div>
        </div>
        <div class="card">
            <div class="kv-title">IMC</div>
            <div class="kv-value"><?= session()->get('imc') !== null ? esc((string) session()->get('imc')) : 'N/A' ?></div>
        </div>
        <div class="card">
            <div class="kv-title">Objectif</div>
            <div class="kv-value" style="font-size:14px;"><?= esc((string) (session()->get('objectif_label') ?? 'N/A')) ?></div>
        </div>
        <div class="card">
            <div class="kv-title">Solde</div>
            <div class="kv-value"><?= esc((string) (session()->get('argent') ?? 0)) ?> Ar</div>
        </div>
        <div class="card">
            <div class="kv-title">Statut</div>
            <div class="kv-value">
                <?= session()->get('is_gold') ? '<span class="badge">Gold</span>' : 'Standard' ?>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin:0 0 10px; font-size:18px;">Accès rapide</h2>
        <div class="actions" style="margin-top:0;">
            <a href="<?= site_url('/profile') ?>" class="btn btn-secondary">Mon profil</a>
            <a href="<?= site_url('/regimes') ?>" class="btn btn-secondary">Régimes</a>
            <a href="<?= site_url('/mes-regimes') ?>" class="btn btn-secondary">Mes régimes</a>
            <a href="<?= site_url('/transactions') ?>" class="btn btn-secondary">Transactions</a>
            <a href="<?= site_url('/promo') ?>" class="btn btn-secondary">Code promo</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
