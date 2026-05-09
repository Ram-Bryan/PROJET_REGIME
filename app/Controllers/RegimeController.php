<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\CommandeModel;
use App\Models\DureeRegimeModel;
use App\Models\ImcModel;
use App\Models\ObjectifModel;
use App\Models\RegimeActiviteModel;
use App\Models\RegimeModel;
use App\Models\UtilisateurModel;
use CodeIgniter\Exceptions\PageNotFoundException;

require_once APPPATH . 'Libraries/fpdf186/fpdf.php';

class RegimeController extends BaseController
{
    public function index()
    {
        $regimeModel = new RegimeModel();
        $dureeModel = new DureeRegimeModel();
        $objectifModel = new ObjectifModel();
        $regimeActiviteModel = new RegimeActiviteModel();

        $duree = $this->request->getGet('duree');
        $duree = is_numeric($duree) ? (int) $duree : null;

        $objectifParam = $this->request->getGet('objectif');

        if ($objectifParam !== null) {
            // User explicitly chose a filter (either a number or "Tous" which is empty string)
            $objectif = ($objectifParam !== '') ? (int) $objectifParam : null;
        } else {
            // No filter applied yet, try fallback to user's default objective
            $objectif = null;
            if (session()->get('is_logged_in')) {
                $userModel = new UtilisateurModel();
                $user = $userModel->find((int) session()->get('id_utilisateur'));
                if (! empty($user['id_objectif'])) {
                    $objectif = (int) $user['id_objectif'];
                }
            }
        }
        
        $userId = session()->get('is_logged_in') ? (int) session()->get('id_utilisateur') : null;
        $regimes = $regimeModel->getFilteredList($duree, $objectif, $userId);
        $regimeDurees = $dureeModel->getAllGroupedByRegime();
        $dureeOptions = $dureeModel->getDistinctDurations();
        $objectifOptions = $objectifModel->orderBy('id_objectif', 'ASC')->findAll();
        $activityCounts = $regimeActiviteModel->getCountsByRegime();

        $regimes = array_map(function (array $regime) use ($activityCounts) {
            $variation = (float) $regime['variation_mensuelle_kg'];
            $regime['variation_label'] = $this->formatVariationLabel($variation);
            $regime['activity_count'] = $activityCounts[(int) $regime['id_regime']] ?? 0;
            return $regime;
        }, $regimes);

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

    public function show(int $id)
    {
        $regimeModel = new RegimeModel();
        $dureeModel = new DureeRegimeModel();
        $regimeActiviteModel = new RegimeActiviteModel();
        $activiteModel = new ActiviteSportiveModel();
        $imcModel = new ImcModel();
        $userModel = new UtilisateurModel();

        $regime = $regimeModel->find($id);
        if ($regime === null) {
            throw PageNotFoundException::forPageNotFound('Régime introuvable');
        }

        $variation = (float) $regime['variation_mensuelle_kg'];
        $regime['variation_label'] = $this->formatVariationLabel($variation);
        $objectiveLabel = $this->getObjectiveLabel($variation);

        $durees = $dureeModel->getByRegimeId($id);
        $activiteIds = $regimeActiviteModel->getActiviteIdsForRegime($id);
        $activites = $activiteModel->getByIds($activiteIds);

        $user = null;
        if (session()->get('is_logged_in')) {
            $user = $userModel->find((int) session()->get('id_utilisateur'));
        }

        $imcIdeal = $imcModel->getIdealRange();
        $imcIdealMin = $imcIdeal !== null ? (float) $imcIdeal['imc_min'] : null;
        $imcIdealMax = $imcIdeal !== null ? (float) $imcIdeal['imc_max'] : null;

        return view('regime/show', [
            'regime' => $regime,
            'durees' => $durees,
            'activites' => $activites,
            'objectiveLabel' => $objectiveLabel,
            'user' => $user,
            'imcIdealMin' => $imcIdealMin,
            'imcIdealMax' => $imcIdealMax,
        ]);
    }

    public function exportPdf(int $id)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $regimeModel = new RegimeModel();
        $dureeModel = new DureeRegimeModel();
        $regimeActiviteModel = new RegimeActiviteModel();
        $activiteModel = new ActiviteSportiveModel();
        $userModel = new UtilisateurModel();

        $regime = $regimeModel->find($id);
        if ($regime === null) {
            throw PageNotFoundException::forPageNotFound('Régime introuvable');
        }

        $user = $userModel->find((int) session()->get('id_utilisateur'));
        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $durees = $dureeModel->getByRegimeId($id);
        $selectedDuree = null;
        foreach ($durees as $duree) {
            if ($selectedDuree === null || (int) $duree['nb_jours'] > (int) $selectedDuree['nb_jours']) {
                $selectedDuree = $duree;
            }
        }

        $variation = (float) $regime['variation_mensuelle_kg'];
        $estimated = $selectedDuree !== null
            ? $variation * ((int) $selectedDuree['nb_jours'] / 30)
            : $variation;

        $objectifDiff = null;
        if (isset($user['poids_objectif']) && $user['poids_objectif'] !== null) {
            $objectifDiff = (float) $user['poids_kg'] - (float) $user['poids_objectif'];
        }

        $objectiveText = 'Non défini';
        if ($objectifDiff !== null) {
            $absDiff = abs($objectifDiff);
            $formattedDiff = rtrim(rtrim(number_format($absDiff, 2, ',', ' '), '0'), ',');
            if ($objectifDiff > 0) {
                $objectiveText = 'perdre ' . $formattedDiff . 'kg';
            } elseif ($objectifDiff < 0) {
                $objectiveText = 'prendre ' . $formattedDiff . 'kg';
            } else {
                $objectiveText = 'maintenir le poids';
            }
        }

        $activiteIds = $regimeActiviteModel->getActiviteIdsForRegime($id);
        $activites = $activiteModel->getByIds($activiteIds);

        require_once APPPATH . 'Libraries/fpdf186/fpdf.php';
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);

