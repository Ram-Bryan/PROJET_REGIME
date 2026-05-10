<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ObjectifModel;
use App\Models\UtilisateurModel;

class AdminController extends BaseController
{
    public function login()
    {
        return view('admin/login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $motDePasse = $this->request->getPost('mot_de_passe');

        $adminModel = new AdminModel();
        $admin = $adminModel->checkAdmin($email, $motDePasse);

        if ($admin) {
            session()->set('admin_id', $admin['id_utilisateur']);
            session()->set('admin_name', $admin['nom']);

            return redirect()->to('/admin/dashboard');
        }

        session()->setFlashdata('error', 'Email ou mot de passe incorrect.');

        return redirect()->back();
    }

    public function dashboard()
    {
        if (! session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        $utilisateurModel = new UtilisateurModel();
        $objectifModel = new ObjectifModel();
        $db = db_connect();

        $usersCount = $utilisateurModel->countAllResults();
        $goldCount = $utilisateurModel->where('is_gold', 1)->countAllResults();
        $salesCount = $db->table('commande')->countAllResults();
        $objectivesCount = $objectifModel->countAllResults();

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

        return view('admin/dashboard', [
            'usersCount' => $usersCount,
            'goldCount' => $goldCount,
            'salesCount' => $salesCount,
            'objectivesCount' => $objectivesCount,
            'objectifs' => $objectifs,
            'recentUsers' => $recentUsers,
            'activeNav' => 'dashboard',
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/admin/login');
    }
}
