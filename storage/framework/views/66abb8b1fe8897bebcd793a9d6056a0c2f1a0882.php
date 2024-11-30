<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <a href="<?php echo e(route('home')); ?>" class="accueil-link">Accueil</a>
    <title>Gestion</title>
</head>
<body>
    <div>
        <!-- Affichage des utilisateurs -->
        <h2>Liste des utilisateurs</h2>
        <?php if($users->isEmpty()): ?>
            <!-- Message s'il n'y a pas d'utilisateurs existant-->
            <p>Aucun utilisateur n'a été ajouté pour le moment.</p>
        <?php endif; ?>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="user">
                <!-- Pour chaque utilisateur on affiche son nom, son adresse mail et ses rôles -->
                <p><?php echo e($user->username); ?></p>
                <p><?php echo e($user->email); ?></p>
                <?php if($user->hasRole('membre')): ?>
                    <!-- Bouton de suppression de l'utilisateur -->
                    <form action="<?php echo e(route('admin.deleteUser', $user->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
    </div>
    <div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <h2>Liste des illustrations</h2>
        <?php if($illustrations->isEmpty()): ?>
            <!-- Message s'il n'y a pas d'illustrations existantes-->
            <p>Aucune illustration n'a été ajoutée pour le moment.</p>
        <?php endif; ?>
        <?php $__currentLoopData = $illustrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $illustration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="illustration_list">
                <!-- Pour chaque illustration on affiche son titre, son domaine, sa langue et ses composants -->
                <p><?php echo e($illustration->title); ?></p>
                <p><?php echo e($illustration->default_language); ?></p>
                <!-- Bouton de suppression de l'illustration -->
                <form action="<?php echo e(route('admin.deleteIllustration', $illustration->image_path)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html>


<?php /**PATH /home/lucas/Téléchargements/Projfinal/Terminologio/resources/views/admin/manage.blade.php ENDPATH**/ ?>