<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Etape 1<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $p = is_array($personal ?? null) ? $personal : []; ?>
<section class="card auth-shell" style="max-width:920px; margin: 0 auto; padding: 0; overflow:hidden;">
    <div style="padding:24px 28px; border-bottom:1px solid var(--border); background:#fff;">
        <div style="display:flex; justify-content:space-between; font-size:12px; color:var(--muted); margin-bottom:8px;">
            <span>Etape 1/3</span><span>Informations personnelles</span>
        </div>
        <div style="height:8px; background:#e2e8f0; border-radius:999px; overflow:hidden;"><div style="height:100%; width:33.33%; background:linear-gradient(90deg,#2563eb,#60a5fa);"></div></div>
    </div>
    <div class="auth-grid" style="display:grid; grid-template-columns: 1fr 1fr; min-height:100%;">
        <div style="padding:28px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.96), rgba(96, 165, 250, 0.74)); color:#fff;">
            <h1 style="margin:0 0 8px;">Creer un compte</h1>
            <p class="sub" style="color: rgba(255,255,255,0.84);">Champs obligatoires: nom, email, mot de passe.</p>
        </div>
        <div style="padding:28px;">
            <form action="<?= site_url('/register') ?>" method="post" class="stack" data-ajax-form="true" id="register-personal-form">
                <?= csrf_field() ?>
                <div class="form-feedback" data-form-feedback></div>

                <div class="field-wrap">
                    <label for="nom">Nom complet <span style="color:#b42318;">*</span></label>
                    <input type="text" id="nom" name="nom" minlength="2" maxlength="100" placeholder="Ex: Jean Rakoto" value="<?= esc(old('nom', $p['nom'] ?? '')) ?>" required>
                    <span class="field-icon" data-icon="nom"></span>
                    <div class="field-error" data-field-error="nom"></div>
                </div>

                <div class="field-wrap">
                    <label>Genre</label>
                    <div class="radio-group">
                        <?php $genre = old('genre', $p['genre'] ?? 'Autre'); ?>
                        <label class="radio-item"><input type="radio" name="genre" value="Homme" <?= $genre === 'Homme' ? 'checked' : '' ?>>Homme</label>
                        <label class="radio-item"><input type="radio" name="genre" value="Femme" <?= $genre === 'Femme' ? 'checked' : '' ?>>Femme</label>
                        <label class="radio-item"><input type="radio" name="genre" value="Autre" <?= $genre === 'Autre' ? 'checked' : '' ?>>Autre</label>
                    </div>
                    <div class="field-error" data-field-error="genre"></div>
                </div>

                <div class="field-wrap">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= esc(old('date_naissance', $p['date_naissance'] ?? '')) ?>">
                    <span class="field-icon" data-icon="date_naissance"></span>
                    <div class="field-error" data-field-error="date_naissance"></div>
                </div>

                <div class="field-wrap">
                    <label for="email">Email <span style="color:#b42318;">*</span></label>
                    <input type="email" id="email" name="email" maxlength="120" placeholder="Ex: jean@email.com" value="<?= esc(old('email', $p['email'] ?? '')) ?>" required>
                    <span class="field-icon" data-icon="email"></span>
                    <div class="field-error" data-field-error="email"></div>
                </div>

                <div class="field-wrap">
                    <label for="mot_de_passe">Mot de passe <span style="color:#b42318;">*</span></label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" maxlength="72" placeholder="8+ caracteres, 1 majuscule, 1 chiffre" value="<?= esc(old('mot_de_passe', $p['mot_de_passe'] ?? '')) ?>" required>
                    <button type="button" class="eye-btn" id="toggle-password"><img src="<?= base_url('assets/icons/eye.svg') ?>" alt="Voir"></button>
                    <span class="field-icon" data-icon="mot_de_passe"></span>
                    <div class="field-hint" id="password-strength">Force: -</div>
                    <div class="field-error" data-field-error="mot_de_passe"></div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Continuer</button>
                    <a href="<?= site_url('/login') ?>" class="btn btn-secondary">Deja un compte</a>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
