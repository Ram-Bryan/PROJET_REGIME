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

}
