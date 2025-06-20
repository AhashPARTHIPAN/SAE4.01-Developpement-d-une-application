<?php
require_once "view_begin.php"?>

    <!-- Présentation du jeu -->
    <div class="container">
        <!-- Section gauche -->
        <!-- Section droite -->
        <div class="info-section">
            <h1><?php echo htmlspecialchars($unJeux["titre"])?></h1>
            <p><span>Éditeur :</span> <?php echo htmlspecialchars($unJeux["nom_editeur"])?></p>
            <p><span>Auteur :</span> <?php echo htmlspecialchars($unJeux["nom_auteur"])?></p>
            <p><span>Âge : </span><?php echo htmlspecialchars($unJeux["age_indique"])?> </p>
            <p><span>Nombre de joueurs :</span> <?php echo htmlspecialchars($unJeux["nombre_de_joueurs"])?></p>
            <p><span>Date de parution :</span> <?php echo htmlspecialchars($unJeux["date_parution_debut"])?></p>
            <p><span>Mécanisme :</span><?php echo htmlspecialchars($unJeux["nom_mecanisme"])?> </p>
            <p><span>Version :</span> <?php echo htmlspecialchars($unJeux["version"])?></p>
            <p><span>Mots-clés :</span> <?php echo htmlspecialchars($unJeux["mots_cles"])?></p>
        </div>
        <div class="section-gauche">
            <div class="game-image"></div>
            <p><strong>Nombre d'exemplaires :</strong> <?php echo htmlspecialchars($nb_boite["nb_boite"])?></p>
            <a class="Bouton" href="?controller=list&action=boiteJeu&id_jeu=<?= $_GET["id_jeu"] ?>">Voir les boîtes</a>
        </div>
    </div>
    <!-- Section des jeux similaires -->
    <div class="jeux-similaires">
        <h2>Autres jeux similaires :</h2>
        <div class="cards">
            <?php foreach($jeuSim as $jeu) :?>
            <div class="card">
                <h3><a href="?controller=list&action=jeuPresentation&id_jeu=<?= htmlspecialchars($jeu['id_jeu']) ?>"><?php echo htmlspecialchars($jeu["titre"])?></a></h3>
                <p>Mecanisme : <?php echo htmlspecialchars($unJeux["nom_mecanisme"])?></p>
            </div>
            <?php endforeach ?>
        </div>
    </div>

<?php require_once "view_end.php"?>
