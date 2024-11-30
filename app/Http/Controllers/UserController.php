<?php

namespace App\Http\Controllers;

use App\Models\User; // Importez le modèle User pour interagir avec la table des utilisateurs.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


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
            'username' => 'required|unique:utilisateurs',
            'email' => 'required|email|unique:utilisateurs',
            'password' => 'required|min:6',
        ]);

        // Créez un nouvel utilisateur et enregistrez-le dans la base de données
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'membre',
        ]);

        // Connexion automatique de l'utilisateur
        Auth::login($user);
        // Logique pour gérer la connexion de l'utilisateur après l'inscription

        return redirect()->route('home'); // Redirigez l'utilisateur vers la page d'accueil après l'inscription
    }

    /**
     * Gère le processus de connexion de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'loginError' => 'Les informations d\'identification fournies ne sont pas valides.',
            ]);
        }

    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
