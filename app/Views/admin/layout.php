<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Admin regime' ?></title>
    <style>
        :root {
            --sidebar-width: 250px;
            --bg: #f4f6fb;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --line: #d9e2ec;
            --line-strong: #c3d0df;
            --text: #132238;
            --muted: #61758a;
            --nav: #183247;
            --nav-strong: #0f2536;
            --accent: #1f8f6a;
            --accent-strong: #157454;
            --accent-soft: #dff7ee;
            --warn-soft: #fff3db;
            --warn-text: #9a6116;
            --danger-soft: #ffe6e6;
            --danger-text: #b33a3a;
            --success-soft: #e6f8ef;
            --success-text: #146c43;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(31, 143, 106, 0.10), transparent 24%),
                radial-gradient(circle at bottom right, rgba(24, 50, 71, 0.10), transparent 24%),
                var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img.icon {
            width: 18px;
            height: 18px;
            display: block;
        }

        .admin-shell {
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--nav) 0%, var(--nav-strong) 100%);
            color: #f8fbff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .brand {
            padding: 8px 10px 0;
        }

        .brand-kicker {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .brand h1 {
            margin: 14px 0 6px;
            font-size: 24px;
            line-height: 1.1;
        }

        .brand p {
            margin: 0;
            color: rgba(248, 251, 255, 0.76);
            font-size: 14px;
        }

        .nav-list {
            display: grid;
            gap: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            border-radius: 14px;
            color: rgba(248, 251, 255, 0.84);
            transition: background 0.18s ease, transform 0.18s ease;
        }

        .nav-link img {
            filter: brightness(0) invert(1);
            opacity: 0.92;
        }

        .nav-link:hover,
        .nav-link.is-active {
            background: rgba(255, 255, 255, 0.10);
            transform: translateX(2px);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 28px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 16px;
            margin-bottom: 22px;
        }

        .page-head h2 {
            margin: 0;
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.05;
        }

        .page-head p {
            margin: 10px 0 0;
            color: var(--muted);
            max-width: 70ch;
        }

        .actions-inline {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: end;
        }

        .flash-stack {
            display: grid;
            gap: 12px;
            margin-bottom: 18px;
        }

        .flash {
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid transparent;
            font-weight: 600;
        }

        .flash.success {
            background: var(--success-soft);
            color: var(--success-text);
            border-color: #b5e3cb;
        }

        .flash.error {
            background: var(--danger-soft);
            color: var(--danger-text);
            border-color: #f1bbbb;
        }

        .card {
            background: var(--surface);
            border: 1px solid rgba(195, 208, 223, 0.55);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .card + .card {
            margin-top: 18px;
        }

        .section-title {
            margin: 0 0 6px;
            font-size: 20px;
        }

        .section-subtitle {
            margin: 0 0 18px;
            color: var(--muted);
        }

        .grid-2,
        .grid-3,
        .grid-4 {
            display: grid;
            gap: 16px;
        }

        .grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid var(--line);
            background: var(--surface-soft);
            border-radius: 14px;
            padding: 13px 14px;
            color: var(--text);
            font: inherit;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: #8db9aa;
            box-shadow: 0 0 0 4px rgba(31, 143, 106, 0.12);
            background: #ffffff;
        }

        .hint {
            margin-top: 8px;
            font-size: 13px;
            color: var(--muted);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid transparent;
            border-radius: 14px;
            padding: 11px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            background: none;
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--accent);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: var(--accent-strong);
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--text);
            border-color: var(--line);
        }

        .btn-secondary:hover {
            background: var(--surface-soft);
            border-color: var(--line-strong);
        }

        .btn-danger {
            background: #ffffff;
            color: var(--danger-text);
            border-color: #efb6b6;
        }

        .btn-danger:hover {
            background: var(--danger-soft);
        }

        .btn-small {
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 14px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 8px 12px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-size: 13px;
            font-weight: 700;
        }

        .badge.warn {
            background: var(--warn-soft);
            color: var(--warn-text);
        }

        .metric {
            padding: 18px;
            border-radius: 18px;
            background: var(--surface-soft);
            border: 1px solid var(--line);
        }

        .metric-label {
            margin: 0 0 10px;
            font-size: 13px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }

        .metric-value {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.1;
        }

        .metric-note {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px 14px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            vertical-align: top;
        }

        th {
            font-size: 13px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            background: var(--surface-soft);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .choice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
        }

        .choice {
            position: relative;
        }

        .choice input {
            position: absolute;
            opacity: 0;
            inset: 0;
            cursor: pointer;
        }

        .choice-card {
            height: 100%;
            border-radius: 18px;
            border: 1px solid var(--line);
            padding: 16px;
            background: var(--surface-soft);
            transition: border-color 0.18s ease, transform 0.18s ease, background 0.18s ease;
        }

        .choice input:checked + .choice-card {
            border-color: #7fb9a3;
            background: #eefaf5;
            transform: translateY(-1px);
        }

        .choice-title {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
        }

        .choice-meta {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .stack {
            display: grid;
            gap: 18px;
        }

        .list-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pill {
            padding: 10px 12px;
            border-radius: 999px;
            background: var(--surface-soft);
            border: 1px solid var(--line);
            font-weight: 600;
        }

        .error-list {
            margin: 0;
            padding-left: 18px;
            color: var(--danger-text);
            display: grid;
            gap: 8px;
        }

        @media (max-width: 980px) {
            .sidebar {
                position: static;
                width: 100%;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .page-head {
                flex-direction: column;
                align-items: start;
            }
        }

        @media (max-width: 720px) {
            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 18px;
            }

            th,
            td {
                padding: 12px 10px;
            }
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body>
<?php
    $activeNav = $activeNav ?? '';
    $navClass = static fn (string $key): string => $activeNav === $key ? 'nav-link is-active' : 'nav-link';
?>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-kicker">Backoffice</span>
                <h1>Admin regime</h1>
                <p>Gestion simple des contenus regime, activite et promo.</p>
            </div>

            <nav class="nav-list" aria-label="Admin navigation">
                <a href="<?= base_url('admin/dashboard') ?>" class="<?= $navClass('dashboard') ?>">
                    <img class="icon" src="<?= esc(base_url('assets/icons/layout-dashboard.svg')) ?>" alt="">
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('admin/regimes') ?>" class="<?= $navClass('regimes') ?>">
                    <img class="icon" src="<?= esc(base_url('assets/icons/apple.svg')) ?>" alt="">
                    <span>Regimes</span>
                </a>
                <a href="<?= base_url('admin/activites') ?>" class="<?= $navClass('activites') ?>">
                    <img class="icon" src="<?= esc(base_url('assets/icons/activity.svg')) ?>" alt="">
                    <span>Activites</span>
                </a>
                <a href="<?= base_url('admin/promos') ?>" class="<?= $navClass('promos') ?>">
                    <img class="icon" src="<?= esc(base_url('assets/icons/ticket-percent.svg')) ?>" alt="">
                    <span>Promos</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="<?= base_url('admin/logout') ?>" class="nav-link" onclick="return confirm('Logout from admin?');">
                    <img class="icon" src="<?= esc(base_url('assets/icons/log-out.svg')) ?>" alt="">
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="content">
            <div class="page-head">
                <div>
                    <h2><?= $this->renderSection('page_title') ?: 'Admin page' ?></h2>
                    <p><?= $this->renderSection('page_subtitle') ?></p>
                </div>
                <div class="actions-inline"><?= $this->renderSection('page_actions') ?></div>
            </div>

            <div class="flash-stack">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash error"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
            </div>

            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
