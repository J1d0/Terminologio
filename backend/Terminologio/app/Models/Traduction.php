<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'composant_illustration_id',
        'language', // Langue de la traduction
        'text', // Texte de la traduction
        // Ajoutez ici les autres attributs pertinents
    ];

    // Relation avec le modèle ComposantIllustration (une traduction appartient à un composant d'illustration)
    public function composantIllustration()
    {
        return $this->belongsTo(ComposantIllustration::class);
    }

    // Vous pouvez ajouter d'autres relations ou logiques métier nécessaires ici.
}
