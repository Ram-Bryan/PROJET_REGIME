<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeActiviteModel extends Model
{
    protected $table = 'regime_activite';
    protected $primaryKey = 'id_regime_activite';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_regime',
        'id_activite',
    ];

    public function getActiviteIdsForRegime(int $idRegime): array
    {
        $rows = $this->select('id_activite')
            ->where('id_regime', $idRegime)
            ->findAll();

        return array_map(static fn(array $row): int => (int) $row['id_activite'], $rows);
    }

    public function getCountsByRegime(): array
    {
        $rows = $this->select('id_regime, COUNT(*) as total')
            ->groupBy('id_regime')
            ->findAll();

        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row['id_regime']] = (int) $row['total'];
        }

        return $counts;
    }
}
