<?php

namespace App\Controllers;

use App\Models\DureeRegimeModel;
use App\Models\ObjectifModel;
use App\Models\RegimeModel;

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
}
