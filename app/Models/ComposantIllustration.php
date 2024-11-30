<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComposantIllustration extends Model
{
    use HasFactory;

    // Spécifiez le nom de la table si ce n'est pas le pluriel du nom du modèle
    protected $table = 'composants_illustrations';

    // Définissez les attributs qui sont assignables en masse
    protected $fillable = [
        'image_path_id',
        'nom', // Nom du composant
        'numero', // Description ou terminologie du composant
        'x',
        'y',
    ];

    // Relation avec le modèle Illustration (un composant appartient à une illustration)
    public function illustration()
    {
        return $this->belongsTo(Illustration::class);
    }

    // Si vous avez un modèle pour les Traductions, définissez la relation ici
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}

