<?php

namespace App\Http\Controllers;

use App\Models\User; // Pour la gestion des utilisateurs.
use App\Models\Illustration; // Pour la gestion des illustrations.
use App\Models\Traduction; // Pour la gestion des traductions.
use App\Models\Domaine; // Pour la gestion des domaines.
use App\Models\ComposantIllustration; // Pour la gestion des composants.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Affiche la page de gestion pour l'administrateur.
     *
     * @return \Illuminate\View\View
     */
    public function manage()
    {
        $users = User::all();
        $illustrations = Illustration::all();
        return view('admin.manage', ['users' => $users, 'illustrations' => $illustrations]);
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
     * @param string $image_path
     * @return \Illuminate\Http\Response
     */
    public function deleteIllustration($image_path)
    {
        $trads = Traduction::where('image_path_id', $image_path)->delete();
        $composants = ComposantIllustration::where('image_path_id', $image_path)->delete();
        $illustration = Illustration::where('image_path', $image_path)->first();
        $dom = $illustration->domain;
        $illustration->delete();
        if (Illustration::where('domain', $dom)->count() == 0) {
            Domaine::where('nom', $dom)->delete();
        }
        Storage::disk('public')->delete($image_path);
        return redirect()->back();
    }

}
