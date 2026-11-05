<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->withCount('inscriptions');

        if ($s = $request->search) {
            $query->where(function ($q) use ($s) {
                $q->where('nom', 'like', "%$s%")
                  ->orWhere('prenom', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('matricule', 'like', "%$s%");
            });
        }
        if ($request->sexe) {
            $query->where('sexe', $request->sexe);
        }
        if ($request->formation_id) {
            $query->whereHas('inscriptions', fn($q) =>
                $q->where('formation_id', $request->formation_id));
        }

        return $query->latest()->paginate($request->per_page ?? 10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule'      => 'required|string|max:30|unique:students',
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'email'          => 'required|email|unique:students',
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe'           => 'required|in:M,F',
            'adresse'        => 'nullable|string|max:255',
        ]);

        return response()->json(Student::create($data), 201);
    }

    public function show(Student $student)
    {
        return $student->load('formations');
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'matricule'      => ['required', 'string', 'max:30', Rule::unique('students')->ignore($student->id)],
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'email'          => ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe'           => 'required|in:M,F',
            'adresse'        => 'nullable|string|max:255',
        ]);

        $student->update($data);
        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Étudiant supprimé']);
    }
}