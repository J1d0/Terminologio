<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'utilisateurs';
    protected $fillable = [
        'username', // Si vous utilisez un nom d'utilisateur au lieu de l'email
        'email',
        'password',
        'role'
    ];

    // Relations avec d'autres modèles, par exemple avec les illustrations
    public function illustrations()
    {
        return $this->hasMany(Illustration::class);
    }

    /**
    * Détermine si l'utilisateur a un rôle spécifique.
    *
    * @param string $role
    * @return bool
    */
   public function hasRole($role)
   {
       return $this->role === $role;
   }
    // Ajoutez ici d'autres méthodes de relation ou attributs selon les besoins de votre application
}
