<?php

namespace App\Http\Controllers;

use App\Models\Illustration; // Importez le modèle Illustration pour interagir avec la table des illustrations.
use Illuminate\Routing\Controller;
class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec la liste des illustrations.
     * 
     * Cette méthode est appelée lorsque l'utilisateur visite la page d'accueil.
     * Elle récupère toutes les illustrations de la base de données et les transmet à la vue.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $illustrations = Illustration::all(); // Récupère toutes les illustrations de la base de données.
        return view('home', ['illustrations' => $illustrations]); // Renvoie à la vue 'home' avec les illustrations récupérées.
    }
}
