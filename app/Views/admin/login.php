<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Gestion du Régime</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --danger-color: #e74c3c;
            --success-color: #27ae60;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #34495e 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #95a5a6;
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #ecf0f1;
            border-right: none;
            color: #7f8c8d;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group .form-control:focus + .input-group-text {
            border-color: var(--accent-color);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--accent-color) 0%, #2980b9 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 15px;
            border-radius: 6px;
            margin-top: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            margin-bottom: 20px;
            border: none;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fadbd8;
            color: #c0392b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background-color: #d5f4e6;
            color: #1e8449;
            border-left: 4px solid var(--success-color);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .form-check {
            margin: 0;
        }

        .form-check-input {
            cursor: pointer;
            width: 18px;
            height: 18px;
            margin-top: 2px;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label {
            margin-bottom: 0;
            cursor: pointer;
            color: var(--primary-color);
        }

        .forgot-password {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background: #f8f9fa;
            font-size: 13px;
            color: #7f8c8d;
        }

        .loading-spinner {
            display: none;
            width: 18px;
            height: 18px;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-spinner.show {
            display: inline-block;
            animation: spin 0.8s linear infinite;
        }

        .icon-lock {
            color: var(--accent-color);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-body {
                padding: 30px 20px;
            }

            .login-footer {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- En-tête -->
            <div class="login-header">
                <h1>
                    <i class="fas fa-lock icon-lock"></i>
                    Admin Panel
                </h1>
                <p>Gestion du Régime</p>
            </div>

            <!-- Corps du formulaire -->
            <div class="login-body">
                <!-- Messages d'erreur -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Formulaire de connexion -->
                <form id="loginForm" action="<?= base_url('/admin/authenticate') ?>" method="post" novalidate>
                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Adresse Email
                        </label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="exemple@email.com"
                            required
                            autocomplete="email"
                        >
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label for="mot_de_passe">
                            <i class="fas fa-key"></i> Mot de passe
                        </label>
                        <div class="input-group">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="mot_de_passe" 
                                name="mot_de_passe" 
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                            <button 
                                class="btn btn-outline-secondary input-group-text" 
                                type="button" 
                                id="togglePassword"
                                style="border: 2px solid #ecf0f1; background: white; cursor: pointer;"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Bouton de connexion -->
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-spinner loading-spinner" id="loadingSpinner"></i>
                        <span id="btnText">Se connecter</span>
                    </button>
                </form>
            </div>

            <!-- Pied de page -->
            <div class="login-footer">
                <p style="margin: 0;">
                    © 2026 Gestion du Régime. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Affichage/Masquage du mot de passe
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('mot_de_passe');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Gestion de la soumission du formulaire
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const spinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            const submitBtn = document.querySelector('.btn-login');

            spinner.classList.add('show');
            btnText.textContent = 'Connexion en cours...';
            submitBtn.disabled = true;
        });

        // Validation du formulaire côté client
        document.getElementById('loginForm').addEventListener('change', function() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('mot_de_passe').value;

            if (email && password) {
                document.querySelector('.btn-login').disabled = false;
            }
        });

        // Focus sur le premier champ
        document.getElementById('email').focus();
    </script>
</body>
</html>
