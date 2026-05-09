-- Admin de test pour l'authentification
-- Email: admin@test.com
-- Mot de passe: admin123 (hashé avec password_hash)
INSERT INTO admin (nom, prenom, email, mot_de_passe) VALUES (
    'Admin',
    'Test',
    'admin@test.com',
    '$2y$10$z8XOQf8aaI4B/Yw8oFJn8.3XHKrLg1u1e.j5VqEp/Nh8uKpkQzwA6'
);
