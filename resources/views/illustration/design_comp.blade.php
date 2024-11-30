<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <a href="{{ route('illustration.cancel', ['imagePath' => $imagePath]) }}" class="accueil-link" >Accueil</a>
    <title>Édition de l'Illustration</title>
</head>
<body>
    <h2>Édition de l'Illustration</h2>
    <div id="image-container">
        <!-- Affichage de l'illustration et des points permettant de localiser les composants -->
        <img id="illustration" src="{{ Storage::url($imagePath) }}" alt="Illustration" style="max-width: 100%;">
    </div>
    <!-- Liste des composants qui apparaiteront au fur et à mesure de leur ajout -->
    <div id="components-title"></div>

    <div class="buttons-container">
    <!-- Boutons permettant de passer en mode suppression et d'enregistrer les modifications -->
    <button id="delete-mode-button">Mode Suppression</button>
    <button id="save-button">Enregistrer</button>
    </div>
    
    <!-- Formulaire permettant d'envoyer les composants au serveur -->
    <form id="components-form" action="{{ route('illustration.store', ['imageTitle' => $imageTitle, 'domain' => $domain, 'language' => $language, 'imagePath' => $imagePath]) }}" method="POST">
        @csrf
    </form>
    
    <script>
        var deleteMode = false;
        var components = [];

        // Gestion du mode suppression
        document.getElementById('delete-mode-button').addEventListener('click', function() {
            deleteMode = !deleteMode;
            this.textContent = deleteMode ? "Quitter le mode Suppression" : "Mode Suppression";
        });

        // Gestion de l'enregistrement des modifications
        document.getElementById('save-button').addEventListener('click', function() {
            // On vérifie qu'il y a au moins un composant
            if (components.length === 0) {
                alert('Vous devez ajouter au moins un composant.');
                return;
            }
            // On ajoute chaque composant au formulaire en tant que champ caché
            components.forEach(function(component) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'components[]';
                input.value = JSON.stringify(component);
                document.getElementById('components-form').appendChild(input);
            });
            document.getElementById('components-form').submit();
        });

        // Gestion de l'ajout d'un composant
        document.getElementById('illustration').addEventListener('click', function(event) {
            if (deleteMode) {
                var clickedPoint = document.elementFromPoint(event.clientX, event.clientY);
                if (clickedPoint && clickedPoint.classList.contains('point')) {
                    removePoint(clickedPoint.dataset.number);
                }
            } else {
                addPoint(event);
            }
        });

        // Fonction d'ajout d'un composant
        function addPoint(event) {
            // Récupérer la position du clic par rapport à l'image
            var img = document.getElementById('illustration');
            var rect = img.getBoundingClientRect();

            var x = (event.clientX - rect.left) // position x du clic ajustée à la largeur naturelle de l'image
            var y = (event.clientY - rect.top)  // position y du clic ajustée à la hauteur naturelle de l'image

            var xPercent = x / rect.width * 100; // Arrondir pour éviter la précision excessive
            var yPercent = y / rect.height * 100; // conversion en pourcentage de la hauteur naturelle

            // Demander à l'utilisateur le nom du composant
            var pointNumber = components.length + 1;
            var defaultTitle = 'Composant ' + pointNumber;
            var userTitle = prompt("Entrez le nom du composant :", defaultTitle);

            if (userTitle == null || userTitle == "") {
                return;
            }

            var point = {
                x: xPercent,
                y: yPercent,
                number: pointNumber,
                title: userTitle
            };

            // Créer un nouveau point visuel sur l'image
            var pointDiv = document.createElement('div');
            pointDiv.className = 'point';
            pointDiv.title = point.title;
            pointDiv.textContent = point.number;
            pointDiv.style.position = 'absolute';
            pointDiv.style.left = xPercent + '%';
            pointDiv.style.top = yPercent + '%';
            pointDiv.dataset.number = point.number;
            document.getElementById('image-container').appendChild(pointDiv);

            // Ajouter les événements de survol et de clic sur les points
            pointDiv.addEventListener('click', function(e) {
                if (deleteMode) {
                    e.stopPropagation();
                    removePoint(this.dataset.number);
                }
            });

            
            pointDiv.addEventListener('mouseenter', mouseEnter);
            pointDiv.addEventListener('mouseleave', mouseLeave);

            var compTitle = document.createElement('p');
            compTitle.textContent = point.number + ' : ' + point.title;
            document.getElementById('components-title').appendChild(compTitle);
            
            components.push(point);
        }

        function removePoint(pointNumber) {
            // Trouvez et supprimez le div.point correspondant au numéro fourni
            var points = document.querySelectorAll('.point');
            points.forEach(function(point) {
                if (point.dataset.number === pointNumber) {
                    point.remove(); // Supprimez le point du DOM
                } else if (point.dataset.number > pointNumber) {
                    // Si le numéro du point est supérieur au numéro du point supprimé, décrémentez-le
                    point.dataset.number--;
                    point.textContent = point.dataset.number;
                }
            });

            // Mettez à jour le tableau de composants en retirant l'objet point
            components = components.filter(function(component) {
                return component.number !== parseInt(pointNumber);
            });

            // Mettez à jour les titres des composants et les numéros des composants
            var titles = document.querySelectorAll('#components-title p');
            titles.forEach(function(title) {
                title.remove();
            });

            for (component of components) {
                if(component.number > pointNumber) {
                    component.number--;
                }
                var compTitle = document.createElement('p');
                compTitle.textContent = component.number + ' : ' + component.title;
                document.getElementById('components-title').appendChild(compTitle);
            }
            console.log(components);
        }

        // Fonctions de changement de couleur des points
        function mouseEnter() {
            this.style.background = 'green';
            this.style.color = 'white';
            this.style.border = '2px solid green';
        }

        function mouseLeave() {
            this.style.background = 'red';
            this.style.color = 'white';
            this.style.border = '2px solid red';
        }

        // Fonction de mise à jour de la position des points lors du redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            var img = document.getElementById('illustration');
            var rect = img.getBoundingClientRect();

            components.forEach(function(component) {
                var pointDiv = document.querySelector('.point[data-number="' + component.number + '"]');
                if (pointDiv) {
                    // Utiliser la taille actuelle de l'image pour recalculer la position des points
                    var newX = component.x * rect.width / 100;
                    var newY = component.y * rect.height / 100;
                    pointDiv.style.left = newX + 'px';
                    pointDiv.style.top = newY + 'px';
                }
            });
        });
    </script>
</body>
</html>

