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
}
