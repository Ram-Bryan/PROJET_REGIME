<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Options<?= $this->endSection() ?>
<?= $this->section('head') ?>
    <style>
        .gold-shell {
            max-width: 980px;
            margin: 0 auto;
        }

        .gold-card {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(226, 232, 240, 0.9);
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 28%),
                linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
            padding: 26px;
            box-shadow: var(--shadow-md);
        }

        .gold-card.is-locked {
            opacity: 0.62;
            filter: saturate(0.7);
        }

        .gold-top {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: start;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .gold-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff7db;
            color: #9a6116;
            font-weight: 800;
        }

        .gold-badge img {
            width: 18px;
            height: 18px;
        }

        .gold-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin: 18px 0 22px;
        }

        .gold-spec {
            padding: 18px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.76);
            border: 1px solid var(--border);
        }

        .gold-spec-label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .gold-spec-value {
            margin-top: 10px;
            font-size: 26px;
            font-weight: 800;
        }

        .gold-note {
            padding: 14px 16px;
            border-radius: var(--radius-md);
            background: #fff7db;
            color: #9a6116;
            border: 1px solid #f2dfb0;
        }

        .gold-note.success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: #b6e7ca;
        }

        @media (max-width: 920px) {
            .gold-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="stack gold-shell">
    <div class="hero">
        <div class="page-header" style="position:relative; z-index:1;">
            <h1>Option Gold</h1>
            <p class="sub">Debloquez une reduction permanente sur vos achats de regimes une fois les conditions remplies.</p>
        </div>
    </div>

    <?php if ($gold === null): ?>
        <div class="card">
            <h2 style="margin:0 0 10px;">Gold indisponible</h2>
            <p class="sub">Aucune offre Gold n'est actuellement configuree par l'administration.</p>
        </div>
    <?php else: ?>
        <?php
            $isGold = ! empty($user['is_gold']);
            $locked = ! $isGold && ! $canUnlock;
            $insufficientBalance = ! $isGold && $canUnlock && ! $hasEnoughBalance;
        ?>
        <div class="gold-card<?= $locked ? ' is-locked' : '' ?>">
            <div class="gold-top">
                <div>
                    <div class="gold-badge">
                        <img src="<?= esc(base_url('assets/icons/crown.svg')) ?>" alt="">
                        <span><?= esc($gold['nom_option']) ?></span>
                    </div>
                    <h2 style="margin:16px 0 8px; font-size:34px;">Accedez a Gold en une seule fois</h2>
                    <p class="sub" style="max-width:70ch;">Une fois achetee, l'option Gold active votre reduction sur tous les prochains achats de regimes.</p>
                </div>
                <span class="badge <?= $isGold ? 'success' : 'neutral' ?>"><?= $isGold ? 'Deja active' : 'Option premium' ?></span>
            </div>

            <div class="gold-grid">
                <div class="gold-spec">
                    <div class="gold-spec-label">Prix unique</div>
                    <div class="gold-spec-value"><?= esc(number_format((float) $gold['prix_unique'], 2, ',', ' ')) ?> Ar</div>
                </div>
                <div class="gold-spec">
                    <div class="gold-spec-label">Reduction appliquee</div>
                    <div class="gold-spec-value">-<?= esc(rtrim(rtrim(number_format((float) $gold['reduction_pourcentage'], 2, ',', ' '), '0'), ',')) ?>%</div>
                </div>
                <div class="gold-spec">
                    <div class="gold-spec-label">Regimes necessaires</div>
                    <div class="gold-spec-value"><?= esc((string) $gold['nb_regimes_achetes']) ?></div>
                </div>
            </div>

            <?php if ($isGold): ?>
                <div class="gold-note success" style="margin-bottom:18px;">Votre compte possede deja Gold. Les reductions sont maintenant appliquees automatiquement.</div>
            <?php elseif ($locked): ?>
                <div class="gold-note" style="margin-bottom:18px;">
                    Vous devez acheter encore <?= esc((string) $remainingPurchases) ?> regime(s) pour pouvoir acceder au Gold.
                    Vous en avez deja achete <?= esc((string) $purchaseCount) ?> sur <?= esc((string) $requiredPurchases) ?>.
                </div>
            <?php elseif ($insufficientBalance): ?>
                <div class="gold-note" style="margin-bottom:18px;">Vous avez debloque l'acces a Gold, mais votre solde actuel ne suffit pas encore pour l'acheter.</div>
            <?php else: ?>
                <div class="gold-note success" style="margin-bottom:18px;">Toutes les conditions sont remplies. Vous pouvez maintenant acheter Gold.</div>
            <?php endif; ?>

            <form action="<?= site_url('options/gold/buy/' . $gold['id_option']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="actions" style="margin-top:0;">
                    <button type="submit" class="btn" <?= ($locked || $insufficientBalance || $isGold) ? 'disabled' : '' ?>>Acheter Gold</button>
                    <a href="<?= site_url('regimes') ?>" class="btn btn-secondary">Voir les regimes</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>
