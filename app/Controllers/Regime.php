<?php

namespace App\Controllers;

use App\Models\RegimeModel;

class Regime extends BaseController
{
    public function index()
    {
        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->orderBy('nom_regime', 'ASC')->findAll();

        return view('regime/index', [
            'regimes' => $regimes,
        ]);
    }
}
