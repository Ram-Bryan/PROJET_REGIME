<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Code promo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:560px; margin:0 auto;">
    <div class="page-header" style="margin-bottom:14px;">
        <h1>Ajouter un code promo</h1>
        <p class="sub">Votre solde actuel : <strong><?= esc((string) $argent) ?> Ar</strong></p>
    </div>

    <form method="POST" action="<?= site_url('/promo') ?>" class="stack">
        <?= csrf_field() ?>
        <div>
            <label for="code_promo">Code promo</label>
            <input type="text" id="code_promo" name="code_promo" minlength="3" maxlength="30" style="text-transform: uppercase;" value="<?= esc(old('code_promo')) ?>" required>
            <p class="field-hint">Exemple: WELCOME2026</p>
        </div>
        <button type="submit" class="btn">Valider le code</button>
    </form>

    <div class="actions">
        <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Retour au dashboard</a>
    </div>
</section>
<?= $this->endSection() ?>
