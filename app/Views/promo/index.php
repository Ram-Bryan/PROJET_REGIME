<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Code promo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:720px; margin:0 auto;">
    <div class="section-title">
        <div>
            <h2>Ajouter un code promo</h2>
            <p class="sub">Votre solde actuel : <strong><?= esc((string) $argent) ?> Ar</strong></p>
        </div>
        <span class="badge badge-warning">Achat immédiat</span>
    </div>

    <div class="hero" style="margin-bottom:20px; padding:20px 22px; border-radius: var(--radius-md); box-shadow:none;">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1 style="font-size:26px;">Réduisez votre solde intelligent</h1>
            <p class="sub">Saisissez votre code promo et laissez le système recalculer votre balance en temps réel après validation serveur.</p>
        </div>
    </div>

    <form method="POST" action="<?= site_url('/promo') ?>" class="stack" data-ajax-form="true">
        <?= csrf_field() ?>
        <div class="form-feedback" data-form-feedback></div>
        <div>
            <label for="code_promo">Code promo</label>
            <input type="text" id="code_promo" name="code_promo" minlength="3" maxlength="30" style="text-transform: uppercase;" value="<?= esc(old('code_promo')) ?>" required>
            <p class="field-hint">Exemple: WELCOME2026</p>
            <div class="field-error" data-field-error="code_promo"></div>
        </div>
        <div class="actions">
            <button type="submit" class="btn">Valider le code</button>
            <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Retour au dashboard</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
