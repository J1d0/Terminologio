<?php

namespace App\Http\Controllers;

use App\Models\User; // Importez le modèle User pour interagir avec la table des utilisateurs.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validez les données d'entrée, par exemple: 'username' et 'password'
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Créez un nouvel utilisateur et enregistrez-le dans la base de données
        $user = User::create([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'membre',
        ]);

        // Logique pour gérer la connexion de l'utilisateur après l'inscription

        return redirect()->route('home'); // Redirigez l'utilisateur vers la page d'accueil après l'inscription
    }

    // Ajoutez ici d'autres méthodes pour la gestion des utilisateurs...
}
