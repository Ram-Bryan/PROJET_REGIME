<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
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

        $userModel = new UtilisateurModel();
        if ($userModel->findByEmail((string) $this->request->getPost('email')) !== null) {
            return redirect()->back()->withInput()->with('error', 'Cet email est déjà utilisé.');
        }

        session()->set('register_step_personal', [
            'nom' => (string) $this->request->getPost('nom'),
            'email' => (string) $this->request->getPost('email'),
            'mot_de_passe' => (string) $this->request->getPost('mot_de_passe'),
            'genre' => (string) $this->request->getPost('genre'),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
        ]);

        return redirect()->to('/register/health')->with('success', 'Infos personnelles enregistrées. Complétez maintenant les informations santé.');
    }

    public function registerHealth()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        $personalStep = session()->get('register_step_personal');
        if (! is_array($personalStep)) {
            return redirect()->to('/register')->with('error', 'Commencez par les informations personnelles.');
        }

        $objectifModel = new ObjectifModel();

        return view('auth/register_health', [
            'personal' => $personalStep,
            'objectifs' => $objectifModel->findAll(),
        ]);
    }

    public function saveRegisterHealth()
    {
        $personalStep = session()->get('register_step_personal');
        if (! is_array($personalStep)) {
            return redirect()->to('/register')->with('error', 'Commencez par les informations personnelles.');
        }

        $rules = [
            'taille_cm' => 'required|numeric|greater_than[0]',
            'poids_kg' => 'required|numeric|greater_than[0]',
            'poids_objectif' => 'required|numeric|greater_than[0]',
            'id_objectif' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez compléter correctement les informations santé.');
        }

        $userModel = new UtilisateurModel();
        $objectifModel = new ObjectifModel();
        $objectif = $objectifModel->find((int) $this->request->getPost('id_objectif'));

        if ($objectif === null) {
            return redirect()->back()->withInput()->with('error', 'Objectif invalide.');
        }

        $tailleCm = (float) $this->request->getPost('taille_cm');
        $poidsKg = (float) $this->request->getPost('poids_kg');

        $userId = $userModel->insert([
            'nom' => $personalStep['nom'],
            'email' => $personalStep['email'],
            'mot_de_passe' => password_hash((string) $personalStep['mot_de_passe'], PASSWORD_DEFAULT),
            'genre' => $personalStep['genre'],
            'taille_cm' => $tailleCm,
            'poids_kg' => $poidsKg,
            'poids_objectif' => (float) $this->request->getPost('poids_objectif'),
            'date_naissance' => $personalStep['date_naissance'],
            'id_objectif' => (int) $this->request->getPost('id_objectif'),
            'is_gold' => false,
            'argent' => 0,
            'role_utilisateur' => 'client',
        ], true);

        if (! is_int($userId) && ! is_string($userId)) {
            return redirect()->back()->withInput()->with('error', 'Impossible de créer le compte.');
        }

        $imc = $userModel->calculateImc($poidsKg, $tailleCm);

        session()->remove('register_step_personal');
        session()->set([
            'is_logged_in' => true,
            'id_utilisateur' => $userId,
            'nom' => $personalStep['nom'],
            'email' => $personalStep['email'],
            'role' => 'client',
            'is_gold' => false,
            'imc' => $imc,
            'objectif_label' => $objectif['label_objectif'],
        ]);

        return redirect()->to('/dashboard')->with('success', 'Compte créé avec succès.');
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

    public function profile()
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UtilisateurModel();
        $user = $userModel->find((int) session()->get('id_utilisateur'));

        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Utilisateur introuvable.');
        }

        $objectifModel = new ObjectifModel();
        $objectif = $objectifModel->find((int) $user['id_objectif']);

        $imc = $userModel->calculateImc((float) $user['poids_kg'], (float) $user['taille_cm']);

        return view('profile/view', [
            'user' => $user,
            'objectif' => $objectif,
            'imc' => $imc,
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Déconnexion effectuée.');
    }
}
