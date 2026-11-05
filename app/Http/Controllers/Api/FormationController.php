<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $query = Formation::query()->withCount('inscriptions');

        if ($request->search) {
            $query->where('intitule', 'like', "%{$request->search}%");
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        return $request->boolean('all') ? $query->get() : $query->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'intitule'    => 'required|string|max:150',
            'description' => 'nullable|string',
            'duree_mois'  => 'required|integer|min:1',
            'frais'       => 'required|numeric|min:0',
            'statut'      => 'required|in:actif,inactif',
        ]);

        return response()->json(Formation::create($data), 201);
    }

    public function show(Formation $formation)
    {
        return $formation->load('students');
    }

    public function update(Request $request, Formation $formation)
    {
        $data = $request->validate([
            'intitule'    => 'required|string|max:150',
            'description' => 'nullable|string',
            'duree_mois'  => 'required|integer|min:1',
            'frais'       => 'required|numeric|min:0',
            'statut'      => 'required|in:actif,inactif',
        ]);

        $formation->update($data);
        return $formation;
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return response()->json(['message' => 'Formation supprimée']);
    }
}