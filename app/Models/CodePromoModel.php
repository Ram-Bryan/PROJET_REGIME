<?php

namespace App\Models;

use CodeIgniter\Model;

class CodePromoModel extends Model
{
    protected $table = 'code_promo';
    protected $primaryKey = 'id_code';
    protected $returnType = 'array';
    protected $allowedFields = [
        'montant',
        'code',
        'deja_utilise',
        'id_utilisateur_utilisation',
    ];

    public function findByCode(string $code): ?array
    {
        $promo = $this->where('code', $code)->first();

        return is_array($promo) ? $promo : null;
    }
}
