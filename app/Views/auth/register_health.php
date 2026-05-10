<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription - Etapes 2 et 3<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card auth-shell" style="max-width:980px; margin: 0 auto; padding: 0; overflow:hidden;">
    <div style="padding:24px 28px; border-bottom:1px solid var(--border); background:#fff;">
        <div style="display:flex; justify-content:space-between; font-size:12px; color:var(--muted); margin-bottom:8px;"><span id="step-indicator">Etape 2/3</span><span id="step-title">Informations sante</span></div>
        <div style="height:8px; background:#e2e8f0; border-radius:999px; overflow:hidden;"><div id="step-progress" style="height:100%; width:66.66%; background:linear-gradient(90deg,#2563eb,#60a5fa);"></div></div>
    </div>

    <div style="padding:28px;">
        <form action="<?= site_url('/register/health') ?>" method="post" class="stack" data-ajax-form="true" id="register-health-form">
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

<?= $this->section('head') ?>
<style>
.field-wrap{position:relative}.field-wrap input{padding-right:36px}.field-icon{position:absolute;right:12px;top:40px;width:16px;height:16px;background-size:16px;background-repeat:no-repeat}.field-icon.ok{background-image:url('<?= base_url('assets/icons/check.svg') ?>')}.field-icon.err{background-image:url('<?= base_url('assets/icons/x.svg') ?>')}
.is-valid{border-color:#12b76a!important;box-shadow:0 0 0 4px rgba(18,183,106,.12)!important}
#imc-pointer{transition:width .45s ease, background-color .45s ease}
.radio-item.is-disabled{opacity:.45;background:#f2f4f7;cursor:not-allowed;}
.invalid-section{border:1px solid #fda29b !important; background:#fff1f2 !important; border-radius:12px; padding:10px;}
.recap-grid{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));background:linear-gradient(180deg,#f8fbff,#eef4ff);padding:14px;border:1px solid #dbe7ff;border-radius:14px}
.recap-item{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:10px;display:grid;gap:4px;justify-items:start}
.recap-item img{width:18px;height:18px;opacity:.85}
.recap-item span{font-size:12px;color:#475467}.recap-item strong{font-size:14px}
@media (max-width: 800px) {
  .auth-shell { border-radius: 14px; }
  .recap-grid { grid-template-columns: 1fr; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
const form=document.getElementById('register-health-form'); if(!form) return;
const step2=document.getElementById('step-2'), step3=document.getElementById('step-3');
const stepIndicator=document.getElementById('step-indicator'), stepTitle=document.getElementById('step-title'), stepProgress=document.getElementById('step-progress');
const taille=form.querySelector('#taille_cm'), poids=form.querySelector('#poids_kg'), poidsObjectif=form.querySelector('#poids_objectif');
const objectifRadios=()=>Array.from(form.querySelectorAll('input[name="id_objectif"]')); const poidsWrap=document.getElementById('poids-objectif-wrap');
let currentImc=null,currentImcLabel=null;
const setFieldState=(name,ok,message='')=>{const input=form.querySelector(`[name="${name}"]`),icon=form.querySelector(`[data-icon="${name}"]`),err=form.querySelector(`[data-field-error="${name}"]`); if(!input||!icon||!err)return; if(String(input.value||'').trim()===''){icon.className='field-icon';input.classList.remove('is-invalid','is-valid');err.textContent='';return;} icon.className=`field-icon ${ok?'ok':'err'}`; input.classList.toggle('is-invalid',!ok); input.classList.toggle('is-valid',!!ok); err.textContent=ok?'':message;};
const selectedObjectif=()=>objectifRadios().find(r=>r.checked)||null;
const requiresTarget=()=>{const s=selectedObjectif(); if(!s) return false; const l=s.closest('label').innerText.toLowerCase(); return l.includes('perte')||l.includes('prise');};
const validatePoidsObjectif=()=>{if(!requiresTarget()) return true; const p=parseFloat(poids.value||'0'), o=parseFloat(poidsObjectif.value||'0'); const l=selectedObjectif()?.closest('label').innerText.toLowerCase()||''; if(!o||o<=0){setFieldState('poids_objectif',false,'Poids cible requis.');return false;} if(l.includes('perte')&&o>=p){setFieldState('poids_objectif',false,'Le poids cible doit etre inferieur au poids actuel.');return false;} if(l.includes('prise')&&o<=p){setFieldState('poids_objectif',false,'Le poids cible doit etre superieur au poids actuel.');return false;} setFieldState('poids_objectif',true); return true;};
const toggleTarget=()=>{const show=requiresTarget(); poidsWrap.style.display=show?'block':'none'; poidsObjectif.required=show; if(!show){poidsObjectif.value=''; setFieldState('poids_objectif',true);}};
let imcTimer=null;
const computeImc=async()=>{const t=parseFloat(taille.value||'0'), p=parseFloat(poids.value||'0'); if(!(t>0&&p>0)) return; try {const res=await fetch('<?= site_url('/register/imc-preview') ?>',{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest'},body:new URLSearchParams({taille_cm:String(t),poids_kg:String(p)})}); const data=await res.json(); if(!data.success) return; currentImc=data.imc; currentImcLabel=data.label||'-'; document.getElementById('imc-value').textContent=String(data.imc); document.getElementById('imc-label').textContent=currentImcLabel; const percent=Math.max(0,Math.min(100,(Number(data.imc)/40)*100)); const ptr=document.getElementById('imc-pointer'); ptr.style.width=`${percent}%`; ptr.style.backgroundColor=data.is_ideal?'#12b76a':(Number(data.imc)<18.5?'#f59e0b':'#ef4444'); const msg=document.getElementById('imc-ideal-message'); msg.style.display=data.is_ideal?'block':'none'; objectifRadios().forEach((r)=>{const isIdeal=r.closest('label').dataset.objectifLabel.includes('ideal'); if(!isIdeal) return; r.disabled=!!data.is_ideal; r.closest('label').classList.toggle('is-disabled',!!data.is_ideal); if(data.is_ideal && r.checked) r.checked=false;}); toggleTarget(); } catch(_) {}};
const scheduleImc=()=>{clearTimeout(imcTimer); imcTimer=setTimeout(computeImc,180);};
['input','blur'].forEach(evt=>{taille.addEventListener(evt,()=>{const v=parseFloat(taille.value||'0'); setFieldState('taille_cm',v>=50&&v<=260,'Entrez une taille valide (ex: 175).'); scheduleImc();}); poids.addEventListener(evt,()=>{const v=parseFloat(poids.value||'0'); setFieldState('poids_kg',v>=20&&v<=350,'Entrez un poids valide (ex: 72).'); scheduleImc();});});
poidsObjectif.addEventListener('blur',validatePoidsObjectif); objectifRadios().forEach(r=>r.addEventListener('change',()=>{toggleTarget();validatePoidsObjectif();}));
document.getElementById('to-recap').addEventListener('click',()=>{let ok=true; const objectifSection=document.getElementById('objectif-section'); const t=parseFloat(taille.value||'0'), p=parseFloat(poids.value||'0'); if(!(t>=50&&t<=260)){setFieldState('taille_cm',false,'Entrez une taille valide (ex: 175).');ok=false;} if(!(p>=20&&p<=350)){setFieldState('poids_kg',false,'Entrez un poids valide (ex: 72).');ok=false;} if(!selectedObjectif()){form.querySelector('[data-field-error="id_objectif"]').textContent='Choisissez un objectif.'; objectifSection.classList.add('invalid-section'); ok=false;} else {form.querySelector('[data-field-error="id_objectif"]').textContent=''; objectifSection.classList.remove('invalid-section');} const targetOk=validatePoidsObjectif(); if(!targetOk) ok=false; poidsWrap.classList.toggle('invalid-section', !!requiresTarget() && !targetOk); if(!ok) return; document.getElementById('r-taille').textContent=`${taille.value} cm`; document.getElementById('r-poids').textContent=`${poids.value} kg`; document.getElementById('r-imc').textContent=currentImc?`${currentImc} (${currentImcLabel||'-'})`:'-'; document.getElementById('r-objectif').textContent=selectedObjectif()?.closest('label').innerText.trim()||'-'; document.getElementById('r-poids-objectif').textContent=poidsObjectif.value?`${poidsObjectif.value} kg`:'Non renseigne'; step2.style.display='none'; step3.style.display='block'; stepIndicator.textContent='Etape 3/3'; stepTitle.textContent='Recapitulatif'; stepProgress.style.width='100%';});
document.getElementById('back-to-health').addEventListener('click',()=>{step3.style.display='none'; step2.style.display='block'; stepIndicator.textContent='Etape 2/3'; stepTitle.textContent='Informations sante'; stepProgress.style.width='66.66%';});
toggleTarget();
})();
</script>
<?= $this->endSection() ?>
