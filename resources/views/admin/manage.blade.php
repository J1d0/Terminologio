<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <a href="{{ route('home') }}" class="accueil-link">Accueil</a>
    <title>Gestion</title>
</head>
<body>
    <div>
        <!-- Affichage des utilisateurs -->
        <h2>Liste des utilisateurs</h2>
        @if ($users->isEmpty())
            <!-- Message s'il n'y a pas d'utilisateurs existant-->
            <p>Aucun utilisateur n'a été ajouté pour le moment.</p>
        @endif
        @foreach ($users as $user)
            <div class="user">
                <!-- Pour chaque utilisateur on affiche son nom, son adresse mail et ses rôles -->
                <p>{{ $user->username }}</p>
                <p>{{ $user->email }}</p>
                @if ($user->hasRole('membre'))
                    <!-- Bouton de suppression de l'utilisateur -->
                    <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                @endif
            </div>
    </div>
    <div>
        @endforeach
        <h2>Liste des illustrations</h2>
        @if ($illustrations->isEmpty())
            <!-- Message s'il n'y a pas d'illustrations existantes-->
            <p>Aucune illustration n'a été ajoutée pour le moment.</p>
        @endif
        @foreach ($illustrations as $illustration)
            <div class="illustration_list">
                <!-- Pour chaque illustration on affiche son titre, son domaine, sa langue et ses composants -->
                <p>{{ $illustration->title }}</p>
                <p>{{ $illustration->default_language }}</p>
                <!-- Bouton de suppression de l'illustration -->
                <form action="{{ route('admin.deleteIllustration', $illustration->image_path) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>


