<?php

namespace App\Controllers;

use App\Models\DureeRegimeModel;
use App\Models\RegimeModel;

class AdminRegimeController extends BaseController
{
    private function requireAdmin()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = db_connect();
        $builder = $db->table('regime r');
        $builder->select('r.id_regime, r.nom_regime, r.variation_poids, r.pourcentage_viande, r.pourcentage_poisson, r.pourcentage_volaille, d.id_duree_regime, d.nb_jours, d.prix');
        $builder->join('duree_regime d', 'd.id_regime = r.id_regime', 'left');

        $nomRegime = trim((string) $this->request->getGet('nom_regime'));
        $variationMin = $this->request->getGet('variation_min');
        $variationMax = $this->request->getGet('variation_max');
        $dureeMin = $this->request->getGet('duree_min');
        $dureeMax = $this->request->getGet('duree_max');
        $prixMin = $this->request->getGet('prix_min');
        $prixMax = $this->request->getGet('prix_max');

        if ($nomRegime !== '') {
            $builder->like('r.nom_regime', $nomRegime);
        }

        if ($variationMin !== null && $variationMin !== '') {
            $builder->where('r.variation_poids >=', (float) $variationMin);
        }

        if ($variationMax !== null && $variationMax !== '') {
            $builder->where('r.variation_poids <=', (float) $variationMax);
        }

        if ($dureeMin !== null && $dureeMin !== '') {
            $builder->where('d.nb_jours >=', (int) $dureeMin);
        }

        if ($dureeMax !== null && $dureeMax !== '') {
            $builder->where('d.nb_jours <=', (int) $dureeMax);
        }

        if ($prixMin !== null && $prixMin !== '') {
            $builder->where('d.prix >=', (float) $prixMin);
        }

        if ($prixMax !== null && $prixMax !== '') {
            $builder->where('d.prix <=', (float) $prixMax);
        }

        $builder->orderBy('r.id_regime', 'DESC');
        $builder->orderBy('d.nb_jours', 'ASC');

        return view('admin/regimes/index', [
            'regimes' => $builder->get()->getResultArray(),
            'filters' => [
                'nom_regime' => $nomRegime,
                'variation_min' => $variationMin,
                'variation_max' => $variationMax,
                'duree_min' => $dureeMin,
                'duree_max' => $dureeMax,
                'prix_min' => $prixMin,
                'prix_max' => $prixMax,
            ],
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/regimes/form', [
            'title' => 'Créer un régime',
            'action' => base_url('admin/regimes/store'),
            'regime' => null,
            'validation' => session('validation'),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom_regime' => 'required|min_length[3]|max_length[100]',
            'variation_poids' => 'required|numeric',
            'pourcentage_viande' => 'required|numeric',
            'pourcentage_poisson' => 'required|numeric',
            'pourcentage_volaille' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $regimeModel = new RegimeModel();
        $regimeModel->insert([
            'nom_regime' => $this->request->getPost('nom_regime'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille'),
        ]);

        return redirect()->to('/admin/regimes')->with('success', 'Régime créé avec succès.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (! $regime) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        return view('admin/regimes/form', [
            'title' => 'Modifier le régime',
            'action' => base_url('admin/regimes/update/' . $id),
            'regime' => $regime,
            'validation' => session('validation'),
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom_regime' => 'required|min_length[3]|max_length[100]',
            'variation_poids' => 'required|numeric',
            'pourcentage_viande' => 'required|numeric',
            'pourcentage_poisson' => 'required|numeric',
            'pourcentage_volaille' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (! $regime) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $regimeModel->update($id, [
            'nom_regime' => $this->request->getPost('nom_regime'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille'),
        ]);

        return redirect()->to('/admin/regimes')->with('success', 'Régime mis à jour avec succès.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (! $regime) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $regimeModel->delete($id);

        return redirect()->to('/admin/regimes')->with('success', 'Régime supprimé avec succès.');
    }

    public function durees(int $regimeId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);

        if (! $regime) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Régime introuvable.',
            ])->setStatusCode(404);
        }

        $dureeRegimeModel = new DureeRegimeModel();

        return $this->response->setJSON([
            'status' => 'success',
            'regime' => $regime,
            'durees' => $dureeRegimeModel->where('id_regime', $regimeId)->orderBy('nb_jours', 'ASC')->findAll(),
        ]);
    }

    public function storeDuree(int $regimeId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        if (! $regimeModel->find($regimeId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Régime introuvable.',
            ])->setStatusCode(404);
        }

        $rules = [
            'nb_jours' => 'required|is_natural_no_zero',
            'prix' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors(),
            ])->setStatusCode(422);
        }

        $dureeRegimeModel = new DureeRegimeModel();
        $id = $dureeRegimeModel->insert([
            'id_regime' => $regimeId,
            'nb_jours' => (int) $this->request->getPost('nb_jours'),
            'prix' => $this->request->getPost('prix'),
        ], true);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Durée-prix créée avec succès.',
            'id_duree_regime' => $id,
        ])->setStatusCode(201);
    }

    public function updateDuree(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $dureeRegimeModel = new DureeRegimeModel();
        $duree = $dureeRegimeModel->find($id);

        if (! $duree) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Durée-prix introuvable.',
            ])->setStatusCode(404);
        }

        $rules = [
            'nb_jours' => 'required|is_natural_no_zero',
            'prix' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors(),
            ])->setStatusCode(422);
        }

        $dureeRegimeModel->update($id, [
            'nb_jours' => (int) $this->request->getPost('nb_jours'),
            'prix' => $this->request->getPost('prix'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Durée-prix mise à jour avec succès.',
        ]);
    }

    public function deleteDuree(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $dureeRegimeModel = new DureeRegimeModel();
        $duree = $dureeRegimeModel->find($id);

        if (! $duree) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Durée-prix introuvable.',
            ])->setStatusCode(404);
        }

        $dureeRegimeModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Durée-prix supprimée avec succès.',
        ]);
    }
}
