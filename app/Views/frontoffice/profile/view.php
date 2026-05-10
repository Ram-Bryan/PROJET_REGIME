<?= $this->extend('frontoffice/layout') ?>

<?= $this->section('title') ?>Mon Profil<?= $this->endSection() ?>


<?= $this->section('content') ?>
<section class="stack">
    <div class="hero">
        <div class="page-header">
            <h1>Mon profil</h1>
            <p class="sub">Consultez vos informations personnelles et santé, puis accédez rapidement à vos actions principales.</p>
        </div>
        <div class="hero-actions">
            <a href="<?= site_url('/profile/edit') ?>" class="btn">Modifier le profil</a>
            <a href="<?= site_url('/mes-regimes') ?>" class="btn btn-secondary">Mes régimes</a>
            <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Informations personnelles</h2>
                <p class="sub">Vos données d’identité principales.</p>
            </div>
        </div>
        <div class="metric-grid">
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/user-round.svg')) ?>" alt="">Nom</div><div class="metric-value small"><?= esc($user['nom']) ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/mail.svg')) ?>" alt="">Email</div><div class="metric-value small"><?= esc($user['email']) ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/venus-and-mars.svg')) ?>" alt="">Genre</div><div class="metric-value"><?= esc($user['genre']) ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/calendar-days.svg')) ?>" alt="">Date de naissance</div><div class="metric-value small"><?= esc($user['date_naissance'] ?? 'Non renseignée') ?></div></div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">
            <div>
                <h2>Informations santé</h2>
                <p class="sub">Les indicateurs liés à votre parcours.</p>
            </div>
        </div>
        <div class="metric-grid">
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/ruler.svg')) ?>" alt="">Taille</div><div class="metric-value"><?= esc($user['taille_cm']) ?> cm</div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/weight.svg')) ?>" alt="">Poids actuel</div><div class="metric-value"><?= esc($user['poids_kg']) ?> kg</div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/weight-tilde.svg')) ?>" alt="">Poids objectif</div><div class="metric-value"><?= isset($user['poids_objectif']) && $user['poids_objectif'] !== null ? esc($user['poids_objectif']) . ' kg' : 'Non défini' ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/activity.svg')) ?>" alt="">IMC</div><div class="metric-value"><?= $imc !== null ? number_format($imc, 2, ',', ' ') : 'Non calculable' ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/target.svg')) ?>" alt="">Objectif</div><div class="metric-value small"><?= $objectif !== null ? esc($objectif['label_objectif']) : 'Non défini' ?></div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/wallet.svg')) ?>" alt="">Solde actuel</div><div class="metric-value"><?= esc((string) ($user['argent'] ?? 0)) ?> Ar</div></div>
            <div class="metric-card"><div class="metric-label icon"><img src="<?= esc(base_url('assets/icons/crown.svg')) ?>" alt="">Statut</div><div class="metric-value"><?= $user['is_gold'] ? '<span class="badge badge-success">Gold</span>' : '<span class="badge">Standard</span>' ?></div></div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
