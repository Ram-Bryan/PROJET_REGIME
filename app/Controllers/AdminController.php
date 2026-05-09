<?php 
namespace App\Controllers;
use App\Models\AdminModel;
class AdminController extends BaseController
{   
    public function login()
    {
        return view('admin/login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $mot_de_passe = $this->request->getPost('mot_de_passe');

        $adminModel = new AdminModel();
        $admin = $adminModel->checkAdmin($email, $mot_de_passe);

        if ($admin) {
            session()->set('admin_id', $admin['id_admin']);
            session()->set('admin_name', $admin['prenom'] . ' ' . $admin['nom']);
            return redirect()->to('/admin/dashboard');
        } else {
            session()->setFlashdata('error', 'Email ou mot de passe incorrect.');
            return redirect()->back();
        }
    }

    public function dashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}