<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class RegimeModel extends Model
{
    protected ImcModel $imcModel;
    protected $table = 'regime';
    protected $primaryKey = 'id_regime';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom_regime',
        'variation_poids',
        'pourcentage_viande',
        'pourcentage_poisson',
        'pourcentage_volaille',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->imcModel = new ImcModel();
    }
    
    public function getSuggestedByUser(array $user): array
    {
        $idObjectif = (int)($user['id_objectif'] ?? 0);

        if ($idObjectif === 1) {
            return $this->where('variation_poids <', 0)->findAll();
        }

        if ($idObjectif === 2) {
            return $this->where('variation_poids >', 0)->findAll();
        }

        if ($idObjectif === 3) {

            $poidsKg = (float)($user['poids_kg'] ?? 0);
            $tailleCm = (float)($user['taille_cm'] ?? 0);

            if ($poidsKg <= 0 || $tailleCm <= 0) return [];

            $tailleM = $tailleCm / 100;
            $imc = $poidsKg / ($tailleM ** 2);

            $ideal = $this->imcModel->getIdealRange();
            if ($ideal === null) return [];

            if ($imc < (float)$ideal['imc_min']) return $this->where('variation_poids >', 0)->findAll();
            if ($imc > (float)$ideal['imc_max']) return $this->where('variation_poids <', 0)->findAll();

            return $this->where('variation_poids >=', -1)->where('variation_poids <=', 1)->findAll();
        }

        return [];
    }

    public function getFilteredList(?int $dureeJours, ?int $objectifId): array
    {
        $builder = $this->builder();
        $builder->select('regime.*');

        if (!empty($dureeJours)) {
            $builder->join('duree_regime', 'duree_regime.id_regime = regime.id_regime');
            $builder->where('duree_regime.nb_jours', $dureeJours);
        }

        if ($objectifId === 1) {
            $builder->where('regime.variation_poids <', 0);
        } elseif ($objectifId === 2) {
            $builder->where('regime.variation_poids >', 0);
        } elseif ($objectifId === 3) {
            $builder->where('regime.variation_poids >=', -1)
                ->where('regime.variation_poids <=', 1);
        }

        $builder->groupBy('regime.id_regime');
        $builder->orderBy('regime.nom_regime', 'ASC');

        return $builder->get()->getResultArray();
    }
}
