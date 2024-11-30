<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Champ pour le nom d'utilisateur -->
            <label for="username">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" required>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

        <!-- Champ pour l'email -->
            <label for="email">Adresse E-mail</label>
                <input id="email" type="email" name="email" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

        <!-- Champ pour le mot de passe -->
            <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

        <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" id="submit">Inscription</button>
    </form>
</body>
</html>