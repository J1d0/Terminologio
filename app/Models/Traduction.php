<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduction extends Model
{
    use HasFactory;

    protected $table = 'traductions';
    protected $fillable = [
        'composant_num', // Numéro du composant
        'langue', // Langue de la traduction
        'texte', // Texte de la traduction
        'image_path_id', // ID de l'illustration
        
    ];

    // Relation avec le modèle ComposantIllustration (une traduction appartient à un composant d'illustration)
    public function composantIllustration()
    {
        return $this->belongsTo(ComposantIllustration::class);
    }
}
