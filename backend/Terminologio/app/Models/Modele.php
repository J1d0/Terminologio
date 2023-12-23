<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;

    // Définissez les attributs qui sont assignables en masse
    protected $fillable = [
        'name', // Nom du domaine, par exemple 'Biologie', 'Physique', etc.
    ];

    // Relation avec le modèle Illustration (un domaine peut avoir plusieurs illustrations)
    public function illustrations()
    {
        return $this->hasMany(Illustration::class);
    }

    // Vous pouvez ajouter d'autres méthodes ou attributs selon les besoins de votre application
}
