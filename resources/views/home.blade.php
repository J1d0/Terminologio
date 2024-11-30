<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>
</head>
<body>
    <div>
        <!-- Boutons de connexion/inscription ou bouton de création d'illustration selon le statut de connexion -->
        @if (Auth::check())
            <!-- Boutons pour les utilisateurs connectés -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
            @if (Auth::user()->hasRole('admin'))
                <!-- Bouton pour les administrateurs -->
                <a href="{{ route('admin.manage') }}" class="admin-btn">Administration</a>
            @else
                <a href="{{ route('illustration.add') }}"class="create-illustration-btn">Créer une illustration</a>
            @endif
        @else
            <!-- Boutons pour les utilisateurs non connectés -->
            <div class="nav-auth-buttons">
                <a href="{{ route('login.form') }}" class="login-btn">Connexion</a>
                <a href="{{ route('register.form') }}" class="sign-in-btn">Inscription</a>
            </div>
        @endif
    </div>


    <!-- Page d'accueil -->
    <h1>Liste des concepts (classés par domaines)</h1>
    <div>
        <!-- Affichage des concepts et des illustrations -->
        @if ($domains->isEmpty())
            <!-- Message s'il n'y a pas de concepts existant-->
            <p>Aucun concept n'a été ajouté pour le moment.</p>
        @endif
        @foreach ($domains as $domain)
            <!-- Pour chaque domaine on affiche son nom et ses illustrations -->
            <h2>{{ $domain->nom }}</h2>
            <ul>
                @foreach ($illustrations as $illustration)
                    @if ($illustration->domain == $domain->nom)
                        <li>
                            <a href="{{ route('illustration.show', ['image_path' => $illustration->image_path]) }}">
                                <figure>
                                    <img id="illustration" src="{{ Storage::url($illustration->image_path) }}" alt="{{ $illustration->image_path }}" style="max-width: 30%;">
                                    <figcaption class="illustration-title">{{ $illustration->title }}</figcaption>
                                </figure>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endforeach
    </div>
</body>
</html>


