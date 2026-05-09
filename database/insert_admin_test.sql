-- Admin de test pour l'authentification
-- Email: admin@test.com
-- Mot de passe: admin123 (hashé avec password_hash)
INSERT INTO admin (nom, prenom, email, mot_de_passe) VALUES (
    'Admin',
    'Test',
    'admin@test.com',
    '$2y$10$lDe00s8Sqm4VfSo65uX1f.rX9oyQCMxElqwNydMvrrH820oHSacTO'
);
