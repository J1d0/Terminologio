<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <a href="<?php echo e(route('home')); ?>" class="accueil-link">Accueil</a>
    <title>Affichage de l'Illustration</title>
</head>
<body>
    <h2 class="illustration-title"><?php echo e($illustration->title); ?> </h2>
    <!-- Affichage de l'illustration et des points permettant de localiser les composants -->
    <div id="image-container">
        <img id="illustration" src="<?php echo e(Storage::url($illustration->image_path)); ?>" alt="<?php echo e($illustration->image_path); ?>" style="max-width: 100%;">
    </div>
    <div class="centered-container">
        <div id="composants">
            <!-- Liste des composants -->
            <p>Composants :</p>
            <?php $__currentLoopData = $composants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $composant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p id="<?php echo e($composant->numero); ?>"></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div id="langues">
            <!-- Liste des langues existantes pour l'illustration -->
            <select id="langs" onchange="updateLang()">
                <option id='default' value="<?php echo e($illustration->default_language); ?>"><?php echo e($illustration->default_language); ?></option>
                <!-- On vérifie s'il existe des traductions pour l'illustration -->
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($language); ?>"><?php echo e($language); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            <!-- Si l'utilisateur est connecté, on affiche l'ajout de traduction -->
            <?php if(Auth::check() && Auth::user()->hasRole('membre')): ?>
                <!-- Si l'utilisateur est l'auteur de l'illustration, on affiche les boutons de modification de la langue par défaut-->
                <?php if(Auth::user()->id == $illustration->user_id): ?>
                    <a href="<?php echo e(route('illustration.edit', ['imagePath' => $illustration->image_path, 'language' => $illustration->default_language])); ?>" class="change-comp">Modifier</a>
                <?php endif; ?>
                <a href="<?php echo e(route('illustration.manageTranslations', ['imagePath' => $illustration->image_path])); ?>" class="add-trad">Ajouter / Modifier une traduction</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // On récupère les composants et les traductions
        var components = JSON.parse(<?php echo json_encode($composants_json, 15, 512) ?>);
        var trads = JSON.parse(<?php echo json_encode($traductions_json, 15, 512) ?>);
        
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
</html><?php /**PATH /home/lucas/Téléchargements/Projfinal/Terminologio/resources/views/illustration/show.blade.php ENDPATH**/ ?>