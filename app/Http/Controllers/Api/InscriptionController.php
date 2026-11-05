<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inscription::with([
            'student:id,nom,prenom,matricule',
            'formation:id,intitule',
        ]);

        if ($request->formation_id) {
            $query->where('formation_id', $request->formation_id);
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        return $query->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'       => 'required|exists:students,id',
            'formation_id'     => 'required|exists:formations,id',
            'date_inscription' => 'required|date',
            'statut'           => 'required|in:en_cours,terminee,abandonnee',
        ]);

        $existe = Inscription::where('student_id', $data['student_id'])
            ->where('formation_id', $data['formation_id'])
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'Étudiant déjà inscrit à cette formation'], 422);
        }

        return response()->json(Inscription::create($data), 201);
    }

    public function update(Request $request, Inscription $inscription)
    {
        $data = $request->validate([
            'statut' => 'required|in:en_cours,terminee,abandonnee',
        ]);

        $inscription->update($data);
        return $inscription;
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return response()->json(['message' => 'Inscription supprimée']);
    }
}