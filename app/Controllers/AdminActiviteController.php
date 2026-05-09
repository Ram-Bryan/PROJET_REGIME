<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\RegimeModel;

class AdminActiviteController extends BaseController
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

        $activiteModel = new ActiviteSportiveModel();
        $regimeModel = new RegimeModel();

        return view('admin/activites/index', [
            'activites' => $activiteModel->orderBy('id_activite', 'DESC')->findAll(),
            'regimes' => $regimeModel->select('id_regime, nom_regime')->orderBy('nom_regime', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/activites/form', [
            'title' => 'Créer une activité sportive',
            'action' => base_url('admin/activites/store'),
            'activite' => null,
            'validation' => session('validation'),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'label_activite' => 'required|min_length[3]|max_length[100]',
            'nb_par_semaine' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $activiteModel = new ActiviteSportiveModel();
        $activiteModel->insert([
            'label_activite' => $this->request->getPost('label_activite'),
            'nb_par_semaine' => (int) $this->request->getPost('nb_par_semaine'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activité sportive créée avec succès.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activiteModel = new ActiviteSportiveModel();
        $activite = $activiteModel->find($id);

        if (! $activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activité introuvable.');
        }

        return view('admin/activites/form', [
            'title' => 'Modifier une activité sportive',
            'action' => base_url('admin/activites/update/' . $id),
            'activite' => $activite,
            'validation' => session('validation'),
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'label_activite' => 'required|min_length[3]|max_length[100]',
            'nb_par_semaine' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $activiteModel = new ActiviteSportiveModel();
        if (! $activiteModel->find($id)) {
            return redirect()->to('/admin/activites')->with('error', 'Activité introuvable.');
        }

        $activiteModel->update($id, [
            'label_activite' => $this->request->getPost('label_activite'),
            'nb_par_semaine' => (int) $this->request->getPost('nb_par_semaine'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activité sportive mise à jour avec succès.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activiteModel = new ActiviteSportiveModel();
        if (! $activiteModel->find($id)) {
            return redirect()->to('/admin/activites')->with('error', 'Activité introuvable.');
        }

        $activiteModel->delete($id);

        return redirect()->to('/admin/activites')->with('success', 'Activité sportive supprimée avec succès.');
    }

    public function regimeActivites(int $regimeId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        if (! $regimeModel->find($regimeId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Régime introuvable.'])->setStatusCode(404);
        }

        $db = db_connect();
        $assigned = $db->table('regime_activite ra')
            ->select('ra.id_regime_activite, a.id_activite, a.label_activite, a.nb_par_semaine')
            ->join('activite_sportive a', 'a.id_activite = ra.id_activite')
            ->where('ra.id_regime', $regimeId)
            ->orderBy('a.label_activite', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'status' => 'success',
            'regime_id' => $regimeId,
            'activites' => $assigned,
        ]);
    }

    public function addRegimeActivite(int $regimeId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'id_activite' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()])->setStatusCode(422);
        }

        $activiteId = (int) $this->request->getPost('id_activite');
        $db = db_connect();

        $exists = $db->table('regime_activite')
            ->where('id_regime', $regimeId)
            ->where('id_activite', $activiteId)
            ->countAllResults();

        if ($exists > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cette activité est déjà liée à ce régime.'])->setStatusCode(409);
        }

        $db->table('regime_activite')->insert([
            'id_regime' => $regimeId,
            'id_activite' => $activiteId,
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Activité ajoutée au régime.'])->setStatusCode(201);
    }

    public function removeRegimeActivite(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = db_connect();
        $row = $db->table('regime_activite')->where('id_regime_activite', $id)->get()->getRowArray();

        if (! $row) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Lien introuvable.'])->setStatusCode(404);
        }

        $db->table('regime_activite')->where('id_regime_activite', $id)->delete();

        return $this->response->setJSON(['status' => 'success', 'message' => 'Lien supprimé.']);
    }
}