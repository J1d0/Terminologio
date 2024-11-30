<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <a href="<?php echo e(route('home')); ?>" class="accueil-link" >Accueil</a>
    <title>Edition des terminologies</title>
</head>
<body>
    <h2 class="illustration-title">Modification de <?php echo e($illustration->title); ?></h2>
    <div id="image-container">
        <!-- Affichage de l'illustration et des points permettant de localiser les composants -->
        <img id="illustration" src="<?php echo e(Storage::url($illustration->image_path)); ?>" alt="<?php echo e($illustration->image_path); ?>" style="max-width: 100%;">
    </div>
    <div id="composants">
        <!-- Liste des composants à modifier -->
        <p>Composants :</p>
        <form id="components-form" action="<?php echo e(route('illustration.updateComponents', ['image_path' => $illustration->image_path, 'language' => $language])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <!-- On vérifie s'il existe déja des noms dans la langue sélectionnée afin de les mettre en tant que placeholder -->
            <?php if($illustration->default_language == $language): ?>
                <?php $__currentLoopData = $composants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $composant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="components[]" value="<?php echo e($composant->nom); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php elseif($traductions == null): ?>
                <?php $__currentLoopData = $composants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $composant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="components[]" value="">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php $__currentLoopData = $traductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $traduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="components[]" value="<?php echo e($traduction->texte); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <!-- Validation des modifications -->
            <button type="submit">Enregistrer les modifications</button>
        </form>
        
    </div>
    <script>
        // Conversion des composants en JSON afin de pouvoir les utiliser en JS
        var components = JSON.parse(<?php echo json_encode($composants_json, 15, 512) ?>);
        
        for (component of components) {
            // Créez un nouveau point visuel sur l'image
            var pointDiv = document.createElement('div');
            pointDiv.className = 'point';
            pointDiv.title = component.nom; // Mettez le nom du composant en tant que titre du point afin de l'afficher au survol
            pointDiv.textContent = component.numero; // Mettez le numéro à l'intérieur du point
            pointDiv.style.left = component.x + '%'; // Positionnez le point en fonction de ses coordonnées
            pointDiv.style.top = component.y + '%'; 
            pointDiv.dataset.number = component.numero; 

            // Changez la couleur du point au survol
            pointDiv.addEventListener('mouseenter', function() {
                this.style.background = 'green';
                this.style.color = 'white';
                this.style.border = '2px solid green';
            });

            // Rechangez la couleur du point lorsque le curseur n'est plus sur le point
            pointDiv.addEventListener('mouseleave', function() {
                this.style.background = 'red';
                this.style.color = 'white';
                this.style.border = '2px solid red';
            });
            
            // Lorsque l'utilisateur clique sur le point, on affiche le composant correspondant dans la liste des composants
            document.getElementById('image-container').appendChild(pointDiv);
        }
    </script>
</body>
</html><?php /**PATH /home/lucas/Téléchargements/Projfinal/Terminologio/resources/views/illustration/edit.blade.php ENDPATH**/ ?>