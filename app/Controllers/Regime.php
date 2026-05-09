<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use App\Models\DureeRegimeModel;
use App\Models\ObjectifModel;
use App\Models\RegimeModel;
use App\Models\UtilisateurModel;

class Regime extends BaseController
{
    public function index()
    {
        $regimeModel = new RegimeModel();
        $dureeModel = new DureeRegimeModel();

        $duree = $this->request->getGet('duree');
        $duree = is_numeric($duree) ? (int) $duree : null;
        $objectif = $this->request->getGet('objectif');
        $objectif = is_numeric($objectif) ? (int) $objectif : null;

        $regimes = $regimeModel->getFilteredList($duree, $objectif);
        $regimeDurees = $dureeModel->getAllGroupedByRegime();
        $dureeOptions = $dureeModel->getDistinctDurations();
        $objectifModel = new ObjectifModel();
        $objectifOptions = $objectifModel->orderBy('id_objectif', 'ASC')->findAll();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'regimes' => $regimes,
                'regimeDurees' => $regimeDurees,
            ]);
        }

        return view('regime/index', [
            'regimes' => $regimes,
            'regimeDurees' => $regimeDurees,
            'dureeOptions' => $dureeOptions,
            'selectedDuree' => $duree,
            'selectedObjectif' => $objectif,
            'objectifOptions' => $objectifOptions,
        ]);
    }

    public function purchase(int $idRegime)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($idRegime);

        if ($regime === null) {
            return redirect()->to('/regimes')->with('error', 'Régime introuvable.');
        }

        $dureeRegimeModel = new DureeRegimeModel();
        $durees = $dureeRegimeModel->getByRegimeId($idRegime);

        $userModel = new UtilisateurModel();
        $user = $userModel->find((int) session()->get('id_utilisateur'));

        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Utilisateur introuvable.');
        }

        $isGold = (bool) ($user['is_gold'] ?? false);
        $discountPercent = $isGold ? 15.0 : 0.0;

        $dureesAffichees = array_map(static function (array $duree) use ($discountPercent): array {
            $prixBase = (float) $duree['prix'];
            $prixFinal = round($prixBase * (1 - ($discountPercent / 100)), 2);

            return $duree + [
                'prix_final' => $prixFinal,
            ];
        }, $durees);

        return view('regime/purchase', [
            'regime' => $regime,
            'durees' => $dureesAffichees,
            'isGold' => $isGold,
            'discountPercent' => $discountPercent,
            'argent' => (float) ($user['argent'] ?? 0),
        ]);
    }

    public function confirmPurchase(int $idRegime)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $rules = [
            'id_duree_regime' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez choisir une durée de régime valide.');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($idRegime);

        if ($regime === null) {
            return redirect()->to('/regimes')->with('error', 'Régime introuvable.');
        }

        $dureeRegimeModel = new DureeRegimeModel();
        $idDureeRegime = (int) $this->request->getPost('id_duree_regime');
        $duree = $dureeRegimeModel->find($idDureeRegime);

        if ($duree === null || (int) $duree['id_regime'] !== $idRegime) {
            return redirect()->back()->withInput()->with('error', 'Durée de régime invalide.');
        }

        $userModel = new UtilisateurModel();
        $user = $userModel->find((int) session()->get('id_utilisateur'));

        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Utilisateur introuvable.');
        }

        $isGold = (bool) ($user['is_gold'] ?? false);
        $discountPercent = $isGold ? 15.0 : 0.0;
        $prixBase = (float) $duree['prix'];
        $prixFinal = round($prixBase * (1 - ($discountPercent / 100)), 2);
        $soldeActuel = (float) ($user['argent'] ?? 0);

        if ($soldeActuel < $prixFinal) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour effectuer cet achat.');
        }

        $commandeModel = new CommandeModel();
        $commandeModel->insert([
            'id_utilisateur' => (int) $user['id_utilisateur'],
            'id_regime' => $idRegime,
            'id_duree_regime' => $idDureeRegime,
            'montant_paye' => $prixFinal,
        ]);

        $nouveauSolde = round($soldeActuel - $prixFinal, 2);
        $userModel->update((int) $user['id_utilisateur'], [
            'argent' => $nouveauSolde,
        ]);

        session()->set('argent', $nouveauSolde);

        return redirect()->to('/transactions')->with('success', 'Achat effectué avec succès.');
    }
}
