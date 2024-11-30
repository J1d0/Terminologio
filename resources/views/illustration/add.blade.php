<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Ajout d'une Illustration</title>
</head>
<body>
    <h2>Ajouter une Illustration</h2>
    <!-- Formulaire d'ajout d'une illustration -->
    <form action="{{ route('illustration.newIllustration') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <!-- Titre de l'illustration -->
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <!-- Domaine de l'illustration -->
            <label for="domain">Domaine:</label>
            <select id="domain" name="domain">   
                <option value="anatomy">Anatomie</option>
                <option value="biology">Biologie</option>
                <option value="mecanic">Mécanique</option>
                <option value="health">Santé</option>
                <option value="physics">Physique</option>
                <option value="chemistry">Chimie</option>
                <option value="mathematics">Mathématiques</option>
                <option value="computer_science">Informatique</option>
                <option value="astronomy">Astronomie</option>
                <option value="geology">Géologie</option>
                <option value="ecology">Écologie</option>
                <option value="zoology">Zoologie</option>
                <option value="botany">Botanique</option>
                <option value="meteorology">Météorologie</option>
                <option value="oceanography">Océanographie</option>
                <option value="psychology">Psychologie</option>
                <option value="sociology">Sociologie</option>
                <option value="anthropology">Anthropologie</option>
                <option value="philosophy">Philosophie</option>
                <option value="linguistics">Linguistique</option>
                <option value="history">Histoire</option>
                <option value="art_history">Histoire de l'art</option>
                <option value="political_science">Science politique</option>
                <option value="economics">Économie</option>
            </select>
        </div>
        <div>
            <!-- Langue par défaut de l'illustration -->
            <label for="language">Langue par défaut :</label>
            <select id="language" name="language">
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
        </div>
        <!-- Téléversement de l'illustration -->
        <input type="file" name="image" id="image" required>
        <button type="submit">Suivant</button>
    </form>
</body>
</html>