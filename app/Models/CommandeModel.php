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
        return $this->select([
            'commande.id_commande',
            'commande.date_achat',
            'commande.montant_paye',
            'regime.nom_regime',
            'duree_regime.nb_jours',
            'duree_regime.prix AS prix_duree',
        ])
            ->join('regime', 'regime.id_regime = commande.id_regime', 'left')
            ->join('duree_regime', 'duree_regime.id_duree_regime = commande.id_duree_regime', 'left')
            ->where('commande.id_utilisateur', $userId)
            ->orderBy('commande.date_achat', 'DESC')
            ->findAll();
    }
}
