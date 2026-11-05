<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Student;

class StatsController extends Controller
{
    public function index()
    {
        return [
            'total_etudiants'    => Student::count(),
            'total_formations'   => Formation::count(),
            'total_inscriptions' => Inscription::count(),
            'revenus_potentiels' => Inscription::join('formations', 'formations.id', '=', 'inscriptions.formation_id')
                                        ->sum('formations.frais'),
            'par_formation'      => Formation::withCount('inscriptions')->get(['id', 'intitule']),
            'par_statut'         => Inscription::selectRaw('statut, count(*) as total')->groupBy('statut')->get(),
            'par_sexe'           => Student::selectRaw('sexe, count(*) as total')->groupBy('sexe')->get(),
        ];
    }
}