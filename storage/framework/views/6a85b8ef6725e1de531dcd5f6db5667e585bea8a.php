<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <!-- Formulaire de connexion -->
    <form action="<?php echo e(route('login.post')); ?>" method="POST">
        <!-- Token CSRF pour la sécurité -->
        <?php echo csrf_field(); ?>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <!-- Lien vers la page d'inscription -->
    <a href="<?php echo e(route('register.form')); ?>" class="sign-in-btn">Inscription</a>
    <!-- Lien retour à la page d'accueil -->
    <a href="<?php echo e(route('home')); ?>" class="accueil-link-login">Accueil</a>

    <!-- Bloc pour afficher les erreurs de validation -->
    <?php if($errors->any()): ?>
    <div>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

</body>
</html>
<?php /**PATH /home/lucas/Téléchargements/Projfinal/Terminologio/resources/views/user/login.blade.php ENDPATH**/ ?>