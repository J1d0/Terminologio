<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illustration extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'default_language', // La langue par défaut de l'illustration
        // Ajoutez ici les autres attributs pertinents comme 'path' pour le chemin de l'image, etc.
    ];

    // Relation avec le modèle User (si un utilisateur peut posséder une illustration)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le modèle ComposantIllustration (une illustration a plusieurs composants)
    public function composants()
    {
        return $this->hasMany(ComposantIllustration::class);
    }

    // Relation avec le modèle de traduction si nécessaire
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    // Vous pouvez ajouter d'autres relations ou logiques métier nécessaires ici.
}
