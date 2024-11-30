<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Illustration;

class Domaine extends Model
{
    use HasFactory;
    protected $table = 'domaines';
    // Définissez les attributs qui sont assignables en masse
    protected $fillable = [
        'nom', // Nom du domaine, par exemple 'Biologie', 'Physique', etc.
    ];
    
    // Relation avec le modèle Illustration (un domaine peut avoir plusieurs illustrations)
    public function illustrations()
    {
        return $this->hasMany(Illustration::class);
    }
}
