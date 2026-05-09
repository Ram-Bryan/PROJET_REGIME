<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin - Gestion du Régime</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --danger-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-bg: #ecf0f1;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            padding-top: 20px;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
        }

        .sidebar-menu a.active {
            background-color: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: var(--accent-color);
        }

        .sidebar-menu i {
            width: 24px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-footer a:hover {
            color: white;
        }

        /* Top Bar */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: white;
            border-bottom: 1px solid var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), #2980b9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #7f8c8d;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--light-bg);
            padding: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .card-body {
            padding: 20px;
        }

        /* Stats Cards */
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card.primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-card.accent {
            background: linear-gradient(135deg, var(--accent-color), #2980b9);
        }

        .stat-card.success {
            background: linear-gradient(135deg, var(--success-color), #229954);
        }

        .stat-card.danger {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .stat-icon {
            font-size: 40px;
            opacity: 0.3;
        }

        /* Buttons */
        .btn {
            border-radius: 6px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }

        /* Table */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border: none;
            background-color: var(--light-bg);
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-color: var(--light-bg);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-section p {
            font-size: 15px;
            opacity: 0.9;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                width: var(--sidebar-width);
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                margin-bottom: 10px;
            }
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-heartbeat"></i> Admin</h2>
            <p>Panneau d'administration</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('admin/dashboard') ?>" class="active">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/utilisateurs') ?>">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/regimes') ?>">
                    <i class="fas fa-apple-alt"></i>
                    <span>Régimes</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/activites') ?>">
                    <i class="fas fa-running"></i>
                    <span>Activités</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/objectifs') ?>">
                    <i class="fas fa-bullseye"></i>
                    <span>Objectifs</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/imc') ?>">
                    <i class="fas fa-calculator"></i>
                    <span>IMC</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/parametres') ?>">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= base_url('admin/logout') ?>" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </nav>

    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-title">
            <i class="fas fa-bars" style="cursor: pointer; display: none;" id="sidebarToggle"></i>
            Tableau de bord
        </div>
        <div class="topbar-right">
            <div class="user-profile">
                <div class="user-avatar">
                    <?= substr(session()->get('admin_name'), 0, 1) ?>
                </div>
                <div class="user-info">
                    <div class="user-name"><?= session()->get('admin_name') ?></div>
                    <div class="user-role">Administrateur</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Messages de bienvenue -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Section de bienvenue -->
        <div class="welcome-section">
            <h1>Bienvenue, <?= session()->get('admin_name') ?> ! 👋</h1>
            <p>Voici un aperçu de votre plateforme de gestion du régime et des activités sportives.</p>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card primary">
                    <div>
                        <div class="stat-value">156</div>
                        <div class="stat-label">Utilisateurs</div>
                    </div>
                    <i class="fas fa-users stat-icon"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card accent">
                    <div>
                        <div class="stat-value">42</div>
                        <div class="stat-label">Régimes Actifs</div>
                    </div>
                    <i class="fas fa-apple-alt stat-icon"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card success">
                    <div>
                        <div class="stat-value">89</div>
                        <div class="stat-label">Activités</div>
                    </div>
                    <i class="fas fa-running stat-icon"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card danger">
                    <div>
                        <div class="stat-value">12</div>
                        <div class="stat-label">Alertes</div>
                    </div>
                    <i class="fas fa-bell stat-icon"></i>
                </div>
            </div>
        </div>

        <!-- Derniers Utilisateurs -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users"></i> Derniers Utilisateurs
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Date d'inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jean Dupont</td>
                                    <td>jean@example.com</td>
                                    <td>09/05/2026</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Voir</a>
                                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marie Martin</td>
                                    <td>marie@example.com</td>
                                    <td>08/05/2026</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Voir</a>
                                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pierre Bernard</td>
                                    <td>pierre@example.com</td>
                                    <td>07/05/2026</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Voir</a>
                                        <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Activité Récente -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history"></i> Activité Récente
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 15px;">
                            <small style="display: block; color: #7f8c8d; margin-bottom: 5px;">Il y a 2 heures</small>
                            <p style="margin: 0; color: var(--primary-color);">Nouvel utilisateur inscrit</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <small style="display: block; color: #7f8c8d; margin-bottom: 5px;">Il y a 5 heures</small>
                            <p style="margin: 0; color: var(--primary-color);">Régime mis à jour</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <small style="display: block; color: #7f8c8d; margin-bottom: 5px;">Hier</small>
                            <p style="margin: 0; color: var(--primary-color);">Activité supprimée</p>
                        </div>
                        <div>
                            <small style="display: block; color: #7f8c8d; margin-bottom: 5px;">Hier</small>
                            <p style="margin: 0; color: var(--primary-color);">Nouvel objectif créé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar sur mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
