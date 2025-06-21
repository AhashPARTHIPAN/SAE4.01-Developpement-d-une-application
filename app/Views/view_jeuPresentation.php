<?php require_once "view_begin.php"?>

    <div class="container jeu-presentation">
        <div class="section-gauche">
            <div class="div-image">
                <img class="game-image" src="https://media.istockphoto.com/id/1053106642/fr/vectoriel/bo%C3%AEte-de-jeu-de-plateau.jpg?s=612x612&w=0&k=20&c=oxOfGAmJhtSQppgUpkQS3foliZzkKghVM5naQo5EwX0=">
            </div>
            <p><strong>Nombre d'exemplaires :</strong> <?php echo htmlspecialchars($nb_boite["nb_boite"])?></p>
            <a class="Bouton" href="?controller=list&action=boiteJeu&id_jeu=<?= $_GET["id_jeu"] ?>">Voir les boîtes</a>
        </div>
        <div class="section-droite info-section">
            <h1><?php echo htmlspecialchars($unJeux["titre"])?></h1>
            <div class="infos-jeu-grid">
                <div><span class="label">Éditeur :</span> <?php echo htmlspecialchars($unJeux["nom_editeur"])?></div>
                <div><span class="label">Auteur :</span> <?php echo htmlspecialchars($unJeux["nom_auteur"])?></div>
                <div><span class="label">Âge :</span> <?php echo htmlspecialchars($unJeux["age_indique"])?></div>
                <div><span class="label">Nombre de joueurs :</span> <?php echo htmlspecialchars($unJeux["nombre_de_joueurs"])?></div>
                <div><span class="label">Date de parution :</span> <?php echo htmlspecialchars($unJeux["date_parution_debut"])?></div>
                <div><span class="label">Mécanisme :</span> <?php echo htmlspecialchars($unJeux["nom_mecanisme"])?></div>
                <div><span class="label">Version :</span> <?php echo htmlspecialchars($unJeux["version"])?></div>
                <div><span class="label">Mots-clés :</span> <?php echo htmlspecialchars($unJeux["mots_cles"])?></div>
            </div>
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
