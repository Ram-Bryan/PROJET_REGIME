<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\RegimeModel;

class AdminActiviteController extends BaseController
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

        $filters = [
            'label_activite' => trim((string) $this->request->getGet('label_activite')),
            'frequence_min' => $this->request->getGet('frequence_min'),
            'frequence_max' => $this->request->getGet('frequence_max'),
        ];

        return view('admin/activites/index', [
            'activites' => $this->getActivityListing($filters),
            'filters' => $filters,
            'activeNav' => 'activites',
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/activites/form', [
            'title' => 'Creer une activite sportive',
            'action' => base_url('admin/activites/store'),
            'activite' => null,
            'validation' => session('validation'),
            'activeNav' => 'activites',
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
            'label_activite' => trim((string) $this->request->getPost('label_activite')),
            'nb_par_semaine' => (int) $this->request->getPost('nb_par_semaine'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite sportive creee avec succes.');
    }

    public function show(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activite = (new ActiviteSportiveModel())->find($id);

        if (! $activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        return view('admin/activites/show', [
            'activite' => $activite,
            'linkedRegimes' => $this->getLinkedRegimes($id),
            'activeNav' => 'activites',
        ]);
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activiteModel = new ActiviteSportiveModel();
        $activite = $activiteModel->find($id);

        if (! $activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        return view('admin/activites/form', [
            'title' => 'Modifier une activite sportive',
            'action' => base_url('admin/activites/update/' . $id),
            'activite' => $activite,
            'validation' => session('validation'),
            'activeNav' => 'activites',
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
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        $activiteModel->update($id, [
            'label_activite' => trim((string) $this->request->getPost('label_activite')),
            'nb_par_semaine' => (int) $this->request->getPost('nb_par_semaine'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite sportive mise a jour avec succes.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $activiteModel = new ActiviteSportiveModel();
        $activite = $activiteModel->find($id);

        if (! $activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        $linkedCount = db_connect()->table('regime_activite')
            ->where('id_activite', $id)
            ->countAllResults();

        if ($linkedCount > 0) {
            return redirect()->to('/admin/activites')->with(
                'error',
                'Suppression impossible: cette activite est liee a ' . $linkedCount . ' regime(s).'
            );
        }

        $activiteModel->delete($id);

        return redirect()->to('/admin/activites')->with('success', 'Activite sportive supprimee avec succes.');
    }

    public function regimeActivites(int $regimeId)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $regimeModel = new RegimeModel();
        if (! $regimeModel->find($regimeId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Regime introuvable.'])->setStatusCode(404);
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
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cette activite est deja liee a ce regime.'])->setStatusCode(409);
        }

        $db->table('regime_activite')->insert([
            'id_regime' => $regimeId,
            'id_activite' => $activiteId,
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Activite ajoutee au regime.'])->setStatusCode(201);
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

        return $this->response->setJSON(['status' => 'success', 'message' => 'Lien supprime.']);
    }

    private function getActivityListing(array $filters): array
    {
        $builder = db_connect()->table('activite_sportive a');
        $builder->select([
            'a.id_activite',
            'a.label_activite',
            'a.nb_par_semaine',
            'COUNT(DISTINCT ra.id_regime_activite) AS nb_regimes',
        ]);
        $builder->join('regime_activite ra', 'ra.id_activite = a.id_activite', 'left');

        if ($filters['label_activite'] !== '') {
            $builder->like('a.label_activite', $filters['label_activite']);
        }

        if ($filters['frequence_min'] !== null && $filters['frequence_min'] !== '') {
            $builder->where('a.nb_par_semaine >=', (int) $filters['frequence_min']);
        }

        if ($filters['frequence_max'] !== null && $filters['frequence_max'] !== '') {
            $builder->where('a.nb_par_semaine <=', (int) $filters['frequence_max']);
        }

        $builder->groupBy([
            'a.id_activite',
            'a.label_activite',
            'a.nb_par_semaine',
        ]);
        $builder->orderBy('a.label_activite', 'ASC');

        return $builder->get()->getResultArray();
    }

    private function getLinkedRegimes(int $activityId): array
    {
        $db = db_connect();
        $variationColumn = $db->fieldExists('variation_mensuelle_kg', 'regime')
            ? 'variation_mensuelle_kg'
            : 'variation_poids';

        return $db->table('regime_activite ra')
            ->select([
                'r.id_regime',
                'r.nom_regime',
                'r.' . $variationColumn . ' AS variation_mensuelle_kg',
            ])
            ->join('regime r', 'r.id_regime = ra.id_regime')
            ->where('ra.id_activite', $activityId)
            ->orderBy('r.nom_regime', 'ASC')
            ->get()
            ->getResultArray();
    }
}
