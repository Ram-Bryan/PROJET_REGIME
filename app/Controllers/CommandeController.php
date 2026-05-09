<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use App\Models\DureeRegimeModel;
use App\Models\UtilisateurModel;

class CommandeController extends BaseController
{
    public function purchase(int $id)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $dureeId = $this->request->getGet('duree');
        $dureeId = is_numeric($dureeId) ? (int) $dureeId : null;

        if ($dureeId === null) {
            return redirect()->to('/regimes/' . $id)->with('error', 'Veuillez choisir une durée.');
        }

        return $this->handlePurchase($id, $dureeId);
    }

    public function confirmPurchase(int $id)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $dureeId = $this->request->getPost('duree');
        $dureeId = is_numeric($dureeId) ? (int) $dureeId : null;

        if ($dureeId === null) {
            return redirect()->to('/regimes/' . $id)->with('error', 'Veuillez choisir une durée.');
        }

        return $this->handlePurchase($id, $dureeId);
    }

    private function handlePurchase(int $regimeId, int $dureeId)
    {
        $dureeModel = new DureeRegimeModel();
        $commandeModel = new CommandeModel();
        $userModel = new UtilisateurModel();

        $userId = (int) session()->get('id_utilisateur');
        if ($commandeModel->hasActiveRegime($userId, $regimeId, $dureeId)) {
            return redirect()->to('/mes-regimes')->with('error', 'Vous avez déjà ce régime pour cette durée.');
        }

        $duree = $dureeModel->find($dureeId);
        if ($duree === null || (int) $duree['id_regime'] !== $regimeId) {
            return redirect()->to('/regimes/' . $regimeId)->with('error', 'Durée invalide.');
        }

        $user = $userModel->find($userId);
        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $prix = (float) $duree['prix'];
        $argent = (float) ($user['argent'] ?? 0);
        if ($argent < $prix) {
            return redirect()->to('/mes-regimes')->with('error', 'Solde insuffisant pour acheter ce régime.');
        }

        $newSolde = $argent - $prix;
        $userModel->update($userId, ['argent' => $newSolde]);
        session()->set('argent', $newSolde);

        $commandeModel->insert([
            'id_utilisateur' => $userId,
            'id_regime' => $regimeId,
            'id_duree_regime' => $dureeId,
            'montant_paye' => $prix,
        ]);

        return redirect()->to('/mes-regimes')->with('success', 'Régime acheté avec succès.');
    }
}
