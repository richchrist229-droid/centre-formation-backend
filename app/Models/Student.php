<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'matricule', 'nom', 'prenom', 'email',
        'telephone', 'date_naissance', 'sexe', 'adresse',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'inscriptions');
    }
}