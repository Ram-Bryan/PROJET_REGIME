<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'activite_sportive';
    protected $primaryKey = 'id_activite';
    protected $returnType = 'array';
    protected $allowedFields = [
        'label_activite',
        'nb_par_semaine',
    ];

    public function getByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return $this->whereIn('id_activite', $ids)
            ->orderBy('label_activite', 'ASC')
            ->findAll();
    }

}
