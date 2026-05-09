<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $primaryKey = 'id_commande';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_utilisateur',
        'id_regime',
        'id_duree_regime',
        'date_achat',
        'montant_paye',
    ];

    public function getHistoryByUserId(int $userId): array
    {
        return $this->db->table('v_commande_regime')
            ->select([
                'id_commande',
                'date_achat',
                'montant_paye',
                'nom_regime',
                'nb_jours',
                'prix AS prix_duree',
            ])
            ->where('id_utilisateur', $userId)
            ->orderBy('date_achat', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPurchasedRegimesByUserId(int $userId): array
    {
        return $this->db->table('v_commande_regime')
            ->select([
                'id_commande',
                'date_achat',
                'montant_paye',
                'id_regime',
                'nom_regime',
                'variation_mensuelle_kg',
                'nb_jours',
                'prix AS prix_duree',
            ])
            ->where('id_utilisateur', $userId)
            ->orderBy('date_achat', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPurchaseById(int $commandeId, int $userId): ?array
    {
        $row = $this->db->table('v_commande_regime')
            ->select([
                'id_commande',
                'id_utilisateur',
                'id_regime',
                'id_duree_regime',
                'date_achat',
                'montant_paye',
                'nom_regime',
                'variation_mensuelle_kg',
                'pourcentage_viande',
                'pourcentage_poisson',
                'pourcentage_volaille',
                'nb_jours',
                'prix AS prix_duree',
            ])
            ->where('id_commande', $commandeId)
            ->where('id_utilisateur', $userId)
            ->get()
            ->getFirstRow('array');

        return $row ?: null;
    }

    public function hasActiveRegime(int $userId, int $regimeId, int $dureeId): bool
    {
        $rows = $this->db->table('v_commande_regime')
            ->select([
                'date_achat',
                'nb_jours',
                'id_duree_regime',
            ])
            ->where('id_utilisateur', $userId)
            ->where('id_regime', $regimeId)
            ->where('id_duree_regime', $dureeId)
            ->orderBy('date_achat', 'DESC')
            ->get()
            ->getResultArray();

        $now = new \DateTimeImmutable('now');

        foreach ($rows as $row) {
            if (empty($row['date_achat']) || empty($row['nb_jours'])) {
                continue;
            }
            $start = new \DateTimeImmutable((string) $row['date_achat']);
            $end = $start->modify('+' . (int) $row['nb_jours'] . ' days');
            if ($end >= $now) {
                return true;
            }
        }

        return false;
    }
}
