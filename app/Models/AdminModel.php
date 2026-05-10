<?php 
namespace App\Models;
use CodeIgniter\Model;
class AdminModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nom',
        'email',
        'mot_de_passe',
        'role_utilisateur',
    ];
    public function checkAdmin($email, $mot_de_passe): ?array
    {
        $admin = $this->where('email', $email)
            ->where('role_utilisateur', 'admin')
            ->first();

        if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
            return $admin;
        }

        return null;
    }
}
?>
