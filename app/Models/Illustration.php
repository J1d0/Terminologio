<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illustration extends Model
{
    use HasFactory;
    protected $table = 'illustrations';
    // Indiquez que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;

    // Indiquez que la clé primaire est de type string
    protected $keyType = 'string';

    // Définissez la clé primaire personnalisée
    protected $primaryKey = 'image_path';
    protected $fillable = [
        'title',
        'default_language', // La langue par défaut de l'illustration
        'image_path', // L'URL de l'image
        'domain', // Le domaine de l'illustration
        'user_id', // L'utilisateur qui a créé l'illustration
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

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }
}
