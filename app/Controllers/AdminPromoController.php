<?php

namespace App\Controllers;

use App\Models\CodePromoModel;

class AdminPromoController extends BaseController
{
    private function requireAdmin()
    {
        if (! session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $promoModel = new CodePromoModel();

        return view('admin/promos/index', [
            'promos' => $promoModel->orderBy('id_code', 'DESC')->findAll(),
            'activeNav' => 'promos',
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/promos/form', [
            'title' => 'Creer un code promo',
            'action' => base_url('admin/promos/store'),
            'promo' => null,
            'validation' => session('validation'),
            'activeNav' => 'promos',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[3]|max_length[50]|is_unique[code_promo.code]',
            'montant' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $promoModel = new CodePromoModel();
        $promoModel->insert([
            'code' => strtoupper(trim((string) $this->request->getPost('code'))),
            'montant' => $this->request->getPost('montant'),
            'deja_utilise' => (bool) $this->request->getPost('deja_utilise'),
            'id_utilisateur_utilisation' => null,
        ]);

        return redirect()->to('/admin/promos')->with('success', 'Code promo cree avec succes.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $promoModel = new CodePromoModel();
        $promo = $promoModel->find($id);

        if (! $promo) {
            return redirect()->to('/admin/promos')->with('error', 'Code promo introuvable.');
        }

        return view('admin/promos/form', [
            'title' => 'Modifier un code promo',
            'action' => base_url('admin/promos/update/' . $id),
            'promo' => $promo,
            'validation' => session('validation'),
            'activeNav' => 'promos',
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $promoModel = new CodePromoModel();
        $promo = $promoModel->find($id);

        if (! $promo) {
            return redirect()->to('/admin/promos')->with('error', 'Code promo introuvable.');
        }

        $rules = [
            'code' => 'required|min_length[3]|max_length[50]|is_unique[code_promo.code,id_code,' . $id . ']',
            'montant' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $promoModel->update($id, [
            'code' => strtoupper(trim((string) $this->request->getPost('code'))),
            'montant' => $this->request->getPost('montant'),
            'deja_utilise' => (bool) $this->request->getPost('deja_utilise'),
        ]);

        return redirect()->to('/admin/promos')->with('success', 'Code promo mis a jour avec succes.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $promoModel = new CodePromoModel();
        if (! $promoModel->find($id)) {
            return redirect()->to('/admin/promos')->with('error', 'Code promo introuvable.');
        }

        $promoModel->delete($id);

        return redirect()->to('/admin/promos')->with('success', 'Code promo supprime avec succes.');
    }

    public function validatePage()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/promos/validate', [
            'result' => session()->getFlashdata('promo_result'),
            'validation' => session()->getFlashdata('validation'),
            'activeNav' => 'promos',
        ]);
    }

    public function validateCode()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[3]|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $code = strtoupper(trim((string) $this->request->getPost('code')));
        $promoModel = new CodePromoModel();
        $promo = $promoModel->where('code', $code)->first();

        if (! $promo) {
            return redirect()->back()->withInput()->with('promo_result', [
                'status' => 'error',
                'message' => 'Code promo introuvable.',
            ]);
        }

        if ((int) ($promo['deja_utilise'] ?? 0) === 1) {
            return redirect()->back()->withInput()->with('promo_result', [
                'status' => 'error',
                'message' => 'Ce code promo a deja ete utilise.',
                'promo' => $promo,
            ]);
        }

        return redirect()->back()->withInput()->with('promo_result', [
            'status' => 'success',
            'message' => 'Code promo valide.',
            'promo' => $promo,
        ]);
    }
}
