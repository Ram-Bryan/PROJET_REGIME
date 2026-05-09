<?php

namespace App\Models;

use CodeIgniter\Model;

class DureeRegimeModel extends Model
{
    protected $table = 'duree_regime';
    protected $primaryKey = 'id_duree_regime';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_regime',
        'nb_jours',
        'prix',
    ];

    public function getByRegimeId(int $idRegime): array
    {
        return $this->where('id_regime', $idRegime)
            ->orderBy('nb_jours', 'ASC')
            ->findAll();
    }
}
