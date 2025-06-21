<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection de jeux</title>
    <link href="Content/css/style-v2.css" rel="stylesheet">
</head>
<body>
    <!-- Tête de page -->
    <header class="nav-header">
        <a href="index.php">
            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e24d432f71ae5fc037e972e78951ca15052e5e8c7824a911375a22f8623cb7b3?placeholderIfAbsent=true&apiKey=d20a853adbac4dde9b424a402120db37" alt="Logo" class="logo">
        </a>
        <nav class="nav-links">
            <a href="index.php" class="nav-link">Accueil</a>
            <a href="?controller=list&action=pagination" class="nav-link">Découvrir</a>
	        <a href="?controller=recherche&action=rechercheAvancee" class="nav-link">Recherche avancée</a>
            
            <!-- Vérifie si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['utilisateur'])): ?>
                <a href="?controller=monCompte" class="nav-link">Mon Compte</a>
                <a href="?controller=connexion_inscription&action=deconnexion" class="nav-link">Se Déconnecter</a>
            <?php else: ?>
                <a href="?controller=connexion_inscription&action=afficher" class="nav-link">Connexion/Inscription</a>
            <?php endif; ?>
        </nav>
    </header>
