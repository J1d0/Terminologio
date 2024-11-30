<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <a href="{{ route('home') }}" class="accueil-link">Accueil</a>
    <title>Affichage de l'Illustration</title>
</head>
<body>
    <h2 class="illustration-title">{{ $illustration->title }} </h2>
    <!-- Affichage de l'illustration et des points permettant de localiser les composants -->
    <div id="image-container">
        <img id="illustration" src="{{ Storage::url($illustration->image_path) }}" alt="{{ $illustration->image_path }}" style="max-width: 100%;">
    </div>
    <div class="centered-container">
        <div id="composants">
            <!-- Liste des composants -->
            <p>Composants :</p>
            @foreach ($composants as $composant)
                <p id="{{ $composant->numero }}"></p>
            @endforeach
        </div>
        <div id="langues">
            <!-- Liste des langues existantes pour l'illustration -->
            <select id="langs" onchange="updateLang()">
                <option id='default' value="{{ $illustration->default_language }}">{{ $illustration->default_language }}</option>
                <!-- On vérifie s'il existe des traductions pour l'illustration -->
                @foreach ($languages as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                @endforeach
            </select>
            
            <!-- Si l'utilisateur est connecté, on affiche l'ajout de traduction -->
            @if (Auth::check() && Auth::user()->hasRole('membre'))
                <!-- Si l'utilisateur est l'auteur de l'illustration, on affiche les boutons de modification de la langue par défaut-->
                @if (Auth::user()->id == $illustration->user_id)
                    <a href="{{ route('illustration.edit', ['imagePath' => $illustration->image_path, 'language' => $illustration->default_language]) }}" class="change-comp">Modifier</a>
                @endif
                <a href="{{ route('illustration.manageTranslations', ['imagePath' => $illustration->image_path]) }}" class="add-trad">Ajouter / Modifier une traduction</a>
            @endif
        </div>
    </div>

    <script>
        // On récupère les composants et les traductions
        var components = JSON.parse(@json($composants_json));
        var trads = JSON.parse(@json($traductions_json));
        
        // On récupère les points de l'illustration et on les replace à l'aide de leur de leur coordonnées
        for (component of components) {
            // Créez un nouveau point visuel sur l'image
            var pointDiv = document.createElement('div');
            pointDiv.className = 'point';
            pointDiv.title = component.nom;
            pointDiv.textContent = component.numero; // Mettez le numéro à l'intérieur du point
            pointDiv.style.left = component.x + '%';
            pointDiv.style.top = component.y + '%';
            pointDiv.dataset.number = component.numero;

            pointDiv.addEventListener('mouseenter', function() {
                this.style.background = 'green';
                this.style.color = 'white';
                this.style.border = '2px solid green';
            });
            pointDiv.addEventListener('mouseleave', function() {
                this.style.background = 'red';
                this.style.color = 'white';
                this.style.border = '2px solid red';
            });

            document.getElementById('image-container').appendChild(pointDiv);

        }

        // Fonction permettant de changer la langue des composants sans recharger la page
        function updateLang() {
            // On récupère la langue sélectionnée
            var lang = document.querySelector('#langs');
            lang = lang.options[lang.selectedIndex];
            var pointDivs = document.getElementsByClassName('point');
            // On vérifie si la langue sélectionnée est la langue par défaut
            if(lang.id == 'default'){
                // Si c'est le cas, on affiche les composants dans la langue par défaut
                for (component of components) {
                    var p = document.getElementById(component.numero);
                    p.textContent = component.numero + ' : ' + component.nom;
                    for (pointDiv of pointDivs) {
                        if(pointDiv.dataset.number == component.numero){
                            pointDiv.title = component.nom;
                        }
                    }
                }
            } else {
                // Sinon, on affiche les composants dans la traduction sélectionnée
                for (component of components) {
                    var p = document.getElementById(component.numero);
                    // Pour chaque composant, on cherche sa traduction dans la langue sélectionnée
                    for (pointDiv of pointDivs) {
                        if(pointDiv.dataset.number == component.numero){
                            for (trad of trads) {
                                if(trad.composant_num == component.numero && trad.langue == lang.value){
                                    pointDiv.title = trad.texte;
                                    p.textContent = component.numero + ' : ' + trad.texte;
                                }
                            }
                        }
                    }
                }
            }
        }
        updateLang();
        
        

        
    </script>
</body>
</html>