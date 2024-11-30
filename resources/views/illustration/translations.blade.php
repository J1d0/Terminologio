<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <a href="{{ route('home') }}" class="accueil-link" >Accueil</a>
    <title>Choix de la traduction</title>
</head>
<body>
    <h2 class="illustration-title">Choix de la langue pour {{ $illustration->title }}</h2>
    <div id="image-container">
        <!-- Affichage de l'illustration -->
        <img id="illustration" src="{{ Storage::url($illustration->image_path) }}" alt="{{ $illustration->image_path }}" style="max-width: 100%;">
    </div>
    <div id="langues">
        <p>Choisissez une langue à traduire :</p>
        <form action="{{ route('illustration.editTranslation', ['imagePath' => $illustration->image_path]) }}" method="POST">
            @csrf
            <!-- Liste déroulante des langues -->
            <select id="langs" name="language">
                <option value="fr">Français</option>
                <option value="en">Anglais</option>
                <option value="es">Espagnol</option>
                <option value="it">Italien</option>
                <option value="de">Allemand</option>
                <option value="pt">Portugais</option>
                <option value="ru">Russe</option>
                <option value="zh">Chinois</option>
                <option value="ja">Japonais</option>
                <option value="ar">Arabe</option>
            </select>
            <button type="submit">Valider</button>
        </form>
    </div>
    <script>
        // On cache la langue par défaut de l'illustration afin de permettre à l'utilisateur de ne pas la sélectionner
        var selectElement = document.getElementById('langs');
        var options = selectElement.options;
        // Si la langue par défaut est la première option, on la cache et le selecteur sélectionne la deuxième option comme valeur par défaut
        if (options[0].value === "{{ $illustration->default_language }}") {
            options[0].style.display = 'none';
            selectElement.selectedIndex = 1;
        } else {
            for (var i = 1; i < options.length; i++) {
                if (options[i].value === "{{ $illustration->default_language }}") {
                    options[i].style.display = 'none';
                }
            }
        }
        
    </script>
</body>
</html>