        // Header (Banner)
        $pdf->SetFillColor(41, 128, 185); // Blue
        $pdf->Rect(0, 0, 210, 40, 'F');
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 15);
        $pdf->Cell(0, 10, utf8_decode('PROPOSITION DE REGIME'), 0, 1, 'C');
        $pdf->Ln(20);

        // Reset Text Color
        $pdf->SetTextColor(50, 50, 50);

        // Calculate IMC
        $tailleCm = (float) $user['taille_cm'];
        $poidsKg = (float) $user['poids_kg'];
        $imcText = 'N/A';
        if ($tailleCm > 0 && $poidsKg > 0) {
            $imc = $poidsKg / (($tailleCm / 100) ** 2);
            $imcText = number_format($imc, 1, ',', '') . ' kg/m²';
        }

        // Section: Utilisateur
        $pdf->SetFillColor(236, 240, 241); // Light gray
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Informations Utilisateur'), 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 8, utf8_decode('Nom:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, utf8_decode($user['nom']), 0, 1);
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->Cell(40, 8, utf8_decode('Poids / Taille:'), 0, 0);
        $pdf->Cell(0, 8, utf8_decode($poidsKg . ' kg / ' . $tailleCm . ' cm'), 0, 1);

        $pdf->Cell(40, 8, utf8_decode('IMC Actuel:'), 0, 0);
        $pdf->Cell(0, 8, utf8_decode($imcText), 0, 1);
        
        $pdf->Cell(40, 8, utf8_decode('Objectif:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(231, 76, 60); // Red
        $pdf->Cell(0, 8, utf8_decode($objectiveText), 0, 1);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->Ln(5);

        // Section: Régime
        $pdf->SetFillColor(212, 239, 223); // Light green
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Détails du Régime : ' . $regime['nom_regime']), 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 12);
        
        // Variation
        $pdf->Cell(40, 8, utf8_decode('Objectif visé:'), 0, 0);
        $pdf->Cell(0, 8, utf8_decode($this->formatVariationLabel((float) $regime['variation_mensuelle_kg'])), 0, 1);
        
        // Proportions
        $pdf->Cell(40, 8, utf8_decode('Composition:'), 0, 0);
        $pdf->Cell(0, 8, utf8_decode(
            $regime['pourcentage_viande'] . '% Viande, ' .
            $regime['pourcentage_poisson'] . '% Poisson, ' .
            $regime['pourcentage_volaille'] . '% Volaille'
        ), 0, 1);

        if ($selectedDuree !== null) {
            $pdf->Cell(40, 8, utf8_decode('Durée max:'), 0, 0);
            $pdf->Cell(0, 8, utf8_decode($selectedDuree['nb_jours'] . ' jours'), 0, 1);
        }

        $estimatedLabel = rtrim(rtrim(number_format($estimated, 2, ',', ' '), '0'), ',');
        $estimatedSign = $estimated > 0 ? '+' : '';
        $pdf->Cell(40, 8, utf8_decode('Résultat estimé:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(39, 174, 96); // Dark green
        $pdf->Cell(0, 8, utf8_decode($estimatedSign . $estimatedLabel . ' kg'), 0, 1);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->Ln(5);

        // Section Activites sportives
        $pdf->SetFillColor(252, 243, 207); // Light yellow
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Activités Sportives Recommandées'), 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 12);
        if (empty($activites)) {
            $pdf->Cell(0, 8, utf8_decode('Aucune activité recommandée.'), 0, 1);
        } else {
            foreach ($activites as $activite) {
                // simple bullet
                $pdf->Cell(10, 8, '-', 0, 0, 'C');
                $pdf->Cell(0, 8, utf8_decode($activite['label_activite'] . ' (' . $activite['nb_par_semaine'] . 'x par semaine)'), 0, 1);
            }
        }
        $pdf->Ln(10);

        // Footer / Prix
        $pdf->SetFillColor(236, 240, 241);
        $y = $pdf->GetY();
        $pdf->Rect(10, $y, 190, 25, 'F');
        $pdf->SetY($y + 5);
        $pdf->SetFont('Arial', 'B', 13);
        
        if ($selectedDuree !== null) {
            $priceLabel = number_format((float) $selectedDuree['prix'], 0, ',', ' ');
            $pdf->Cell(0, 8, utf8_decode('Prix indicatif : ' . $priceLabel . ' Ar'), 0, 1, 'C');
        } else {
            $pdf->Cell(0, 8, utf8_decode('Prix indicatif : Non disponible'), 0, 1, 'C');
        }
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(0, 6, utf8_decode('Document généré le ' . date('d/m/Y H:i')), 0, 1, 'C');

        $pdfData = $pdf->Output('S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="regime-' . $id . '.pdf"')
            ->setBody($pdfData);
    }

    public function myRegimes()
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $commandeModel = new CommandeModel();
        $purchases = $commandeModel->getPurchasedRegimesByUserId((int) session()->get('id_utilisateur'));

        $purchases = array_map(function (array $purchase) {
            $variation = (float) ($purchase['variation_mensuelle_kg'] ?? 0);
            $purchase['variation_label'] = $this->formatVariationLabel($variation);
            $purchase['objective_label'] = $this->getObjectiveLabel($variation);
            return $purchase;
        }, $purchases);

        return view('regime/my_regimes', [
            'purchases' => $purchases,
        ]);
    }

    public function myRegimeDetail(int $commandeId)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $commandeModel = new CommandeModel();
        $regimeActiviteModel = new RegimeActiviteModel();
        $activiteModel = new ActiviteSportiveModel();
        $userModel = new UtilisateurModel();

        $userId = (int) session()->get('id_utilisateur');
        $purchase = $commandeModel->getPurchaseById($commandeId, $userId);

        if ($purchase === null) {
            throw PageNotFoundException::forPageNotFound('Achat introuvable');
        }

        $variation = (float) ($purchase['variation_mensuelle_kg'] ?? 0);
        $purchase['variation_label'] = $this->formatVariationLabel($variation);
        $purchase['objective_label'] = $this->getObjectiveLabel($variation);

        $activiteIds = $regimeActiviteModel->getActiviteIdsForRegime((int) $purchase['id_regime']);
        $activites = $activiteModel->getByIds($activiteIds);

        $user = $userModel->find($userId);

        return view('regime/my_regime_detail', [
            'purchase' => $purchase,
            'activites' => $activites,
            'user' => $user,
        ]);
    }

    public function exportRegimePdf(int $commandeId)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $commandeModel = new CommandeModel();
        $regimeActiviteModel = new RegimeActiviteModel();
        $activiteModel = new ActiviteSportiveModel();
        $userModel = new UtilisateurModel();

        $userId = (int) session()->get('id_utilisateur');
        $purchase = $commandeModel->getPurchaseById($commandeId, $userId);

        if ($purchase === null) {
            throw PageNotFoundException::forPageNotFound('Achat introuvable');
        }

        $user = $userModel->find($userId);
        if ($user === null) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $activiteIds = $regimeActiviteModel->getActiviteIdsForRegime((int) $purchase['id_regime']);
        $activites = $activiteModel->getByIds($activiteIds);

        $variation = (float) ($purchase['variation_mensuelle_kg'] ?? 0);
        $estimated = $variation * ((int) ($purchase['nb_jours'] ?? 0) / 30);

        $objectifDiff = null;
        if (isset($user['poids_objectif']) && $user['poids_objectif'] !== null) {
            $objectifDiff = (float) $user['poids_kg'] - (float) $user['poids_objectif'];
        }

        $objectiveText = 'Non défini';
        if ($objectifDiff !== null) {
            $absDiff = abs($objectifDiff);
            $formattedDiff = rtrim(rtrim(number_format($absDiff, 2, ',', ' '), '0'), ',');
            if ($objectifDiff > 0) {
                $objectiveText = 'perdre ' . $formattedDiff . 'kg';
            } elseif ($objectifDiff < 0) {
                $objectiveText = 'prendre ' . $formattedDiff . 'kg';
            } else {
                $objectiveText = 'maintenir le poids';
            }
        }

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);

        // Header (Banner)
        $pdf->SetFillColor(46, 204, 113); // Emerald Green
        $pdf->Rect(0, 0, 210, 40, 'F');
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 15);
        $pdf->Cell(0, 10, utf8_decode('RECAPITULATIF DE VOTRE ACHAT'), 0, 1, 'C');
        $pdf->Ln(20);

        // Reset Text Color
        $pdf->SetTextColor(50, 50, 50);

        // Calculate IMC
        $tailleCm = (float) $user['taille_cm'];
        $poidsKg = (float) $user['poids_kg'];
        $imcText = 'N/A';
        if ($tailleCm > 0 && $poidsKg > 0) {
            $imc = $poidsKg / (($tailleCm / 100) ** 2);
            $imcText = number_format($imc, 1, ',', '') . ' kg/m²';
        }

        // Section: Utilisateur
        $pdf->SetFillColor(236, 240, 241);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Informations Client'), 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 7, utf8_decode('Nom:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 7, utf8_decode($user['nom']), 0, 1);
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(40, 7, utf8_decode('Email:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode($user['email']), 0, 1);
        $pdf->Cell(40, 7, utf8_decode('Poids / Taille:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode($poidsKg . ' kg / ' . $tailleCm . ' cm'), 0, 1);
        $pdf->Cell(40, 7, utf8_decode('IMC Actuel:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode($imcText), 0, 1);
        
        $pdf->Cell(40, 7, utf8_decode('Objectif:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(231, 76, 60);
        $pdf->Cell(0, 7, utf8_decode($objectiveText), 0, 1);
        $pdf->SetTextColor(50, 50, 50);

        $pdf->Ln(5);

        // Section: Achats
        $pdf->SetFillColor(212, 239, 223); // Light green
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Détails de la Commande N° ' . $commandeId), 0, 1, 'L', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 7, utf8_decode('Régime:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 7, utf8_decode($purchase['nom_regime']), 0, 1);
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->Cell(40, 7, utf8_decode('Objectif visé:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode($this->formatVariationLabel((float) ($purchase['variation_mensuelle_kg'] ?? 0))), 0, 1);
        
        $pdf->Cell(40, 7, utf8_decode('Composition:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode(
            ($purchase['pourcentage_viande'] ?? 0) . '% Viande, ' .
            ($purchase['pourcentage_poisson'] ?? 0) . '% Poisson, ' .
            ($purchase['pourcentage_volaille'] ?? 0) . '% Volaille'
        ), 0, 1);
        
        $pdf->Cell(40, 7, utf8_decode('Durée:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode($purchase['nb_jours'] . ' jours'), 0, 1);
        $pdf->Cell(40, 7, utf8_decode('Date d\'achat:'), 0, 0);
        $pdf->Cell(0, 7, utf8_decode(date('d/m/Y', strtotime((string) $purchase['date_achat']))), 0, 1);

        $estimatedLabel = rtrim(rtrim(number_format($estimated, 2, ',', ' '), '0'), ',');
        $estimatedSign = $estimated > 0 ? '+' : '';
        $pdf->Cell(40, 7, utf8_decode('Résultat estimé:'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(39, 174, 96);
        $pdf->Cell(0, 7, utf8_decode($estimatedSign . $estimatedLabel . ' kg'), 0, 1);
        $pdf->SetTextColor(50, 50, 50);

        $pdf->Ln(5);
        
        // Section Activites sportives
        $pdf->SetFillColor(252, 243, 207); // Light yellow
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('  Activités Sportives Requises'), 0, 1, 'L', true);
        $pdf->Ln(2);
        
        $pdf->SetFont('Arial', '', 12);
        if (empty($activites)) {
            $pdf->Cell(0, 7, utf8_decode('Aucune activité recommandée.'), 0, 1);
        } else {
            foreach ($activites as $activite) {
                $pdf->Cell(10, 7, '-', 0, 0, 'C');
                $pdf->Cell(0, 7, utf8_decode($activite['label_activite'] . ' (' . $activite['nb_par_semaine'] . 'x par semaine)'), 0, 1);
            }
        }

        $pdf->Ln(10);
        
        // Footer / Facturation
        $pdf->SetFillColor(236, 240, 241);
        $y = $pdf->GetY();
        $pdf->Rect(10, $y, 190, 25, 'F');
        $pdf->SetY($y + 5);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(95, 8, utf8_decode('MONTANT TOTAL PAYE :'), 0, 0, 'R');
        $pdf->SetTextColor(192, 57, 43); // Dark red
        $pdf->Cell(95, 8, utf8_decode(number_format((float) $purchase['montant_paye'], 0, ',', ' ') . ' Ariary'), 0, 1, 'L');
        
        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln(2);
        $pdf->Cell(0, 6, utf8_decode('Merci de votre confiance. Gardez ce document comme reçu.'), 0, 1, 'C');

        $pdfData = $pdf->Output('S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="achat-' . $commandeId . '.pdf"')
            ->setBody($pdfData);
    }


    private function formatVariationLabel(float $variation): string
    {
        $formatted = number_format($variation, 2, ',', ' ');
        $formatted = rtrim(rtrim($formatted, '0'), ',');
        $sign = $variation > 0 ? '+' : '';

        return $sign . $formatted . ' kg / 30 j';
    }

    private function getObjectiveLabel(float $variation): string
    {
        if ($variation > 0) {
            return 'Prise de masse';
        }

        if ($variation < 0) {
            return 'Perte de poids';
        }

        return 'IMC idéal';
    }
}
