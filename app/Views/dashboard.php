<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack">
    <div class="hero">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1>Dashboard</h1>
            <p class="sub">Bienvenue, <?= esc($nom) ?>. Retrouvez ici les éléments clés de votre parcours régime, votre statut et vos raccourcis d’action.</p>
        </div>
        <div class="hero-actions" style="position:relative; z-index:1;">
            <a href="<?= site_url('/regimes') ?>" class="btn">Explorer les régimes</a>
            <a href="<?= site_url('/mes-regimes') ?>" class="btn btn-secondary">Mes régimes</a>
            <a href="<?= site_url('/profile') ?>" class="btn btn-secondary">Mon profil</a>
        </div>
    </div>

    <div class="section-title">
        <div>
            <h2>Vue d’ensemble</h2>
            <p class="sub">Les informations importantes en un coup d’œil.</p>
        </div>
    </div>

    <div class="metric-grid">
        <div class="metric-card">
            <div class="metric-label">Email</div>
            <div class="metric-value small"><?= esc($email) ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Rôle</div>
            <div class="metric-value"><?= esc($role) ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">IMC</div>
            <div class="metric-value"><?= session()->get('imc') !== null ? esc((string) session()->get('imc')) : 'N/A' ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Objectif</div>
            <div class="metric-value small"><?= esc((string) (session()->get('objectif_label') ?? 'N/A')) ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Solde</div>
            <div class="metric-value"><?= esc((string) (session()->get('argent') ?? 0)) ?> Ar</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Statut</div>
            <div class="metric-value"><?= session()->get('is_gold') ? '<span class="badge badge-success">Gold</span>' : '<span class="badge">Standard</span>' ?></div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Accès rapide</h2>
                <p class="sub">Les pages les plus utilisées sont à portée de clic.</p>
            </div>
        </div>
        <div class="actions" style="margin-top:0;">
            <a href="<?= site_url('/profile/edit') ?>" class="btn btn-secondary">Modifier mon profil</a>
            <a href="<?= site_url('/transactions') ?>" class="btn btn-secondary">Transactions</a>
            <a href="<?= site_url('/promo') ?>" class="btn btn-secondary">Code promo</a>
            <a href="<?= site_url('/logout') ?>" class="btn btn-secondary" data-confirm-message="Voulez-vous vraiment vous déconnecter ?">Déconnexion</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
