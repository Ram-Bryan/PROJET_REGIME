<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $primaryKey = 'id_commande';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_utilisateur',
        'id_regime',
        'id_duree_regime',
        'date_achat',
        'montant_paye',
    ];

    public function getPurchasedByUser(int $userId): array
    {
        return $this->db->table('v_commande_regime')
            ->where('id_utilisateur', $userId)
            ->orderBy('date_achat', 'DESC')
            ->get()
            ->getResultArray();
    }
}
