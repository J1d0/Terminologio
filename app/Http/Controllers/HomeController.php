<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use App\Models\Domaine; // Importez le modèle Domaine pour interagir avec la table des domaines.
use App\Models\Illustration; // Importez le modèle Illustration pour interagir avec la table des illustrations.

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
        $domains = Domaine::all(); // Récupère tous les domaines de la base de données.
        $illustrations = Illustration::all(); // Récupère toutes les illustrations de la base de données.
        return view('home', ['domains' => $domains ,'illustrations' => $illustrations]); // Renvoie à la vue 'home' avec les illustrations récupérées.
    }

}
