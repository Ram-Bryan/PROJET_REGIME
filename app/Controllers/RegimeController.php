<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use App\Models\DureeRegimeModel;
use App\Models\ObjectifModel;
use App\Models\RegimeActiviteModel;
use App\Models\RegimeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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
        $objectif = $this->request->getGet('objectif');
        $objectif = is_numeric($objectif) ? (int) $objectif : null;

        $regimes = $regimeModel->getFilteredList($duree, $objectif);
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

        return view('regime/show', [
            'regime' => $regime,
            'durees' => $durees,
            'activites' => $activites,
            'objectiveLabel' => $objectiveLabel,
        ]);
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
