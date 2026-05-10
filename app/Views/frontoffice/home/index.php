<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Régime — Atteignez vos objectifs santé</title>
    <meta name="description" content="Projet Régime : plans alimentaires personnalisés et suivi de vos objectifs santé. Perdez du poids, prenez de la masse ou atteignez votre IMC idéal.">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/frontoffice.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/landing.css') ?>">
</head>
<body>

<!-- ── Header ── -->
<header class="topbar">
    <div class="topbar-inner">
        <a class="fo-brand" href="<?= esc(site_url('/')) ?>">PROJET RÉGIME</a>
        <button class="mobile-menu-btn" aria-label="Menu">
            <img src="<?= esc(base_url('assets/icons/menu.svg')) ?>" alt="Menu">
        </button>
        <nav class="nav">
            <a href="<?= esc(site_url('login')) ?>">Connexion</a>
            <a href="<?= esc(site_url('register')) ?>" class="btn" style="padding: 9px 16px;">S'inscrire</a>
        </nav>
    </div>
</header>

<!-- ── Hero ── -->
<section class="landing-hero">
    <div class="landing-hero-inner">
        <div>
            <h1>Transformez votre <span>alimentation</span>, transformez votre vie.</h1>
            <p>Des plans alimentaires personnalisés, un suivi d'objectifs complet et des activités sportives adaptées pour atteindre votre IMC idéal.</p>
            <div class="actions">
                <a href="<?= esc(site_url('register')) ?>" class="btn">Commencer maintenant</a>
                <a href="#features" class="btn btn-secondary">En savoir plus</a>
            </div>
        </div>
        <div><!-- Placeholder for hero visual --></div>
    </div>
</section>

<!-- ── Stats bar ── -->
<section class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-item">
            <h3>+200</h3>
            <p>Utilisateurs actifs</p>
        </div>
        <div class="stat-item">
            <h3>+50</h3>
            <p>Régimes disponibles</p>
        </div>
        <div class="stat-item">
            <h3>95%</h3>
            <p>Taux de satisfaction</p>
        </div>
    </div>
</section>

<!-- ── Features ── -->
<section class="features-section" id="features">
    <div class="features-inner">
        <h2>Tout ce dont vous avez besoin</h2>
        <p>Une plateforme complète pour gérer votre parcours santé de A à Z.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="<?= esc(base_url('assets/icons/apple.svg')) ?>" alt="">
                </div>
                <h3>Régimes personnalisés</h3>
                <p>Choisissez parmi des dizaines de régimes adaptés à vos objectifs : perte de poids, prise de masse, ou maintien de l'IMC idéal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="<?= esc(base_url('assets/icons/target.svg')) ?>" alt="">
                </div>
                <h3>Objectifs sur mesure</h3>
                <p>Définissez vos objectifs et suivez votre progression grâce à un tableau de bord intuitif et des estimations en temps réel.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="<?= esc(base_url('assets/icons/activity.svg')) ?>" alt="">
                </div>
                <h3>Activités sportives</h3>
                <p>Complétez votre régime avec des activités sportives recommandées et des options personnalisables pour chaque plan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="<?= esc(base_url('assets/icons/trending-up.svg')) ?>" alt="">
                </div>
                <h3>Suivi intelligent</h3>
                <p>Suivez vos résultats, votre IMC, et vos transactions depuis un tableau de bord clair et intuitif.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── How It Works ── -->
<section class="how-section">
    <div class="how-inner">
        <h2>Comment ça marche ?</h2>
        <p>Trois étapes simples pour démarrer votre parcours santé.</p>
        <div class="how-steps">
            <div class="how-step">
                <div class="step-number">1</div>
                <h3>Créez votre compte</h3>
                <p>Renseignez vos informations (taille, poids, objectif) et obtenez votre IMC en temps réel.</p>
            </div>
            <div class="how-step">
                <div class="step-number">2</div>
                <h3>Choisissez un régime</h3>
                <p>Parcourez les régimes adaptés à votre profil et sélectionnez une durée et des options.</p>
            </div>
            <div class="how-step">
                <div class="step-number">3</div>
                <h3>Suivez vos progrès</h3>
                <p>Consultez votre tableau de bord pour voir vos estimations, vos transactions et vos objectifs atteints.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── Featured Regimes ── -->
<?php if (!empty($featuredRegimes)): ?>
<section class="regimes-section">
    <div class="regimes-inner">
        <h2>Nos régimes populaires</h2>
        <p>Commencez dès maintenant avec l'un de nos régimes les plus demandés.</p>
        <div class="regimes-grid">
            <?php foreach ($featuredRegimes as $regime): ?>
                <div class="regime-card card">
                    <h3><?= esc($regime['nom_regime']) ?></h3>
                    <div class="regime-meta">
                        <?php
                            $variation = (float) ($regime['variation_mensuelle_kg'] ?? 0);
                            $typeLabel = $variation < 0 ? 'Perte de poids' : ($variation > 0 ? 'Prise de masse' : 'Maintien');
                            $typeBadge = $variation < 0 ? 'badge-success' : ($variation > 0 ? 'badge-warning' : 'badge-neutral');
                        ?>
                        <span class="badge <?= $typeBadge ?>"><?= $typeLabel ?></span>
                        <span class="badge badge-neutral"><?= esc($regime['pourcentage_viande']) ?>% viande</span>
                    </div>
                    <div class="regime-price">
                        <?php if (isset($regime['prix_min'])): ?>
                            <?= number_format((float) $regime['prix_min'], 0, ',', ' ') ?> Ar
                            <span>/ à partir de</span>
                        <?php else: ?>
                            <span>Tarifs disponibles</span>
                        <?php endif; ?>
                    </div>
                    <a href="<?= esc(site_url('register')) ?>" class="btn" style="margin-top: var(--space-4);">Commencer</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Testimonials ── -->
<section class="testimonials-section">
    <div class="testimonials-inner">
        <h2>Ce que disent nos utilisateurs</h2>
        <p>Des résultats concrets et des expériences positives.</p>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $t): ?>
                <div class="testimonial-card">
                    <p>"<?= esc($t['text']) ?>"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar"><?= esc($t['initials']) ?></div>
                        <div>
                            <strong><?= esc($t['name']) ?></strong>
                            <span><?= esc($t['role']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Final CTA ── -->
<section class="cta-section">
    <div class="cta-inner">
        <h2>Prêt à transformer votre alimentation ?</h2>
        <p>Rejoignez la communauté Projet Régime et commencez votre parcours vers une meilleure santé dès aujourd'hui.</p>
        <a href="<?= esc(site_url('register')) ?>" class="btn">Créer mon compte gratuitement</a>
    </div>
</section>



<script src="<?= base_url('assets/js/frontoffice.js') ?>"></script>
</body>
</html>