.field-wrap { position:relative; }
.field-wrap input { padding-right:64px; }
.field-icon { position:absolute; right:14px; top:40px; width:16px; height:16px; background-repeat:no-repeat; background-size:16px; }
.field-icon.ok { background-image:url('<?= base_url('assets/icons/check.svg') ?>'); }
.field-icon.err { background-image:url('<?= base_url('assets/icons/x.svg') ?>'); }
.is-valid { border-color:#12b76a !important; box-shadow:0 0 0 4px rgba(18,183,106,.12) !important; }
.eye-btn { position:absolute; right:34px; top:35px; width:28px; height:28px; border:none; background:transparent; cursor:pointer; padding:0; }
.eye-btn img { width:18px; height:18px; opacity:.75; }
@media (max-width: 800px) { .auth-grid { grid-template-columns: 1fr !important; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
    const form = document.getElementById('register-personal-form');
    if (!form) return;
    const emailInput = form.querySelector('#email');
    const passwordInput = form.querySelector('#mot_de_passe');

    const setFieldState = (name, ok, message = '') => {
        const input = form.querySelector(`[name="${name}"]`);
        const icon = form.querySelector(`[data-icon="${name}"]`);
        const err = form.querySelector(`[data-field-error="${name}"]`);
        if (!input || !icon || !err) return;
        if (String(input.value || '').trim() === '') { icon.className = 'field-icon'; input.classList.remove('is-invalid','is-valid'); err.textContent = ''; return; }
        icon.className = `field-icon ${ok ? 'ok' : 'err'}`;
        input.classList.toggle('is-invalid', !ok); input.classList.toggle('is-valid', !!ok);
        err.textContent = ok ? '' : message;
    };

    form.querySelector('#nom').addEventListener('blur', (e) => {
        const v = e.target.value.trim();
        setFieldState('nom', v.length >= 2 && v.length <= 100, 'Le nom doit contenir entre 2 et 100 caracteres.');
    });

    form.querySelector('#date_naissance').addEventListener('blur', (e) => {
        const v = e.target.value;
        setFieldState('date_naissance', v === '' || /^\d{4}-\d{2}-\d{2}$/.test(v), 'Date invalide.');
    });

    emailInput.addEventListener('blur', async () => {
        const v = emailInput.value.trim();
        if (!v) return setFieldState('email', false, 'Email requis. Exemple: jean@gmail.com');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return setFieldState('email', false, 'Format invalide. Exemple: jean@gmail.com');
        try {
            const res = await fetch('<?= site_url('/register/check-email') ?>', {method:'POST', headers:{'X-Requested-With':'XMLHttpRequest'}, body:new URLSearchParams({email:v})});
            const data = await res.json();
            setFieldState('email', !!data.available, data.message || 'Email indisponible.');
        } catch (_) { setFieldState('email', false, 'Verification impossible. Reessayez.'); }
    });

    const updateStrength = () => {
        const v = passwordInput.value;
        const ok = v.length >= 8 && /[A-Z]/.test(v) && /\d/.test(v);
        const score = [v.length >= 8, /[A-Z]/.test(v), /\d/.test(v)].filter(Boolean).length;
        document.getElementById('password-strength').textContent = `Force: ${['Faible','Moyenne','Bonne','Forte'][score]}`;
        setFieldState('mot_de_passe', ok, 'Le mot de passe doit contenir au moins 8 caracteres, une majuscule et un chiffre.');
    };
    passwordInput.addEventListener('input', updateStrength);
    passwordInput.addEventListener('blur', updateStrength);

    const btn = document.getElementById('toggle-password');
    btn.addEventListener('click', () => {
        const hidden = passwordInput.type === 'password';
        passwordInput.type = hidden ? 'text' : 'password';
        btn.querySelector('img').src = hidden ? '<?= base_url('assets/icons/eye-off.svg') ?>' : '<?= base_url('assets/icons/eye.svg') ?>';
    });
})();
</script>
<?= $this->endSection() ?>
