<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?: 'Projet Régime' ?></title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f6f7fb;
            --card: #ffffff;
            --text: #101828;
            --muted: #667085;
            --border: #eaecf0;
            --primary: #2b59ff;
            --primary-weak: #e8eeff;
            --success-bg: #ecfdf3;
            --success-text: #027a48;
            --error-bg: #fef3f2;
            --error-text: #b42318;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .brand {
            font-weight: 800;
            font-size: 16px;
            color: var(--text);
            text-decoration: none;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .nav a {
            text-decoration: none;
            color: #344054;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 600;
        }

        .nav a:hover {
            background: #f9fafb;
            border-color: var(--border);
        }

        .nav a.active {
            background: var(--primary-weak);
            color: var(--primary);
            border-color: #c7d7fe;
        }

        .shell {
            max-width: 1100px;
            margin: 28px auto 40px;
            padding: 0 20px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 30px;
        }

        .sub {
            color: var(--muted);
            margin: 8px 0 0;
            font-size: 14px;
        }

        .stack { display: grid; gap: 16px; }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.06);
        }

        .grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        input, select, button {
            font: inherit;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--primary);
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-secondary {
            background: #fff;
            color: var(--primary);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid;
            font-size: 14px;
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
            padding: 28px 16px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-weight: 600;
        }

        tr:last-child td { border-bottom: none; }

        .kv-title {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 6px;
        }

        .kv-value {
            font-size: 16px;
            font-weight: 700;
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
                <a href="<?= esc(site_url('logout')) ?>">Déconnexion</a>
            <?php else: ?>
                <a class="<?= $isActive(['login']) ? 'active' : '' ?>" href="<?= esc(site_url('login')) ?>">Connexion</a>
                <a class="<?= $isActive(['register']) ? 'active' : '' ?>" href="<?= esc(site_url('register')) ?>">Inscription</a>
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

<?= $this->renderSection('scripts') ?>
</body>
</html>