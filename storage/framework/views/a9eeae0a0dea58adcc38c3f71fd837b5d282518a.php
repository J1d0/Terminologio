<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
</head>
<body>
    <div>
        <!-- Boutons de connexion/inscription ou bouton de création d'illustration selon le statut de connexion -->
        <?php if(Auth::check()): ?>
            <!-- Boutons pour les utilisateurs connectés -->
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
            <?php if(Auth::user()->hasRole('admin')): ?>
                <!-- Bouton pour les administrateurs -->
                <a href="<?php echo e(route('admin.manage')); ?>" class="admin-btn">Administration</a>
            <?php else: ?>
                <a href="<?php echo e(route('illustration.add')); ?>"class="create-illustration-btn">Créer une illustration</a>
            <?php endif; ?>
        <?php else: ?>
            <!-- Boutons pour les utilisateurs non connectés -->
            <div class="nav-auth-buttons">
                <a href="<?php echo e(route('login.form')); ?>" class="login-btn">Connexion</a>
                <a href="<?php echo e(route('register.form')); ?>" class="sign-in-btn">Inscription</a>
            </div>
        <?php endif; ?>
    </div>


    <!-- Page d'accueil -->
    <h1>Liste des concepts (classés par domaines)</h1>
    <div>
        <!-- Affichage des concepts et des illustrations -->
        <?php if($domains->isEmpty()): ?>
            <!-- Message s'il n'y a pas de concepts existant-->
            <p>Aucun concept n'a été ajouté pour le moment.</p>
        <?php endif; ?>
        <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Pour chaque domaine on affiche son nom et ses illustrations -->
            <h2><?php echo e($domain->nom); ?></h2>
            <ul>
                <?php $__currentLoopData = $illustrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $illustration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($illustration->domain == $domain->nom): ?>
                        <li>
                            <a href="<?php echo e(route('illustration.show', ['image_path' => $illustration->image_path])); ?>">
                                <figure>
                                    <img id="illustration" src="<?php echo e(Storage::url($illustration->image_path)); ?>" alt="<?php echo e($illustration->image_path); ?>" style="max-width: 30%;">
                                    <figcaption class="illustration-title"><?php echo e($illustration->title); ?></figcaption>
                                </figure>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html>


<?php /**PATH /home/lucas/Téléchargements/Projfinal/Terminologio/resources/views/home.blade.php ENDPATH**/ ?>