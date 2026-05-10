<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected ImcModel $imcModel;
    protected string $variationColumn = 'variation_mensuelle_kg';
    protected $table = 'regime';
    protected $primaryKey = 'id_regime';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom_regime',
        'variation_mensuelle_kg',
        'variation_poids',
        'pourcentage_viande',
        'pourcentage_poisson',
        'pourcentage_volaille',
    ];
    protected $afterFind = ['normalizeVariationColumn'];

    public function __construct()
    {
        parent::__construct();
        $this->imcModel = new ImcModel();
        $this->variationColumn = $this->db->fieldExists('variation_mensuelle_kg', $this->table)
            ? 'variation_mensuelle_kg'
            : 'variation_poids';
    }
    
    public function getSuggestedByUser(array $user): array
    {
        $idObjectif = (int)($user['id_objectif'] ?? 0);

        if ($idObjectif === 1) {
            return $this->where($this->variationColumn . ' <', 0)->findAll();
        }

        if ($idObjectif === 2) {
            return $this->where($this->variationColumn . ' >', 0)->findAll();
        }

        if ($idObjectif === 3) {

            $poidsKg = (float)($user['poids_kg'] ?? 0);
            $tailleCm = (float)($user['taille_cm'] ?? 0);

            if ($poidsKg <= 0 || $tailleCm <= 0) return [];

            $tailleM = $tailleCm / 100;
            $imc = $poidsKg / ($tailleM ** 2);

            $ideal = $this->imcModel->getIdealRange();
            if ($ideal === null) return [];

            if ($imc < (float)$ideal['imc_min']) return $this->where($this->variationColumn . ' >', 0)->findAll();
            if ($imc > (float)$ideal['imc_max']) return $this->where($this->variationColumn . ' <', 0)->findAll();

            // Already in ideal IMC -> nothing to suggest to attain it
            return [];
        }

        return [];
    }

    public function getFilteredList(?int $dureeJours, ?int $objectifId, ?int $userId = null): array
    {
        $builder = $this->db->table('regime r');
        $variationColumn = 'r.' . $this->variationColumn;
        $builder->distinct();
        $builder->select('r.id_regime, r.nom_regime, ' . $variationColumn . ' AS variation_mensuelle_kg, r.pourcentage_viande, r.pourcentage_poisson, r.pourcentage_volaille');
        $builder->join('duree_regime d', 'd.id_regime = r.id_regime');

        if (!empty($dureeJours)) {
            $builder->where('d.nb_jours', $dureeJours);
        }

        if ($objectifId === 1) {
            $builder->where($variationColumn . ' <', 0);
        } elseif ($objectifId === 2) {
            $builder->where($variationColumn . ' >', 0);
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
                                $builder->where($variationColumn . ' >', 0);
                                $idealConditionSet = true;
                            } elseif ($imc > (float)$ideal['imc_max']) {
                                $builder->where($variationColumn . ' <', 0);
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

        $builder->orderBy('r.nom_regime', 'ASC');

        return $builder->get()->getResultArray();
    }

    protected function normalizeVariationColumn(array $data): array
    {
        if (! isset($data['data'])) {
            return $data;
        }

        if (isset($data['data']['variation_poids']) && ! isset($data['data']['variation_mensuelle_kg'])) {
            $data['data']['variation_mensuelle_kg'] = $data['data']['variation_poids'];
            return $data;
        }

        if (is_array($data['data'])) {
            foreach ($data['data'] as &$row) {
                if (is_array($row) && isset($row['variation_poids']) && ! isset($row['variation_mensuelle_kg'])) {
                    $row['variation_mensuelle_kg'] = $row['variation_poids'];
                }
            }
        }

        return $data;
    }
}
