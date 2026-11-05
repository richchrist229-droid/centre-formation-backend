<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Formation::insert([
            ['intitule' => 'Développement Web', 'duree_mois' => 6, 'frais' => 150000, 'statut' => 'actif', 'created_at' => now(), 'updated_at' => now()],
            ['intitule' => 'Bureautique', 'duree_mois' => 3, 'frais' => 50000, 'statut' => 'actif', 'created_at' => now(), 'updated_at' => now()],
            ['intitule' => 'Marketing Digital', 'duree_mois' => 4, 'frais' => 100000, 'statut' => 'actif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $noms = [['Koffi', 'Marc'], ['Adjovi', 'Sarah'], ['Hounkpatin', 'Paul'], ['Dossou', 'Grace'], ['Agbo', 'Jean']];

        foreach ($noms as $i => [$nom, $prenom]) {
            Student::create([
                'matricule' => 'ETU' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nom'       => $nom,
                'prenom'    => $prenom,
                'email'     => strtolower($prenom) . '@exemple.com',
                'telephone' => '019000' . $i . '00',
                'sexe'      => $i % 2 === 0 ? 'M' : 'F',
            ]);
        }
    }
}