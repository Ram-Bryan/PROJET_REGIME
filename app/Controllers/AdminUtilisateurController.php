<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AdminUtilisateurController extends BaseController
{
    public function index()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        $utilisateurModel = new UtilisateurModel();
        
        // Fetch all users except admin
        $utilisateurs = $utilisateurModel->where('role_utilisateur !=', 'admin')
                                         ->orderBy('id_utilisateur', 'DESC')
                                         ->findAll();

        return view('admin/utilisateurs/index', [
            'utilisateurs' => $utilisateurs,
            'activeNav'    => 'utilisateurs',
        ]);
    }

    public function show($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        $utilisateurModel = new UtilisateurModel();
        
        $user = $utilisateurModel->find($id);

        if (!$user || $user['role_utilisateur'] === 'admin') {
            session()->setFlashdata('error', 'Utilisateur introuvable.');
            return redirect()->to('/admin/utilisateurs');
        }

        $db = db_connect();
        $commandes = $db->table('v_commande_regime')
                        ->where('id_utilisateur', $id)
                        ->orderBy('date_achat', 'DESC')
                        ->get()
                        ->getResultArray();

        return view('admin/utilisateurs/show', [
            'user'      => $user,
            'commandes' => $commandes,
            'activeNav' => 'utilisateurs',
        ]);
    }
}
