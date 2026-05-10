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

    public function getDashboardStats(): array
    {
        $db = \Config\Database::connect();
        $utilisateurModel = new UtilisateurModel();
        $objectifModel = new ObjectifModel();

        $usersCount = $utilisateurModel->countAllResults();
        $goldCount = $utilisateurModel->where('is_gold', 1)->countAllResults();
        $salesCount = $db->table('commande')->countAllResults();
        $objectivesCount = $objectifModel->countAllResults();
        $regimesCount = $db->table('regime')->countAllResults();
        $chiffreAffaireRow = $db->table('commande')->selectSum('montant_paye')->get()->getRowArray();
        $chiffreAffaire = empty($chiffreAffaireRow['montant_paye']) ? 0 : $chiffreAffaireRow['montant_paye'];

        $objectifs = $objectifModel
            ->select('objectif.id_objectif, objectif.label_objectif, COUNT(utilisateur.id_utilisateur) AS total', false)
            ->join('utilisateur', 'utilisateur.id_objectif = objectif.id_objectif', 'left')
            ->groupBy('objectif.id_objectif')
            ->orderBy('objectif.id_objectif', 'ASC')
            ->findAll();

        $recentUsers = $utilisateurModel
            ->select('nom, email')
            ->orderBy('id_utilisateur', 'DESC')
            ->findAll(5);

        $pieColors = ['#1f8f6a', '#2563eb', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9'];
        $pieData = [];
        foreach ($objectifs as $index => $objectif) {
            $pieData[] = [
                'label' => $objectif['label_objectif'],
                'total' => (int) $objectif['total'],
                'color' => $pieColors[$index % count($pieColors)],
            ];
        }

        $trendLabels = [];
        $trendValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-{$i} months"));
            $trendLabels[] = date('M Y', strtotime("-{$i} months"));
            $row = $db->table('commande')
                ->selectSum('montant_paye')
                ->where("DATE_FORMAT(date_achat, '%Y-%m')", $date)
                ->get()
                ->getRowArray();
            $trendValues[] = (float) ($row['montant_paye'] ?? 0);
        }

        return [
            'usersCount' => $usersCount,
            'goldCount' => $goldCount,
            'salesCount' => $salesCount,
            'objectivesCount' => $objectivesCount,
            'regimesCount' => $regimesCount,
            'chiffreAffaire' => $chiffreAffaire,
            'objectifs' => $objectifs,
            'recentUsers' => $recentUsers,
            'pieData' => $pieData,
            'trendLabels' => $trendLabels,
            'trendValues' => $trendValues,
        ];
    }
}
?>
