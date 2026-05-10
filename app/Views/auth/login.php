<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Connexion<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card auth-shell" style="max-width:640px; margin: 0 auto; padding: 0; overflow: hidden;">
    <div class="auth-grid" style="display:grid; grid-template-columns: 1.1fr 0.9fr; min-height: 100%;">
        <div style="padding: 28px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.96), rgba(59, 130, 246, 0.78)); color:#fff; display:flex; flex-direction:column; justify-content:space-between; gap:24px;">
            <div>
                <div class="badge" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.18);">Espace membre</div>
                <div class="page-header" style="margin-top: 18px;">
                    <h1>Connexion</h1>
                    <p class="sub" style="color: rgba(255,255,255,0.84);">Accédez à votre espace personnel, vos régimes et votre suivi en quelques secondes.</p>
                </div>
            </div>
            <div class="sub" style="color: rgba(255,255,255,0.78);">Connexion sécurisée • expérience mobile propre • accès rapide aux actions clés</div>
        </div>

        <div style="padding: 28px;">
            <form action="<?= site_url('/login') ?>" method="post" class="stack" data-ajax-form="true">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" maxlength="120" autocomplete="email" placeholder="Ex: jean@gmail.com" value="<?= esc(old('email')) ?>" required>
                    <div class="field-error" data-field-error="email"></div>
                </div>

                <div class="field-wrap">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" autocomplete="current-password" required>
                    <button type="button" class="eye-btn" id="toggle-login-password"><img src="<?= base_url('assets/icons/eye.svg') ?>" alt="Voir"></button>
                    <div class="field-error" data-field-error="mot_de_passe"></div>
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>

            <p style="margin-top: 14px;">Pas encore de compte ? <a href="<?= site_url('/register') ?>">Créer un compte</a></p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
.field-wrap { position: relative; }
.field-wrap input { padding-right: 50px; }
.eye-btn { position:absolute; right:12px; top:34px; width:28px; height:28px; border:none; background:transparent; cursor:pointer; padding:0; }
.eye-btn img { width:18px; height:18px; opacity:.75; }
@media (max-width: 800px) {
  .auth-grid { grid-template-columns: 1fr !important; }
  .auth-shell .badge { font-size: 11px; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
  const input = document.getElementById('mot_de_passe');
  const btn = document.getElementById('toggle-login-password');
  if (!input || !btn) return;
  btn.addEventListener('click', () => {
    const hidden = input.type === 'password';
    input.type = hidden ? 'text' : 'password';
    btn.querySelector('img').src = hidden ? '<?= base_url('assets/icons/eye-off.svg') ?>' : '<?= base_url('assets/icons/eye.svg') ?>';
  });
})();
</script>
<?= $this->endSection() ?>

