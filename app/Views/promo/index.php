<?= $this->extend('layouts/main') ?>

<?php
    $statusStyles = [
        'en_attente' => ['label' => 'En attente', 'bg' => 'var(--warning-bg)', 'color' => 'var(--warning-text)'],
        'accepte' => ['label' => 'Accepte', 'bg' => 'var(--success-bg)', 'color' => 'var(--success-text)'],
        'refuse' => ['label' => 'Refuse', 'bg' => 'var(--error-bg)', 'color' => 'var(--error-text)'],
    ];
?>

<?= $this->section('title') ?>Code promo<?= $this->endSection() ?>
<?= $this->section('head') ?>
    <style>
        .promo-kicker {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--warning-bg);
            color: var(--warning-text);
            font-size: 13px;
            font-weight: 800;
        }

        .history-list {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.8);
        }

        .history-item strong {
            letter-spacing: 0.04em;
        }

        .history-meta {
            color: var(--muted);
            font-size: 13px;
        }

        .history-status {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        @media (max-width: 720px) {
            .history-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="card" style="max-width:760px; margin:0 auto;">
    <div class="section-title">
        <div>
            <h2>Ajouter un code promo</h2>
            <p class="sub">Votre solde actuel : <strong><?= esc(number_format((float) $argent, 2, ',', ' ')) ?> Ar</strong></p>
        </div>
        <span class="promo-kicker">Validation admin</span>
    </div>

    <div class="hero" style="margin-bottom:20px; padding:20px 22px; border-radius: var(--radius-md); box-shadow:none;">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1 style="font-size:26px;">Envoyez votre code promo</h1>
            <p class="sub">Votre demande sera transmise au backoffice pour verification. Si le code a deja ete utilise, le systeme vous le signalera tout de suite.</p>
        </div>
    </div>

    <form method="POST" action="<?= site_url('/promo') ?>" class="stack" data-ajax-form="true">
        <?= csrf_field() ?>
        <div class="form-feedback" data-form-feedback></div>
        <div>
            <label for="code_promo">Code promo</label>
            <input type="text" id="code_promo" name="code_promo" minlength="3" maxlength="30" style="text-transform: uppercase;" value="<?= esc(old('code_promo')) ?>" required>
            <p class="field-hint">Le code est envoye pour verification, meme s'il n'existe pas encore dans la base.</p>
            <div class="field-error" data-field-error="code_promo"></div>
        </div>
        <div class="actions">
            <button type="submit" class="btn">Envoyer la demande</button>
            <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary">Retour au dashboard</a>
        </div>
    </form>

    <?php if (! empty($demandes)): ?>
        <div style="margin-top:24px;">
            <div class="section-title">
                <div>
                    <h2>Mes demandes recentes</h2>
                    <p class="sub">Suivez l'etat des codes deja envoyes a l'administration.</p>
                </div>
            </div>

            <div class="history-list">
                <?php foreach ($demandes as $demande): ?>
                    <?php $status = $statusStyles[$demande['statut'] ?? 'en_attente'] ?? $statusStyles['en_attente']; ?>
                    <div class="history-item">
                        <div>
                            <strong><?= esc($demande['code_saisi'] ?? '') ?></strong>
                            <div class="history-meta">
                                Envoyee le <?= esc((string) ($demande['date_demande'] ?? '')) ?>
                            </div>
                        </div>
                        <span class="history-status" style="background: <?= esc($status['bg']) ?>; color: <?= esc($status['color']) ?>;">
                            <?= esc($status['label']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>
