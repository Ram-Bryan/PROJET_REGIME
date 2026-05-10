<?php 
namespace App\Models;
use CodeIgniter\Model;
class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
    ];
    public function checkAdmin($email, $mot_de_passe): ?array
    {
        $admin = $this->where('email', $email)->first();

        if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
            return $admin;
        }

        return null;
    }
}
?>