<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'libelle',
        'desc',
        'dateDebut',
        'dateFin',
    ];

    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'cours_professeur', 'cour_id', 'professeur_id');
    }
}
