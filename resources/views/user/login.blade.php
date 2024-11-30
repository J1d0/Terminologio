<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <!-- Formulaire de connexion -->
    <form action="{{ route('login.post') }}" method="POST">
        <!-- Token CSRF pour la sécurité -->
        @csrf
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <!-- Lien vers la page d'inscription -->
    <a href="{{ route('register.form') }}" class="sign-in-btn">Inscription</a>
    <!-- Lien retour à la page d'accueil -->
    <a href="{{ route('home') }}" class="accueil-link-login">Accueil</a>

    <!-- Bloc pour afficher les erreurs de validation -->
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
