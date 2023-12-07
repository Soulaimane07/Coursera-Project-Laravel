<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
      
    ];

    public function cours()
    {
        return $this->belongsToMany(Cour::class, 'cours_professeur', 'professeur_id', 'cour_id');
    }
}
