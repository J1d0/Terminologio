<?php

namespace App\Http\Controllers;

use App\Models\User; // Pour la gestion des utilisateurs.
use App\Models\Illustration; // Pour la gestion des illustrations.
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Affiche la page de gestion pour l'administrateur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        $illustrations = Illustration::all();
        return view('admin.index', ['users' => $users, 'illustrations' => $illustrations]);
    }

    /**
     * Supprime un utilisateur spécifié.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }

    /**
     * Supprime une illustration spécifiée.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteIllustration($id)
    {
        Illustration::find($id)->delete();
        return redirect()->back();
    }

    // Autres méthodes pour la gestion par l'administrateur...
}
