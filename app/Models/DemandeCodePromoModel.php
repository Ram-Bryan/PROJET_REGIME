<?php

namespace App\Models;

use CodeIgniter\Model;

class DemandeCodePromoModel extends Model
{
    protected $table = 'demande_code_promo';
    protected $primaryKey = 'id_demande_code_promo';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_utilisateur',
        'code_saisi',
        'statut',
        'id_admin_traitement',
        'note_admin',
        'date_demande',
        'date_traitement',
    ];

    public function hasPendingRequest(int $userId, string $code): bool
    {
        return $this->where('id_utilisateur', $userId)
            ->where('code_saisi', strtoupper(trim($code)))
            ->where('statut', 'en_attente')
            ->countAllResults() > 0;
    }

    public function getPendingAdminListing(): array
    {
        $builder = $this->db->table('demande_code_promo d');
        $builder->select([
            'd.id_demande_code_promo',
            'd.code_saisi',
            'd.statut',
            'd.note_admin',
            'd.date_demande',
            'd.date_traitement',
            'u.id_utilisateur',
            'u.nom AS utilisateur_nom',
            'u.email AS utilisateur_email',
        ]);
        $builder->join('utilisateur u', 'u.id_utilisateur = d.id_utilisateur', 'left');
        $builder->where('d.statut', 'en_attente');
        $builder->orderBy('d.date_demande', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function countPending(): int
    {
        return $this->where('statut', 'en_attente')->countAllResults();
    }

    public function getUserHistory(int $userId): array
    {
        return $this->where('id_utilisateur', $userId)
            ->orderBy('date_demande', 'DESC')
            ->findAll();
    }
}
