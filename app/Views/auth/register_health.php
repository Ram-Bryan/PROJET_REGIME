<?= $this->extend('frontoffice/layout') ?>

<?= $this->section('title') ?>Inscription - Etapes 2 et 3<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card auth-shell">
    <div class="auth-progress">
        <div class="auth-progress-meta"><span id="step-indicator">Etape 2/3</span><span id="step-title">Informations sante</span></div>
        <div class="auth-progress-bar"><div id="step-progress" class="auth-progress-fill" style="width:66.66%;"></div></div>
    </div>

    <div class="auth-form-panel">
        <form action="<?= site_url('/register/health') ?>" method="post" class="stack" data-ajax-form="true" id="register-health-form" data-imc-preview-url="<?= site_url('/register/imc-preview') ?>">
            <?= csrf_field() ?>
            <div class="form-feedback" data-form-feedback></div>

            <div id="step-2">
                <div class="grid">
                    <div class="field-wrap"><label for="taille_cm">Taille (cm) <span style="color:#b42318;">*</span></label><input type="number" step="0.01" min="50" max="260" id="taille_cm" name="taille_cm" placeholder="Ex: 175" value="<?= esc(old('taille_cm')) ?>" required><span class="field-icon" data-icon="taille_cm"></span><div class="field-error" data-field-error="taille_cm"></div></div>
                    <div class="field-wrap"><label for="poids_kg">Poids actuel (kg) <span style="color:#b42318;">*</span></label><input type="number" step="0.01" min="20" max="350" id="poids_kg" name="poids_kg" placeholder="Ex: 72" value="<?= esc(old('poids_kg')) ?>" required><span class="field-icon" data-icon="poids_kg"></span><div class="field-error" data-field-error="poids_kg"></div></div>
                </div>

                <div class="card" style="background:#f8fafc;">
                    <div><strong>IMC actuel:</strong> <span id="imc-value">-</span> (<span id="imc-label">-</span>)</div>
                    <div style="height:12px; margin-top:10px; background:#e2e8f0; border-radius:999px; overflow:hidden;"><div id="imc-pointer" style="height:100%; width:0%; background:#f59e0b;"></div></div>
                    <div id="imc-ideal-message" class="field-hint" style="display:none; color:#475467; margin-top:8px;">Vous etes deja dans l'IMC ideal.</div>
                </div>

                <div id="objectif-section">
                    <label>Objectif (choix manuel) <span style="color:#b42318;">*</span></label>
                    <div class="radio-group" id="objectif-group">
                        <?php foreach ($objectifs as $objectif): ?>
                            <label class="radio-item" data-objectif-label="<?= esc(strtolower($objectif['label_objectif'])) ?>"><input type="radio" name="id_objectif" value="<?= esc($objectif['id_objectif']) ?>" <?= old('id_objectif') == $objectif['id_objectif'] ? 'checked' : '' ?>><?= esc($objectif['label_objectif']) ?></label>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-error" data-field-error="id_objectif"></div>
                </div>

                <div id="poids-objectif-wrap" class="field-wrap" style="display:none;"><label for="poids_objectif">Poids cible (kg) <span style="color:#b42318;">*</span></label><input type="number" step="0.01" min="20" max="350" id="poids_objectif" name="poids_objectif" placeholder="Ex: 65" value="<?= esc(old('poids_objectif')) ?>"><span class="field-icon" data-icon="poids_objectif"></span><div class="field-error" data-field-error="poids_objectif"></div></div>
                <div class="actions"><button type="button" class="btn" id="to-recap">Voir recapitulatif</button><a href="<?= site_url('/register') ?>" class="btn btn-secondary">Retour etape 1</a></div>
            </div>

            <div id="step-3" style="display:none;">
                <h2 style="margin:0 0 12px;">Recapitulatif</h2>
                <div class="recap-grid">
                    <div class="recap-item"><img src="<?= base_url('assets/icons/ruler.svg') ?>" alt=""><span>Taille</span><strong id="r-taille">-</strong></div>
                    <div class="recap-item"><img src="<?= base_url('assets/icons/weight.svg') ?>" alt=""><span>Poids</span><strong id="r-poids">-</strong></div>
                    <div class="recap-item"><img src="<?= base_url('assets/icons/activity.svg') ?>" alt=""><span>IMC</span><strong id="r-imc">-</strong></div>
                    <div class="recap-item"><img src="<?= base_url('assets/icons/target.svg') ?>" alt=""><span>Objectif</span><strong id="r-objectif">-</strong></div>
                    <div class="recap-item"><img src="<?= base_url('assets/icons/weight-tilde.svg') ?>" alt=""><span>Poids cible</span><strong id="r-poids-objectif">-</strong></div>
                </div>
                <div class="actions"><button type="submit" class="btn">Creer mon compte</button><button type="button" class="btn btn-secondary" id="back-to-health">Retour etape 2</button></div>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/auth.js') ?>"></script>
<?= $this->endSection() ?>
