<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected ImcModel $imcModel;
    protected $table = 'regime';
    protected $primaryKey = 'id_regime';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom_regime',
        'variation_mensuelle_kg',
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
            return $this->where('variation_mensuelle_kg <', 0)->findAll();
        }

        if ($idObjectif === 2) {
            return $this->where('variation_mensuelle_kg >', 0)->findAll();
        }

        if ($idObjectif === 3) {

            $poidsKg = (float)($user['poids_kg'] ?? 0);
            $tailleCm = (float)($user['taille_cm'] ?? 0);

            if ($poidsKg <= 0 || $tailleCm <= 0) return [];

            $tailleM = $tailleCm / 100;
            $imc = $poidsKg / ($tailleM ** 2);

            $ideal = $this->imcModel->getIdealRange();
            if ($ideal === null) return [];

            if ($imc < (float)$ideal['imc_min']) return $this->where('variation_mensuelle_kg >', 0)->findAll();
            if ($imc > (float)$ideal['imc_max']) return $this->where('variation_mensuelle_kg <', 0)->findAll();

            // Already in ideal IMC -> nothing to suggest to attain it
            return [];
        }

        return [];
    }

    public function getFilteredList(?int $dureeJours, ?int $objectifId, ?int $userId = null): array
    {
        $builder = $this->db->table('v_regime_duree');
        $builder->select('id_regime, nom_regime, variation_mensuelle_kg, pourcentage_viande, pourcentage_poisson, pourcentage_volaille');

        if (!empty($dureeJours)) {
            $builder->where('nb_jours', $dureeJours);
        }

        if ($objectifId === 1) {
            $builder->where('variation_mensuelle_kg <', 0);
        } elseif ($objectifId === 2) {
            $builder->where('variation_mensuelle_kg >', 0);
        } elseif ($objectifId === 3) {
            $idealConditionSet = false;
            
            if ($userId !== null) {
                $userModel = new \App\Models\UtilisateurModel();
                $user = $userModel->find($userId);
                
                if ($user) {
                    $poidsKg = (float)($user['poids_kg'] ?? 0);
                    $tailleCm = (float)($user['taille_cm'] ?? 0);
                    
                    if ($poidsKg > 0 && $tailleCm > 0) {
                        $tailleM = $tailleCm / 100;
                        $imc = $poidsKg / ($tailleM ** 2);
                        
                        $ideal = $this->imcModel->getIdealRange();
                        if ($ideal !== null) {
                            if ($imc < (float)$ideal['imc_min']) {
                                $builder->where('variation_mensuelle_kg >', 0);
                                $idealConditionSet = true;
                            } elseif ($imc > (float)$ideal['imc_max']) {
                                $builder->where('variation_mensuelle_kg <', 0);
                                $idealConditionSet = true;
                            } else {
                                // User is already at ideal IMC, they don't need any regime to attain it
                                $builder->where('1 = 0'); 
                                $idealConditionSet = true;
                            }
                        }
                    }
                }
            }
            
            if (!$idealConditionSet) {
                // Fallback for an objective 3 without a valid logged-in user => show nothing or maintenance
                $builder->where('1 = 0');
            }
        }

        $builder->groupBy('id_regime');
        $builder->orderBy('nom_regime', 'ASC');

        return $builder->get()->getResultArray();
    }
}
