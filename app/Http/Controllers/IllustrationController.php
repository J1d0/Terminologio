<?php

namespace App\Http\Controllers;

use App\Models\Illustration;
use App\Models\ComposantIllustration;
use App\Models\Domaine;
use App\Models\Traduction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class IllustrationController extends Controller
{
    /**
     * Affiche la page pour ajouter une nouvelle illustration.
     *
     * @return \Illuminate\View\View
     */
    public function add()
    {
        return view('illustration.add');
    }

    /**
    * Crée une nouvelle illustration à modifier
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function newIllustration(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'title' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'language' => 'required|string|max:2',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Traitement du téléversement de l'image
        if ($request->hasFile('image')) {
            $imageName = $request->title.'_'.$request->language;
            if (Storage::disk('public')->exists($imageName)) {
                // Gérer l'erreur si le fichier existe déjà
                return redirect()->back()->with('error', 'Une illustration avec le même titre et la même langue existe déjà.');
            } else {
                $request->file('image')->storeAs('', $imageName, 'public');
            }
        } else {
            // Gérer l'erreur si aucun fichier n'est téléversé
            return redirect()->back()->with('error', 'Une erreur lors du téléversement.');
        }

        // Redirection vers une page appropriée après enregistrement (averifier)
        return redirect()->route('illustration.design_comp', ['imageTitle' => $request->title, 'domain' => $request->domain, 'language' => $request->language, 'imagePath' => $imageName]);
    }

    /**
     * Annule la création d'une nouvelle illustration.
     * 
     * @param string $imagePath
     * @return \Illuminate\Http\Response
     */
    public function cancel($imagePath)
    {
        // Supprime l'image téléversée
        Storage::disk('public')->delete($imagePath);
        // Redirige l'utilisateur vers la page d'accueil
        return redirect()->route('home');
    }

    
    /**
     * Affiche la page pour la désignation des composants d'une illustration.
     *
     * @param  string $imageTitle
     * @param  string $domain
     * @param  string $language
     * @param  string $imagePath
     * @return \Illuminate\View\View
     */
    public function design_comp($imageTitle, $domain, $language, $imagePath)
    {
        return view('illustration.design_comp', ['imageTitle' => $imageTitle, 'domain' => $domain, 'language' => $language, 'imagePath' => $imagePath]);
    }

    
    /**
     * Enregistre une nouvelle illustration dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $imageTitle
     * @param  string $domain
     * @param  string $language
     * @param  string $imagePath
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $imageTitle, $domain, $language, $imagePath)
    {
        if (!(Domaine::where('nom', $domain)->exists())) {
            // Création d'un nouveau domaine s'il n'existe pas
            $domaine = Domaine::create([
                'nom' => $domain,
            ]);
        }

        // Enregistrement de l'illustration dans la base de données
        $illustration = Illustration::create([
            'title' => $imageTitle,
            'default_language' => $language,
            'image_path' => $imagePath,
            'domain' => $domain,
            'user_id' => Auth::user()->id,
        ]);

        // Enregistrement des composants de l'illustration dans la base de données
        foreach ($request->input('components') as $comp) {
            $comp = json_decode($comp);
            ComposantIllustration::create([
                'image_path_id' => $imagePath,
                'nom' => $comp->title,
                'numero' => $comp->number,
                'x' => $comp->x,
                'y' => $comp->y,                
            ]);
        }

        return redirect()->route('home')->with('success', 'Illustration ajoutée avec succès.');
    }


    /**
     * Gère l'affichage d'une illustration spécifique.
     *
     * @param string $imagePath
     * @return \Illuminate\View\View
     */
    public function show($imagePath)
    {
        // Vérifiez si l'illustration existe
        $illustration = Illustration::find($imagePath);
        if (!$illustration) {
            return redirect()->back()->with('error', 'Illustration introuvable.');
        }

        // Récupérez les composants de l'illustration et les traductions associées dans la base de données et convertissez-les en JSON
        $composants = ComposantIllustration::where('image_path_id', $imagePath)->get();
        $composants_json = $composants->toJson();
        $traductions = Traduction::where('image_path_id', $imagePath)->get();
        $traductions_json = $traductions->toJson();

        // Récupérez les langues disponibles pour l'illustration
        $languages = [];
        foreach ($traductions as $traduction) {
            if (!(in_array($traduction->langue, $languages))) {
                array_push($languages, $traduction->langue);
            }
        }
        return view('illustration.show', ['illustration' => $illustration, 'composants' => $composants, 'composants_json' => $composants_json, 'traductions' => $traductions, 'traductions_json' => $traductions_json,'languages' => $languages]);
    }


    /**
     * Affiche la page pour éditer la terminologie d'une illustration.
     *
     * @param  string $imagePath
     * @param string $language
     * @return \Illuminate\View\View
     */
    public function edit($imagePath, $language)
    {
        // Vérifiez si l'illustration existe
        $illustration = Illustration::find($imagePath);
        if (!$illustration) {
            return redirect()->back()->with('error', 'Illustration introuvable.');
        }

        // Récupérez les composants de l'illustration associées dans la base de données et convertissez-les en JSON
        $composants = ComposantIllustration::where('image_path_id', $imagePath)->get();
        $composants_json = $composants->toJson();

        // On vérifie s'il existe déja une traduction dans la langue choisie
        $traductions = null;
        // On vérifie si la langue par défaut de l'illustration est la même que celle choisie par l'utilisateur
        if ($illustration->default_language != $language) {
            // On vérifie si des traductions existent déjà pour cette illustration et cette langue
            if (Traduction::where('image_path_id', $imagePath)->where('langue', $language)->exists()) {
                $traductions = Traduction::where('image_path_id', $imagePath)->where('langue', $language)->get();
            }
        } 
        return view('illustration.edit', ['illustration' => $illustration, 'composants' => $composants, 'composants_json' => $composants_json, 'language' => $language, 'traductions' => $traductions]);
    }



    /**
     * Met à jour les composants d'une illustration spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $imagePath
     * @param  string $language
     * @return \Illuminate\Http\Response
     */
    public function updateComponents(Request $request, $imagePath, $language)
    {
        // Vérifiez si l'illustration existe
        $illustration = Illustration::find($imagePath);
        if (!$illustration) {
            return redirect()->back()->with('error', 'Illustration introuvable.');
        }

        // Vérifiez si la langue par défaut de l'illustration est la même que celle choisie par l'utilisateur
        if ($illustration->default_language == $language) {
            // Si oui, mettez à jour les composants de l'illustration dans la base de données
            $index = 1;
            foreach ($request->input('components') as $comp) {
                ComposantIllustration::where('image_path_id', $imagePath)->where('numero', $index)->update(['nom' => $comp]);
                $index++;
            }
        } else {
            // Si non, on vérifie si une traduction existe déjà dans cette langue
            $index = 1;
            if (Traduction::where('image_path_id', $imagePath)->where('langue', $language)->exists()) {
                // Si oui, mettez à jour les trauctions des composants dans la base de données
                foreach ($request->input('components') as $comp) {
                    Traduction::where('image_path_id', $imagePath)->where('langue', $language)->where('composant_num', $index)->update(['texte' => $comp]);
                    $index++;
                }
            } else {
                // Si non, créez une nouvelle traduction dans la base de données
                foreach ($request->input('components') as $comp) {
                    Traduction::create([
                        'image_path_id' => $imagePath,
                        'langue' => $language,
                        'composant_num' => $index,
                        'texte' => $comp,
                    ]);
                    $index++;
                }
                return redirect()->route('illustration.show', ['image_path' => $imagePath])->with('success', 'Traduction ajoutée avec succès.');
            }
        }

        // Redirigez l'utilisateur vers la page d'accueil après la mise à jour
        return redirect()->route('illustration.show', ['image_path' => $imagePath])->with('success', 'Composants mis à jour avec succès.');
    }


    /**
     * Gère la gestion des traductions pour une illustration.
     *
     * @param string $imagePath
     * @return \Illuminate\View\View
     */
    public function manageTranslations($imagePath)
    {
        // Vérifiez si l'illustration existe
        $illustration = Illustration::find($imagePath);
        if (!$illustration) {
            return redirect()->back()->with('error', 'Illustration introuvable.');
        }
        
        return view('illustration.translations', ['illustration' => $illustration]);
    }

    /**
     * Affiche la page pour éditer la traduction d'une illustration.
     *
     * @param \Illuminate\Http\Request  $request
     * @param string $language
     * @return \Illuminate\Http\Response
     */
    public function editTranslation(Request $request, $imagePath)
    {
        $language = $request->input('language');
        return redirect()->route('illustration.edit', ['imagePath' => $imagePath, 'language' => $language]);
    }
    
}