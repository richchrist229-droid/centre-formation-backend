<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'intitule', 'description', 'duree_mois', 'frais', 'statut',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'inscriptions');
    }
}