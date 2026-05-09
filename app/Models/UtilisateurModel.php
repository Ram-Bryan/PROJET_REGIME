<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'email',
        'mot_de_passe',
        'genre',
        'taille_cm',
        'poids_kg',
        'date_naissance',
        'id_objectif',
        'is_gold',
        'argent',
        'role_utilisateur',
    ];

    public function findByEmail(string $email): ?array
    {
        $user = $this->where('email', $email)->first();

        return is_array($user) ? $user : null;
    }

    public function calculateImc(float $poidsKg, float $tailleCm): ?float
    {
        if ($poidsKg <= 0 || $tailleCm <= 0) {
            return null;
        }
        
        $tailleM = $tailleCm / 100;
        $imc = $poidsKg / ($tailleM ** 2);

        return round($imc, 2);
    }

    public function getImc(array $user): ?float
    {
        return $this->calculateImc(
            (float)$user['poids_kg'],
            (float)$user['taille_cm']
        );
    }

    public function getTestUser(): ?array
    {
        return $this->orderBy($this->primaryKey, 'ASC')->first();
    }
}
