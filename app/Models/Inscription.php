<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'student_id', 'formation_id', 'date_inscription', 'statut',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}