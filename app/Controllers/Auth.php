<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return redirect()->to('/login');
    }

    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register_personal');
    }

    public function saveRegisterPersonal()
    {
        $rules = [
            'nom' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'mot_de_passe' => 'required|min_length[6]',
            'genre' => 'required|in_list[Homme,Femme]',
            'date_naissance' => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez compléter correctement les informations personnelles.');
        }

        session()->set('register_step_personal', [
            'nom' => (string) $this->request->getPost('nom'),
            'email' => (string) $this->request->getPost('email'),
            'mot_de_passe' => (string) $this->request->getPost('mot_de_passe'),
            'genre' => (string) $this->request->getPost('genre'),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
        ]);

        return redirect()->to('/register')->with('success', 'Infos personnelles enregistrées. La partie santé viendra à l’étape suivante.');
    }

    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'mot_de_passe' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe invalide.');
        }

        $email = (string) $this->request->getPost('email');
        $motDePasse = (string) $this->request->getPost('mot_de_passe');

        $userModel = new UtilisateurModel();
        $user = $userModel->findByEmail($email);

        if ($user === null || ! password_verify($motDePasse, (string) $user['mot_de_passe'])) {
            return redirect()->back()->withInput()->with('error', 'Identifiants incorrects.');
        }

        session()->set([
            'is_logged_in' => true,
            'id_utilisateur' => $user['id_utilisateur'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role_utilisateur'],
            'is_gold' => (bool) $user['is_gold'],
        ]);

        return redirect()->to('/dashboard')->with('success', 'Connexion réussie.');
    }

    public function dashboard()
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('dashboard', [
            'nom' => (string) session()->get('nom'),
            'email' => (string) session()->get('email'),
            'role' => (string) session()->get('role'),
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Déconnexion effectuée.');
    }
}
