<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?: 'Projet Régime' ?></title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4f7fb;
            --bg-soft: #eef3ff;
            --surface: rgba(255, 255, 255, 0.88);
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --border-strong: #cbd5e1;
            --primary: #2563eb;
            --primary-strong: #1d4ed8;
            --primary-weak: #dbeafe;
            --success-bg: #ecfdf3;
            --success-text: #027a48;
            --error-bg: #fef2f2;
            --error-text: #b42318;
            --warning-bg: #fffbeb;
            --warning-text: #b45309;
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 10px 30px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 40px rgba(15, 23, 42, 0.12);
            --space-1: 4px;
            --space-2: 8px;
            --space-3: 12px;
            --space-4: 16px;
            --space-5: 20px;
            --space-6: 24px;
            --space-8: 32px;
            --space-10: 40px;
            --space-12: 48px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 30%),
                radial-gradient(circle at top right, rgba(56, 189, 248, 0.08), transparent 26%),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
            color: var(--text);
            line-height: 1.5;
            min-height: 100vh;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-inner {
            max-width: 1180px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            letter-spacing: 0.02em;
            font-size: 15px;
            color: var(--text);
            text-decoration: none;
            white-space: nowrap;
        }

        .brand::before {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary), #60a5fa);
            box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.12);
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .nav a {
            text-decoration: none;
            color: #334155;
            padding: 9px 13px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.18s ease;
        }

        .nav a:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: var(--border);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .nav a.active {
            background: var(--primary-weak);
            color: var(--primary);
            border-color: #bfd4ff;
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.06);
        }

        .shell {
            max-width: 1180px;
            margin: 32px auto 56px;
            padding: 0 20px;
        }

        .page-header {
            display: grid;
            gap: var(--space-2);
        }

        .page-header h1 {
            margin: 0;
            font-size: clamp(28px, 2.7vw, 40px);
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        .sub {
            color: var(--muted);
            margin: 0;
            font-size: 14px;
        }

        .stack { display: grid; gap: var(--space-4); }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 28px 28px 24px;
            background:
                linear-gradient(135deg, rgba(37, 99, 235, 0.96), rgba(59, 130, 246, 0.82)),
                linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0));
            color: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .hero::after {
            content: '';
            position: absolute;
            right: -80px;
            top: -80px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(30px, 3vw, 44px);
            line-height: 1.05;
            letter-spacing: -0.04em;
        }

        .hero .sub {
            color: rgba(255, 255, 255, 0.88);
            margin-top: 10px;
            max-width: 66ch;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .hero .btn {
            box-shadow: none;
            border-color: rgba(255,255,255,0.2);
        }

        .hero .btn-secondary {
            color: #fff;
            background: rgba(255,255,255,0.14);
            border-color: rgba(255,255,255,0.2);
        }

        .hero .btn-secondary:hover {
            background: rgba(255,255,255,0.22);
            color: #fff;
        }

        .section-title {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .section-title h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: -0.02em;
        }

        .section-title .sub {
            font-size: 13px;
        }

        .metric-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .metric-card {
            padding: 18px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.86);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: var(--shadow-sm);
        }

        .metric-label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 700;
        }

        .metric-value {
            margin-top: 8px;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text);
        }

        .metric-value.small {
            font-size: 15px;
            font-weight: 700;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-lg);
        }

        .table-wrap table {
            min-width: 760px;
        }

        .card {
            background: var(--surface);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            box-shadow: var(--shadow-md);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border-strong);
        }

        .grid {
            display: grid;
            gap: var(--space-4);
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
            font-weight: 600;
        }

        input, select, button {
            font: inherit;
        }

        input, select {
            width: 100%;
            padding: 11px 13px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 14px;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #9db4ff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14);
            transform: translateY(-1px);
        }

        .radio-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            overflow-x: auto;
        }

        .radio-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
            min-height: 38px;
            padding: 9px 14px 9px 12px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: #fff;
            cursor: pointer;
            transition: border-color .2s ease, background .2s ease, color .2s ease, box-shadow .2s ease;
            user-select: none;
            white-space: nowrap;
        }

        input[type="radio"].control-radio,
        .radio-item input[type="radio"],
        .option-card input[type="radio"] {
            appearance: none;
            width: 18px;
            height: 18px;
            min-width: 18px;
            margin: 0;
            padding: 0;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            background: #fff;
            display: grid;
            place-content: center;
            flex: 0 0 auto;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }

        input[type="radio"].control-radio::before,
        .radio-item input[type="radio"]::before,
        .option-card input[type="radio"]::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            transform: scale(0);
            transition: transform .2s ease;
        }

        .radio-item:hover {
            border-color: #94a3b8;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
        }

        .radio-item:has(input[type="radio"]:checked) {
            border-color: var(--primary);
            background: #eff6ff;
            color: var(--primary);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .12);
        }

        input[type="radio"].control-radio:checked,
        .radio-item input[type="radio"]:checked,
        .option-card input[type="radio"]:checked {
            border-color: var(--primary);
            background: var(--primary);
        }

        input[type="radio"].control-radio:checked::before,
        .radio-item input[type="radio"]:checked::before,
        .option-card input[type="radio"]:checked::before {
            transform: scale(1);
        }

        input[type="radio"].control-radio:focus-visible,
        .radio-item input[type="radio"]:focus-visible,
        .option-card input[type="radio"]:focus-visible {
            outline: 3px solid rgba(37, 99, 235, .22);
            outline-offset: 2px;
        }

        .field-hint {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--primary);
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
            transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            background: var(--primary-strong);
            border-color: var(--primary-strong);
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(29, 78, 216, 0.2);
        }

        .btn-secondary {
            background: #fff;
            color: var(--primary);
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: #f8fbff;
            color: var(--primary-strong);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
        }

        .form-feedback {
            display: none;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
        }

        .form-feedback.is-visible {
            display: block;
        }

        .form-feedback.success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: #abefc6;
        }

        .form-feedback.error {
            background: var(--error-bg);
            color: var(--error-text);
            border-color: #fecdca;
            border-left: 4px solid #f04438;
            font-weight: 600;
        }
        .confirm-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(2, 6, 23, .55);
            backdrop-filter: blur(4px);
            z-index: 1000;
            padding: 16px;
        }
        .confirm-modal.open { display: flex; }
        .confirm-card {
            width: min(460px, 100%);
            border-radius: 16px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: confirmIn .18s ease-out;
        }
        .confirm-head {
            padding: 16px 18px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, #f8fbff, #fff);
        }
        .confirm-head img { width: 18px; height: 18px; }
        .confirm-body { padding: 16px 18px; color: #334155; }
        .confirm-actions { padding: 14px 18px; display: flex; gap: 10px; justify-content: flex-end; }
        @keyframes confirmIn { from { transform: translateY(10px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .field-error {
            min-height: 16px;
            margin-top: 6px;
            font-size: 12px;
            color: var(--error-text);
        }

        .is-invalid {
            border-color: var(--error-text) !important;
            box-shadow: 0 0 0 4px rgba(180, 35, 24, 0.10) !important;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: #abefc6;
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border-color: #fecdca;
        }

        .empty {
            text-align: center;
            color: var(--muted);
            padding: 32px 16px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--primary-weak);
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
        }

        .badge-success {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .badge-warning {
            background: var(--warning-bg);
            color: var(--warning-text);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-weight: 600;
        }

        tr:last-child td { border-bottom: none; }

        a {
            color: var(--primary-strong);
        }

        a:hover {
            color: var(--primary);
        }

        .kv-title {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .kv-value {
            font-size: 16px;
            font-weight: 700;
        }

        .surface {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        @media (max-width: 720px) {
            .topbar-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav {
                width: 100%;
            }

            .nav a {
                padding: 8px 10px;
            }

            .shell {
                margin-top: 22px;
                margin-bottom: 36px;
                padding: 0 16px;
            }

            .card {
                padding: 18px;
            }
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body>
<?php
    $isLoggedIn = (bool) session()->get('is_logged_in');
    $path = trim(uri_string(), '/');
    $isActive = static function (array $prefixes) use ($path): bool {
        foreach ($prefixes as $prefix) {
            if ($prefix === '' && $path === '') {
                return true;
            }
            if ($prefix !== '' && ($path === $prefix || str_starts_with($path, $prefix . '/'))) {
                return true;
            }
        }
        return false;
    };
?>

<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="<?= esc(site_url($isLoggedIn ? 'dashboard' : 'login')) ?>">PROJET RÉGIME</a>
        <nav class="nav">
            <?php if ($isLoggedIn): ?>
                <a class="<?= $isActive(['dashboard']) ? 'active' : '' ?>" href="<?= esc(site_url('dashboard')) ?>">Dashboard</a>
                <a class="<?= $isActive(['profile']) ? 'active' : '' ?>" href="<?= esc(site_url('profile')) ?>">Profil</a>
                <a class="<?= $isActive(['regimes']) ? 'active' : '' ?>" href="<?= esc(site_url('regimes')) ?>">Régimes</a>
                <a class="<?= $isActive(['mes-regimes']) ? 'active' : '' ?>" href="<?= esc(site_url('mes-regimes')) ?>">Mes régimes</a>
                <a class="<?= $isActive(['transactions']) ? 'active' : '' ?>" href="<?= esc(site_url('transactions')) ?>">Transactions</a>
                <a class="<?= $isActive(['promo']) ? 'active' : '' ?>" href="<?= esc(site_url('promo')) ?>">Code promo</a>
                <a href="<?= esc(site_url('logout')) ?>" data-confirm-message="Voulez-vous vraiment vous déconnecter ?">Déconnexion</a>
            <?php else: ?>
                <a class="<?= $isActive(['login']) ? 'active' : '' ?>" href="<?= esc(site_url('login')) ?>">Connexion</a>
                <a class="<?= $isActive(['register']) ? 'active' : '' ?>" href="<?= esc(site_url('register')) ?>">Inscription</a>
                <a class="<?= $isActive(['admin', 'admin/login']) ? 'active' : '' ?>" href="<?= esc(site_url('admin/login')) ?>">Admin</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="shell stack">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>
<div class="confirm-modal" id="confirm-modal" aria-hidden="true">
    <div class="confirm-card" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="confirm-head">
            <img src="<?= esc(base_url('assets/icons/shield-alert.svg')) ?>" alt="">
            <strong id="confirm-title">Confirmation</strong>
        </div>
        <div class="confirm-body" id="confirm-message">Confirmer cette action ?</div>
        <div class="confirm-actions">
            <button type="button" class="btn btn-secondary" id="confirm-cancel">Annuler</button>
            <button type="button" class="btn" id="confirm-ok">Confirmer</button>
        </div>
    </div>
</div>

<script>
    (function () {
        const resetFieldErrors = (form) => {
            form.querySelectorAll('.field-error').forEach((node) => {
                node.textContent = '';
            });
            form.querySelectorAll('.is-invalid').forEach((node) => {
                node.classList.remove('is-invalid');
            });
        };

        const setFeedback = (form, type, message, errors = {}) => {
            const feedback = form.querySelector('[data-form-feedback]');
            if (!feedback) {
                return;
            }

            feedback.className = `form-feedback is-visible ${type}`;

            const errorEntries = Object.entries(errors || {});
            if (type === 'error' && errorEntries.length) {
                const unique = [...new Set(errorEntries.map(([, value]) => String(value)))].filter((value) => value !== String(message || ''));
                const list = unique.map((value) => `<li>${value}</li>`).join('');
                feedback.innerHTML = list
                    ? `<strong>${message}</strong><ul style="margin:8px 0 0; padding-left:18px;">${list}</ul>`
                    : `<strong>${message}</strong>`;
            } else {
                feedback.textContent = message || '';
            }
        };

        const showFieldErrors = (form, errors = {}) => {
            Object.entries(errors || {}).forEach(([fieldName, errorMessage]) => {
                const errorNode = form.querySelector(`[data-field-error="${fieldName}"]`);
                const inputNode = form.querySelector(`[name="${fieldName}"]`);
                if (errorNode) {
                    errorNode.textContent = errorMessage;
                }
                if (inputNode) {
                    inputNode.classList.add('is-invalid');
                }
            });
        };

        const setLoading = (submit, loading) => {
            if (!submit) return;
            if (loading) {
                submit.dataset.originalText = submit.tagName.toLowerCase() === 'button' ? submit.textContent : submit.value;
                if (submit.tagName.toLowerCase() === 'button') {
                    submit.textContent = 'Traitement...';
                } else {
                    submit.value = 'Traitement...';
                }
                submit.disabled = true;
            } else {
                const original = submit.dataset.originalText;
                if (original) {
                    if (submit.tagName.toLowerCase() === 'button') {
                        submit.textContent = original;
                    } else {
                        submit.value = original;
                    }
                }
                submit.disabled = false;
            }
        };

        const modal = document.getElementById('confirm-modal');
        const modalMessage = document.getElementById('confirm-message');
        const modalOk = document.getElementById('confirm-ok');
        const modalCancel = document.getElementById('confirm-cancel');
        let pendingAction = null;

        const closeModal = () => {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            pendingAction = null;
        };

        modalCancel?.addEventListener('click', closeModal);
        modal?.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });
        modalOk?.addEventListener('click', () => {
            if (!pendingAction) return closeModal();
            const action = pendingAction;
            closeModal();
            if (action.type === 'link') {
                window.location.href = action.href;
            } else if (action.type === 'submit') {
                if (typeof action.form.requestSubmit === 'function') {
                    action.form.requestSubmit(action.submitter || undefined);
                } else if (action.submitter) {
                    action.submitter.click();
                } else {
                    action.form.submit();
                }
            }
        });

        document.querySelectorAll('[data-confirm-message]').forEach((element) => {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                const message = this.getAttribute('data-confirm-message') || 'Confirmer cette action ?';
                modalMessage.textContent = message;
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
                if (this.tagName.toLowerCase() === 'a') {
                    pendingAction = { type: 'link', href: this.getAttribute('href') };
                } else if (this.type === 'submit' && this.form) {
                    pendingAction = { type: 'submit', form: this.form, submitter: this };
                }
            });
        });

        document.querySelectorAll('form').forEach((form) => {
            if (form.dataset.ajaxForm !== 'true') {
                form.addEventListener('submit', function () {
                    const submit = this.querySelector('button[type="submit"], input[type="submit"]');
                    if (!submit) {
                        return;
                    }

                    const original = submit.dataset.originalText || submit.textContent || submit.value || 'Envoyer';
                    submit.dataset.originalText = original;
                    if (submit.tagName.toLowerCase() === 'button') {
                        submit.textContent = 'Traitement...';
                    } else {
                        submit.value = 'Traitement...';
                    }
                    submit.disabled = true;
                });
                return;
            }

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const submit = form.querySelector('button[type="submit"], input[type="submit"]');
                resetFieldErrors(form);
                setFeedback(form, 'error', '', {});
                setLoading(submit, true);

                try {
                    const response = await fetch(form.action, {
                        method: (form.method || 'POST').toUpperCase(),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: new FormData(form),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        setFeedback(form, 'error', data.message || 'Veuillez vérifier les champs du formulaire.', data.errors || {});
                        const errors = data.errors || {};
                        const messages = Object.values(errors).map((v) => String(v));
                        const allSameAsTop = messages.length > 0 && messages.every((m) => m === String(data.message || ''));
                        if (!allSameAsTop) {
                            showFieldErrors(form, errors);
                        }
                        setLoading(submit, false);
                        return;
                    }

                    if (data.message) {
                        setFeedback(form, 'success', data.message);
                    }

                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    setLoading(submit, false);
                } catch (error) {
                    setFeedback(form, 'error', 'Une erreur est survenue. Merci de réessayer.', {});
                    setLoading(submit, false);
                }
            });
        });
    })();
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
