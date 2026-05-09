<?php

namespace App\Models;

use CodeIgniter\Model;

class DureeRegimeModel extends Model
{
    protected $table = 'duree_regime';
    protected $primaryKey = 'id_duree_regime';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_regime',
        'nb_jours',
        'prix',
    ];
}